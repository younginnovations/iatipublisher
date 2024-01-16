<?php

declare(strict_types=1);

namespace App\CsvImporter\Queue\Exceptions;

use Exception;

/**
 * Class HeaderMismatchException.
 */
class HeaderMismatchException extends Exception
{
    /**
     * Message for the HeaderMismatch Exception.
     */
    public $message;

    /**
     * HeaderMismatchException constructor.
     */
    public function __construct()
    {
        $this->message = translateCommonError('header_mismatch_exception');
    }
}
