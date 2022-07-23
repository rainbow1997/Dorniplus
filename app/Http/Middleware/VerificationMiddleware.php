<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     if(\Auth::check())
    //     if(!$request->user()->is_email_verified)
    //         return redirect()->route('code_verification');

    //     return $next($request);
    // }
}
