<?php

namespace App\Http\Controllers;

use App\Http\Resources\Appointment\AppointmentPhotoResource;
use App\Models\Appointment;
use App\Models\AppointmentPhoto;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @group Appointment
 *
 */
class AppointmentPhotoController extends Controller
{
    /**
     * Randevu Fotoğraf Listesi
     *
     * @param \App\Models\Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function index(Appointment $appointment)
    {
        return response()->json([
            'photos' => AppointmentPhotoResource::collection($appointment->photos),
            'total' => $appointment->photos->count(),
        ]);
    }

    /**
     * Fotoğraf Ekleme
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Appointment $appointment)
    {
        if ($request->hasFile('image')) {
            $response = UploadFile::uploadFile($request->file('image'), 'appointmentPhotos/appointment'. $appointment->id);
            $appointmentPhoto = new AppointmentPhoto();
            $appointmentPhoto->appointment_id = $appointment->id;
            $appointmentPhoto->image = $response["image"]["way"];
            $appointmentPhoto->save();

            return response()->json([
                'status' => "success",
                'message' => "Fotoğraf Kayıt Edildi"
            ]);
        } else{
            return response()->json([
                'status' => "error",
                'message' => "Fotoğraf Seçilmesi Zorunludur",
            ], 422);
        }

    }
    /**
     * Randevu Fotoğrafı silme
     *
     * Bunda fotoğrafın id gönderilecek
     *
     * @param  \App\Models\AppointmentPhoto  $appointmentPhoto
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppointmentPhoto $appointmentPhoto)
    {
        if ($appointmentPhoto->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Fotoğraf Silindi"
            ]);
        }
    }
}
