<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {

            if (Auth::check() && Auth::user()->role == 'user'){
                return redirect('/dashboard');
            } if (Auth::check() && Auth::user()->role == 'instructor'){
                return redirect('/instructor/dashboard');
            } if (Auth::check() && Auth::user()->role == 'admin'){
                return redirect('/admin/dashboard');
            }

        }

        return $next($request);
    }
}
