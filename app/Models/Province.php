<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\User;
class Province extends Model
{
    use HasFactory;

    protected $fillable = ['title'];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
