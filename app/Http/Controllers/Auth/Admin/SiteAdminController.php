<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Request as RequestFacade;
use Inertia\Inertia;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
class SiteAdminController extends Controller
{
    protected array $searchParams = ['fullname', 'email', 'province', 'city', 'birth', 'created_at'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function searchFiltering(EloquentBuilder $users)
    {
        $request = collect(RequestFacade::all());
        $search = apartSearchParameters($request, $this->searchParams);
        if ($search->isNotEmpty()) {

            $users->when($search['fullname'], function ($query, $search) {// $search['title] become $search

                return $query->fullname($search);
            })
                ->when($search['email'], function ($query, $search) {

                    return $query->email($search);
                })
                ->when($search['province'], function ($query, $search) {
                    return $query->province($search);
                })
                ->when($search['city'], function ($query, $search) {
                    return $query->city($search);
                })
//                ->when($search['roles'], function ($query, $search) {
//
//                    return $query->role($search);
//                 })
                ->when($search['birth'], function ($query, $search) {
                    return $query->birth(convertDateForDB($search));
                })
                ->when($search['created_at'], function ($query, $search) {
                    return $query->createdat(convertDateForDB($search));
                });

        }

        return $users = $users->with(['province', 'city', 'roles']);
    }
    public function index()
    {
        //

        $users = User::role('Admin');
        $users = $this->searchFiltering($users);
        $users = $users->orderBy('id', 'ASC')->paginate(5);


        return
            Inertia::render('SiteAdmin/Index',['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $users = User::query();
        $users = $this->searchFiltering($users)->orderBy('id','DESC')->paginate(5);
        return Inertia::render('SiteAdmin/Add',['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $user = User::findOrFail($request['id']);
        $user->assignRole('Admin');
        return redirect()->route('site_admin.index')->with('message','مدیر جدید با موفقیت افزوده گردید');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
