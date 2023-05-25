<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class EmailVerifyNotification extends VerifyEmail
{

    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(Lang::get('Verify Email Address'))
            ->line(Lang::get('Please click the button below to verify your email address.'))
            ->action(Lang::get('Verify Account'), $url . '/activated')
            ->line(Lang::get('If you did not create an account, no further action is required.'))
            ->view('email-verify', ['url' => $url]);
    }
}