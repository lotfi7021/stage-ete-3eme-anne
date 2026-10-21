<?php

namespace App\Providers;

use App\Models\Admin;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\CommandeM::class => \App\Policies\CommandePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Autorisation par rôle : Gate::allows('role', 'admin') ou Gate::allows('role', ['admin', 'client'])
        Gate::define('role', function (?Admin $admin, ...$roles): bool {
            return $admin !== null && in_array($admin->role, $roles, true);
        });
    }
}
