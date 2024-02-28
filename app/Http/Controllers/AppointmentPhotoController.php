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
        return response()->json(AppointmentPhotoResource::collection($appointment->photos));
    }

    /**
     * Fotoğraf Ekleme
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Appointment $appointment)
    {
        $data = [
            "appointmentId" => 23,
            "image" => [
                "_parts" => [
                    "uri" => "file:///Users/mertkutukcu/Library/Developer/CoreSimulator/Devices/6F4B1515-3F5A-43F1-AD41-8624938FB5B9/data/Containers/Data/Application/FA783FE3-0ABE-42AE-B7C3-0F5F9336443E/tmp/038E6BCC-AFA2-469D-8075-4F88E8975550.jpg",
                    "type" => "image/jpeg",
                    "name" => "038E6BCC-AFA2-469D-8075-4F88E8975550.jpg"
                ]
            ]
        ];

        // Dosya yolunu al
        $filePath = $data['image']['_parts']['uri'];

        // Dosya tipini al
        $fileType = $data['image']['_parts']['type'];

        // Dosya adını al
        $fileName = $data['image']['_parts']['name'];

        // Dosya boyutunu al (örnek olarak 1024 byte kullanılıyor)
        $fileSize = 1024; // Gerçek dosya boyutunu burada belirtmelisiniz

        // Dosya örneğini oluştur
        $file = new UploadedFile($filePath, $fileName, $fileType, $fileSize);

        // Dosya örneğini request'e ekleyin
        $request->files->set('image', $file);
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
