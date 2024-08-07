<?php

namespace App\Http\Controllers;

use App\Http\Resources\Comment\CommentListResource;
use App\Models\BusinessComment;
use Illuminate\Http\Request;

/**
 * @group Yorumlar
 *
 */
class BusinessCommentController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            return $next($request);
        });
    }

    /**
     * Yorum Listesi
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'comments' => CommentListResource::collection($this->business->comments),
            'commentTotal' => $this->business->comments->count(),
            'commentPoint' => $this->business->comments->sum('point') > 0 ? ($this->business->comments->sum('point') / $this->business->comments()->count()) : 0
        ]);
    }

    /**
     * Yorum Durumu Güncelleme
     * @param Request $request
     * @param BusinessComment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, BusinessComment $comment)
    {
        $comment->status = !$comment->status;
        $comment->save();

        if ($comment->status == 1) {
            return response()->json([
                'status' => "success",
                'message' => "Yorum Yayına Alındı"
            ]);
        } else {
            return response()->json([
                'status' => "success",
                'message' => "Yorum Yayından Kaldırıldı"
            ]);
        }

    }

    /**
     * Yorum Silme
     * @param BusinessComment $comment
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function destroy(BusinessComment $comment)
    {
        if ($comment->delete()) {
            return response()->json([
                'status' => "success",
                'message' => "Yorum Silindi"
            ]);
        }
    }
}
