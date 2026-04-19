<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
        // Permite entrar al panel: admin global O moderador de al menos un módulo
        Gate::define('access-admin', function (User $user) {
            return $user->is_admin_global || $user->modules()->exists();
        });

        // Solo admin global (para Usuarios y Configurar Web)
        Gate::define('admin-only', function (User $user) {
            return $user->is_admin_global === true;
        });
    }
}
