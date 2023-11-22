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
    public function handle(Request $request, Closure $next, ... $roles)
    {
        if (! Auth::check()) {

            return redirect()->route('login');
        }
        if (Auth::user()->type == '0') {
            return redirect('reader');

        }
        if (Auth::user()->type == '1') {
            return redirect('admin');
        }
        if (Auth::user()->type == '2') {
            return redirect('moderator');
        }
        if (Auth::user()->type == '3') {
            return redirect('writer');
        }
        if (Auth::user()->type == '4') {
            return $next($request);
        }
    }
}
