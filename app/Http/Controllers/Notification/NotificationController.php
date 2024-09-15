<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationListResource;
use App\Models\BusinessNotification;

/**
 * @group Notifications
 *
 */
class NotificationController extends Controller
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
     * Bildirimler
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(NotificationListResource::collection($this->user->notifications));
    }

    public function store()
    {
        BusinessNotification::where('business_id', $this->user->id)->update([
            'status' => 1,
        ]);
        return response()->json([
            'status' => "success",
            'message' => "Tüm Bildirimleriniz Okundu Olarak İşaretlendi"
        ]);
    }
    /**
     * Bildirim Detayı
     *
     * @param BusinessNotification $notification
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessNotification $notification)
    {
        $notification->status = 1;
        $notification->save();
        return response()->json(NotificationListResource::make($notification));
    }

    /**
     * Bildirim Sil
     *
     * @param BusinessNotification $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessNotification $notification)
    {
        if ($notification->delete()) {
            return response()->json([
                'status' => "success",
                'message' => "Bildirim Silindi"
            ]);
        }
    }

    /**
     * Parapuan Bildirimleri
     * @return \Illuminate\Http\JsonResponse
     */
    public function cashPointNotification()
    {
        return response()->json(NotificationListResource::collection($this->user->cashPointnotifications));
    }
}
