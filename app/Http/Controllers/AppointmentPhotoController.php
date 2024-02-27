<?php

namespace App\Http\Controllers;

use App\Http\Resources\Appointment\AppointmentPhotoResource;
use App\Models\Appointment;
use App\Models\AppointmentPhoto;
use App\Services\UploadFile;
use Illuminate\Http\Request;
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
        return response()->json(AppointmentPhotoResource::collection($appointment->photos));
    }

    /**
     * Fotoğraf Ekleme
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Appointment $appointment)
    {
        $imagePath = $this->base64Convertor($request->base64);
        $fullPath = asset($imagePath);
        $response = UploadFile::uploadFile($fullPath, 'appointmentPhotos/appointment'. $appointment->id);
        $appointmentPhoto = new AppointmentPhoto();
        $appointmentPhoto->appointment_id = $appointment->id;
        $appointmentPhoto->image = $response["image"]["way"];
        $appointmentPhoto->save();

        return response()->json([
           'status' => "success",
           'message' => "Fotoğraf Kayıt Edildi"
        ]);
    }
    function base64Convertor($base64){
        $path = storage_path('app/public/temp');
        \File::makeDirectory($path, 0711, true, true);
        $newProfile = "data:image/jpeg;base64,".$base64;
        $data = explode(',', $newProfile);
        $image = base64_decode($data[1]);

        $path = 'temp/' . Str::random(64). ".jpeg";
        Storage::put($path, $image);

        $newUrl = 'storage/'.$path;

        return $newUrl;
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
