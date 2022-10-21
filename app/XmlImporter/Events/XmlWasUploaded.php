<?php

declare(strict_types=1);

namespace App\XmlImporter\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

/**
 * Class XmlWasUploaded.
 */
class XmlWasUploaded extends Event
{
//    use SerializesModels;

    /**
     * @var
     */
    public $filename;

    /**
     * @var
     */
    public $userId;

    /**
     * @var
     */
    public $organizationId;

    /**
     * XmlWasUploaded constructor.
     * @param $filename
     * @param $userId
     * @param $organizationId
     */
    public function __construct($filename, $userId, $organizationId)
    {
        file_put_contents('valid_test.json', sprintf('%s%s', 'XmlWasUploaded class construct ', PHP_EOL), FILE_APPEND);
        $this->filename = $filename;
        $this->userId = $userId;
        $this->organizationId = $organizationId;
    }
}
