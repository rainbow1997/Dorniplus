<?php
    
namespace App\Http\Controllers\Auth\Admin;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Knp\Snappy\Pdf;
use ExcelReport;
use PdfReport;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('fnameSearch')){
    
            $data = User::search($request->fnameSearch)->paginate(6);
        }
        else
            $data = User::with(['city','province'])->orderBy('id','DESC')->paginate(5);
        return view('auth.users_index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function displayUsersReport(Request $request)
    {
        // $fromDate = $request->input('from_date');
        // $toDate = $request->input('to_date');
        // $sortBy = $request->input('sort_by');
        
    $title = 'گزارش کاربران ثبت نامی'; 

    $meta = [
      
    ];

    $queryBuilder = User::with(['province','city'])->select(['fname','lname','province_id', 'city_id','gender','created_at']);
    
    $columns = [ // Set Column to be displayed
        'نام' => 'fname',
        'نام خانوادگی' => 'lname',
        'استان' => function($result)
        {
            return $result->province->title;
        },
        'شهرستان' => function($result){
            return $result->city->title;
        },
        'جنسیت' => function($result)
        {

            if($result->gender === \App\Enum\Gender::MALE)
                return 'مذکر';
            return 'مونث';
        
        },
        'تاریخ ثبت نام' => 'created_at',
       
    ];
    if($request->method == 'pdf'){
        return PdfReport::of($title, $meta, $queryBuilder, $columns)
            ->showTotal([ 
                'Total Balance' => 'point'
        ])
    ->limit(20) 
    ->download('User Reports'); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
            }
    else
    {
        return ExcelReport::of($title, $meta, $queryBuilder, $columns)
        ->showTotal([ 
            'Total Balance' => 'point'
         ])
        ->limit(20) 
        ->download('User Reports'); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
    }
}    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('auth.create_user',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with(['city','province'])->find($id);
        return view('auth.show_user',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('auth.edit_user',compact('user','roles','userRole'));
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
        $this->validate($request, [
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
        

        activity()->performedOn($user)
        ->causedBy(\Auth::user())
        ->log('the user has been updated with these information');

        return redirect()->route('users.index')
                        ->with('success','کاربر با موفقیت ویرایش گردید.');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        activity()->performedOn($user)
        ->causeBy(\Auth::user())
        ->log('the user has been deleted with these information');
        return redirect()->route('users.index')
                        ->with('success','حذف کاربر موفقیت آمیز بود.');
    }
}