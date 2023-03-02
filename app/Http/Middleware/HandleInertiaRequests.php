<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Support\Facades\Lang;
class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param Request $request
     * @return string|null
     *
     */
    public function rootView(Request $request)
    {

        if ($request->route()->getPrefix() == '/admin') {

            return 'layouts.AdminPanel.masterpage';
        }

        return parent::rootView($request);
    }
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param Request $request
     * @return array
     */
    public function share(Request $request)
    {

        return array_merge(parent::share($request), [
            'appName' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'message' => fn() => $request->session()->get('message')
            ],
            'langs' => [
                'fa_IR' => ['lang' => Lang::get('site',[],'fa_IR'),'langInfo' => ['direction'=>'rtl']],
                'en_US' => ['lang' => Lang::get('site',[],'en_US'),'langInfo' => ['direction'=>'ltr']],

                'site_locale' => app()->getLocale(),

            ],
            'storage_url' =>  config('app.storage_url'),
            'ziggy' => function () {
                return (new Ziggy)->toArray();
            },
        ]);
    }
}
