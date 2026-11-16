<?php

namespace Tests\Feature\Web;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
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

    #[DataProvider('invalidQuantities')]
    public function test_an_invalid_quantity_is_rejected_and_the_cart_is_unchanged(string $quantity): void
    {
        $product = $this->createProduct(['price' => 50]);
        $this->post("/cart/add/{$product->id}");

        $this->postJson("/cart/update/{$product->id}/{$quantity}")
            ->assertUnprocessable()
            ->assertJsonValidationErrors('quantity');

        $this->post("/cart/update/{$product->id}/{$quantity}")->assertSessionHasErrors('quantity');

        $this->assertSame(1, session("cart.{$product->id}.quantity"));
        $this->assertEquals(50, session('cart.total'));
    }

    /** @return array<string, array{string}> */
    public static function invalidQuantities(): array
    {
        return [
            'negative' => ['-5'],
            'fraction' => ['1.5'],
            'over the limit' => ['100'],
            'not a number' => ['abc'],
        ];
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

    public function test_adding_with_fetch_returns_the_count_and_the_drawer(): void
    {
        $product = $this->createProduct(['title' => 'Borbet Apex 18x8']);
        $this->post("/cart/add/{$product->id}");

        $response = $this->postJson("/cart/add/{$product->id}")
            ->assertOk()
            ->assertJson(['count' => 2]);

        $this->assertStringContainsString('Apex 18x8', $response->json('drawer'));
        $this->assertStringContainsString('id="quantity-'.$product->id.'"', $response->json('drawer'));
    }

    public function test_pages_expose_the_csrf_token_for_the_cart_drawer(): void
    {
        // The drawer's fetch() reads this tag; without it every +/-/remove click threw.
        $this->get('/')->assertSee('<meta name="csrf-token" content="', false);
    }

    public function test_an_out_of_stock_product_cannot_be_added(): void
    {
        $product = $this->createProduct(['stock' => 0]);

        $this->postJson("/cart/add/{$product->id}")->assertUnprocessable()->assertJsonPath('message', fn ($m) => str_contains($m, 'out of stock'));
        $this->from('/')->post("/cart/add/{$product->id}")->assertRedirect('/')->assertSessionHas('error');

        $this->assertNull(session("cart.{$product->id}"));
    }

    public function test_the_cart_cannot_hold_more_than_is_in_stock(): void
    {
        $product = $this->createProduct(['stock' => 3]);
        $this->post("/cart/add/{$product->id}", ['quantity' => 2]);

        $this->postJson("/cart/add/{$product->id}", ['quantity' => 2])->assertUnprocessable();
        $this->postJson("/cart/update/{$product->id}/4")->assertUnprocessable()->assertJsonPath('quantity', 2);
        $this->assertSame(2, session("cart.{$product->id}.quantity"));

        $this->postJson("/cart/update/{$product->id}/3")->assertOk();
        $this->assertSame(3, (int) session("cart.{$product->id}.quantity"));
    }

    public function test_a_cart_over_the_current_stock_can_still_be_lowered(): void
    {
        $product = $this->createProduct(['stock' => 5]);
        $this->post("/cart/add/{$product->id}", ['quantity' => 5]);
        $product->update(['stock' => 2]);

        $this->get('/')->assertSee('Only 2 left. Lower the quantity to check out.');
        $this->postJson("/cart/update/{$product->id}/4")->assertOk();
        $this->assertSame(4, (int) session("cart.{$product->id}.quantity"));
    }
}
