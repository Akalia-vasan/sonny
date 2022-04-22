<?php

namespace App\Http\Controllers\Auth;


use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect(route('loginview'));
    }

    // protected function loggedOut(Request $request)
    // {
    //     return $request->wantsJson()
    //         ? new JsonResponse([], 204)
    //         : redirect(route('login'));
    // }

    public function preloginview(Request $request)
    {
        return view('auth.pre_login');
    }
    public function prelogin(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'mobile' => ['required' , 'exists:users'],
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }
        if($request->password && $request->password!=null)
        {
            $user = User::where('mobile',$request->mobile)->first();
            $this->guard()->login($user);
            return redirect($this->redirectTo );
        }
        sendOtp($request->mobile);
        $data['mobile'] = $request->mobile;
        return view('auth.login',$data);
    }
    public function login1(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'mobile' => ['required' , 'exists:users'],
            'otp' => ['required'],
        ]);
        if($validator->fails())
        {
            $data['mobile'] = $request->mobile;
            $data['otp'] = $request->otp;
            $data['otperror'] = 'The otp must be required.';
            return view('auth.login',$data);
        }
        if(UserOtp::where('mobile', $request['mobile'])->where('otp', $request['otp'])->count() == 0)
        {
            $data['mobile'] = $request->mobile;
            $data['otp'] = $request->otp;
            $data['otperror'] = 'The otp is invalid.';
            return view('auth.login',$data);
        }

        $user = User::where('mobile',$request->mobile)->first();
        UserOtp::where('mobile', $request['mobile'])->where('otp', $request['otp'])->delete();
        $this->guard()->login($user);
        return redirect($this->redirectTo );
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }
    
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
    }
    
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    public function username()
    {
        return 'mobile';
    }

}
