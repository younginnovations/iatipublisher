<?php

namespace App\Exceptions;

use Exception;

/**
 * Class PublisherNotFound.
 */
class PublisherNotFound extends Exception
{
    /**
     * @var string
     */
    protected $message;

    /**
     * PublisherNotFoundException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}
