<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerCreateRequest;
use App\Http\Resources\Business\BusinessOfficialResource;
use App\Models\Business;
use App\Models\BusinessNotificationPermission;
use App\Models\BusinessOfficial;
use App\Models\CustomerNotificationPermission;
use App\Models\SmsConfirmation;
use App\Services\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group Authentication
 */
class AuthController extends Controller
{

    /**
     * POST api/auth/login
     *
     * Status Codes
     * <ul>
     * <li>phone</li>
     * <li>password</li>
     * <li> 401 Unauthorized Hatası </li>
     * </ul>
     * Login apisi
     *
     *
     */
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = BusinessOfficial::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Telefon Numarası veya şifre yanlış'
            ], 401);
        }

        $token = $user->createToken('Access Token')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => BusinessOfficialResource::make($user),
        ]);
    }

    /**
     * POST api/auth/logout
     *
     *
     * <ul>
     * <li>Token Göndermeniz Yeterli</li>
     * </ul>
     * Logout apisi
     *
     * @header Bearer {token}
     *
     */
    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Sistemden Çıkış Yapıldı']);
    }

    /**
     * GET api/auth/user
     *
     *
     * <ul>
     * <li>Token Göndermeniz Yeterli</li>
     * </ul>
     * Logout apisi
     *
     * @header Bearer {token}
     *
     */
    public function user(Request $request)
    {
        return response()->json(BusinessOfficialResource::make($request->user()));
    }

    /**
     * POST api/auth/check-phone
     *
     *
     * <ul>
     * <li>phone | string | required</li>
     * </ul>
     * telefon numarası kontrol apisi
     *
     *
     */
    public function register(Request $request)
    {
        $this->createVerifyCode($request->phone);

        return response()->json([
            'status' => "success",
            'message' => "Lütfen Telefon Numaranızı Doğrulayınız"
        ]);
        /*if ($this->existPhone(clearPhone($request->phone))) {
            return response()->json([
                'status' => "warning",
                'message' => "Bu telefon numarası ile kayıtlı kullanıcı bulunmakta."
            ]);
        } else {

            $this->createVerifyCode($request->phone);

            return response()->json([
                'status' => "success",
                'message' => "Lütfen Telefon Numaranızı Doğrulayınız"
            ]);
        }*/
    }

    /**
     * POST api/auth/verify
     *
     *
     * <ul>
     * <li>code | string | required | Doğrulama Kodu</li>
     * <li>phone | string | required | Kullanıcı Telefon Numarası</li>
     * <li>name | string | required | Kullanıcı Adı</li>
     * <li>business_name | string | required | İşletme Adı</li>
     * <li>phone | string | required</li>
     * </ul>
     * Kod doğrulama ve kullanıcı kayıt apisi
     *
     *
     */
    public function verify(Request $request)
    {
        $code = SmsConfirmation::where("code", $request->code)->where('action', 'OFFICIAL-REGISTER')->first();
        if ($code) {
            if ($code->expire_at < now()) {

                $this->createVerifyCode($code->phone);

                return response()->json([
                    'status' => "warning",
                    'message' => "Doğrulama Kodunun Süresi Dolmuş. Doğrulama Kodu Tekrar Gönderildi"
                ]);

            } else {

                if ($code->phone == $request->phone) {
                    $generatePassword = rand(100000, 999999);

                    $business = $this->createBusiness($request->business_name);

                    $user = new BusinessOfficial();
                    $user->name = $request->name;
                    $user->phone = $code->phone;
                    $user->password = Hash::make($generatePassword);
                    $user->business_id = $business->id;
                    $user->is_admin = 1;
                    $user->save();

                    $this->setAdmin($business, $user);
                    $this->addPermission($business->id);

                    Sms::send(clearPhone($request->input('phone')), config('settings.appy_site_title') . "Sistemine giriş için şifreniz " . $generatePassword);

                    return response()->json([
                        'status' => "success",
                        'message' => "Telefon Numaranız doğrulandı. Sisteme giriş için şifreniz gönderildi."
                    ]);
                } else {
                    return response()->json([
                        'status' => "success",
                        'message' => "Doğrulama Kodu Hatalı veya Yanlış Tuşladınız."
                    ]);
                }
            }

        } else {
            return response()->json([
                'status' => "danger",
                'message' => "Doğrulama Kodu Hatalı."
            ]);
        }

    }

    /**
     * POST api/business/auth/reset-password
     *
     *
     * <ul>
     * <li>phone | string | required</li>
     * </ul>
     * Doğrulama yapılacak telefon numarasının gönderilmesi yeterli
     *
     *
     */
    public function passwordReset(Request $request)
    {
        $user = BusinessOfficial::where('phone', clearPhone($request->input('phone')))->first();
        if ($user) {
            $this->resetVerifyCode($request->input('phone'));
            return response()->json([
                'status' => "success",
                'message' => "Telefon Numaranıza Gönderilen Doğrulama Kodunu Giriniz"
            ]);
        } else {
            return response()->json([
                'status' => "warning",
                'message' => "Bu telefon numarası ile kayıtlı kullanıcı bulunamadı"
            ]);
        }
    }

    /**
     * POST api/business/auth/verify-reset-password
     *
     *
     * <ul>
     * <li>code | string | required</li>
     * </ul>
     * Doğrulama yapılacak doğurlama kodunun gönderilmesi yeterli
     *
     *
     */
    public function verifyResetPassword(Request $request)
    {
        $code = SmsConfirmation::where("code", $request->code)->where('action', 'OFFICIAL-PASSWORD-RESET')->first();
        if ($code) {
            if ($code->expire_at < now()) {

                $this->resetVerifyCode($code->phone);

                return response()->json([
                    'status' => "warning",
                    'message' => "Doğrulama Kodunun Süresi Dolmuş. Doğrulama Kodu Tekrar Gönderildi"
                ]);

            } else {
                $generatePassword = rand(100000, 999999);
                $official = BusinessOfficial::where('phone', $code->phone)->first();
                $official->password = Hash::make($generatePassword);
                if ($official->save()) {
                    Sms::send($code->phone, config('settings.appy_site_title') . "Sistemine giriş için yeni şifreniz " . $generatePassword);
                    return response()->json([
                        'status' => "success",
                        'message' => "Telefon Numaranız doğrulandı. Sisteme giriş için yeni şifreniz gönderildi."
                    ]);
                }
            }
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

    function createBusiness($business_name)
    {
        $business = new Business();
        $business->name = $business_name;
        $business->company_id = rand(1000000, 9999999);
        $business->package_id = 1;
        $business->save();

        return $business;
    }

    function createVerifyCode($phone)
    {
        $generateCode = rand(100000, 999999);
        $smsConfirmation = new SmsConfirmation();
        $smsConfirmation->phone = clearPhone($phone);
        $smsConfirmation->action = "OFFICIAL-REGISTER";
        $smsConfirmation->code = $generateCode;
        $smsConfirmation->expire_at = now()->addMinute(3);
        $smsConfirmation->save();

        Sms::send(clearPhone($phone), setting('appy_site_title') . "Sistemine kayıt için, telefon numarası doğrulama kodunuz " . $generateCode);

        return $generateCode;
    }

    function resetVerifyCode($phone)
    {
        $generateCode = rand(100000, 999999);
        $smsConfirmation = new SmsConfirmation();
        $smsConfirmation->phone = clearPhone($phone);
        $smsConfirmation->action = "OFFICIAL-PASSWORD-RESET";
        $smsConfirmation->code = $generateCode;
        $smsConfirmation->expire_at = now()->addMinute(3);
        $smsConfirmation->save();

        Sms::send($smsConfirmation->phone, setting('appy_site_title') . "Şifre yenileme için, telefon numarası doğrulama kodunuz " . $generateCode);

        return $generateCode;
    }
}
