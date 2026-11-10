<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_product_page_renders_with_specs_and_meta_tags(): void
    {
        $brand = $this->createBrand('OZ Racing');
        $product = $this->createProduct([
            'title' => 'OZ Racing Apex 18x8.5',
            'description' => 'Flow-formed alloy wheel in gloss black.',
            'diameter' => 18, 'width' => 8.5, 'et' => 45, 'cb' => 66.6,
            'bolt' => 5, 'bolt_diameter' => 112, 'type' => 'Alloy', 'price' => 420,
        ], $brand);

        $this->assertSame('oz-racing-apex-18x8-5', $product->slug);

        $this->get('/products/oz-racing-apex-18x8-5')
            ->assertOk()
            ->assertSee('<title>OZ Racing Apex 18x8.5 · Offset</title>', false)
            ->assertSee('<meta property="og:title" content="OZ Racing Apex 18x8.5">', false)
            ->assertSee('<meta name="description" content="Flow-formed alloy wheel in gloss black.">', false)
            ->assertSee('<link rel="canonical" href="'.route('products.show', $product).'">', false)
            // Breadcrumbs: Catalogue → Brand → Product.
            ->assertSeeInOrder(['Catalogue', 'OZ Racing', 'Apex 18x8.5'])
            ->assertSee('href="'.route('main', ['brand' => $brand->id]).'"', false)
            // The heading is the model alone; the brand sits above it.
            ->assertSee('Apex 18x8.5</h1>', false)
            ->assertSeeInOrder(['Offset (ET, mm)', '45', 'Center bore (mm)', '66.6', 'Bolt pattern (PCD)', '5×112'])
            ->assertSee('€420.00');
    }

    public function test_an_unknown_slug_is_a_404(): void
    {
        $this->createProduct(['title' => 'Real wheel']);

        $this->get('/products/no-such-wheel')->assertNotFound();
    }

    public function test_a_deleted_product_is_a_404(): void
    {
        $product = $this->createProduct(['title' => 'Old wheel']);
        $product->delete();

        $this->get('/products/'.$product->slug)->assertNotFound();
    }

    public function test_similar_wheels_share_diameter_and_bolt_pattern_and_exclude_the_current_one(): void
    {
        $fit = ['diameter' => 18, 'bolt' => 5, 'bolt_diameter' => 112];
        $product = $this->createProduct(['title' => 'Current', ...$fit]);
        $matches = collect(range(1, 5))->map(fn ($i) => $this->createProduct(['title' => "Match {$i}", 'price' => 100 * $i, ...$fit]));
        $this->createProduct(['title' => 'Other diameter', ...$fit, 'diameter' => 17]);
        $this->createProduct(['title' => 'Other pattern', ...$fit, 'bolt_diameter' => 120]);

        $this->get('/products/'.$product->slug)
            ->assertOk()
            ->assertViewHas('similar', function ($similar) use ($product, $matches) {
                $ids = $similar->pluck('id');

                return $ids->count() === 4
                    && ! $ids->contains($product->id)
                    && $ids->diff($matches->pluck('id'))->isEmpty();
            });
    }

    public function test_slugs_are_unique(): void
    {
        $first = $this->createProduct(['title' => 'Borbet LV5']);
        $second = $this->createProduct(['title' => 'Borbet LV5']);
        $first->delete();
        $third = $this->createProduct(['title' => 'Borbet LV5']);

        $this->assertSame(['borbet-lv5', 'borbet-lv5-2', 'borbet-lv5-3'], [$first->slug, $second->slug, $third->slug]);
    }

    public function test_catalogue_cards_link_to_the_product_page(): void
    {
        $product = $this->createProduct(['title' => 'Linked wheel']);

        $this->get('/')->assertSee('href="'.route('products.show', $product).'"', false);
    }

    public function test_the_product_page_adds_the_chosen_quantity(): void
    {
        $product = $this->createProduct();

        $this->from('/products/'.$product->slug)
            ->post("/cart/add/{$product->id}", ['quantity' => 4])
            ->assertRedirect('/products/'.$product->slug);

        $this->assertSame(4, session("cart.{$product->id}.quantity"));

        $this->post("/cart/add/{$product->id}", ['quantity' => 0])->assertSessionHasErrors('quantity');
    }
}
