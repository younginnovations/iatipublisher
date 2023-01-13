<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class NewUserEmail.
 */
class NewUserEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $user;

    /**
     * @var
     */
    public $mailDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $mailDetails)
    {
        $this->user = $user;
        $this->mailDetails = $mailDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->view('mail.new-user')->subject('Welcome to IATI Publisher');
    }
}
