<?php

namespace App\Http\Controllers;

use App\Http\Requests\Birthday\MessageSendRequest;
use App\Http\Resources\Birthday\BirthdayMessageListResource;
use App\Http\Resources\CustomerListResource;
use App\Models\Customer;
use App\Models\MessageList;
use App\Services\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @group Birthday
 *
 */
class BirthdayController extends Controller
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
     * Doğum Günü Listesi.
     *
     * Doğum günü olan işletme müşterileri gelecek bu endpointte takvime tıklanınca bu apiye " date " değişkeninde tarihi gönderebilirsiniz
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $reqDate = Carbon::parse($request->input('date'));

        $customers = $this->user->business->customers()->whereHas('customer', function ($q) use ($reqDate){
            $q->whereDate('birthday', $reqDate->toDateString());
        })->get();


        return response()->json([
            'date' => $reqDate->translatedFormat('d F D'),
            'customers' => CustomerListResource::collection($customers)
        ]);
    }

    /**
     * Mesaj Listesi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return response()->json(BirthdayMessageListResource::collection(MessageList::whereStatus(1)->get()));
    }

    /**
     * Mesajları Gönder
     *
     * @param  MessageSendRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MessageSendRequest $request)
    {
        $message = MessageList::find($request->input('messageId'));
        $title = $message->title;
        $content = $message->content;

        $reqDate = now();
        $customers = $this->user->business->customers()->whereHas('customer', function ($q) use ($reqDate){
            $q->whereDate('birthday', $reqDate->toDateString());
        })->get();

        foreach ($customers as $findCustomer){

            $newContent = str_replace('[]', $findCustomer->name, $content);

            Sms::send($findCustomer->phone, $newContent);
            //$findCustomer->sendNotification($title, $content);
            //Push Bildirim Eklenecek
        }
        return response()->json([
           'stutus' => "success",
           'message' => "Mesajlar Gönderildi",
        ]);
    }
}
