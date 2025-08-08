<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone, $message, $data;

    public function __construct($user, $message)
    {
        $this->phone = $user;
        $this->message = $message;

        $this->data = array(
            'phone' => $this->phone,
            'message' => $this->message
        );
    }

    public function handle()
    {
        $client = new Client();
        $client->post('https://api.twilio.com/2010-04-01/Accounts/' .env('SID_TWILIO') . '/Messages.json', [
            'auth' => [env('SID_TWILIO'), env('AUTH_TOKEN_TWILIO')],
            'form_params' => [
                'To' => $this->phone,
                'From' => env('FROM_NUMBER_TWILIO'),
                'Body' => $this->data['message'],
            ],
        ]);
        return $client;
    }
}
