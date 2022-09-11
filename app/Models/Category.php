<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\CalendarUtils;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return CalendarUtils::strftime('Y/m/d', strtotime($value));


    }

    public function getUpdatedAtAttribute($value)
    {
        return CalendarUtils::strftime('Y/m/d', strtotime($value));


    }

    public function scopeTitle($query, $title)
    {

        return $query->where('title', 'like', "%{$title}%");
    }

    public function scopeCreatedat($query, $created_at)
    {

        if (!is_null($created_at))
            return $query->whereDate('created_at', '>=', $created_at->toDateString());
    }

    public function scopeUpdatedat($query, $updated_at)
    {
        if (!is_null($updated_at))
            return $query->whereDate('updated_at', '>=', $updated_at->toDateString());
    }
}
