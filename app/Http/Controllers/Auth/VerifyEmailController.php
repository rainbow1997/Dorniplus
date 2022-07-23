<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Verta;
class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
    public function checkingCode(Request $request)
    {
        $user = $request->user();
        $request->validate(['token' 
            => ['required','numeric','exists:users_verify,token']]);
       
        if($user->emailVerificationCode->token == $request->token){
            $this->setVerification($user);
            return redirect()->route('dashboard')
                ->with('status','اکانت شما با موفقیت فعال سازی شد');
        }
                return redirect()->route('dashboard')
            ->with('status','اکانت شما فعال سازی نگردید.');

            
    
}
    public function setVerification($user)
    {
        $user->is_email_verified = 1;
        $user->email_verified_at = Verta::now()->datetime();
        return $user->save();
    }
}
