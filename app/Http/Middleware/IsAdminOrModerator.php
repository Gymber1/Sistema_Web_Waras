<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminOrModerator
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect('/');
        }

        $user = auth()->user();
        
        // Verifica si es admin global o tiene rol de moderador
        if ($user->is_admin_global ?? false) {
            return $next($request);
        }

        // Si no es admin, verifica si es moderador de algún módulo
        if ($user->moderates()->exists()) {
            return $next($request);
        }

        return redirect('/')->with('error', 'No tienes acceso al panel administrativo');
    }
}
