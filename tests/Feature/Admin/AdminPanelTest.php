<?php

namespace Tests\Feature\Admin;

use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\StatsRevenue;
use App\Models\Product;
use App\Models\User;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_admin_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/login')->assertOk();
    }

    public function test_regular_users_cannot_access_the_panel(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_admin_sees_the_dashboard_with_stats(): void
    {
        $admin = $this->createAdmin();
        $product = $this->createProduct(['price' => 150]);
        $this->createOrderFor($admin, [$product->id => 2])->update(['status' => 'Delivered']);

        $this->actingAs($admin)->get('/admin')->assertOk();

        // Widgets are lazy-loaded, so render them directly.
        Livewire::test(StatsOverview::class)
            ->assertSee('Users Registered')
            ->assertSee('Orders Created');
        Livewire::test(StatsRevenue::class)
            ->assertSee('Revenue')
            ->assertSee('$300');
    }

    public static function resourcePages(): array
    {
        return [
            'brands' => ['brands', true],
            'images' => ['images', true],
            'orders' => ['orders', true],
            'payments' => ['payments', false], // payments are never created by hand
            'products' => ['products', true],
            'users' => ['users', true],
        ];
    }

    #[DataProvider('resourcePages')]
    public function test_admin_can_open_every_resource_page(string $slug, bool $hasCreatePage): void
    {
        $admin = $this->createAdmin();
        $product = $this->createProduct();
        $order = $this->createOrderFor($admin, [$product->id => 2]);

        $records = [
            'brands' => $product->brand_id,
            'images' => $product->images()->first()->id,
            'orders' => $order->id,
            'payments' => $order->payment_id,
            'products' => $product->id,
            'users' => $admin->id,
        ];

        $this->actingAs($admin);

        $this->get("/admin/{$slug}")->assertOk();
        $this->get("/admin/{$slug}/create")->assertStatus($hasCreatePage ? 200 : 404);
        $this->get("/admin/{$slug}/{$records[$slug]}/edit")->assertOk();
    }

    public function test_admin_can_create_a_product(): void
    {
        $brand = $this->createBrand('OZ Racing');
        $this->actingAs($this->createAdmin());

        Livewire::test(CreateProduct::class)
            ->fillForm([
                'title' => 'OZ Racing Ultraleggera',
                'description' => 'Lightweight alloy wheel',
                'diameter' => '18',
                'width' => '8',
                'et' => '45',
                'cb' => '57.1',
                'bolt' => '5',
                'bolt_diameter' => '112',
                'type' => 'Alloy',
                'price' => 420,
                'brand_id' => $brand->id,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('products', [
            'title' => 'OZ Racing Ultraleggera',
            'diameter' => 18,
            'brand_id' => $brand->id,
        ]);
    }

    public function test_product_form_validates_required_fields(): void
    {
        $this->actingAs($this->createAdmin());

        Livewire::test(CreateProduct::class)
            ->fillForm(['title' => ''])
            ->call('create')
            ->assertHasFormErrors(['title' => 'required', 'price' => 'required', 'brand_id' => 'required']);
    }

    public function test_admin_can_update_a_product_with_decimal_specs(): void
    {
        // Stored doubles come back as 114.3 / 7.5 / 66.1, not "114.30" etc.
        $product = $this->createProduct([
            'price' => 100,
            'width' => 7.50,
            'cb' => 66.10,
            'bolt_diameter' => 114.30,
        ]);
        $this->actingAs($this->createAdmin());

        Livewire::test(EditProduct::class, ['record' => $product->getRouteKey()])
            ->assertSchemaStateSet(['title' => $product->title])
            ->fillForm(['price' => 199])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertEquals(199, $product->fresh()->price);
    }

    public function test_admin_can_bulk_delete_products(): void
    {
        $product = $this->createProduct();
        $this->actingAs($this->createAdmin());

        Livewire::test(ListProducts::class)
            ->assertCanSeeTableRecords([$product])
            ->callTableBulkAction(DeleteBulkAction::class, [$product]);

        $this->assertSoftDeleted($product);
        $this->assertSame(0, Product::count());
    }
}
