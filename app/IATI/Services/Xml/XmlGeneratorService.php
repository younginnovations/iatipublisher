<?php

declare(strict_types=1);

namespace App\IATI\Services\Xml;

use App\IATI\Elements\Xml\XmlGenerator;
use App\IATI\Traits\XmlServiceTrait;
use DOMDocument;
use Exception;

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
     * @return DomDocument|null
     */
    public function generateActivityXml($activity, $transaction, $result, $settings, $organization): ?DomDocument
    {
        return $this->xmlGenerator->generateActivityXml($activity, $transaction, $result, $settings, $organization);
    }

    /**
     * Generates combines activities xml file and publishes to IATI.
     *
     * @param $activities
     * @param $settings
     * @param $organization
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function generateActivitiesXml($activities, $settings, $organization): void
    {
        $this->xmlGenerator->generateActivitiesXml($activities, $settings, $organization);
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
     * Returns xml data of activity.
     *
     * @param $activity
     * @param $transaction
     * @param $result
     * @param $settings
     * @param $organization
     *
     * @return string
     *
     * @throws \JsonException
     */
    public function getActivityXmlData($activity, $transaction, $result, $settings, $organization): string
    {
        $xmlDom = $this->xmlGenerator->getXml($activity, $transaction, $result, $settings, $organization);

        return $xmlDom->saveXML();
    }

    /**
     * Appends generated/new XML content to merged xml and uploads to S3.
     *
     * @param DomDocument $generatedXmlContent
     * @param $settings
     * @param string $targetIdentifier
     *
     * @return void
     *
     * @throws Exception
     */
    public function appendCompleteActivityXmlToMergedXml(DomDocument $generatedXmlContent, $settings, $activity, $organization): void
    {
        $this->xmlGenerator->appendCompleteActivityXmlToMergedXml($generatedXmlContent, $settings, $activity, $organization);
    }

    /**
     * Removes given activity from merged xml and re-uploads it to s3.
     *
     * @throws Exception
     */
    public function removeActivityXmlFromMergedXmlInS3($activity, $organization, $settings): void
    {
        $this->xmlGenerator->removeActivityXmlFromMergedXmlInS3($activity, $organization, $settings);
    }
}
