<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class NewSendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $subject;
    protected $content;
    protected $data;

    public function __construct($email, $subject, $content)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->content = $content;

        $this->data = array(
            'subject' => $this->subject,
            'email' => $this->email,
            'content' => $this->content
        );
    }

    public function handle()
    {
        Mail::send('mails.send-email-template', $this->data, function ($message) {
            $baseUrl = env('API_ENDPOINT');
            $message->to($this->data['email']);
            $message->subject($this->data['subject' . $baseUrl]);
            $message->from(env('MAIL_USERNAME'), setting('admin.title'));
        });
    }
}
