<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;

class LangChecker
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    private function hasLanguageSession(Request $request): bool
    {
        if ($request->session()->has(config('app.language_session_name')))
            return true;
        return false;
    }

    private function getLanguageSession(Request $request): string
    {
        return $request->session()->get('language');
    }

    private function setLanguageSession(Request $request): bool
    {
        try {
            $request->session()->put('language', config('app.locale'));
            return true;
        } catch (\Exception $e) {
            Log::critical($e);
        }
    }

    private function checkLanguage(Request $request): string|bool
    {
        if (!$this->hasLanguageSession($request))
            $this->setLanguageSession($request);
        try {
            App::setLocale($this->getLanguageSession($request));
            return true;
        } catch (\Exception $e) {
            Log::critical($e);
            return false;
        }
    }

    public function handle(Request $request, Closure $next)
    {

        if($this->checkLanguage($request))
            return $next($request);
    }
}
