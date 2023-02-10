<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Notifications\ActivationNotif;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->route(app()->getLocale().'.dashboard');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function code_verification(Request $request)
    {
        return Inertia::render('Auth/CodeVerification');
    }
    public function checkingCode(Request $request)
    {
        $user = $request->user();
        $request->validate(['token'
        => ['required', 'numeric', 'exists:users_verify,token']]);

        if ($user->emailVerificationCode->token == $request->token) {
            $this->setVerification($user);
            return redirect()->route(app()->getLocale().'.dashboard')
                ->with('status', 'اکانت شما با موفقیت فعال سازی شد');
        }
        return redirect()->route(app()->getLocale().'.code_verification')
            ->with('status', 'اکانت شما فعال سازی نگردید.');


    }

    public function setVerification($user)
    {
        $user->is_email_verified = 1;
        $user->email_verified_at = Carbon::now();
        $user->notify(new ActivationNotif($user));
        return $user->save();

    }
}
