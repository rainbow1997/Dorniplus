<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class LangChecker
{
    private string $languageParamInUrl;

    public function __construct()
    {
        $this->languageParamInUrl = request()->segment(1) ?? '';
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->checkLanguage($request))
            return $next($request);
    }

    private function checkLanguage(Request $request): string|bool
    {
        if (!$this->hasLanguageSession($request))
            $this->setLanguageByDefault($request);

        if ($this->hasLanguageInUrl())
            $this->setLanguageByUrl($request);

        try {
            App::setLocale($this->getLanguageSession($request));
            return true;
        } catch (\Exception $e) {
            Log::critical($e);
            return false;
        }
    }

    private function hasLanguageSession(Request $request): bool
    {
        if ($request->session()->has(config('app.language_session_name')))
            return true;
        return false;
    }

    private function setLanguageByDefault(Request $request): void
    {
        try {
            $request->session()->put('language', config('app.locale'));
        } catch (\Exception $e) {
            Log::critical($e);
        }
    }


    private function getLanguageSession(Request $request): string
    {
        return $request->session()->get('language') ?? '';
    }

    private function hasLanguageInUrl(): bool
    {
        if (in_array($this->languageParamInUrl, config('app.locales_array')))
            return true;

        return false;
    }

    private function setLanguageByUrl(Request $request): void
    {
        if ($this->hasLanguageInUrl())
            $request->session()->put('language', $this->languageParamInUrl);

    }

}
