<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\RoomAddRequest;
use App\Http\Resources\Rooms\RoomsDetailResource;
use App\Http\Resources\Rooms\RoomsListResource;
use App\Models\BusinessRoom;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use function App\Http\Controllers\create_delete_button;
use function App\Http\Controllers\create_edit_button;
use function App\Http\Controllers\create_switch;
use function App\Http\Controllers\createCheckbox;

/**
 * @group Oda İşlemleri
 *
 */
class BusinessRoomController extends Controller
{
    private $business;
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            $this->business = $this->user->business;
            return $next($request);
        });
    }
    /**
     * Oda Listesi
     *
     */
    public function index()
    {
        $rooms = $this->business->rooms;
        return response()->json(RoomsListResource::collection($rooms));
    }

    /**
     * Oda Ekleme
     *
     */
    public function store(Request $request)
    {
        $businessRoom = new BusinessRoom();
        $businessRoom->business_id = $this->business->id;
        $businessRoom->name = $request->input('name');
        $businessRoom->color = $request->input('color_code');
        $businessRoom->increase_type = 1; // yüzdelik fiyat artışı
        $businessRoom->price = $request->input('price');
        if ($businessRoom->save()){
            return response()->json([
               'status' => "success",
               'message' => "Oda Başarılı Bir Şekilde Eklendi"
            ]);
        }
    }

    /**
     * Oda Düzenleme
     *
     */
    public function show(BusinessRoom $room)
    {
        return response()->json(RoomsDetailResource::make($room));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomAddRequest $request, BusinessRoom $room)
    {
        $room->name = $request->input('name');
        $room->color = $request->input('color_code');
        //$room->increase_type = $request->input('increase_type');
        $room->price = $request->input('price');
        if ($request->filled('status')){
            $room->status = $request->status;
        }
        if ($room->save()){
            return response()->json([
                'status' => "success",
                'message' => "Oda Bilgileri Başarılı Şekilde Güncellendi"
            ]);
        }
    }
    /**
     * Oda Silme
     *
     */
    public function destroy(BusinessRoom $room)
    {
        if ($room->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Oda Bilgileri Silindi"
            ]);
        }

    }
}
