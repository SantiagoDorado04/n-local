<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmailUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details, $data;

    public function __construct($details)
    {
        $this->details = $details;
        $this->data = array(
            'subject' => $this->details['subject'],
            'email' => $this->details['email'],
            'name'=>$this->details['name'],
        );
    }


    public function handle()
    {
        Mail::send('mails.user', $this->data, function ($message) {
            $message->to($this->data['email']);
            $message->subject($this->data['subject']);
            $message->from('danielcriollo9706@gmail.com', 'Primer LATAM');
        });
    }
}

