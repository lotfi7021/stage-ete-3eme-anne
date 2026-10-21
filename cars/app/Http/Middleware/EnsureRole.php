<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Autorise uniquement les rôles passés en paramètre (ex: role:admin,livreur).
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $admin = Auth::guard('admin')->user();

        if (! $admin || ! in_array($admin->role, $roles, true)) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
