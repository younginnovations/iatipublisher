<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

/**
 * class MaxMergeSizeExceededException.
 */
class MaxMergeSizeExceededException extends Exception
{
    public function __construct($message = 'Merged file max size exceeded', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
