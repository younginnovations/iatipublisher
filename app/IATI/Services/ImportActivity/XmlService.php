<?php

declare(strict_types=1);

namespace App\IATI\Services\ImportActivity;

use App\IATI\Elements\Xml\XmlGenerator;
use App\IATI\Traits\XmlServiceTrait;

/**
 * Class XmlService.
 */
class XmlService
{
    use XmlServiceTrait;

    /**
     * @var XmlGenerator
     */
    protected XmlGenerator $xmlGenerator;

    /**
     * @param XmlGenerator         $xmlGenerator
     */
    public function __construct(XmlGenerator $xmlGenerator)
    {
        $this->xmlGenerator = $xmlGenerator;
    }

    /**
     * formats uploaded xml.
     *
     * @param $tempXmlContent
     *
     * @return array
     */
    public function formatUploadedXml($tempXmlContent): array
    {
        return explode("\n", $tempXmlContent);
    }
}
