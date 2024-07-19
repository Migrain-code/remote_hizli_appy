<?php

namespace App\Jobs;

use App\Models\Appointment;
use App\Services\Sms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $appointment;
    /**
     * Create a new job instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Hatırlatma mesajını gönderme kodu buraya gelecek
        $customer = $this->appointment->customer;
        $business = $this->appointment->business;
        $message = "Değerli Müşterimiz, {$business->name} işletmesinden aldığınız {$this->appointment->start_time->format('d.m.Y H:i')} randevusu için bir hatırlatma mesajıdır. Zamanında gelmenizi rica ederiz. Teşekkürler.";
        //Sms::send($customer->phone, $message);
        $customer->sendNotification('Randevu Hatırlatma', $message);
    }
}
