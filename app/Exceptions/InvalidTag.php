<?php

namespace App\Exceptions;

use Exception;

/**
 * Class InvalidTag.
 */
class InvalidTag extends Exception
{
    /**
     * @var string
     */
    protected $message;

    /**
     * InvalidTagException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}
