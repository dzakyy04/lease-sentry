<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('super-admin', function (User $user) {
            return $user->role == 'Super Admin';
        });

        Gate::define('admin-pkn', function (User $user) {
            return $user->role == 'Admin Pkn';
        });

        Gate::define('admin-penilai', function (User $user) {
            return $user->role == 'Admin Penilai';
        });
        Gate::define('admin-pkn-super-admin', function (User $user) {
            return $user->role == 'Admin Pkn' || $user->role == 'Super Admin';
        });
    }
}
