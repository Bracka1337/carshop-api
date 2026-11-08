<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_are_listed_publicly_with_pagination(): void
    {
        $product = $this->createProduct([
            'price' => 420,
            'diameter' => 18,
            'width' => 8.5,
            'bolt' => 5,
            'bolt_diameter' => 114.3,
        ], $this->createBrand('OZ Racing'));

        $this->getJson('/api/products')
            ->assertOk()
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.id', $product->id)
            ->assertJsonPath('data.0.brand.title', 'OZ Racing')
            ->assertJsonPath('data.0.price', 420)
            ->assertJsonPath('data.0.currency', 'EUR')
            ->assertJsonPath('data.0.specs.diameter', 18)
            ->assertJsonPath('data.0.specs.width', 8.5)
            ->assertJsonPath('data.0.specs.bolt_diameter', 114.3)
            ->assertJsonPath('data.0.images.0', asset('storage/images/Borbet.webp'))
            ->assertJsonStructure(['data', 'links', 'meta' => ['current_page', 'last_page', 'per_page']]);
    }

    public function test_products_use_the_catalogue_filters(): void
    {
        $brand = $this->createBrand();
        $cheap = $this->createProduct(['diameter' => 16, 'price' => 80], $brand);
        $pricey = $this->createProduct(['diameter' => 19, 'price' => 900], $brand);

        $this->getJson('/api/products?diameter=19')
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $pricey->id);

        $this->getJson('/api/products?order=price_asc')
            ->assertJsonPath('data.0.id', $cheap->id)
            ->assertJsonPath('data.1.id', $pricey->id);
    }

    public function test_invalid_filters_return_422(): void
    {
        $this->get('/api/products?order=random')
            ->assertUnprocessable()
            ->assertJsonValidationErrors('order');
    }

    public function test_a_single_product_can_be_fetched(): void
    {
        $product = $this->createProduct();

        $this->getJson("/api/products/{$product->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $product->id)
            ->assertJsonPath('data.title', $product->title);
    }

    public function test_missing_or_deleted_products_return_404(): void
    {
        $product = $this->createProduct();
        $product->delete();

        $this->getJson("/api/products/{$product->id}")->assertNotFound();
        $this->get('/api/products/999')->assertNotFound()->assertJsonStructure(['message']);
    }
}
