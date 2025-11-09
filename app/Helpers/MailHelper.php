<?php

use Illuminate\Mail\Message;
use App\Jobs\SendCustomMailJob;
use Illuminate\Support\Facades\Mail;

if (!function_exists('sendCustomMail')) {
    function sendCustomMail(string $to, string $subject, string $htmlContent): void
    {
        // Dispatch email to queue instead of sending instantly
        dispatch(new SendCustomMailJob($to, $subject, $htmlContent));
    }
}
