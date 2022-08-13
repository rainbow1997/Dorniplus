<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Enum\Gender;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use DB;
use ExcelReport;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use PdfReport;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Request as RequestFacade;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    protected array $searchParams = ['fullname','email','province','city','birth','created_at'];

    public function index()
    {
        //Don't remember this validation afterwards,
        $request = collect(RequestFacade::all());
        $search = apartSearchParameters($request,$this->searchParams);
        $users = User::query();
        if($search->isNotEmpty()) {

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

        $users = $users->with(['province','city','roles']);
        $users = $users->orderBy('id', 'DESC')->paginate(5);

        return Inertia::render('UsersIndex', ['users' => $users]);


    }

    public function displayUsersReport(Request $request)
    {
        // $fromDate = $request->input('from_date');
        // $toDate = $request->input('to_date');
        // $sortBy = $request->input('sort_by');

        $title = 'گزارش کاربران ثبت نامی';

        $meta = [

        ];

        $queryBuilder = User::with(['province', 'city'])->select(['fname', 'lname', 'province_id', 'city_id', 'gender', 'created_at']);

        $columns = [ // Set Column to be displayed
            'نام' => 'fname',
            'نام خانوادگی' => 'lname',
            'استان' => function ($result) {
                return $result->province->title;
            },
            'شهرستان' => function ($result) {
                return $result->city->title;
            },
            'جنسیت' => function ($result) {

                if ($result->gender === Gender::MALE)
                    return 'مذکر';
                return 'مونث';

            },
            'تاریخ ثبت نام' => 'created_at',

        ];
        if ($request->method == 'pdf') {
            return PdfReport::of($title, $meta, $queryBuilder, $columns)
                ->showTotal([
                    'Total Balance' => 'point'
                ])
                ->limit(20)
                ->download('User Reports'); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
        } else {
            return ExcelReport::of($title, $meta, $queryBuilder, $columns)
                ->showTotal([
                    'Total Balance' => 'point'
                ])
                ->limit(20)
                ->download('User Reports'); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        activity()->performedOn($user)
            ->causedBy(Auth::user())
            ->log('the user has been created with these information');
        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('auth.create_user', compact('roles'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::with(['city', 'province'])->find($id);
        return view('auth.show_user', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('auth.edit_user', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();

        $user->assignRole($request->input('roles'));

        activity()->performedOn($user)
            ->causedBy(Auth::user())
            ->log('the user has been updated with these information');

        return redirect()->route('users.index')
            ->with('success', 'کاربر با موفقیت ویرایش گردید.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->delete();// or $user->syncRoles([]);
        activity()->performedOn($user)
            ->causedBy(Auth::user())
            ->log('the user has been deleted with these information');
        return redirect()->route('users.index')
            ->with('success', 'حذف کاربر موفقیت آمیز بود.');
    }
}
