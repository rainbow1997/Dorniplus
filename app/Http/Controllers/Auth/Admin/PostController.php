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
use \App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Image;
class PostController extends Controller
{
    //
    
   public function index()
   {
        $posts = Post::with('writerPerson','category')->paginate(10);
        return view('auth.posts_index',['posts' => $posts]);

   }
   public function create(){
        $categories = Category::pluck('title','id')->all();

        return view('auth.post_create',['categories' => $categories]);
   }
   public function store(Request $request)
   {
        $validData = $this->validateCreatedPost($request);
        if($request->hasFile('post_image'))
            $validData->put('post_image', $this->uploadPostImage($request));
        $validData->put('estimated_time', $this->estimatedTimeCaculating($validData['text']));
        $validData->put('user_id', \Auth::id());
        //dd($validData->toArray());
        $post = Post::create($validData->toArray());
        activity()->performedOn($post)
        ->causedBy(\Auth::user())
        ->log('the user has been created with these information');
        return redirect()->route('posts.index')
        ->with('message','پست جدید با موفقیت افزوده شد.');

   }
   protected function uploadPostImage(Request $request)
   {
        $uploadedFile = $request->file('post_image');      
        $this->imageSizeOptimizer($uploadedFile->getRealPath());                                                                                                 
        $filename = time().$uploadedFile->getClientOriginalName();
        $file = Storage::disk('public')->putFileAs( 'posts', $uploadedFile,$filename);
        return $file;
   }
   protected function imageSizeOptimizer($file)
    {
    
        $image = Image::make($file);
        $image->resize(400,400,function($const){
            $const->aspectRatio();
        })->save();
        //return $image;
    }
   public function validateCreatedPost(Request $request)
    {
        return collect($request->validate([
            'title' => ['required','string'],
            'text' => ['required','string'],
            'post_image' => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
            
            'category_id' => ['required','numeric','exists:categories,id'],
        ]));


    }
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
        ->with('message','استان مورد نظر حذف گردید.');
    }

    public function estimatedTimeCaculating($text, $adultsAvgTime = 200){
        $delimiters = [' ',"\t","\n"];
        $str = str_replace($delimiters, $delimiters[0],$text);

        $secondDelimiters = ['.','?','!',',',';'];
        $str = str_replace($secondDelimiters,'',$str);

        $wordsArray = explode(' ',$str);
        
        $secondDuration = (ceil(count($wordsArray) / $adultsAvgTime) ) * 60;//convert to seconds
        return ($datetime = date('i:s',$secondDuration));
    }
}