<?php

namespace Tests\Feature\Web;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_product_can_be_added_to_the_cart(): void
    {
        $product = $this->createProduct(['price' => 120]);

        $this->from('/')->post("/cart/add/{$product->id}")
            ->assertRedirect('/')
            ->assertSessionHas("cart.{$product->id}.quantity", 1)
            ->assertSessionHas('cart.total', 120);
    }

    public function test_adding_the_same_product_twice_increases_quantity(): void
    {
        $product = $this->createProduct(['price' => 120]);

        $this->post("/cart/add/{$product->id}");
        $this->post("/cart/add/{$product->id}")
            ->assertSessionHas("cart.{$product->id}.quantity", 2)
            ->assertSessionHas('cart.total', 240);
    }

    public function test_adding_an_unknown_product_is_a_404(): void
    {
        $this->post('/cart/add/999')->assertNotFound();
    }

    public function test_cart_quantity_can_be_updated(): void
    {
        $product = $this->createProduct(['price' => 50]);
        $this->post("/cart/add/{$product->id}");

        $this->post("/cart/update/{$product->id}/4")
            ->assertSessionHas("cart.{$product->id}.quantity", 4)
            ->assertSessionHas('cart.total', 200);
    }

    public function test_setting_quantity_to_zero_removes_the_item(): void
    {
        $product = $this->createProduct();
        $this->post("/cart/add/{$product->id}");

        $this->post("/cart/update/{$product->id}/0")
            ->assertSessionMissing("cart.{$product->id}");
    }

    public function test_an_item_can_be_removed_from_the_cart(): void
    {
        $product = $this->createProduct();
        $this->post("/cart/add/{$product->id}");

        $this->post("/cart/remove/{$product->id}")
            ->assertOk()
            ->assertJson(['message' => 'Product removed successfully!'])
            ->assertSessionMissing("cart.{$product->id}");
    }

    public function test_removing_from_an_empty_cart_is_a_404(): void
    {
        $this->post('/cart/remove/1')->assertNotFound();
    }

    public function test_a_product_without_images_can_be_added_to_the_cart(): void
    {
        $product = Product::factory()->create(['brand_id' => $this->createBrand()->id]);

        $this->post("/cart/add/{$product->id}")->assertRedirect();

        $this->assertNull(session("cart.{$product->id}.image"));
        $this->assertSame(1, session("cart.{$product->id}.quantity"));
    }

    public function test_adding_to_the_cart_over_get_is_rejected(): void
    {
        $product = $this->createProduct();

        $this->get("/cart/add/{$product->id}")->assertMethodNotAllowed();
        $this->get("/products/{$product->id}")->assertNotFound();

        $this->assertNull(session('cart'));
    }

    public function test_the_catalogue_adds_to_the_cart_with_a_post_form(): void
    {
        $product = $this->createProduct();

        $this->get('/')
            ->assertOk()
            ->assertSee('action="'.route('cart.add', $product->id).'" method="POST"', false)
            ->assertSee('name="_token"', false);
    }

    public function test_the_cart_drawer_gets_json_when_it_asks_for_it(): void
    {
        $product = $this->createProduct(['price' => 50]);
        $this->post("/cart/add/{$product->id}");

        // The drawer's fetch() parses JSON; it used to get a redirect to an HTML page.
        $this->postJson("/cart/update/{$product->id}/3")
            ->assertOk()
            ->assertJson(['message' => 'Cart updated successfully!', 'total' => 150]);

        $this->postJson('/cart/update/999/1')->assertNotFound()->assertJson(['message' => 'Product not found in cart!']);
    }

    public function test_pages_expose_the_csrf_token_for_the_cart_drawer(): void
    {
        // The drawer's fetch() reads this tag; without it every +/-/remove click threw.
        $this->get('/')->assertSee('<meta name="csrf-token" content="', false);
    }
}
