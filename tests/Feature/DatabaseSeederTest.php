<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderLine;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_demo_data_seeds(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertTrue(User::where('email', 'admin@eastsquad.com')->where('role', 'Admin')->exists());
        $this->assertTrue(User::where('email', 'default@eastsquad.com')->exists());
        $this->assertGreaterThan(0, Order::count());
        $this->assertSame(Order::count() * 3, OrderLine::count());
        $this->assertSame(0, OrderLine::whereNull('unit_price')->count());
    }
}
