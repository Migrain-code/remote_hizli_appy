<?php

namespace App\Http\Controllers\PersonelAccount;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonelAccount\PersonalLoginRequest;
use App\Http\Resources\Personel\PersonelResource;
use App\Http\Resources\PersonelAccount\AccountResource;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group PersonalAuth
 *
 */
class PersonalAuthController extends Controller
{
    private $personel;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->personel = auth('personel')->user();
            return $next($request);
        });
    }

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
        return response()->json(AccountResource::make($this->personel));
    }
}
