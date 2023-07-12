<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordBase;

class ResetPassword extends ResetPasswordBase
{
	public function toMail($notifiable): MailMessage
	{
		$url = $this->resetUrl($notifiable);

		$url = env('FRONT_BASE_URL') . '/reset-password?token=' . $this->token . '&email=' . urlencode($notifiable->email);

		return (new MailMessage())
		->subject('Reset Password')
		->view(
			'email.reset-message',
			['url'  => $url,
				'name' => $notifiable->username]
		);
	}
}
