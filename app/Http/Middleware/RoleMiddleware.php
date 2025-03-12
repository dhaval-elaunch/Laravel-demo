<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // dd(Auth::user());
        if (!Auth::check()) {
            return redirect('/admin/login');
        }

        // if (!Auth::user()->hasRole($role)) {
        //     abort(403, 'Unauthorized action.');
        // }

        return $next($request);
    }
}
