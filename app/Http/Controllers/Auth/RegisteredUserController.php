<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Enum\Gender;
use App\Models\Province;
use Verta;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $regions = Province::with('cities')->get();
        return view('auth.register',['regions'=>$regions]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function userValidating(Request $request)
    {
        $self = $this;
        $tenYearsAgo = new Verta('-10 year');
        $tenYearsAgo = $tenYearsAgo->format('Y/m/d');
        $request->merge(['birth' => persianizeNumber($request->input('birth'))]);
        return $request->validate([
            'fname' => ['required', 'string', 'max:455'],
            'lname' => ['required', 'string', 'max:455'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'national_code' => ['required','unique:users',function($attribute,$value,$fail) use($self){
                    if(!$self->nationalCodeChecking($value))
                        $fail('The'.$attribute.'is invalid.');
                }
                               ],
            'phone' => ['required','digits_between:10,11'],
            'gender' => ['required','in:male,female'],//if it gets much time ,remove it and use string
            'birth' => ['required','jdate','jdate_after:'.$tenYearsAgo],
            'username' => ['required','alpha_num','regex:/^[^0-9]/'],
            'military_status' => ['nullable','required_if:gender,male'],
            'post_image' => ['nullable','mimes:png,jpg,jpeg','max:200'],
            'province_id' => ['nullable','numeric','exists:provinces'],
            'city_id' => ['nullable','numeric','exists:cities'],
        ]);
    }
    public function store(Request $request)
    {
        
        $validData = $this->userValidating($request);
        $user = User::create($validData);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    protected function nationalCodeChecking($code)
    {
        if(!preg_match('/^[0-9]{10}$/',$code))
            return false;
        for($i=0;$i<10;$i++)
            if(preg_match('/^'.$i.'{10}$/',$code))
                return false;
        for($i=0,$sum=0;$i<9;$i++)
            $sum+=((10-$i)*intval(substr($code, $i,1)));
        $ret=$sum%11;
        $parity=intval(substr($code, 9,1));
        if(($ret<2 && $ret==$parity) || ($ret>=2 && $ret==11-$parity))
            return true;
        return false;
    }
}
