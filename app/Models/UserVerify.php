<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerify extends Model
{
    use HasFactory;

    protected $table = "users_verify";
    protected $fillable = ['user_id', 'token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function showVerificationForm()
    {
        return view('auth.codeVerification');
    }

    public function setToken()
    {
        return $this->token = rand(100000, 9999999);
    }


}
