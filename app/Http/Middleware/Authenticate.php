<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request,Closure $next,...$guards)
    {
        if(\Auth::check())
            if(!$request->user()->is_email_verified) {

                return redirect()->route('code_verification');
            }
            else
                return $next($request);
        return abort(403);
    }
    protected function redirectTo($request)
    {

        if (! $request->expectsJson()) {
            return route('login');
        }
    }

}
