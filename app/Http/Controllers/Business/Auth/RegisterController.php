<?php

namespace App\Http\Controllers\Business\Auth;

use App\Http\Controllers\Controller;
use App\Mail\BasicMail;
use App\Models\Business;
use App\Models\BusinessNotificationPermission;
use App\Models\BusinessOfficial;
use App\Models\SmsConfirmation;
use App\Providers\RouteServiceProvider;
use App\Services\Sms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $this->middleware('guest:official');
    }

    public function showRegistrationForm()
    {

        return view('business.auth.register');
    }


    protected function register(Request $request)
    {
        if ($this->existPhone(clearPhone($request->phone))) {
            return back()->with('response', [
                'status' => "warning",
                'message' => "Bu telefon numarası ile kayıtlı kullanıcı bulunmakta."
            ]);
        } else {

            $this->createVerifyCode(clearPhone($request->phone));

            $business = new Business();
            $business->name = $request->business_name;
            $business->company_id = rand(1000000, 9999999);
            $business->package_id = 1;

            $user = new BusinessOfficial();
            $user->phone = clearPhone($request->phone);
            $user->name = $request->input('name');
            $user->password = Hash::make(rand(10000, 80000));
            $user->business_id = $business->id;

            session()->put('newBusiness', $business);
            session()->put('newBusinessOfficial', $user);

            return to_route('business.verify.showForm')->with('response', [
                'status' => "success",
                'message' => "Telefon Numaranızı Doğrulamanız için Kod Gönderildi"
            ]);
        }

    }

    public function verify(Request $request)
    {

        $codes = [
            "code_1" => $request->input("code_1"),
            "code_2" => $request->input("code_2"),
            "code_3" => $request->input("code_3"),
            "code_4" => $request->input("code_4"),
            "code_5" => $request->input("code_5"),
            "code_6" => $request->input("code_6")
        ];

        $implodeCode = implode("", $codes);

        $code = SmsConfirmation::where("code", $implodeCode)->where('action', 'OFFICIAL-REGISTER')->first();

        if ($code) {

            if ($code->expire_at < now()) {

                $this->createVerifyCode($code->phone);

                return back()->with('response', [
                    'status' => "warning",
                    'message' => "Doğrulama Kodunun Süresi Dolmuş. Doğrulama Kodu Tekrar Gönderildi"
                ]);

            } else {
                $authUserPhone = session()->get('hashedUser');

                if ($authUserPhone) {

                    $authUser = BusinessOfficial::where('phone', $authUserPhone)->first();
                    if ($code->phone == $authUser->phone) {
                        $authUser->verify_phone = 1;
                        $authUser->save();
                        Auth::guard('official')->loginUsingId($authUser->id);
                        return to_route('business.home')->with('response', [
                            'status' => "success",
                            'message' => "Telefon Numaranız doğrulandı. Sisteme erişiminiz açıldı."
                        ]);
                    } else {
                        return back()->with('response', [
                            'status' => "error",
                            'message' => "Doğrulama Kodu Hatalı veya Yanlış Tuşladınız."
                        ]);
                    }
                } else {
                    $user = session()->get('newBusinessOfficial');
                    $business = session()->get('newBusiness');
                    if ($code->phone == $user->phone) {

                        $generatePassword = rand(100000, 999999);

                        $business = $this->createBusiness($business->name);

                        $newUser = new BusinessOfficial();
                        $newUser->name = $user->name;
                        $newUser->phone = $code->phone;
                        $newUser->password = Hash::make($generatePassword);
                        $newUser->business_id = $business->id;
                        $newUser->verify_phone = 1;
                        $newUser->save();

                        $this->setAdmin($business, $user);
                        $this->addPermission($business->id);

                        Sms::send(clearPhone($request->input('phone')), config('settings.appy_site_title') . "Sistemine giriş için şifreniz " . $generatePassword);

                        return to_route('business.login')->with('response', [
                            'status' => "success",
                            'message' => "Telefon Numaranız doğrulandı. Sisteme giriş için şifreniz gönderildi."
                        ]);
                    } else {
                        return back()->with('response', [
                            'status' => "error",
                            'message' => "Doğrulama Kodu Hatalı veya Yanlış Tuşladınız."
                        ]);
                    }
                }
            }


        } else {
            return back()->with('response', [
                'status' => "error",
                'message' => "Doğrulama Kodu Hatalı veya Yanlış Tuşladınız"
            ]);
        }

    }

    public function existPhone($phone)
    {
        $existPhone = BusinessOfficial::where('phone', $phone)->first();
        if ($existPhone != null) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function createVerifyCode($phone)
    {
        $generateCode = rand(100000, 999999);
        $smsConfirmation = new SmsConfirmation();
        $smsConfirmation->phone = $phone;
        $smsConfirmation->action = "OFFICIAL-REGISTER";
        $smsConfirmation->code = $generateCode;
        $smsConfirmation->expire_at = now()->addMinute(3);
        $smsConfirmation->save();

        Sms::send(clearPhone($phone), setting('appy_site_title') . "Sistemine kayıt için, telefon numarası doğrulama kodunuz " . $generateCode);

        return $generateCode;
    }

    function createBusiness($business_name)
    {
        $business = new Business();
        $business->name = $business_name;
        $business->company_id = rand(1000000, 9999999);
        $business->package_id = 1;
        $business->save();

        return $business;
    }

    function addPermission($id)
    {
        $businessPermission = new BusinessNotificationPermission();
        $businessPermission->business_id = $id;
        $businessPermission->save();
        return true;
    }

    function setAdmin($business, $user)
    {
        $business->admin_id = $user->id;
        $business->save();
    }
}
