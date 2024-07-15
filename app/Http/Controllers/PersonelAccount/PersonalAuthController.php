<?php

namespace App\Http\Controllers\PersonelAccount;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonelAccount\PasswordUpdateRequest;
use App\Http\Requests\PersonelAccount\PersonalLoginRequest;
use App\Http\Resources\Personel\PersonelResource;
use App\Http\Resources\PersonelAccount\AccountResource;
use App\Models\Device;
use App\Models\Personel;
use App\Models\SmsConfirmation;
use App\Services\NotificationService;
use App\Services\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group PersonalAuth
 *
 */
class PersonalAuthController extends Controller
{
    /**
     * Personel Girişi
     * @param PersonalLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(PersonalLoginRequest $request)
    {
        $user = Personel::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Telefon Numarası veya şifre yanlış'
            ], 401);
        }

        $token = $user->createToken('Access Token')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => AccountResource::make($user),
        ]);
    }

    /**
     * Personel Çıkış Yap
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
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
     * Personel Bilgisi
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        $personel = auth('personel')->user();
        return response()->json(AccountResource::make($personel));
    }

    public function passwordReset(Request $request)
    {
        $user = Personel::where('phone', clearPhone($request->input('phone')))->first();
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

    public function verifyResetPassword(Request $request)
    {
        $code = SmsConfirmation::where("code", $request->code)->where('action', 'PERSONEL-PASSWORD-RESET')->first();
        if ($code) {
            if ($code->expire_at < now()) {

                $this->resetVerifyCode($code->phone);

                return response()->json([
                    'status' => "warning",
                    'message' => "Doğrulama Kodunun Süresi Dolmuş. Doğrulama Kodu Tekrar Gönderildi"
                ]);

            } else {
                $generatePassword = rand(100000, 999999);
                $official = Personel::where('phone', $code->phone)->first();
                $official->password = Hash::make($generatePassword);
                if ($official->save()) {
                    Sms::send($code->phone, config('settings.appy_site_title') . " Sistemine giriş için yeni şifreniz " . $generatePassword);
                    return response()->json([
                        'status' => "success",
                        'message' => "Telefon Numaranız doğrulandı. Sisteme giriş için yeni şifreniz gönderildi."
                    ]);
                }
            }
        }
    }

    function resetVerifyCode($phone)
    {
        $generateCode = rand(100000, 999999);
        $smsConfirmation = new SmsConfirmation();
        $smsConfirmation->phone = clearPhone($phone);
        $smsConfirmation->action = "PERSONEL-PASSWORD-RESET";
        $smsConfirmation->code = $generateCode;
        $smsConfirmation->expire_at = now()->addMinute(3);
        $smsConfirmation->save();

        Sms::send($smsConfirmation->phone, setting('appy_site_title') . " Şifre yenileme için, telefon numarası doğrulama kodunuz " . $generateCode);

        return $generateCode;
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        $personel = auth('personel')->user();
        $personel->password = Hash::make($request->input('password'));
        if ($personel->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Şifreniz Güncellendi"
            ]);
        }
    }

    /**
     * Bildiriim Tokenı Kaydetme
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveToken(Request $request)
    {
        $user = auth('personel')->user();
        $title = "Merhaba ". $user->name;
        $message = "Hızlı Randevu Sistemine Hoşgeldiniz";
        if (isset($user->device)){
            $deviceToken = $request->input('device_token');
            if (isset($deviceToken) && $user->device->token != $deviceToken) { // İŞTE BU SATIR
                $device = $user->device;
                $device->token = $deviceToken;
                $device->save();
            }
            NotificationService::sendPushNotification($user->device->token, $title, $message);
        } else{
            if ($request->filled('device_token')){
                $device = new Device();
                $device->customer_id = $user->id;
                $device->token = $request->input('device_token');
                $device->type = 2;//personel, 3 => business Token
                $device->save();
                NotificationService::sendPushNotification($device->token, $title, $message);

            }
        }
        return response()->json([
           'status' => "success",
           'message' => "Cihaz Kayıt Edildi"
        ]);
    }
}
