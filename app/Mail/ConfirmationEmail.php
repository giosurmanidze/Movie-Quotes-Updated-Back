<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $user;
    public $confirmationLink;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param string $confirmationLink
     */
    public function __construct(User $user, string $confirmationLink)
    {
        $this->user = $user;
        $this->confirmationLink = $confirmationLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): Mailable
    {
        return $this->view('email.confirmation-email', [
            'user' => $this->user,
            'confirmationLink' => $this->confirmationLink,
        ]);
    }
}
