<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is logged in
        if (!session('logged_in')) {
            return redirect('/login')->with('error', 'Please login to access this page.');
        }

        // Check if user has the required role
        if (session('role') !== $role) {
            // Redirect based on current role
            if (session('role') === 'admin') {
                return redirect('/admin/dashboard')->with('error', 'You do not have permission to access this page.');
            }
            return redirect('/user/dashboard')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
