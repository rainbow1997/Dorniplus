<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|null
     */
    private function httpsSanitize(string $url)
    {
        return str_replace("http","https",$url);
    }
    public function handle($request, Closure $next, ...$guards)
    {
   
        if (Auth::check())
            if (!$request->user()->is_email_verified && !in_array($this->httpsSanitize($request->url()),getAuthCheckingUrls()) ) {
                return Redirect::route('code_verification');
            } else
                return $next($request);
        return abort(403);
    }

    protected function redirectTo($request)
    {

        if (!$request->expectsJson()) {
            return route('login');
        }
    }

}
