<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::check()) {

            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect('/admin/dashboard');
            }

            if ($role === 'verifikator') {
                return redirect('/verifikator/dashboard');
            }

            return redirect('/user/dashboard');
        }

        return $next($request);
    }
}