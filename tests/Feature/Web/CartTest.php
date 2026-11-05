<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_product_can_be_added_to_the_cart(): void
    {
        $product = $this->createProduct(['price' => 120]);

        $this->from('/')->get("/products/{$product->id}")
            ->assertRedirect('/')
            ->assertSessionHas("cart.{$product->id}.quantity", 1)
            ->assertSessionHas('cart.total', 120);
    }

    public function test_adding_the_same_product_twice_increases_quantity(): void
    {
        $product = $this->createProduct(['price' => 120]);

        $this->get("/products/{$product->id}");
        $this->get("/products/{$product->id}")
            ->assertSessionHas("cart.{$product->id}.quantity", 2)
            ->assertSessionHas('cart.total', 240);
    }

    public function test_adding_an_unknown_product_is_a_404(): void
    {
        $this->get('/products/999')->assertNotFound();
    }

    public function test_cart_quantity_can_be_updated(): void
    {
        $product = $this->createProduct(['price' => 50]);
        $this->get("/products/{$product->id}");

        $this->post("/cart/update/{$product->id}/4")
            ->assertSessionHas("cart.{$product->id}.quantity", 4)
            ->assertSessionHas('cart.total', 200);
    }

    public function test_setting_quantity_to_zero_removes_the_item(): void
    {
        $product = $this->createProduct();
        $this->get("/products/{$product->id}");

        $this->post("/cart/update/{$product->id}/0")
            ->assertSessionMissing("cart.{$product->id}");
    }

    public function test_an_item_can_be_removed_from_the_cart(): void
    {
        $product = $this->createProduct();
        $this->get("/products/{$product->id}");

        $this->post("/cart/remove/{$product->id}")
            ->assertOk()
            ->assertJson(['message' => 'Product removed successfully!'])
            ->assertSessionMissing("cart.{$product->id}");
    }

    public function test_removing_from_an_empty_cart_is_a_404(): void
    {
        $this->post('/cart/remove/1')->assertNotFound();
    }
}
