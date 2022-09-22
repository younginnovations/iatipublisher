<?php

declare(strict_types=1);

namespace App\IATI\Services\ImportActivity;

use App\IATI\Elements\Xml\XmlGenerator;
use App\IATI\Services\Xml\XmlSchemaErrorParser;
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
     * @var XmlSchemaErrorParser
     */
    private XmlSchemaErrorParser $xmlErrorParser;

    /**
     * @param XmlGenerator         $xmlGenerator
     * @param XmlSchemaErrorParser $xmlSchemaErrorParser
     */
    public function __construct(XmlGenerator $xmlGenerator, XmlSchemaErrorParser $xmlSchemaErrorParser)
    {
        $this->xmlGenerator = $xmlGenerator;
        $this->xmlErrorParser = $xmlSchemaErrorParser;
    }

    /**
     * Get messages for schema errors.
     *
     * @param $tempXmlContent
     *
     * @return array
     */
    public function getSchemaErrors($tempXmlContent): array
    {
        libxml_use_internal_errors(true);
        $xml = new \DOMDocument();
        $xml->loadXML($tempXmlContent);
        $schemaPath = app_path('/XmlImporter/Template/iati-activities-schema.xsd');
        $messages = [];

        if (!$xml->schemaValidate($schemaPath)) {
            $messages = $this->libxml_display_errors();
        }

        return $messages;
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
