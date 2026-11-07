<?php

namespace Tests\Feature\Admin;

use App\Enums\PaymentStatus;
use App\Filament\Resources\BrandResource\Pages\CreateBrand;
use App\Filament\Resources\ImageResource\Pages\CreateImage;
use App\Filament\Resources\OrderResource\Pages\EditOrder;
use App\Filament\Resources\OrderResource\RelationManagers\DeliveryDetailsRelationManager;
use App\Filament\Resources\OrderResource\RelationManagers\OrderLinesRelationManager;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminFormsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs($this->createAdmin());
    }

    public function test_an_order_line_stores_the_chosen_product(): void
    {
        $order = $this->createOrderFor(User::factory()->create(), [$this->createProduct()->id => 1]);
        $this->createProduct(['title' => 'Filler'], $this->createBrand('Filler'));
        $chosen = $this->createProduct(['price' => 250], $this->createBrand('OZ'));

        Livewire::test(OrderLinesRelationManager::class, ['ownerRecord' => $order, 'pageClass' => EditOrder::class])
            ->callTableAction('create', data: ['product_id' => $chosen->id, 'quantity' => 2])
            ->assertHasNoTableActionErrors();

        $this->assertDatabaseHas('product_quantities', [
            'order_id' => $order->id,
            'product_id' => $chosen->id,
            'quantity' => 2,
            'unit_price' => 250,
        ]);
    }

    public function test_an_order_line_needs_a_positive_quantity(): void
    {
        $order = $this->createOrderFor(User::factory()->create(), [$this->createProduct()->id => 1]);

        Livewire::test(OrderLinesRelationManager::class, ['ownerRecord' => $order, 'pageClass' => EditOrder::class])
            ->callTableAction('create', data: ['product_id' => $order->lines()->value('product_id'), 'quantity' => 'abc'])
            ->assertHasTableActionErrors(['quantity']);
    }

    public function test_editing_an_order_saves_its_payment_status(): void
    {
        $order = $this->createOrderFor(User::factory()->create(), [$this->createProduct()->id => 1]);

        Livewire::test(EditOrder::class, ['record' => $order->getRouteKey()])
            ->fillForm(['payment.status' => PaymentStatus::Refunded->value])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame(PaymentStatus::Refunded, $order->payment->fresh()->status);
    }

    public function test_delivery_details_accept_the_values_checkout_stores(): void
    {
        $order = $this->createOrderFor(User::factory()->create(), [$this->createProduct()->id => 1]);
        $details = $order->deliveryDetails;

        Livewire::test(DeliveryDetailsRelationManager::class, ['ownerRecord' => $order, 'pageClass' => EditOrder::class])
            ->callTableAction('edit', $details, data: ['payment_method' => 'pay-on-delivery', 'delivery_method' => 'express'])
            ->assertHasNoTableActionErrors();

        $this->assertSame('pay-on-delivery', $details->fresh()->payment_method);
        $this->assertSame('express', $details->fresh()->delivery_method);
    }

    public function test_a_user_created_in_the_admin_gets_a_role_the_shop_knows(): void
    {
        Livewire::test(CreateUser::class)
            ->fillForm(['name' => 'Jane', 'email' => 'jane@example.com', 'password' => 'secret123', 'role' => 'User'])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame('User', User::where('email', 'jane@example.com')->value('role'));
    }

    public function test_required_admin_fields_are_validated(): void
    {
        Livewire::test(CreateBrand::class)
            ->fillForm(['title' => ''])
            ->call('create')
            ->assertHasFormErrors(['title' => 'required']);

        Livewire::test(CreateImage::class)
            ->fillForm(['product_id' => null])
            ->call('create')
            ->assertHasFormErrors(['product_id' => 'required']);
    }

    public function test_admin_user_form_reports_a_taken_email_or_phone(): void
    {
        User::factory()->create(['email' => 'taken@example.com', 'phone_nr' => '+37120000000']);

        Livewire::test(CreateUser::class)
            ->fillForm(['name' => 'Jane', 'email' => 'taken@example.com', 'phone_nr' => '+37120000000', 'password' => 'secret123', 'role' => 'User'])
            ->call('create')
            ->assertHasFormErrors(['email' => 'unique', 'phone_nr' => 'unique']);
    }
}
