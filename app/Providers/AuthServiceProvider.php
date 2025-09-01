<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Define simple gates based on user role
        Gate::define('isAdmin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('isGuru', function ($user) {
            return $user->role === 'guru';
        });

        Gate::define('isMurid', function ($user) {
            return $user->role === 'murid';
        });
    }
}
