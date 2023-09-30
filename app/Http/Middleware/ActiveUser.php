<?php

namespace App\Http\Middleware;

use App\Models\SmsConfirmation;
use App\Services\Sms;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       
        if (auth('official')->check() && auth('official')->user()->verify_phone != 1) {
            $this->createVerifyCode(auth('official')->user()->phone);
            session()->put('hashedUser', auth('official')->user()->phone);
            Auth::guard('official')->logout();
            return to_route('business.verify.showForm')->with('response', [
                'status'=>"error",
                'message'=>"Telefon Numaranızı doğrulamanız gerekmektedir. Telefonunuza gönderilen kodu giriniz. ",
            ]);

        }
        return $next($request);
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
}
