<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmailForm implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details, $data;

    public function __construct($details)
    {
        $this->details = $details;
        $this->data = array(
            'subject' => $this->details['subject'],
            'email' => $this->details['email'],
            'convocations'=>$this->details['convocations'],
            'name'=>$this->details['name'],
            'form'=>$this->details['form']
        );
    }

    
    public function handle()
    {
        Mail::send('mails.form', $this->data, function ($message) {
            $message->to($this->data['email']);
            $message->subject($this->data['subject']);
            $message->from(env('MAIL_USERNAME'),  setting('admin.title'));
        });
    }
}
