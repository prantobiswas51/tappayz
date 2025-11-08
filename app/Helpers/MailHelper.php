<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

if (!function_exists('sendCustomMail')) {
    function sendCustomMail(string $to, string $subject, string $htmlContent): void
    {
        Mail::send([], [], function (Message $message) use ($to, $subject, $htmlContent) {
            $message->to($to)
                ->subject($subject)
                ->html($htmlContent);
        });
    }
}
