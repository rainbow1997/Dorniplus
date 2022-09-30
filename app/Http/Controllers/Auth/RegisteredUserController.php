<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\User;
use App\Models\UserVerify;
use App\Notifications\RegisterNotification;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Image;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    public function store(Request $request)
    {

        $validData = $this->userValidating($request);
        $validData = collect($validData);
        $this->securePassword($validData);
        if ($request->hasFile('avatar'))
            $validData->put('avatar', $this->uploadAvatar($request));

        $user = User::create($validData->toArray());
        $userVerify = new UserVerify;
        $userVerify->setToken();
        $user->emailVerificationCode()->save($userVerify);
        $user->save();
        $user->notify(new RegisterNotification($user));
        //event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    protected function userValidating(Request $request)
    {
        $self = $this;
        $tenYearsAgo = Carbon::now()->subYear(10)->format('Y/m/d');
        $request['birth'] = convertDateForDB($request['birth']);
        return $request->validate([
            'fname' => ['required', 'string', 'max:455'],
            'lname' => ['required', 'string', 'max:455'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'national_code' => ['required', 'unique:users', function ($attribute, $value, $fail) use ($self) {
                if (!$self->nationalCodeChecking($value))
                    $fail('فرمت کد ملی صحیح نمی باشد.');
            }
            ],
            'phone' => ['required', 'digits_between:10,11'],
            'gender' => ['required', 'in:male,female'],//if it gets much time ,remove it and use string
            'birth' => ['required', 'date', 'before:' . $tenYearsAgo],
            'username' => ['required', 'alpha_num', 'regex:/^[^0-9]/', 'unique:users'],
            'military_status' => ['nullable', 'required_if:gender,male',
                'in:permanent_exemption,temporary_exemption,done'],
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:200'],
            'province_id' => ['nullable', 'numeric', 'exists:provinces,id'],
            'city_id' => ['nullable', 'numeric', 'exists:cities,id'],

            'captcha_num' => ['required', 'numeric', function ($attribute, $value, $fail) {
                if (session('captcha_num') != $value)
                    $fail(__('site.security_code_problem'));
            }]
        ]);
    }

    protected function nationalCodeChecking($code)
    {
        if (!preg_match('/^[0-9]{10}$/', $code))
            return false;
        for ($i = 0; $i < 10; $i++)
            if (preg_match('/^' . $i . '{10}$/', $code))
                return false;
        for ($i = 0, $sum = 0; $i < 9; $i++)
            $sum += ((10 - $i) * intval(substr($code, $i, 1)));
        $ret = $sum % 11;
        $parity = intval(substr($code, 9, 1));
        if (($ret < 2 && $ret == $parity) || ($ret >= 2 && $ret == 11 - $parity))
            return true;
        return false;
    }

    private function securePassword(Collection $validData)
    {
        $validData['password'] = Hash::make($validData['password']);
        return $validData;
    }

    protected function uploadAvatar(Request $request)
    {

        $uploadedFile = $request->file('avatar');
        $filename = time() . $uploadedFile->getClientOriginalName();

        $file = Storage::disk('public')->putFileAs('avatars', $uploadedFile, $filename);

        $this->imageSizeOptimizer($file);

        return $file;
    }

    protected function imageSizeOptimizer($file)
    {

        $image = Image::make('storage/' . $file);
        $image->resize(400, 400, function ($const) {
            $const->aspectRatio();
        })->save();
    }

    /**
     * Display the registration view.
     *
     * @return View
     */
    public function create()
    {
        $regions = Province::with('cities')->get();
        return Inertia::render('Auth/Register', ['regions' => $regions]);
    }

    public function changePasswordIndex()
    {

        return Inertia::render('ChangePassword', ['user' => \Auth::user()]);
    }

    public function changePassword(Request $request)
    {
        $user = User::find($request->user_id);//to avoid of modification inderction error with $request->user->password

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('dashboard')
            ->with('message', 'گذرواژه با موفقیت تغییر کرد');
    }

    public function editProfile()
    {
        // dd(\Auth::user());

        return Inertia::render('EditProfile', ['user' => \Auth::user(),
            'regions' => $regions = Province::with('cities')->get()]);
    }

    public function storeProfile(User $user, Request $request)
    {

        $validData = collect($this->storeValidating($user, $request));


        if ($request->hasFile('avatar')) {
            removeFiles($user->avatar);
            $validData['avatar'] = $this->uploadAvatar($request);
        }

        $user->update($validData->toArray());

        return redirect()->route('dashboard')
            ->with('message', 'پروفایل با موفقیت تغییر کرد');
    }

    public function storeValidating(User $user, Request $request)
    {


        $self = $this;
        $tenYearsAgo = Carbon::now()->subYear(10)->format('Y/m/d');

        $request['birth'] = convertDateForDBFromJalalian($request['birth']);

        return $request->validate([
            'fname' => 'required|string|max:455',
            'lname' => 'required|string|max:455',
            'national_code' => 'required|unique:users,national_code,' . $user->id, function ($attribute, $value, $fail) use ($self) {
                if (!$self->nationalCodeChecking($value))
                    $fail('The' . $attribute . 'is invalid.');
            }
            ,
            'phone' => 'required|digits_between:10,11',
            'gender' => 'required|in:male,female',//if it gets much time ,remove it and use string
            'birth' => 'required|date|before:' . $tenYearsAgo,
            'military_status' => 'nullable|required_if:gender,male|
             in:permanent_exemption,temporary_exemption,done',
            'avatar' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'province_id' => 'nullable|numeric|exists:provinces,id',
            'city_id' => 'nullable|numeric|exists:cities,id',
        ]);

    }


}
