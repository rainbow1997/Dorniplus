<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;
use Inertia\Inertia;

class PostController extends Controller
{
    //

    public function index()
    {
        $posts = Post::with('writerPerson', 'category');
        return view('auth.posts_index', ['posts' => $posts]);

    }

    public function show(Post $post)
    {
        $post->load(['writerPerson', 'category']);
        return Inertia::render('Post/Show', ['post' => $post]);
    }

    public function store(Request $request)
    {
        $validData = $this->validateCreatedPost($request);
        if ($request->hasFile('post_image'))
            $validData->put('post_image', $this->uploadPostImage($request));
        $validData->put('estimated_time', $this->estimatedTimeCaculating($validData['text']));
        $validData->put('user_id', Auth::id());
        //dd($validData->toArray());
        $post = Post::create($validData->toArray());
        activity()->performedOn($post)
            ->causedBy(Auth::user())
            ->log('the post has been created with these information');
        return redirect()->route('posts.index')
            ->with('message', 'پست جدید با موفقیت افزوده شد.');

    }

    public function validateCreatedPost(Request $request)
    {
        return collect($request->validate([
            'title' => ['required', 'string'],
            'text' => ['required', 'string'],
            'post_image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],

            'category_id' => ['required', 'numeric', 'exists:categories,id'],
        ]));


    }

    protected function uploadPostImage(Request $request)
    {

        $uploadedFile = $request->file('post_image');
        $filename = time() . $uploadedFile->getClientOriginalName();

        $file = Storage::disk('public')->putFileAs('posts', $uploadedFile, $filename);

        $this->imageSizeOptimizer($file);

        return $file;
    }

    protected function imageSizeOptimizer($file)
    {

        $image = Image::make('storage/' . $file);
        $image->resize(400, 400, function ($const) {
            $const->aspectRatio();
        })->save();
        //return $image;
    }

    public function estimatedTimeCaculating($text, $adultsAvgTime = 200)
    {
        $delimiters = [' ', "\t", "\n"];
        $str = str_replace($delimiters, $delimiters[0], $text);

        $secondDelimiters = ['.', '?', '!', ',', ';'];
        $str = str_replace($secondDelimiters, '', $str);

        $wordsArray = explode(' ', $str);

        $secondDuration = (ceil(count($wordsArray) / $adultsAvgTime));//convert to seconds
        return ($datetime = date('i:s', $secondDuration));
    }

    public function create()
    {
        $categories = Category::pluck('title', 'id')->all();

        return view('auth.post_create', ['categories' => $categories]);
    }

    public function edit(Post $post)
    {
        $categories = Category::pluck('title', 'id')->all();

        return view('auth.posts_edit', ['post' => $post, 'categories' => $categories]);
    }

    public function update(Post $post, Request $request)
    {
        //  dd($post->post_image);
        $validated = ($this->validateEditedPost($request))->toArray();
        if ($request->hasFile('post_image')) {
            removeFiles($post->post_image);
            $validated['post_image'] = $this->uploadPostImage($request);
            $post->post_image = $validated['post_image'];
        }


        $category = Category::find($validated['category_id']);
        $category->posts()->save($post);
        $post->title = $validated['title'];
        $post->text = $validated['text'];
        $post->estimated_time = $this->estimatedTimeCaculating($validated['text']);

        $post->save();

        activity()->performedOn($post)
            ->causedBy(Auth::user())
            ->log('the post has been edited with these information');

        return redirect()->route('posts.index')
            ->with('message', 'پست ویرایش شد');
    }

    public function validateEditedPost(Request $request)
    {
        return collect($request->validate([
            'title' => ['required', 'string'],
            'text' => ['required', 'string'],
            'post_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],

            'category_id' => ['required', 'numeric', 'exists:categories,id'],
        ]));


    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
            ->with('message', 'استان مورد نظر حذف گردید.');
    }
}
