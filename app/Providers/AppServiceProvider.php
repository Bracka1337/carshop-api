<?php

namespace App\Providers;

use App\Models\User;
use App\Services\CartService;
use App\Services\ShippingCalculator;
use App\Services\TotalsCalculator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ShippingCalculator::class, fn () => ShippingCalculator::fromConfig());
        $this->app->singleton(TotalsCalculator::class, fn ($app) => TotalsCalculator::fromConfig($app->make(ShippingCalculator::class)));
        $this->app->singleton(CartService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! $this->app->environment('local')) {
            URL::forceScheme('https');
        }

        // Lazy loading, silently discarded attributes and missing attributes
        // throw outside production, so N+1 queries show up in tests.
        Model::shouldBeStrict(! $this->app->isProduction());

        Blade::component('layouts.app', 'app-layout');
        Blade::component('admin.layouts.admin', 'admin-layout');
        // needs to be included in the blade file

        // @money($amount) prints the amount in the shop currency.
        Blade::directive('money', fn (string $expression) => "<?php echo e(\App\Support\Money::format($expression)); ?>");

        Gate::define('admin-access', function (User $user) {
            return $user->role === 'Admin';
        });
    }
}
