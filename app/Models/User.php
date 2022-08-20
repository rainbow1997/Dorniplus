<?php

namespace App\Models;

use App\Enum\Gender;
use App\Enum\MilitaryStatus;
use App\Notification\RegisterNotification;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Morilog\Jalali\CalendarUtils;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, \Illuminate\Contracts\Auth\CanResetPassword
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable, CanResetPassword;

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
        'birth' => 'date',
        'gender' => Gender::class,
        'military_status' => MilitaryStatus::class

    ];

    public function emailVerificationCode()
    {
        return $this->hasOne(UserVerify::class);
    }

    //it is cast to jalali
    public function getCreatedAtAttribute($value)
    {
        return CalendarUtils::strftime('Y/m/d', strtotime($value));


    }

    public function getBirthAttribute($value)
    {

        return CalendarUtils::strftime('Y/m/d', strtotime($value));
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    public function getCityName()
    {
        return $this->city->title;
    }
    public function scopeFullname($query, $fullname){

        return $query->where('fname' , 'like' , "%{$fullname}%")
                     ->orWhere('lname', 'like',"%{$fullname}%");
    }
    public function scopeEmail($query, $email)
    {
        return $query->where('email','like',"%{$email}%");
    }
    public function scopeProvince($query,$province)
    {
        return $query->whereHas('province',function($query) use($province){
            return $query->where('title','like',"%{$province}%");
        });
    }
    public function scopeCity($query,$city)
    {
        return $query->whereHas('city',function($query) use($city){
            return $query->where('title','like',"%{$city}%");
        });
    }

    public function scopeRole(Builder $query, $roles, $guard = null): Builder
    {
        return $query->whereHas('roles',function($query) use($roles){

            return $query->whereIn('id','=',$roles);
        });//it's a good way to make a scope with an array of values
    }

    public function scopeBirth($query,$birth)
    {
        if (!is_null($birth))
            return $query->whereDate('birth', '=', $birth->toDateString());
    }

    public function scopeCreatedat($query,$created_at)
    {
        if (!is_null($created_at))
            return $query->whereDate('created_at', '>=', $created_at->toDateString());
    }


}
