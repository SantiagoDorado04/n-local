<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WaOfiJob implements ShouldQueue
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
        $url = 'https://graph.facebook.com/v13.0/' . env('DESCRIPTION_WA ') . '/messages';
        $token = env('TOKEN_WA ');

        $post_data = json_encode(array(
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $this->phone, 'type' => 'text',
            'text' => array('preview_url' => true, 'body' => $this->message)
        ), JSON_FORCE_OBJECT);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            )
        );

        $result = curl_exec($ch);

        return $result;
    }
}
