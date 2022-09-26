<?php

namespace App\Models;

use App\Enum\CommentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
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
}
