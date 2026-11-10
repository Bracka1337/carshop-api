<?php

namespace Tests\Feature\Web;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Shop pages must render when a product has no images or its brand was removed.
 */
class MissingDataTest extends TestCase
{
    use RefreshDatabase;

    private function productWithoutImages(): Product
    {
        return Product::factory()->create(['brand_id' => $this->createBrand('Bare')->id, 'title' => 'Bare wheel']);
    }

    public function test_the_catalogue_renders_a_product_without_images(): void
    {
        $this->productWithoutImages();

        $this->get('/')->assertOk()->assertSeeText('Bare wheel');
    }

    public function test_the_catalogue_renders_a_product_whose_brand_was_deleted(): void
    {
        $product = $this->createProduct(['title' => 'Orphan wheel']);
        $product->brand->delete();

        $this->get('/')->assertOk()->assertSee('Orphan wheel');
    }

    public function test_order_pages_render_lines_for_products_without_images(): void
    {
        $user = User::factory()->create();
        $order = $this->createOrderFor($user, [$this->productWithoutImages()->id => 1]);
        $this->actingAs($user);

        $this->get('/profile')->assertOk()->assertSee('Order #'.$order->id);
        $this->get("/profile/orderdetails/{$order->id}")->assertOk()->assertSee('Bare wheel');
    }

    public function test_the_cart_renders_an_item_without_an_image(): void
    {
        $product = $this->productWithoutImages();
        $this->post("/cart/add/{$product->id}");

        $this->get('/')->assertOk()->assertDontSee('src="'.asset('/storage/').'"', false);
    }

    public function test_past_orders_still_show_a_product_that_was_deleted(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct(['title' => 'Retired wheel']);
        $order = $this->createOrderFor($user, [$product->id => 1]);
        $product->delete();

        $this->actingAs($user);
        $this->get('/profile')->assertOk();
        $this->get("/profile/orderdetails/{$order->id}")->assertOk()->assertSee('Retired wheel');
    }
}
