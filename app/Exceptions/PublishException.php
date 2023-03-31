<?php

namespace App\Exceptions;

use Exception;

/**
 * Class PublishException.
 */
class PublishException extends Exception
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected int $iatiOrganizationId;

    /**
     * PublishException constructor.
     *
     * @param string $message
     */
    public function __construct($iatiOrganizationId, $message)
    {
        $this->iatiOrganizationId = $iatiOrganizationId;
        $this->message = $message;
    }

    /**
     * Returns IATI Organization Id.
     *
     * @return int
     */
    public function getIatiOrganizationId(): int
    {
        return $this->iatiOrganizationId;
    }
}
