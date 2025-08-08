<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $details, $data, $cc, $cco;

    public function __construct($details)
    {
        $this->details = $details;

        $this->cc = $this->details['cc'];
        $this->cco = $this->details['cco'];
        $this->data = array(
            'subject' => $this->details['subject'],
            'content' => $this->details['content'],
            'email' => $this->details['email'],
            'email_id'=>$this->details['email_id'],
        );
    }

    public function handle()
    {
        Mail::send('mails.individual', $this->data, function ($message) {

            $message->to($this->data['email']);
            $message->subject($this->data['subject']);
            $message->from('danielcriollo9706@gmail.com', 'Primer LATAM');

            if ($this->cc != '') {
                foreach ($this->cc as $ccemail) {
                    $message->cc($ccemail);
                }
            }

            if ($this->cco != '') {
                foreach ($this->cco as $bccemail) {
                    $message->bcc($bccemail);
                }
            }
        });
    }
}
