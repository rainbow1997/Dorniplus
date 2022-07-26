<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use \App\Models\Province;
use \App\Models\City;
use \App\Models\User;
use Spatie\Activitylog\Models\Activity;
use \App\Models\Post;
class PostController extends Controller
{
    //
    
   public function index()
   {
    $posts = Post::with('writerPerson','category')->paginate(10);
    return view('auth.posts_index',['posts' => $posts]);

   }
   public function create(){
        return view('auth.post_create');
   }
   public function store(Request $request)
   {
        $validData = $this->validateCreatedPost($request);
        $post = Post::create($validData);
        activity()->performedOn($post)
        ->causedBy(Auth::user())
        ->log('the user has been created with these information');
        return redirect()->route('regions.index')
        ->with('message','پست جدید با موفقیت افزوده شد.');

   }
   public function validateCreatedPost(Request $request)
    {
        return $request->validate([
            'title' => ['required','string'],
            'text' => ['required','string'],
            'estimated_time' => ['required','duration'],
            'post_image' => ['nullable|image|mimes:jpg,jpeg,png|max:2048'],
            'category_id' => ['required','numeric','exists:categories,id'],
            'user_id' => ['required','numeric','exists:users,id']
        ]);


    }
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('regions.index')
        ->with('message','استان مورد نظر حذف گردید.');
    }
}