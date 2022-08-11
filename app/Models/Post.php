<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\CalendarUtils;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'text', 'post_image', 'estimated_time', 'category_id', 'user_id','updated_at'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function writerPerson()
    {
        return $this->belongsTo(User::class, 'user_id');
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

    public function scopeCategory($query, $categoryTitle)
    {
        return $query->whereHas('category', function ($query) use ($categoryTitle) {
            return $query->where('title', 'like', "%{$categoryTitle}%");

        });
    }

    public function scopeUser($query, $userFullName)
    {
        return $query->whereHas('writerPerson', function ($query) use ($userFullName) {
            return $query->where('fname', 'like', "%{$userFullName}%")
                ->orWhere('lname', 'like', "%{$userFullName}%");
        });
    }

    public function scopeStartDate($query, $startDate)
    {
       // dd($startDate->timestamp);
        if (!is_null($startDate))
            return $query->whereDate('updated_at', '>=', $startDate->toDateString());
    }

    public function scopeEndDate($query, $endDate)
    {

        if (!is_null($endDate)) // it's not a good way, is  it? ask!
            return $query->whereDate('updated_at', '<=', $endDate->toDateString());
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {

        if (!is_null($startDate) && !is_null($endDate)) {
           return $query->whereBetween('updated_at', [$startDate->toDateString(), $endDate->toDateString()]);

        }

    }

}
