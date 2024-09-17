<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

/**
 * Class MaxBatchSizeExceededException.
 */
class MaxBatchSizeExceededException extends Exception
{
    public function __construct(string $message = 'Batch file size exceeded.', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
