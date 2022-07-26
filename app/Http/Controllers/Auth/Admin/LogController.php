<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use \App\Models\Province;
use \App\Models\City;
use \App\Models\User;
use Spatie\Activitylog\Models\Activity;
class LogController extends Controller
{
    //
    
   public function index()
   {

    $activities = Activity::all();
    $activities->each(function ($item,$key){
        $item->user = $item->causer_type::find($item->causer_id);
    });
    return view('auth.logs_index',['activities' => $activities]);

   }
}