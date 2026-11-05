<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogueTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_shop_lists_products(): void
    {
        $product = $this->createProduct(['description' => 'Shiny alloy rim']);

        $this->get('/')
            ->assertOk()
            ->assertViewHas('initialProducts', fn ($page) => $page->total() === 1
                && $page->first()->is($product));
    }

    public function test_products_can_be_filtered(): void
    {
        $brand = $this->createBrand('Borbet');
        $small = $this->createProduct(['diameter' => 16, 'type' => 'Steel', 'price' => 80], $brand);
        $large = $this->createProduct(['diameter' => 19, 'type' => 'Alloy', 'price' => 900], $brand);

        $this->get('/?diameter=19')
            ->assertViewHas('initialProducts', fn ($page) => $page->pluck('id')->all() === [$large->id]);

        $this->get('/?type=Steel')
            ->assertViewHas('initialProducts', fn ($page) => $page->pluck('id')->all() === [$small->id]);

        $this->get('/?price_from=100&price_to=1000')
            ->assertViewHas('initialProducts', fn ($page) => $page->pluck('id')->all() === [$large->id]);

        $this->get('/?order=price_desc')
            ->assertViewHas('initialProducts', fn ($page) => $page->pluck('id')->all() === [$large->id, $small->id]);
    }

    public function test_products_can_be_filtered_by_brand(): void
    {
        $oz = $this->createProduct([], $this->createBrand('OZ Racing'));
        $this->createProduct([], $this->createBrand('Ronal'));

        $this->get('/?brand='.$oz->brand_id)
            ->assertViewHas('initialProducts', fn ($page) => $page->pluck('id')->all() === [$oz->id]);
    }

    public function test_invalid_filters_are_rejected(): void
    {
        $this->createProduct();

        $this->from('/')->get('/?order=random&price_from=-5')
            ->assertRedirect('/')
            ->assertSessionHasErrors(['order', 'price_from']);
    }

    public function test_about_page_renders(): void
    {
        $this->get('/aboutus')->assertOk();
    }
}
