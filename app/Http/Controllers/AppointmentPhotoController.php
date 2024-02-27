<?php

namespace App\Http\Controllers;

use App\Http\Resources\Appointment\AppointmentPhotoResource;
use App\Models\Appointment;
use App\Models\AppointmentPhoto;
use App\Services\UploadFile;
use Illuminate\Http\Request;

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
        return response()->json(AppointmentPhotoResource::collection($appointment->photos));
    }

    /**
     * Fotoğraf Ekleme
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasAny('image')){
            return response()->json([
                'message' => "Görsel Gönderildi"
            ]);
        }
        $appointment = Appointment::find($request->appointmentId);
        $response = UploadFile::uploadFile($request->file('image'), 'appointmentPhotos/appointment'. $appointment->id);
        $appointmentPhoto = new AppointmentPhoto();
        $appointmentPhoto->appointment_id = $appointment->id;
        $appointmentPhoto->image = $response["image"]["way"];
        $appointmentPhoto->save();

        return response()->json([
           'status' => "success",
           'message' => "Fotoğraf Kayıt Edildi"
        ]);
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
