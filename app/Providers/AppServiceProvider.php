<?php

namespace App\Providers;

use App\Models\User;
use App\Services\CartService;
use App\Services\ShippingCalculator;
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
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        $this->app->singleton(ShippingCalculator::class, fn () => ShippingCalculator::fromConfig());
        $this->app->singleton(CartService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('layouts.app', 'app-layout');
        Blade::component('admin.layouts.admin', 'admin-layout');
        // needs to be included in the blade file

        Gate::define('admin-access', function (User $user) {
            return $user->role === 'Admin';
        });
    }
}
