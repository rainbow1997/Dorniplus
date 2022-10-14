<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
class DashboardController extends Controller
{
    //role checking in middlewares
    public function index(Request $request, User $admin)
    {
        $dashboardData['users'] = User::all()->count();
        $dashboardData['posts'] = Post::all()->count();
        $dashboardData['comments'] = Comment::all()->count();
        $dashboardData['unReadComments'] = Comment::where('is_seen',0)->count();

        return Inertia::render('Dashboard',['dashboardData'=>$dashboardData]);
    }
}
