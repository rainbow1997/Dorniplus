<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomeController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'posts' => $this->getPosts()//for test *
        ]);
    }

    private function getPosts()
    {
        $posts = Post::query()->with(['category', 'writerPerson']);


        $posts = $posts->orderBy('updated_at', 'DESC')->paginate(10);
//         $updated_posts = $posts->getCollection();
//         $posts->each(function($post){
//             $post->hasContinue = FALSE;
//             $postTextLength = strlen( $post->text );
//             $post->postLength = $postTextLength;
//             if($postTextLength > 1000 ) {
//
//                 $post->text = substr(html_entity_decode(htmlspecialchars($post->text)), 0, $postTextLength / 10);
//                 $post->hasContinue = TRUE;
//             }
//             else
//                 $post->text = substr(html_entity_decode($post->text),0,$postTextLength - 1);
//             return $post;
//         });
        //$posts->setCollection($updated_posts);
//         dd($posts);
        return $posts;

    }
}
