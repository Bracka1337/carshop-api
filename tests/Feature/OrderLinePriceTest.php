<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OrderLinePriceTest extends TestCase
{
    use RefreshDatabase;

    private function placeOrder(User $user, int $productId, int $times): Order
    {
        $this->actingAs($user);

        for ($i = 0; $i < $times; $i++) {
            $this->get("/products/{$productId}");
        }

        $this->post('/payment', [
            'f_name' => 'Jane',
            'l_name' => 'Doe',
            'your_email' => 'jane@example.com',
            'country' => 'LV',
            'city' => 'Riga',
            'addr_line_1' => 'Brivibas iela 1',
            'phone' => '+37120000000',
            'payment_method' => 'pay-on-delivery',
            'delivery_method' => 'dhl',
            'm_name' => '',
            'addr_line_2' => '',
            'company_email' => '',
            'company_name' => '',
            'vat_number' => '',
        ])->assertRedirect(route('main'));

        return Order::where('user_id', $user->id)->sole();
    }

    public function test_checkout_stores_the_unit_price_on_each_line(): void
    {
        $product = $this->createProduct(['price' => 120]);

        $order = $this->placeOrder(User::factory()->create(), $product->id, 2);

        $this->assertDatabaseHas('product_quantities', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'unit_price' => 120,
        ]);
    }

    public function test_order_totals_do_not_follow_later_price_changes(): void
    {
        $product = $this->createProduct(['price' => 120]);
        $user = User::factory()->create();
        $order = $this->placeOrder($user, $product->id, 2);

        $product->update(['price' => 999]);

        // 240 + 10% shipping
        $this->assertSame(264.0, $order->fresh()->costBreakdown()['total']);

        Sanctum::actingAs($user);
        $this->getJson("/api/orders/{$order->id}")
            ->assertOk()
            ->assertJsonPath('data.items.0.unit_price', 120)
            ->assertJsonPath('data.items.0.line_total', 240)
            ->assertJsonPath('data.totals.total', 264);
    }

    public function test_the_migration_backfills_existing_lines_from_current_prices(): void
    {
        $product = $this->createProduct(['price' => 75.5]);
        $order = $this->createOrderFor(User::factory()->create(), [$product->id => 2]);

        Artisan::call('migrate:rollback', ['--step' => 1]);
        $this->assertFalse(DB::getSchemaBuilder()->hasColumn('product_quantities', 'unit_price'));

        Artisan::call('migrate');

        $this->assertEquals(75.5, DB::table('product_quantities')->where('order_id', $order->id)->value('unit_price'));
    }
}
