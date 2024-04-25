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


    /**
     * Bildirim Detayı
     *
     * @param BusinessNotification $notification
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessNotification $notification)
    {
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
