<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class SendCustomMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $to;
    public $subject;
    public $htmlContent;

    public function __construct($to, $subject, $htmlContent)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->htmlContent = $htmlContent;
    }

    public function handle(): void
    {
        Mail::send([], [], function (Message $message) {
            $message->to($this->to)
                ->subject($this->subject)
                ->html($this->htmlContent);
        });
    }
}
