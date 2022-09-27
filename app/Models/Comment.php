<?php

namespace App\Models;

use App\Enum\CommentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Morilog\Jalali\CalendarUtils;
use App\Models\Post;
use Carbon\Carbon;
class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['fullname', 'email', 'phone', 'user_id', 'text', 'data', 'status','commentable_type', 'commentable_id'];
    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime:Y/m/d H:i:s',
        'status' => CommentStatus::class
    ];

    public function commentable()
    {
        return $this->morphTo();

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getCreatedAtAttribute($value)
    {
        if(app()->getLocale()=='fa_IR')
            return CalendarUtils::strftime('Y/m/d H:i', strtotime($value));

         $datetime = new Carbon($value);
         return $datetime->toDateTimeString();


    }

    public function getUpdatedAtAttribute($value)
    {
        return CalendarUtils::strftime('Y/m/d', strtotime($value));


    }

    public function scopeFullname($query, $fullname)
    {
        return $query->where('fullname', 'like', "%{$fullname}%");
    }

    public function scopePost($query, $postTitle)
    {
        return $query->whereHas('post', function ($query) use ($postTitle) {
            return $query->where('title', 'like', "%{$postTitle}%");

        });
    }

    public function scopeEmail($query, $email)
    {
        return $query->where('email', 'like', "%{$email}%");

    }
    public function scopePhone($query, $phone)
    {
        return $query->where('phone', 'like', "%{$phone}%");

    }
    public function scopeContent($query, $content)
    {
        return $query->where('text', 'like', "%{$content}%");

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
