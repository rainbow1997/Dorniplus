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
    private function httpsSanitize(string $url): string|bool
    {
        if (!str_contains($url, 'https'))
            return str_replace("http", "https", $url);
        return true;// if the request is based on https we don't need to change it!
    }

    private function basedOnHttps(Request $request): bool
    {
        if ($request->secure())
            return true;
        return false;

    }

    private function isInActivationPage(Request $request): bool
    {
        if ($this->basedOnHttps($request))
            return in_array($request->url(), getAuthCheckingUrls());
        return in_array($this->httpsSanitize($request->url()), getAuthCheckingUrls());//to convert http to https

    }

    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::check())
            if (!$request->user()->is_email_verified && !$this->isInActivationPage($request)) {
                return Redirect::route(app()->getLocale() . '.code_verification');
            } else
                return $next($request);
        return abort(403);
    }

    protected function redirectTo($request)
    {

        if (!$request->expectsJson()) {
            return route(app()->getLocale() . '.login');
        }
    }

}
