<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdateEmailVerifyMail extends Mailable
{
	use Queueable;

	use SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @param User   $user
	 * @param string $email
	 */
	public function __construct(public $user, public $email)
	{
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build(): Mailable
	{
		return $this->view('email.confirmation-email')->subject('Verify New Email');
	}
}
