<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title','text','post_image','estimated_time','category_id','user_id'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function writerPerson()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    


}
