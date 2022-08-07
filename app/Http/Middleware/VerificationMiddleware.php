<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     if(\Auth::check())
    //     if(!$request->user()->is_email_verified)
    //         return redirect()->route('code_verification');

    //     return $next($request);
    // }
}
