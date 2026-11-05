<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class AuthTokenTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_returns_a_token_that_authenticates_requests(): void
    {
        $user = User::factory()->create(['password' => 'secret123']);

        $token = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'secret123',
            'device_name' => 'phpunit',
        ])
            ->assertCreated()
            ->assertJsonPath('token_type', 'Bearer')
            ->assertJsonPath('user.email', $user->email)
            ->assertJsonMissingPath('user.password')
            ->json('token');

        $this->assertSame('phpunit', PersonalAccessToken::findToken($token)->name);

        $this->withToken($token)
            ->getJson('/api/user')
            ->assertOk()
            ->assertExactJson(['data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone_nr' => $user->phone_nr,
            ]]);
    }

    public function test_login_rejects_wrong_credentials(): void
    {
        $user = User::factory()->create(['password' => 'secret123']);

        $this->postJson('/api/login', ['email' => $user->email, 'password' => 'nope'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('email');

        $this->postJson('/api/login', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email', 'password']);

        $this->assertSame(0, PersonalAccessToken::count());
    }

    public function test_login_is_rate_limited(): void
    {
        $user = User::factory()->create();

        for ($i = 0; $i < 6; $i++) {
            $this->postJson('/api/login', ['email' => $user->email, 'password' => 'nope']);
        }

        $this->postJson('/api/login', ['email' => $user->email, 'password' => 'nope'])
            ->assertTooManyRequests();
    }

    public function test_protected_endpoints_require_a_token(): void
    {
        // No Accept header: the API must still answer 401 JSON, not redirect to /login.
        $this->get('/api/user')->assertUnauthorized()->assertJson(['message' => 'Unauthenticated.']);
        $this->getJson('/api/orders')->assertUnauthorized();
        $this->postJson('/api/logout')->assertUnauthorized();
        $this->withToken('1|not-a-real-token')->getJson('/api/user')->assertUnauthorized();
    }

    public function test_logout_revokes_only_the_current_token(): void
    {
        $user = User::factory()->create();
        $phone = $user->createToken('phone')->plainTextToken;
        $laptop = $user->createToken('laptop')->plainTextToken;

        $this->withToken($phone)->postJson('/api/logout')->assertNoContent();

        $this->assertNull(PersonalAccessToken::findToken($phone));
        $this->assertNotNull(PersonalAccessToken::findToken($laptop));
    }
}
