<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. If not authenticated, redirect to login page with error flash
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }

        $user = $request->user();

        // 2. Check if user has one of the allowed roles
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        // 3. User is logged in but does not have the required role -> auto redirect to their assigned role dashboard
        $targetRoute = $user->getDashboardRoute();

        return redirect($targetRoute)->with('warning', 'Akses ditolak. Anda telah dialihkan ke dashboard sesuai role Anda (' . ($user->role->nama ?? 'Role') . ').');
    }
}
