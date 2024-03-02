<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationPermission\PermissionUpdateRequest;
use App\Http\Resources\NotificationPermission\NotificationPermissionListResource;
use App\Models\BusinessNotificationPermission;
use Illuminate\Http\Request;

/**
 * @group NotificationPermission
 *
 */
class BusinessNotificationPermissionController extends Controller
{
    private $business;
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            $this->user = auth()->user();
            return $next($request);
        });
    }
    /**
     * Bildirim İzinleri
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(NotificationPermissionListResource::make($this->user->permission));
    }

    /**
     * Bildirim Güncelle
     *
     * Bildirim izinleri listesindeki response dönen verilerden is_email,is_sms,is_phone,is_notification örnek gönderim ({"column": "is_email"})
     *
     * @param  PermissionUpdateRequest  $request
     * @param  BusinessNotificationPermission $notificationPermission
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PermissionUpdateRequest $request, BusinessNotificationPermission $notificationPermission)
    {
        $notificationPermission->{$request->column} = !$notificationPermission->{$request->column};
        if ($notificationPermission->save()){
            return response()->json([
                'status' => "success",
                'message' => "Bildirim Ayarlarınız Güncellendi",
            ]);
        }
    }

}
