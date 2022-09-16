<?php

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
    protected $xmlGenerator;

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
     * @param $filename
     * @param $organizationId
     * @param $publishedActivity
     * @return array
     */
    public function savePublishedFiles($filename, $organizationId, $publishedActivity)
    {
        return $this->xmlGenerator->savePublishedFiles($filename, $organizationId, $publishedActivity);
    }

    /**
     * get all the modified errors.
     * @param $validateXml
     * @param $errors
     * @return array
     */
    public function getSpecificErrors($validateXml, $errors)
    {
        $errorsList = [];
        foreach ($errors as $error) {
            $errMessage = $this->xmlErrorParser->getModifiedError($error, $validateXml);
            isset($errorsList[$errMessage]) ? $errorsList[$errMessage] += 1 : $errorsList[$errMessage] = 1;
        }

        $messages = [];
        foreach ($errorsList as $message => $count) {
            if ($count > 1) {
                $newMessage = str_replace('The required', 'Multiple', $message);
                $newMessage = str_replace(' is ', ' are ', $newMessage);
            } else {
                $newMessage = $message;
            }
            $messages[] = $newMessage;
        }

        return $messages;
    }

    /**
     * Get messages for schema errors.
     * @param $tempXmlContent
     * @param $version
     * @return array
     */
    public function getSchemaErrors($tempXmlContent, $version)
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
     * get Xml in format.
     * @param $tempXmlContent
     * @return array
     */
    public function getFormattedXml($tempXmlContent)
    {
        // $xmlString = htmlspecialchars($tempXmlContent);
        // $xmlString = str_replace(" ", "&nbsp;&nbsp;", $xmlString);
        $xmlLines = explode("\n", $tempXmlContent);

        return $xmlLines;
    }

    /**
     *  formats uploaded xml.
     * @param $tempXmlContent
     * @return array
     */
    public function formatUploadedXml($tempXmlContent)
    {
        // $xmlString = htmlspecialchars($tempXmlContent);
        // $xmlString = str_replace(" ", "&nbsp;", $xmlString);
        $xmlLines = explode("\n", $tempXmlContent);

        return $xmlLines;
    }
}
