<?php

namespace Tests\Feature\Web;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_and_register_pages_render(): void
    {
        $this->get('/login')->assertOk();
        $this->get('/register')->assertOk();
    }

    public function test_a_visitor_can_register(): void
    {
        $this->post('/register', [
            'name' => 'Jane',
            'email' => 'jane@example.com',
            'phone_nr' => '+37120000000',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ])->assertRedirect(route('login'));

        $user = User::where('email', 'jane@example.com')->firstOrFail();
        $this->assertSame('User', $user->role);
        $this->assertTrue(Hash::check('secret123', $user->password));
    }

    public function test_registration_is_validated(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $this->from('/register')->post('/register', [
            'name' => 'Jane',
            'email' => 'taken@example.com',
            'phone_nr' => '123',
            'password' => 'secret123',
            'password_confirmation' => 'different',
        ])->assertRedirect('/register');

        $this->assertSame(1, User::count());
        $this->assertGuest();
    }

    public function test_a_user_can_log_in(): void
    {
        $user = User::factory()->create(['password' => 'secret123']);

        $this->post('/login', ['email' => $user->email, 'password' => 'secret123'])
            ->assertRedirect('/profile');

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_regenerates_the_session_id(): void
    {
        $user = User::factory()->create(['password' => 'secret123']);

        $this->startSession();
        $before = session()->getId();

        $this->post('/login', ['email' => $user->email, 'password' => 'secret123']);

        $this->assertNotSame($before, session()->getId());
    }

    public function test_wrong_credentials_are_rejected(): void
    {
        $user = User::factory()->create(['password' => 'secret123']);

        $this->from('/login')
            ->post('/login', ['email' => $user->email, 'password' => 'wrong'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_logged_in_users_are_sent_away_from_guest_pages(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/login')
            ->assertRedirect('/profile');
    }

    public function test_a_user_can_log_out(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/logout')
            ->assertRedirect(route('main'));

        $this->assertGuest();
    }

    public function test_logging_out_over_get_is_rejected(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/logout')
            ->assertMethodNotAllowed();

        $this->assertAuthenticated();
    }

    public function test_the_log_out_button_posts_a_form(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/aboutus')
            ->assertSee('action="'.route('logout').'" method="POST"', false);
    }

    public function test_registration_errors_are_reported_per_field(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $this->from('/register')->post('/register', [
            'name' => 'Jane',
            'email' => 'taken@example.com',
            'phone_nr' => '123',
            'password' => 'secret123',
            'password_confirmation' => 'different',
        ])->assertSessionHasErrors(['email', 'phone_nr', 'password'])
            ->assertSessionDoesntHaveErrors('default');
    }

    public function test_a_phone_number_can_only_be_registered_once(): void
    {
        User::factory()->create(['phone_nr' => '+37120000000']);

        // phone_nr has a unique index; this used to be a 500.
        $this->from('/register')->post('/register', [
            'name' => 'Jane',
            'email' => 'jane@example.com',
            'phone_nr' => '+37120000000',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ])->assertRedirect('/register')
            ->assertSessionHasErrors('phone_nr');

        $this->assertSame(1, User::count());
    }

    public function test_two_customers_may_share_a_name(): void
    {
        User::factory()->create(['name' => 'Jane']);

        // users.name had a unique index, so this used to be a 500.
        $this->post('/register', [
            'name' => 'Jane',
            'email' => 'another.jane@example.com',
            'phone_nr' => '+37120000001',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ])->assertRedirect(route('login'));

        $this->assertSame(2, User::where('name', 'Jane')->count());
    }
}
