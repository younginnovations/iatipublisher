<?php

declare(strict_types=1);

namespace App\IATI\Services\Xml;

use App\IATI\Elements\Xml\XmlGenerator;
use App\IATI\Traits\XmlServiceTrait;

/**
 * Class XmlGeneratorService.
 */
class XmlGeneratorService
{
    use XmlServiceTrait;

    /**
     * @var XmlGenerator
     */
    protected XmlGenerator $xmlGenerator;

    /**
     * @var XmlSchemaErrorParser
     */
    protected XmlSchemaErrorParser $xmlErrorParser;

    /**
     * XmlGeneratorService Constructor.
     *
     * @param XmlGenerator $xmlGenerator
     * @param XmlSchemaErrorParser $xmlErrorParser
     */
    public function __construct(XmlGenerator $xmlGenerator, XmlSchemaErrorParser $xmlErrorParser)
    {
        $this->xmlGenerator = $xmlGenerator;
        $this->xmlErrorParser = $xmlErrorParser;
    }

    /**
     * Generates combines activities xml file and publishes to IATI.
     *
     * @param $activity
     * @param $transaction
     * @param $result
     * @param $settings
     * @param $organization
     *
     * @return void
     */
    public function generateActivityXml($activity, $transaction, $result, $settings, $organization): void
    {
        $this->xmlGenerator->generateActivityXml($activity, $transaction, $result, $settings, $organization);
    }

    /**
     * Deletes the unpublished file from server.
     *
     * @param $filename
     *
     * @return void
     */
    public function deleteUnpublishedFile($filename): void
    {
        $this->xmlGenerator->deleteUnpublishedFile($filename);
    }

    /**
     * Generates new xml file after unpublishing.
     *
     * @param $publishedFile
     *
     * @return void
     */
    public function generateNewXmlFile($publishedFile): void
    {
        $this->xmlGenerator->getMergeXml($publishedFile->published_activities, $publishedFile->filename);
    }

    /**
     * Returns xml data of activity.
     *
     * @param $activity
     * @param $transaction
     * @param $result
     * @param $settings
     * @param $organization
     *
     * @return string
     */
    public function getActivityXmlData($activity, $transaction, $result, $settings, $organization): string
    {
        $xmlDom = $this->xmlGenerator->getXml($activity, $transaction, $result, $settings, $organization);
        awsUploadFile("xmlValidation/$activity->org_id/activity_$activity->id.xml", $xmlDom->saveXML());

        return $xmlDom->saveXML();
    }
}
