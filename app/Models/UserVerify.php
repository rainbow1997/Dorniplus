<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerify extends Model
{
    use HasFactory;
    protected $table = "users_verify";
    protected $fillable = ['user_id','token'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function showVerificationForm()
    {
        return view('auth.codeVerification');
    }

    public function verifyAccount()
    {
        $request->validate([
            'token' => 'required|numeric|exists:user_verify,token'
        ]);
        
        $verifyUser = UserVerify::where('token',$request->token)->first();
        if(!is_null($verifyUser))
            $user = $verifyUser->user;
        if(!$user->is_email_verified){
            $verifyUser->user->is_email_verified = 1;
            $verifyUser->user->save();
            $message = 'Your email is verified. You can now login.';

        }
        else
            $message = 'Your email is already verified.You can now login.';
        
        $message = 'Sorry boy,your email cannot be identified';

        return redirect()->route('login')->with('message',$message);
    }
}
