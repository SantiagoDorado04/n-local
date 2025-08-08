<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class OrSendCertificateEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to;
    protected $subject;
    protected $content;
    protected $cc;
    protected $bcc;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $subject, $content, $cc = [], $bcc = [])
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->content = $content;
        $this->cc = $cc;
        $this->bcc = $bcc;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            'subject' => $this->subject,
            'email' => $this->to,
            'content' => $this->content,
        ];

        Mail::send('mails.or-send-email-template', $data, function ($message) {
            $message->to($this->to)
                ->subject($this->subject)
                ->from(env('MAIL_USERNAME'), setting('admin.title'));

            if (!empty($this->cc)) {
                $message->cc($this->cc);
            }

            if (!empty($this->bcc)) {
                $message->bcc($this->bcc);
            }
        });
    }
}
