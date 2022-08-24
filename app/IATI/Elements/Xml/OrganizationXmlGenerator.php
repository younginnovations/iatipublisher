<?php

namespace App\IATI\Elements\Xml;

use App\IATI\Services\Organization\DocumentLinkService;
use App\IATI\Services\Organization\NameService;
use App\IATI\Services\Organization\OrganizationIdentifierService;
use App\IATI\Services\Organization\OrganizationPublishedService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\Organization\RecipientCountryBudgetService;
use App\IATI\Services\Organization\RecipientOrgBudgetService;
use App\IATI\Services\Organization\RecipientRegionBudgetService;
use App\IATI\Services\Organization\ReportingOrgService;
use App\IATI\Services\Organization\TotalBudgetService;
use App\IATI\Services\Organization\TotalExpenditureService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

/**
 * Class OrganizationXmlGenerator.
 */
class OrganizationXmlGenerator
{
    /**
     * @var OrganizationService
     */
    protected OrganizationService $organizationService;

    /**
     * @var DocumentLinkService
     */
    protected DocumentLinkService $documentLinkService;

    /**
     * @var NameService
     */
    protected NameService $nameService;

    /**
     * @var OrganizationIdentifierService
     */
    protected OrganizationIdentifierService $organizationIdentifierService;

    /**
     * @var RecipientCountryBudgetService
     */
    protected RecipientCountryBudgetService $recipientCountryBudgetService;

    /**
     * @var RecipientOrgBudgetService
     */
    protected RecipientOrgBudgetService $recipientOrgBudgetService;

    /**
     * @var RecipientRegionBudgetService
     */
    protected RecipientRegionBudgetService $recipientRegionBudgetService;

    /**
     * @var ReportingOrgService
     */
    protected ReportingOrgService $reportingOrgService;

    /**
     * @var TotalBudgetService
     */
    protected TotalBudgetService $totalBudgetService;

    /**
     * @var TotalExpenditureService
     */
    protected TotalExpenditureService $totalExpenditureService;

    /**
     * @var ArrayToXml
     */
    protected ArrayToXml $arrayToXml;

    /**
     * @var OrganizationPublishedService
     */
    protected OrganizationPublishedService $organizationPublishedService;

    /**
     * OrganizationXmlGenerator Constructor.
     *
     * @param OrganizationService $organizationService
     * @param ArrayToXml $arrayToXml
     * @param OrganizationPublishedService $organizationPublishedService
     */
    public function __construct(
        OrganizationService $organizationService,
        ArrayToXml $arrayToXml,
        OrganizationPublishedService $organizationPublishedService
    ) {
        $this->organizationService = $organizationService;
        $this->arrayToXml = $arrayToXml;
        $this->organizationPublishedService = $organizationPublishedService;
    }

    /**
     * Generates combines activities xml file and publishes to IATI.
     *
     * @param $settings
     * @param $organization
     *
     * @return void
     */
    public function generateOrganizationXml($settings, $organization)
    {
        $publishingInfo = $settings->publishing_info;

        if (is_string($publishingInfo)) {
            $publishingInfo = json_decode($publishingInfo, true);
        }

        $publisherId = Arr::get($publishingInfo, 'publisher_id', 'Not Available');
        $filename = sprintf('%s-%s.xml', $publisherId, 'organisation');
        $publishedOrganization = sprintf('%s-%s.xml', $publisherId, $organization->id);
        $xml = $this->getXml($settings, $organization);

        $result = Storage::disk('minio')->put(
            sprintf('%s/%s', 'organizationXmlFiles', $filename),
            $xml->saveXML(),
            $filename
        );

        if ($result) {
            $publishedFiles = $this->savePublishedFiles($filename, $organization->id, $publishedOrganization);
        }
    }

    /**
     * Stores published file details in database.
     *
     * @param $filename
     * @param $organizationId
     * @param $publishedActivity
     *
     * @return array
     */
    public function savePublishedFiles($filename, $organizationId, $publishedActivity): array
    {
        $published = $this->organizationPublishedService->findOrCreate($filename, $organizationId);

        return $published->toArray();
    }

