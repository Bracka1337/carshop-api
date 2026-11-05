<?php

namespace Tests;

use App\Models\Brand;
use App\Models\Delivery_details;
use App\Models\Image;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Product_quantity;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createAdmin(array $attributes = []): User
    {
        return User::factory()->create(['role' => 'Admin', ...$attributes]);
    }

    protected function createBrand(string $title = 'Borbet'): Brand
    {
        return Brand::create(['title' => $title]);
    }

    protected function createProduct(array $attributes = [], ?Brand $brand = null): Product
    {
        $brand ??= $this->createBrand();

        $product = Product::factory()->create([
            'brand_id' => $brand->id,
            'title' => $brand->title,
            ...$attributes,
        ]);

        Image::create(['img_uri' => 'images/Borbet.webp', 'product_id' => $product->id]);

        return $product;
    }

    /**
     * @param  array<int, int>  $quantities  product_id => quantity
     */
    protected function createOrderFor(User $user, array $quantities, string $paymentStatus = 'Processing'): Order
    {
        $order = Order::create([
            'status' => 'Processing',
            'date' => now(),
            'user_id' => $user->id,
            'delivery_details_id' => Delivery_details::factory()->create()->id,
            'payment_id' => Payment::create(['status' => $paymentStatus, 'date' => now()])->id,
        ]);

        foreach ($quantities as $productId => $quantity) {
            Product_quantity::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return $order;
    }
}
