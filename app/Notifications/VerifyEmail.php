<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

class VerifyEmail extends VerifyEmailBase
{
	public function toMail($notifiable): MailMessage
	{
		$url = $this->verificationUrl($notifiable);
		return (new MailMessage())
			->subject(Lang::get(__('email.email-verification-subject')))
			->view(
				'email.email-verification',
				['url'  => $url,
					'name' => $notifiable->name]
			);
	}
}
