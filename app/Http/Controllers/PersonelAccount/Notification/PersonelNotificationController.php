<?php

namespace App\Http\Controllers\PersonelAccount\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationListResource;
use App\Models\BusinessNotification;
use App\Models\PersonelNotification;

/**
 * @group Personel Bildirimler
 *
 */
class PersonelNotificationController extends Controller
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
     * Bildirimler
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(NotificationListResource::collection($this->personel->notifications));
    }


    /**
     * Bildirim Detayı
     *
     * @param PersonelNotification $notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PersonelNotification $notification)
    {
        return response()->json(NotificationListResource::make($notification));
    }

    /**
     * Bildirim Sil
     *
     * @param PersonelNotification $notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PersonelNotification $notification)
    {
        if ($notification->delete()) {
            return response()->json([
                'status' => "success",
                'message' => "Bildirim Silindi"
            ]);
        }
    }
}
