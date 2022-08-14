<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Enum\Gender;
use App\Events\TempFileDownloaded;
use App\Http\Controllers\Controller;
use App\Models\TempFile;
use App\Models\User;
use Auth;
use DB;
use ExcelReport;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use PdfReport;
use Spatie\Permission\Models\Role;
use ZanySoft\Zip\Zip;

class UserController extends Controller
{
    public $tempFile;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    protected array $searchParams = ['fullname', 'email', 'province', 'city', 'birth', 'created_at'];
    protected $tempDirectoryPath;

    public function index()
    {
        //Don't remember this validation afterwards,
        $request = collect(RequestFacade::all());
        $search = apartSearchParameters($request, $this->searchParams);
        $users = User::query();
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

        $users = $users->with(['province', 'city', 'roles']);
        $users = $users->orderBy('id', 'DESC')->paginate(5);

        return Inertia::render('UsersIndex', ['users' => $users]);


    }

    public function getReport(Request $request)
    {
        //dont forget its validation
        //$request Of Request works in post but doesn't work in get
        $request = $request->all();// $request['parameters'],['methods']
        return $this->displayUsersReport($request);

    }

    public function displayUsersReport($request)
    {
        //dd($request);
        $fromDate = $request['parameters']['start_date'];
        $toDate = $request['parameters']['end_date'];
        //$sortBy = $request->input('sort_by');

        $title = 'گزارش کاربران ثبت نامی';

        $meta = [

        ];

        $queryBuilder = User::with(['province', 'city'])->select(['fname', 'lname', 'province_id', 'city_id', 'gender', 'created_at']);
        $columns = [ // Set Column to be displayed
            'نام' => 'fname',
            'نام خانوادگی' => 'lname',
            'تاریخ ثبت نام' => 'created_at',

        ];

        if ($request['parameters']['province'])
            $columns['استان'] = function ($result) {
                return $result->province->title ?? '';
            };
        if ($request['parameters']['city'])
            $columns['شهر'] = function ($result) {
                return $result->city->title ?? '';
            };

        if ($request['parameters']['gender']) {
            $columns['جنسیت'] = function ($result) {
                if ($result->gender === Gender::MALE)
                    return 'مذکر';
                return 'مونث';
            };
        }

        $files = [];
        $zipPath = storage_path('app/public/reports.zip');

        $tempFile1 = TempFile::create([
            'path' => 'temp',
            'type' => 'directory',
            'user_id' => Auth::id(),
            'description' => 'temp directory for users reports'
        ]);

        if (Storage::disk('public')->exists('reports.zip'))
            Storage::disk('public')->delete('reports.zip');

        $zip = Zip::create($zipPath);

        foreach ($request['methods'] as $method)
            if ($method == 'pdf')
                $files['pdf'] = PdfReport::of($title, $meta, $queryBuilder, $columns)
                    ->showTotal([
                        'Total Balance' => 'point'
                    ])
                    ->limit(20)
                    ->store('public/temp/reports.pdf');

            else if ($method == 'excel')
                $files['excel'] = ExcelReport::of($title, $meta, $queryBuilder, $columns)
                    ->showTotal([
                        'Total Balance' => 'point'
                    ])
                    ->limit(20)
                    ->store('public/temp/reports.xlsx');
        // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
        $zip->add(storage_path('app/public/temp', true));
        $zip->close();

        TempFileDownloaded::dispatch($tempFile1);//for delete temp directory

        $tempFile2 = TempFile::create([
            'path' => ('reports.zip'),
            'type' => 'file',
            'user_id' => Auth::id(),
            'description' => 'just .zip file'
        ]);
        return Inertia::location(route('downloading', $tempFile2->id));
        //then user should go /downloading with below method to complete download the file.

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

    public function downloading(TempFile $tempFile)
    {
        if (!is_null($tempFile)) {
            TempFileDownloaded::dispatch($tempFile);
            return Storage::disk('public')->download($tempFile->path);
        }

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
