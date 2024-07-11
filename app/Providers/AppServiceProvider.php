<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('layouts.app', 'app-layout');
        Blade::component('admin.layouts.admin','admin-layout');
        //needs to be included in the blade file

        Gate::define('admin-access', function (User $user) {
            return $user->role === 'Admin';
        });
    }
}
