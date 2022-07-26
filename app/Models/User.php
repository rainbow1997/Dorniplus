<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use \App\Models\UserVerify;
use Verta;
use \App\Notification\RegisterNotification;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Scout\Searchable;


class User extends Authenticatable implements MustVerifyEmail, \Illuminate\Contracts\Auth\CanResetPassword
{
    use HasApiTokens, HasRoles,Searchable,HasFactory, Notifiable, \Illuminate\Auth\Passwords\CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'lname',
        'username',
        'national_code',
        'phone',
        'gender',
        'birth',
        'military_status',
        'avatar',
        'province_id',
        'city_id',
        'email',
        'password',
        'is_email_verified'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth' =>  'datetime:Y/m/d',
        'gender' => \App\Enum\Gender::class,
        'military_status' => \App\Enum\MilitaryStatus::class
    
    ];
    public function searchableAs()
    {
        return 'users_index';
    }
    public function emailVerificationCode()
    {
        return $this->hasOne(UserVerify::class);
    }
    //it is cast to jalali
    public function getCreatedAtAttribute($value)
    {
        
        return (verta($value))->format('Y/m/d');
    }
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function city()
    {
        return $this->belongsTo('App\Models\City','city_id','id');
    }
    public function getCityName()
    {
        return $this->city->title;
    }

}
