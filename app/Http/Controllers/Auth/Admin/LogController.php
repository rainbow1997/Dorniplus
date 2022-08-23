<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    //
    public function __construct(){

        $this->middleware('permission:log-list', ['only' => ['index']]);
    }
    public function index()
    {

        $activities = Activity::all();
        $activities->each(function ($item, $key) {
            $item->user = $item->causer_type::find($item->causer_id);
        });
        return view('auth.logs_index', ['activities' => $activities]);

    }
}
