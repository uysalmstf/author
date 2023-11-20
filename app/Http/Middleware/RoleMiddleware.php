<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {

            return redirect()->route('login');
        }

        if (Auth::user()->role == 0) {
            return redirect()->route('reader');

        }
        if (Auth::user()->role == 1) {
            return redirect()->route('admin');
        }
        if (Auth::user()->role == 2) {
            return redirect()->route('moderator');
        }
        if (Auth::user()->role == 3) {
            return redirect()->route('writer');
        }
        if (Auth::user()->role == 4) {
            return $next($request);
        }
    }
}
