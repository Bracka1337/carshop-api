<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
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

        // Titles are "Brand Model DIAMETERxWIDTH" and descriptions list the fitment.
        foreach (Product::with('brand')->get() as $product) {
            $this->assertMatchesRegularExpression(
                '/^'.preg_quote((string) $product->brand?->title, '/').' [A-Z][a-z]+ '.$product->diameter.'x[\d.]+$/',
                $product->title
            );
            $this->assertStringContainsString('bolt pattern', $product->description);
        }

        // Neighbouring products don't open with the same picture.
        $firstImages = Product::with('images')->orderBy('id')->get()
            ->map(fn (Product $product) => $product->images->sortBy('id')->first()?->img_uri);

        foreach ($firstImages->sliding(2) as $pair) {
            $this->assertNotSame($pair->first(), $pair->last());
        }
    }
}
