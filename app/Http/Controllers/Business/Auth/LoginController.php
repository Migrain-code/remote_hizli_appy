<?php

namespace App\Http\Controllers\Business\Auth;

use App\Http\Controllers\Controller;
use App\Models\BusinessOfficial;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $this->middleware('guest:official')->except('logout');
    }

    public function showLoginForm()
    {
        return view('business.auth.login');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ], [], [
            'phone' => 'Telefon Numarası',
            'password' => 'Parola'
        ]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);


        $official = BusinessOfficial::where('phone', clearPhone($request->input('phone')))->first();
        if ($official && Hash::check($request->input('password'), $official->password)) {
            Auth::guard('official')->loginUsingId($official->id);
            return to_route('business.home')->with('response', [
                'status' => "success",
                'message' => "Sisteme Hoşgeldiniz"
            ]);
        } else {
            return to_route('business.login')->with('response', [
                'status' => "error",
                'message' => "Telefon Numarası veya Şifre Hatalı"
            ]);
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    protected function guard()
    {
        return Auth::guard('official');
    }

    public function username()
    {
        return 'phone';
    }

}
