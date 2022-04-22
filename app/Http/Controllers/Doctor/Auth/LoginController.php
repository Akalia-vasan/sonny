<?php

namespace App\Http\Controllers\Doctor\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
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
    protected $redirectTo = RouteServiceProvider::DOCTORHOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:doctor')->except('logout');
    }
    protected function guard()
    {
        return Auth::guard('doctor');
    }

    public function showLoginForm()
    {
        return view('doctor.auth.login');
    }
    
    protected function validateLogin(Request $request)
    {
        // dd($this->guard());
        $request->validate([
            'email' => 'required|string|exists:doctors',
            'password' => 'required|string',
        ],[
           'email.exists' => 'Email does not exist.'
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'password' => 'Password is Wrong.',
        ]);
    }

    protected function loggedOut(Request $request)
    {
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect(route('doctor.login'));
    }
}
