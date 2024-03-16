<?php

namespace App\Http\Controllers\PersonelAccount\Notification;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationPermission\PermissionUpdateRequest;
use App\Http\Resources\NotificationPermission\NotificationPermissionListResource;
use App\Models\BusinessNotificationPermission;

/**
 * @group Personel Bildirim İzinleri
 *
 */
class PersonelNotificationPermissionController extends Controller
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
     * Bildirim İzinleri
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (isset($this->personel->permission) == false){
            $this->personel->createPermission();
        }
        return response()->json(NotificationPermissionListResource::make($this->personel->permission));
    }

    /**
     * Bildirim Güncelle
     *
     * is_email,is_sms,is_phone,is_notification örnek gönderim ({"column": "is_email"})
     *
     * @param  PermissionUpdateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PermissionUpdateRequest $request)
    {
        $notificationPermission = $this->personel->permission;
        $notificationPermission->{$request->column} = !$notificationPermission->{$request->column};
        if ($notificationPermission->save()){
            return response()->json([
                'status' => "success",
                'message' => "Bildirim Ayarlarınız Güncellendi",
            ]);
        }
    }

}
