<?php

namespace App\Actions\Checkout;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\DeliveryDetail;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Turns the cart into an order: delivery details, an open payment and one
 * line per product at its current price, all in one transaction. The stock
 * is taken when the order is placed, so a declined card keeps it reserved
 * for the retry.
 */
class PlaceOrder
{
    /**
     * @param  array<string, mixed>  $details  validated by PlaceOrderRequest
     * @param  array<int|string, mixed>  $cart  the session cart (product id => item)
     *
     * @throws ValidationException when the cart is empty, holds products that are no longer sold, or asks for more than is in stock
     */
    public function handle(User $user, array $details, array $cart): Order
    {
        $items = collect($cart)->except(['total', 'tax'])->filter(fn ($item) => is_array($item));

        if ($items->isEmpty()) {
            throw ValidationException::withMessages(['cart' => 'Your cart is empty.']);
        }

        return DB::transaction(function () use ($user, $details, $items) {
            // Lock the rows so two checkouts can't both take the last units.
            $products = Product::whereIn('id', $items->keys())->lockForUpdate()->get()->keyBy('id');

            if ($products->count() !== $items->count()) {
                throw ValidationException::withMessages([
                    'cart' => 'Some products in your cart are no longer available. Please remove them and try again.',
                ]);
            }

            $quantities = $items->map(fn (array $item) => (int) $item['quantity']);

            $short = $products
                ->filter(fn (Product $product) => $quantities->get($product->id, 0) > $product->stock)
                ->map(fn (Product $product) => $product->stock > 0
                    ? "{$product->title} (only {$product->stock} left)"
                    : "{$product->title} (out of stock)");

            if ($short->isNotEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => 'Not enough stock for '.$short->join(', ', ' and ').'. Please update your cart and try again.',
                ]);
            }

            $deliveryDetails = DeliveryDetail::create([
                'f_name' => $details['f_name'],
                'm_name' => $details['m_name'] ?? null,
                'l_name' => $details['l_name'],
                'addr_line_1' => $details['addr_line_1'].', '.$details['city'],
                'addr_line_2' => $details['addr_line_2'] ?? null,
                'country' => $details['country'],
                'company_email' => $details['company_email'] ?? null,
                'company_name' => $details['company_name'] ?? null,
                'company_reg_nr' => $details['vat_number'] ?? null,
                'payment_method' => $details['payment_method'],
                'delivery_method' => $details['delivery_method'],
            ]);

            $payment = Payment::create([
                'status' => PaymentStatus::Processing,
                'date' => now(),
            ]);

            $order = Order::create([
                'status' => OrderStatus::Processing,
                'date' => now(),
                'user_id' => $user->id,
                'delivery_details_id' => $deliveryDetails->id,
                'payment_id' => $payment->id,
            ]);

            foreach ($products as $product) {
                $quantity = $quantities->get($product->id, 0);

                $order->lines()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                ]);

                // Conditional update as well as the lock: SQLite ignores FOR UPDATE.
                $taken = Product::whereKey($product->id)->where('stock', '>=', $quantity)->decrement('stock', $quantity);

                if ($taken !== 1) {
                    throw ValidationException::withMessages([
                        'cart' => "{$product->title} just sold out. Please update your cart and try again.",
                    ]);
                }
            }

            return $order;
        });
    }
}
