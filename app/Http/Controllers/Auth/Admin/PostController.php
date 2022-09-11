<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Storage;
use Image;
use Inertia\Inertia;

class PostController extends Controller
{
    //
    protected array $searchParams = ['title', 'category_title', 'writer_name', 'start_date', 'end_date'];

    public function __construct()
    {
        $this->middleware('permission:post-list|post-create|post-edit|post-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:post-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:post-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:post-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
//        $search = RequestFacade::all();//why its work but why $request from Request doesn't work?
        $posts = Post::query();
////        $posts = Post::with(['writerPerson', 'category']);
        $request = collect(RequestFacade::all());
        $search = apartSearchParameters($request, $this->searchParams);

        if ($search->isNotEmpty()) {

            $posts->when($search['title'], function ($query, $search) {// $search['title] become $search

                return $query->title($search);
            })
                ->when($search['category_title'], function ($query, $search) {
                    return $query->category($search);
                })
                ->when($search['writer_name'], function ($query, $search) {
                    return $query->user($search);
                });

            if (!is_null($search['start_date']) && !is_null($search['end_date']))
                $posts = $posts->dateRange(convertDateForDB($search['start_date']), convertDateForDB($search['end_date']));

            else if (!is_null($search['start_date']))
                $posts = $posts->startDate(convertDateForDB($search['start_date']));

            else if (!is_null($search['end_date']))
                $posts = $posts->endDate(convertDateForDB($search['end_date']));
//                ->when($search['start_date'], function ($query, $search) {
//                    return $query->dateRange( convertDateForDB($search),null);
//                })
//                ->when($search['end_date'], function ($query, $search) {
//                    return $query->dateRange( null,convertDateForDB($search));
//                });
        }

        $posts = $posts->with(['writerPerson', 'category']);
        $posts = $posts->orderBy('id', 'DESC')->paginate(5);


        //  ddd($posts);
        return Inertia::render('Post/Index', ['posts' => $posts]);

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
        $validData['slug'] = str_to_slug($validData['title'], '_');// ofcourse we can use put but it's a good way too.
        //dd($validData->toArray());
        $post = Post::create($validData->toArray());
        activity()->performedOn($post)
            ->causedBy(Auth::user())
            ->log("پست جدید با نام $post->title ساخته شده است .");
        return redirect()->route('posts.index')
            ->with('message', 'پست جدید با موفقیت افزوده شد.');

    }

    public function validateCreatedPost(Request $request)
    {
        return collect($request->validate([
            'title' => ['required', 'string'],
            'text' => ['required', 'string'],
            'summary' => ['required', 'string'],
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
        $categories = Category::all();
        return Inertia::render('Post/Create', ['categories' => $categories]);
//        return view('auth.post_create', ['categories' => $categories]);
    }

    public function edit(Post $post)
    {

        $categories = Category::all();

        return Inertia::render('Post/Edit', ['post' => $post, 'categories' => $categories]);
    }

    public function update(Post $post, Request $request)
    {

        $validated = $this->validateEditedPost($request, $post);
        $validated['slug'] = str_to_slug($validated['title'], '_');// ofcourse we can use put but it's a good way too.

        if ($request->hasFile('post_image')) {
            removeFiles($post->post_image);
            $validated['post_image'] = $this->uploadPostImage($request);
            $post->post_image = $validated['post_image'];
        }

        $post->slug = $validated['slug'];
        $post->category_id = $validated['category_id'];
        $post->title = $validated['title'];
        $post->text = $validated['text'];
        $post->summary = $validated['summary'];
        $post->estimated_time = $this->estimatedTimeCaculating($validated['text']);

        $post->save();

        activity()->performedOn($post)
            ->causedBy(Auth::user())
            ->log("پست  با نام $post->title ویرایش شده است .");

        return redirect()->route('posts.index')
            ->with('message', 'پست ویرایش شد');


    }

    public function validateEditedPost(Request $request, Post $post)
    {

        return collect($request->validate([
            'title' => ['required', 'string'],
            'text' => ['required', 'string'],
            'post_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'summary' => ['required', 'string'],
            'category_id' => ['required', 'numeric', 'exists:categories,id'],

        ]));


    }

    public function destroy(Post $post)
    {
        activity()->performedOn($post)
            ->causedBy(Auth::user())
            ->log("پست  با نام $post->title حذف شده است .");
        $post->delete();

        return redirect()->route('posts.index')
            ->with('message', 'مطلب مورد نظر حذف گردید.');
    }

    protected function validatePostSearchStrings()
    {

    }
}