    /**
     * Generates individual activity xml file.
     *
     * @param $activity
     * @param $transaction
     * @param $result
     * @param $settings
     * @param $organization
     *
     * @return \DomDocument
     */
    public function getXml($settings, $organization): ?\DomDocument
    {
        $this->setServices();
        $xmlData = [];
        $xmlData['@attributes'] = [
            'version' => '2.03',
            'generated-datetime' => gmdate('c'),
        ];

        $xmlData['iati-organisation'] = $this->getXmlData($organization);
        $xmlData['iati-organisation']['@attributes'] = [
            'last-updated-datetime' => gmdate('c', time()),
            'xml:lang'              => Arr::get($settings->default_field_values, '0.default_language', null),
            'default-currency'      => Arr::get($settings->default_field_values, '0.default_currency', null),
            // 'humanitarian'          => Arr::get($settings->default_field_values, '0.humanitarian', false),
            'hierarchy'             => Arr::get($settings->default_field_values, '0.default_hierarchy', 1),
            'linked-data-uri'       => Arr::get($settings->default_field_values, '0.linked_data_uri', null),
        ];

        return $this->arrayToXml->createXml('iati-organisations', $xmlData);
    }

    /**
     * Calls OrganizationService to set required service for elements.
     *
     * @return void
     */
    public function setServices()
    {
        $this->nameService = $this->organizationService->getService('NameService');
        $this->organizationIdentifierService = $this->organizationService->getService('OrganizationIdentifierService');
        $this->reportingOrgService = $this->organizationService->getService('ReportingOrgService');
        $this->recipientCountryBudgetService = $this->organizationService->getService('RecipientCountryBudgetService');
        $this->recipientOrgBudgetService = $this->organizationService->getService('RecipientOrgBudgetService');
        $this->recipientRegionBudgetService = $this->organizationService->getService('RecipientRegionBudgetService');
        $this->documentLinkService = $this->organizationService->getService('DocumentLinkService');
        $this->totalBudgetService = $this->organizationService->getService('TotalBudgetService');
        $this->totalExpenditureService = $this->organizationService->getService('TotalExpenditureService');
    }

    /**
     * Returns array of xml data.
     *
     * @param $activity
     * @param $transaction
     * @param $result
     * @param $organization
     *
     * @return array
     */
    public function getXmlData($organization)
    {
        $xmlOrganization = [];
        $xmlOrganization['organisation-identifier'] = $this->organizationIdentifierService->getXmlData($organization);
        $xmlOrganization['document-link'] = $this->documentLinkService->getXmlData($organization);
        $xmlOrganization['recipient-org'] = $this->reportingOrgService->getXmlData($organization);
        $xmlOrganization['recipient-org-budget'] = $this->recipientOrgBudgetService->getXmlData($organization);
        $xmlOrganization['recipient-country-budget'] = $this->recipientCountryBudgetService->getXmlData($organization);
        $xmlOrganization['recipient-region-budget'] = $this->recipientRegionBudgetService->getXmlData($organization);
        $xmlOrganization['name'] = $this->nameService->getXmlData($organization);
        $xmlOrganization['total-budget'] = $this->totalBudgetService->getXmlData($organization);
        $xmlOrganization['total-expenditure'] = $this->totalExpenditureService->getXmlData($organization);
        removeEmptyValues($xmlOrganization);

        return $xmlOrganization;
    }

    /**
     * Deletes the unpublished file from server.
     *
     * @param $filename
     *
     * @return void
     */
    public function deleteUnpublishedFile($filename)
    {
        if (Storage::disk('minio')->exists(sprintf('%s/%s/%s', 'xml', 'organizationXmlFiles', $filename))) {
            Storage::disk('minio')->delete(sprintf('%s/%s/%s', 'xml', 'organizationXmlFiles', $filename));
        }
    }
}
