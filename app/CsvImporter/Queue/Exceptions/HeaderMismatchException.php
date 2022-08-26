<?php

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
    const MESSAGE = 'The headers in the uploaded Csv file do not match with the provided template.';

    /**
     * HeaderMismatchException constructor.
     */
    public function __construct()
    {
        $this->message = self::MESSAGE;
    }
}
