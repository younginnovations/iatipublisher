<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class XlsDownloadMail.
 */
class XlsDownloadMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Stores mail detail.
     *
     * @var array
     */
    public array $mailDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailDetails)
    {
        $this->mailDetails = $mailDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->view('mail.xls-download')->subject('Xls File Ready For Download');
    }
}
