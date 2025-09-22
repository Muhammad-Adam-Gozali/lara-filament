<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Spatie\Permission\Models\Permission;

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
        Filament::serving(function () {
            if (auth()->check() && auth()->user()->email === 'superadmin@example.com') {
                $user = auth()->user();
                $user->syncPermissions(Permission::all());
            }
        });
    }
}
