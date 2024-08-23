<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationPermission\PermissionUpdateRequest;
use App\Http\Resources\DeviceNotificationPermission\DeviceNotificationPermissionListResource;
use App\Models\BusinessDeviceNotificationPermission;
use Illuminate\Http\Request;

/**
 * @group Cihaz Bildirimleri
 *
 */
class BusinessDeviceNotificationPermissionController extends Controller
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $permissions = $this->user->devicePermission;
       
        if (!isset($permissions)){
            $permissions = new BusinessDeviceNotificationPermission();
            $permissions->business_id = $this->user->id;
            $permissions->save();
        }

        return response()->json(DeviceNotificationPermissionListResource::make($permissions));
    }

    /**
     * Bildirim Güncelle
     *
     * Bildirim izinleri listesindeki response dönen verilerden is_email,is_sms,is_phone,is_notification örnek gönderim ({"column": "is_email"})
     *
     * @param  PermissionUpdateRequest  $request
     * @param  BusinessDeviceNotificationPermission $notificationPermission
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PermissionUpdateRequest $request, BusinessDeviceNotificationPermission $deviceNotificationPermission)
    {
        $deviceNotificationPermission->{$request->column} = !$deviceNotificationPermission->{$request->column};
        if ($deviceNotificationPermission->save()){
            return response()->json([
                'status' => "success",
                'message' => "Bildirim Ayarlarınız Güncellendi",
            ]);
        }
    }
}
