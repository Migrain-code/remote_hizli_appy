<?php

namespace App\Http\Controllers\Business\Auth;

use App\Http\Controllers\Controller;
use App\Mail\BasicMail;
use App\Models\Business;
use App\Providers\RouteServiceProvider;
use App\Services\Sms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

        $this->middleware('guest:business');
    }

    public function showRegistrationForm()
    {

        return view('business.auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'owner'=> ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:20', 'unique:businesses'],
        ], [], [
            'name' => 'İşletme Adı',
            'email' => 'Telefon Numarası',
            'owner'=>'Salon Sahibi'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return Model|Business
     */
    protected function create(array $data)
    {
        $generateCode=rand(100000, 999999);
        $phone=str_replace(array('(', ')', '-', ' '), '', $data["email"]);
        Sms::send($phone,config('settings.bussiness_site_title'). "Sistemine giriş için, telefon numarası doğrulama kodunuz ". $generateCode);

        return Business::create([
            'name' => $data['name'],
            'owner' => $data['owner'],
            'email' => $data['email'],
            'status'=>1,
            'password' => Hash::make(Str::random(8)),
            'package_id'=>1,
            'verification_code'=>$generateCode,
        ]);

    }
    protected function registered(Request $request, $user)
    {
        return to_route('business.verify');

    }
}
