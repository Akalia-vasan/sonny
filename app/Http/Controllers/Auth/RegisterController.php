<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         // 'lname' => ['required', 'string', 'max:255'],
    //         'mobile' => ['required' , 'unique:users'],
    //         // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //         'otp' => ['required'],
    //     ]);
    // }
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function create(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required' , 'unique:users'],
            'password' => ['required', 'string', 'min:8',],
            'otp' => ['required'],
        ]);
        if($validator->fails())
        {
            $data['name'] = $request->name;
            $data['mobile'] = $request->mobile;
            $data['password'] = $request->password;
            $data['otp'] = $request->otp;
            $data['otperror'] = 'The otp must be required.';
            return view('auth.register',$data);
        }
        if(UserOtp::where('mobile', $request['mobile'])->where('otp', $request['otp'])->count() == 0)
        {
            $data['name'] = $request->name;
            $data['mobile'] = $request->mobile;
            $data['password'] = $request->password;
            $data['otp'] = $request->otp;
            $data['otperror'] = 'The otp is invalid.';
            return view('auth.register',$data);
        }

        $user = User::create([
            'name' => $request['name'],
            'mobile' => $request['mobile'],
            'send_password' => $request['password'],
            'password' => Hash::make($request['password']),
        ]);
        UserOtp::where('mobile', $request['mobile'])->where('otp', $request['otp'])->delete();
        $this->guard()->login($user);
        return redirect($this->redirectTo );
    }


    public function preregisterview(Request $request)
    {
        return view('auth.pre_register');
    }
    public function preregister(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required' , 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }
        sendOtp($request->mobile);
        $data['name'] = $request->name;
        $data['mobile'] = $request->mobile;
        $data['password'] = $request->password;
        return view('auth.register',$data);
    }

}
