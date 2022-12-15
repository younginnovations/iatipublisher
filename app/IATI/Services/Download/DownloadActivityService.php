<?php

declare(strict_types=1);

namespace App\IATI\Services\Download;

use App\CsvImporter\Traits\ChecksCsvHeaders;
use App\IATI\Elements\Xml\XmlGenerator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Support\Arr;

/**
 * Class DownloadActivityService.
 */
class DownloadActivityService
{
    use ChecksCsvHeaders;

    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var XmlGenerator
     */
    protected XmlGenerator $xmlGenerator;

    /**
     * @var array
     */
    protected array $multipleElements = [
        'other_identifier',
        'title',
        'description',
        'activity_date',
        'contact_info',
        'participating_org',
        'recipient_country',
        'recipient_region',
        'location',
        'sector',
        'country_budget_items',
        'humanitarian_scope',
        'policy_marker',
        'default_aid_type',
        'budget',
        'planned_disbursement',
        'document_link',
        'related_activity',
        'legacy_data',
        'conditions',
        'tag',
        'transactions',
    ];

    /**
     * @var array
     */
    protected array $insertedDates = [];

    /**
     * DownloadActivityService Constructor.
     *
     * @param ActivityRepository $activityRepository
     * @param XmlGenerator $xmlGenerator
     */
    public function __construct(
        ActivityRepository $activityRepository,
        XmlGenerator $xmlGenerator
    ) {
        $this->activityRepository = $activityRepository;
        $this->xmlGenerator = $xmlGenerator;
    }

    /**
     * Returns activities having given ids for downloading.
     *
     * @param $activityIds
     *
     * @return object
     */
    public function getActivitiesToDownload($activityIds): object
    {
        return $this->activityRepository->getActivitiesToDownload($activityIds);
    }

    /**
     * Returns formatted csv data for downloading.
     *
     * @param $activities
     *
     * @return array
     */
    public function getCsvData($activities): array
    {
        $data = [];

        foreach ($activities as $activity) {
            $activityArrayData = $this->getActivityArrayData($activity->toArray());

            if (count($activityArrayData)) {
                foreach ($activityArrayData as $arrayData) {
                    $data[] = $arrayData;
                }
            }
        }

        return $data;
    }

    /**
     * Returns combined xml for download.
     *
     * @param $activities
     *
     * @return string
     */
    public function getCombinedXmlFile($activities): string
    {
        return $this->xmlGenerator->getCombinedXmlFile($activities);
    }

    /**
     * Get organization publisher id.
     *
     * @return null|string
     */
    public function getOrganizationPublisherId(): ?string
    {
        $publisherId = null;
        $organization = auth()->user()->organization;

        if ($organization && $organization->settings) {
            $publisherInfo = $organization->settings->publishing_info;

            if ($publisherInfo) {
                $publisherId = Arr::get($publisherInfo, 'publisher_id', 'Not Available');
            }
        }

        return $publisherId;
    }

    /**
     * Returns name for the file to be downloaded.
     *
     * @param $publisherId
     *
     * @return string
     */
    public function getDownloadFilename($publisherId): string
    {
        $filename = $publisherId ? $publisherId . '_' : '';

        return $filename . (now()->toDateString());
    }

    public function getActivityArrayData($activityArray)
    {
        $data = [];
        $defaultLanguage = Arr::get($activityArray, 'default_field_values.default_language', '');
        $count = $this->getElementCount($activityArray);

        for ($i = 0; $i < $count; $i++) {
            $data[$i]['Activity Identifier'] = ($i === 0) ? Arr::get($activityArray, 'iati_identifier.activity_identifier', 'Not Available') : '';
            $data[$i]['Activity Default Currency'] = ($i === 0) ? $defaultLanguage : '';
            $data[$i]['Activity Default Language'] = ($i === 0) ? Arr::get($activityArray, 'default_field_values.default_language', '') : '';
            $data[$i]['Humanitarian'] = ($i === 0) ? Arr::get($activityArray, 'default_field_values.humanitarian', '') : '';
            $data[$i]['Reporting Org Reference'] = Arr::get($activityArray, 'reporting_org.' . $i . '.ref', '');
            $data[$i]['Reporting Org Type'] = Arr::get($activityArray, 'reporting_org.' . $i . '.type', '');
            $data[$i]['Reporting Org Secondary Reporter'] = Arr::get($activityArray, 'reporting_org.' . $i . '.secondary_reporter', '');
            $data[$i]['Reporting Org Narrative'] = $this->getNarrativeText(Arr::get($activityArray, 'reporting_org.' . $i . '.narrative', []), $defaultLanguage);
            $data[$i]['Activity Title'] = ($i === 0) ? $this->getNarrativeText(Arr::get($activityArray, 'title', []), $defaultLanguage) : '';
            $data[$i]['Activity Description (General)'] = ($i === 0) ? $this->getDescriptionText(Arr::get($activityArray, 'description', []), $defaultLanguage, '1') : '';
            $data[$i]['Activity Description (Objectives)'] = ($i === 0) ? $this->getDescriptionText(Arr::get($activityArray, 'description', []), $defaultLanguage, '2') : '';
            $data[$i]['Activity Description (Target Groups)'] = ($i === 0) ? $this->getDescriptionText(Arr::get($activityArray, 'description', []), $defaultLanguage, '3') : '';
            $data[$i]['Activity Description (Others)'] = ($i === 0) ? $this->getDescriptionText(Arr::get($activityArray, 'description', []), $defaultLanguage, '4') : '';
            $data[$i]['Activity Status'] = ($i === 0) ? Arr::get($activityArray, 'activity_status', '') : '';
            $data[$i]['Actual Start Date'] = $this->getActivityDate(Arr::get($activityArray, 'activity_date', []), '2');
            $data[$i]['Actual End Date'] = $this->getActivityDate(Arr::get($activityArray, 'activity_date', []), '4');
            $data[$i]['Planned Start Date'] = $this->getActivityDate(Arr::get($activityArray, 'activity_date', []), '1');
            $data[$i]['Planned End Date'] = $this->getActivityDate(Arr::get($activityArray, 'activity_date', []), '3');
            $data[$i]['Participating Organisation Role'] = Arr::get($activityArray, 'participating_org.' . $i . '.organization_role', '');
            $data[$i]['Participating Organisation Reference'] = Arr::get($activityArray, 'participating_org.' . $i . '.ref', '');
            $data[$i]['Participating Organisation Type'] = Arr::get($activityArray, 'participating_org.' . $i . '.type', '');
            $data[$i]['Participating Organisation Name'] = $this->getNarrativeText(Arr::get($activityArray, 'participating_org.' . $i . '.narrative', []), $defaultLanguage);
            $data[$i]['Participating Organisation Identifier'] = Arr::get($activityArray, 'participating_org.' . $i . '.identifier', '');
            $data[$i]['Participating Organisation Crs Channel Code'] = Arr::get($activityArray, 'participating_org.' . $i . '.crs_channel_code', '');
            $data[$i]['Recipient Country Code'] = Arr::get($activityArray, 'recipient_country.' . $i . '.country_code', '');
            $data[$i]['Recipient Country Percentage'] = Arr::get($activityArray, 'recipient_country.' . $i . '.percentage', '');
            $data[$i]['Recipient Country Narrative'] = $this->getNarrativeText(Arr::get($activityArray, 'recipient_country.' . $i . '.narrative', []), $defaultLanguage);
            $data[$i]['Recipient Region Code'] = $this->getRecipientRegionCode(Arr::get($activityArray, 'recipient_region.' . $i . '.region_vocabulary', ''), Arr::get($activityArray, 'recipient_region.' . $i, []));
            $data[$i]['Recipient Region Percentage'] = Arr::get($activityArray, 'recipient_region.' . $i . '.percentage', '');
            $data[$i]['Recipient Region Vocabulary Uri'] = Arr::get($activityArray, 'recipient_region.' . $i . '.vocabulary_uri', '');
            $data[$i]['Recipient Region Narrative'] = $this->getNarrativeText(Arr::get($activityArray, 'recipient_region.' . $i . '.narrative', []), $defaultLanguage);
            $data[$i]['Sector Vocabulary'] = Arr::get($activityArray, 'sector.' . $i . '.sector_vocabulary', '');
            $data[$i]['Sector Vocabulary URI'] = Arr::get($activityArray, 'sector.' . $i . '.vocabulary_uri', '');
            $data[$i]['Sector Code'] = $this->getSectorCode(Arr::get($activityArray, 'sector.' . $i . '.sector_vocabulary', ''), Arr::get($activityArray, 'sector.' . $i, []));
            $data[$i]['Sector Percentage'] = Arr::get($activityArray, 'sector.' . $i . '.percentage', '');
            $data[$i]['Sector Narrative'] = $this->getNarrativeText(Arr::get($activityArray, 'sector.' . $i . '.narrative', []), $defaultLanguage);
            $data[$i]['Transaction Internal Reference'] = Arr::get($activityArray, 'transactions.' . $i . '.transaction.reference', '');
            $data[$i]['Transaction Type'] = Arr::get($activityArray, 'transactions.' . $i . '.transaction.transaction_type.0.transaction_type_code', '');
            $data[$i]['Transaction Date'] = Arr::get($activityArray, 'transactions.' . $i . '.transaction.transaction_date.0.date', '');
            $data[$i]['Transaction Value'] = Arr::get($activityArray, 'transactions.' . $i . '.transaction.value.0.amount', '');
            $data[$i]['Transaction Value Date'] = Arr::get($activityArray, 'transactions.' . $i . '.transaction.value.0.date', '');
            $data[$i]['Transaction Description'] = $this->getNarrativeText(Arr::get($activityArray, 'transactions.' . $i . '.transaction.description.0.narrative', []), $defaultLanguage);
            $data[$i]['Transaction Provider Organisation Identifier'] = Arr::get($activityArray, 'transactions.' . $i . '.transaction.provider_organization.0.organization_identifier_code', '');
            $data[$i]['Transaction Provider Organisation Type'] = Arr::get($activityArray, 'transactions.' . $i . '.transaction.provider_organization.0.type', '');
            $data[$i]['Transaction Provider Organisation Activity Identifier'] = Arr::get($activityArray, 'transactions.' . $i . '.transaction.provider_organization.0.provider_activity_id', '');
            $data[$i]['Transaction Provider Organisation Description'] = $this->getNarrativeText(Arr::get($activityArray, 'transactions.' . $i . '.transaction.provider_organization.0.narrative', []), $defaultLanguage);
            $data[$i]['Transaction Receiver Organisation Identifier'] = Arr::get($activityArray, 'transactions.' . $i . '.transaction.receiver_organization.0.organization_identifier_code', '');
            $data[$i]['Transaction Receiver Organisation Type'] = Arr::get($activityArray, 'transactions.' . $i . '.transaction.receiver_organization.0.type', '');
            $data[$i]['Transaction Receiver Organisation Activity Identifier'] = Arr::get($activityArray, 'transactions.' . $i . '.transaction.receiver_organization.0.receiver_activity_id', '');
            $data[$i]['Transaction Receiver Organisation Description'] = $this->getNarrativeText(Arr::get($activityArray, 'transactions.' . $i . '.transaction.receiver_organization.0.narrative', []), $defaultLanguage);
            $data[$i]['Transaction Sector Vocabulary'] = Arr::get($activityArray, 'transactions.' . $i . '.transaction.sector.0.sector_vocabulary', '');
            $data[$i]['Transaction Sector Vocabulary URI'] = Arr::get($activityArray, 'transactions.' . $i . '.transaction.sector.0.vocabulary_uri', '');
            $data[$i]['Transaction Sector Code'] = $this->getSectorCode(Arr::get($activityArray, 'transactions.' . $i . '.transaction.sector.0.sector_vocabulary', ''), Arr::get($activityArray, 'transactions.' . $i . '.transaction.sector.0', []));
            $data[$i]['Transaction Sector Narrative'] = $this->getNarrativeText(Arr::get($activityArray, 'transactions.' . $i . '.transaction.sector.0.narrative', []), $defaultLanguage);
            $data[$i]['Transaction Recipient Country Code'] = Arr::get($activityArray, 'transactions.' . $i . '.transaction.recipient_country.0.country_code', '');
            $data[$i]['Transaction Recipient Region Code'] = $this->getRecipientRegionCode(Arr::get($activityArray, 'transactions.' . $i . '.transaction.recipient_region.0.region_vocabulary', ''), Arr::get($activityArray, 'transactions.' . $i . '.transaction.recipient_region.0', []));
            $data[$i]['Transaction Recipient Region Vocabulary Uri'] = Arr::get($activityArray, 'transactions.' . $i . '.transaction.recipient_region.0.vocabulary_uri', '');
            $data[$i]['Policy Marker Vocabulary'] = Arr::get($activityArray, 'policy_marker.' . $i . '.policy_marker_vocabulary', '');
            $data[$i]['Policy Marker Code'] = $this->getPolicyMarkerCode(Arr::get($activityArray, 'policy_marker.' . $i . '.policy_marker_vocabulary', ''), Arr::get($activityArray, 'policy_marker.' . $i, []));
            $data[$i]['Policy Marker Significance'] = Arr::get($activityArray, 'policy_marker.' . $i . '.significance', '');
            $data[$i]['Policy Marker Vocabulary Uri'] = Arr::get($activityArray, 'policy_marker.' . $i . '.vocabulary_uri', '');
            $data[$i]['Policy Marker Narrative'] = $this->getNarrativeText(Arr::get($activityArray, 'policy_marker.' . $i . '.narrative', []), $defaultLanguage);
            $data[$i]['Activity Scope'] = ($i === 0) ? Arr::get($activityArray, 'activity_scope', '') : '';
            $data[$i]['Budget Type'] = Arr::get($activityArray, 'budget.' . $i . '.budget_type', '');
            $data[$i]['Budget Status'] = Arr::get($activityArray, 'budget.' . $i . '.budget_status', '');
            $data[$i]['Budget Period Start'] = Arr::get($activityArray, 'budget.' . $i . '.period_start.0.date', '');
            $data[$i]['Budget Period End'] = Arr::get($activityArray, 'budget.' . $i . '.period_end.0.date', '');
            $data[$i]['Budget Value'] = Arr::get($activityArray, 'budget.' . $i . '.budget_value.0.amount', '');
            $data[$i]['Budget Value Date'] = Arr::get($activityArray, 'budget.' . $i . '.budget_value.0.value_date', '');
            $data[$i]['Budget Currency'] = Arr::get($activityArray, 'budget.' . $i . '.budget_value.0.currency', '');
            $data[$i]['Related Activity Identifier'] = Arr::get($activityArray, 'related_activity.' . $i . '.activity_identifier', '');
            $data[$i]['Related Activity Type'] = Arr::get($activityArray, 'related_activity.' . $i . '.relationship_type', '');
            $data[$i]['Contact Type'] = Arr::get($activityArray, 'contact_info.' . $i . '.type', '');
            $data[$i]['Contact Organization'] = $this->getNarrativeText(Arr::get($activityArray, 'contact_info.' . $i . '.organisation.0.narrative', []), $defaultLanguage);
            $data[$i]['Contact Department'] = $this->getNarrativeText(Arr::get($activityArray, 'contact_info.' . $i . '.department.0.narrative', []), $defaultLanguage);
            $data[$i]['Contact Person Name'] = $this->getNarrativeText(Arr::get($activityArray, 'contact_info.' . $i . '.person_name.0.narrative', []), $defaultLanguage);
            $data[$i]['Contact Job Title'] = $this->getNarrativeText(Arr::get($activityArray, 'contact_info.' . $i . '.job_title.0.narrative', []), $defaultLanguage);
            $data[$i]['Contact Telephone'] = Arr::get($activityArray, 'contact_info.' . $i . '.telephone.0.telephone', '');
            $data[$i]['Contact Email'] = Arr::get($activityArray, 'contact_info.' . $i . '.email.0.email', '');
            $data[$i]['Contact Website'] = Arr::get($activityArray, 'contact_info.' . $i . '.website.0.website', '');
            $data[$i]['Contact Mailing Address'] = $this->getMailingAddressText(Arr::get($activityArray, 'contact_info.' . $i . '.mailing_address', []), $defaultLanguage);
            $data[$i]['Other Identifier Reference'] = Arr::get($activityArray, 'other_identifier.' . $i . '.reference', '');
            $data[$i]['Other Identifier Type'] = Arr::get($activityArray, 'other_identifier.' . $i . '.reference_type', '');
            $data[$i]['Owner Org Reference'] = Arr::get($activityArray, 'other_identifier.' . $i . '.owner_org.0.ref', '');
            $data[$i]['Owner Org Narrative'] = $this->getNarrativeText(Arr::get($activityArray, 'other_identifier.' . $i . '.owner_org.0.narrative', []), $defaultLanguage);
            $data[$i]['Tag Vocabulary'] = Arr::get($activityArray, 'tag.' . $i . '.tag_vocabulary', '');
            $data[$i]['Tag Code'] = $this->getTagCode(Arr::get($activityArray, 'tag.' . $i . '.tag_vocabulary', ''), Arr::get($activityArray, 'tag.' . $i, []));
            $data[$i]['Tag Vocabulary Uri'] = Arr::get($activityArray, 'tag.' . $i . '.vocabulary_uri', '');
            $data[$i]['Tag Narrative'] = $this->getNarrativeText(Arr::get($activityArray, 'tag.' . $i . '.narrative', []), $defaultLanguage);
            $data[$i]['Collaboration Type'] = ($i === 0) ? Arr::get($activityArray, 'collaboration_type', '') : '';
            $data[$i]['Default Flow Type'] = ($i === 0) ? Arr::get($activityArray, 'default_flow_type', '') : '';
            $data[$i]['Default Finance Type'] = ($i === 0) ? Arr::get($activityArray, 'default_finance_type', '') : '';
            $data[$i]['Default Aid Type Vocabulary'] = Arr::get($activityArray, 'default_aid_type.' . $i . '.default_aid_type_vocabulary', '');
            $data[$i]['Default Aid Type Code'] = $this->getDefaultAidTypeCode(Arr::get($activityArray, 'default_aid_type.' . $i . '.default_aid_type_vocabulary', ''), Arr::get($activityArray, 'default_aid_type.' . $i, []));
            $data[$i]['Default Tied Status'] = ($i === 0) ? Arr::get($activityArray, 'default_tied_status', '') : '';
            $data[$i]['Country Budget Item Vocabulary'] = ($i === 0) ? Arr::get($activityArray, 'country_budget_items.country_budget_vocabulary', '') : '';
            $data[$i]['Budget Item Code'] = Arr::get($activityArray, 'country_budget_items.budget_item.' . $i . '.code', '');
            $data[$i]['Budget Item Percentage'] = Arr::get($activityArray, 'country_budget_items.budget_item.' . $i . '.percentage', '');
            $data[$i]['Budget Item Description'] = $this->getNarrativeText(Arr::get($activityArray, 'country_budget_items.budget_item.' . $i . '.description.0.narrative', []), $defaultLanguage);
            $data[$i]['Humanitarian Scope Type'] = Arr::get($activityArray, 'humanitarian_scope.' . $i . '.type', '');
            $data[$i]['Humanitarian Scope Vocabulary'] = Arr::get($activityArray, 'humanitarian_scope.' . $i . '.vocabulary', '');
            $data[$i]['Humanitarian Scope Vocabulary Uri'] = Arr::get($activityArray, 'humanitarian_scope.' . $i . '.vocabulary_uri', '');
            $data[$i]['Humanitarian Scope Code'] = Arr::get($activityArray, 'humanitarian_scope.' . $i . '.code', '');
            $data[$i]['Humanitarian Scope Narrative'] = $this->getNarrativeText(Arr::get($activityArray, 'humanitarian_scope.' . $i . '.narrative', []), $defaultLanguage);
            $data[$i]['Capital Spend'] = ($i === 0) ? Arr::get($activityArray, 'capital_spend', '') : '';
            $data[$i]['Conditions Attached'] = ($i === 0) ? Arr::get($activityArray, 'conditions.condition_attached', '') : '';
            $data[$i]['Condition Type'] = Arr::get($activityArray, 'conditions.condition.' . $i . '.condition_type', '');
            $data[$i]['Condition Narrative'] = $this->getNarrativeText(Arr::get($activityArray, 'conditions.condition.' . $i . '.narrative', []), $defaultLanguage);
            $data[$i]['Legacy Data Name'] = Arr::get($activityArray, 'legacy_data.' . $i . '.legacy_name', '');
            $data[$i]['Legacy Data Value'] = Arr::get($activityArray, 'legacy_data.' . $i . '.value', '');
            $data[$i]['Legacy Data IATI Equivalent'] = Arr::get($activityArray, 'legacy_data.' . $i . '.iati_equivalent', '');
            $data[$i]['Document Link Url'] = Arr::get($activityArray, 'document_link.' . $i . '.url', '');
            $data[$i]['Document Link Format'] = Arr::get($activityArray, 'document_link.' . $i . '.format', '');
            $data[$i]['Document Link Title'] = $this->getNarrativeText(Arr::get($activityArray, 'document_link.' . $i . '.title.0.narrative', []), $defaultLanguage);
            $data[$i]['Document Link Description'] = $this->getNarrativeText(Arr::get($activityArray, 'document_link.' . $i . '.description.0.narrative', []), $defaultLanguage);
            $data[$i]['Document Link Category'] = Arr::get($activityArray, 'document_link.' . $i . '.category.0.code', '');
            $data[$i]['Document Link Language'] = Arr::get($activityArray, 'document_link.' . $i . '.language.0.code', '');
            $data[$i]['Document Date'] = Arr::get($activityArray, 'document_link.' . $i . '.document_date.0.date', '');
            $data[$i]['Location Reference'] = Arr::get($activityArray, 'location.' . $i . '.ref', '');
            $data[$i]['Location Reach Code'] = Arr::get($activityArray, 'location.' . $i . '.location_reach.0.code', '');
            $data[$i]['Location Id Vocabulary'] = Arr::get($activityArray, 'location.' . $i . '.location_reach.0.vocabulary', '');
            $data[$i]['Location Id Code'] = Arr::get($activityArray, 'location.' . $i . '.location_reach.0.code', '');
            $data[$i]['Location Name'] = $this->getNarrativeText(Arr::get($activityArray, 'location.' . $i . '.name.0.narrative', []), $defaultLanguage);
            $data[$i]['Location Description'] = $this->getNarrativeText(Arr::get($activityArray, 'location.' . $i . '.description.0.narrative', []), $defaultLanguage);
            $data[$i]['Location Activity Description'] = $this->getNarrativeText(Arr::get($activityArray, 'location.' . $i . '.activity_description.0.narrative', []), $defaultLanguage);
            $data[$i]['Location Administrative Vocabulary'] = Arr::get($activityArray, 'location.' . $i . '.administrative.0.vocabulary', '');
            $data[$i]['Location Administrative Code'] = Arr::get($activityArray, 'location.' . $i . '.administrative.0.code', '');
            $data[$i]['Location Administrative Level'] = Arr::get($activityArray, 'location.' . $i . '.administrative.0.level', '');
            $data[$i]['Location Point srsName'] = Arr::get($activityArray, 'location.' . $i . '.point.0.srs_name', '');
            $data[$i]['Pos Latitude'] = Arr::get($activityArray, 'location.' . $i . '.point.0.pos.0.latitude', '');
            $data[$i]['Pos Longitude'] = Arr::get($activityArray, 'location.' . $i . '.point.0.pos.0.longitude', '');
            $data[$i]['Location Exactness'] = Arr::get($activityArray, 'location.' . $i . '.exactness.0.code', '');
            $data[$i]['Location Class'] = Arr::get($activityArray, 'location.' . $i . '.location_class.0.code', '');
            $data[$i]['Feature Designation'] = Arr::get($activityArray, 'location.' . $i . '.feature_designation.0.code', '');
            $data[$i]['Planned Disbursement Type'] = Arr::get($activityArray, 'planned_disbursement.' . $i . '.planned_disbursement_type', '');
            $data[$i]['Planned Disbursement Period Start'] = Arr::get($activityArray, 'planned_disbursement.' . $i . '.period_start.0.date', '');
            $data[$i]['Planned Disbursement Period End'] = Arr::get($activityArray, 'planned_disbursement.' . $i . '.period_end.0.date', '');
            $data[$i]['Planned Disbursement Value'] = Arr::get($activityArray, 'planned_disbursement.' . $i . '.value.0.amount', '');
            $data[$i]['Planned Disbursement Value Currency'] = Arr::get($activityArray, 'planned_disbursement.' . $i . '.value.0.currency', '');
            $data[$i]['Planned Disbursement Value Date'] = Arr::get($activityArray, 'planned_disbursement.' . $i . '.value.0.value_date', '');
            $data[$i]['Planned Disbursement Provider Org Reference'] = Arr::get($activityArray, 'planned_disbursement.' . $i . '.provider_org.0.ref', '');
            $data[$i]['Planned Disbursement Provider Org Activity Id'] = Arr::get($activityArray, 'planned_disbursement.' . $i . '.provider_org.0.provider_activity_id', '');
            $data[$i]['Planned Disbursement Provider Org Type'] = Arr::get($activityArray, 'planned_disbursement.' . $i . '.provider_org.0.type', '');
            $data[$i]['Planned Disbursement Provider Org Narrative'] = $this->getNarrativeText(Arr::get($activityArray, 'planned_disbursement.' . $i . '.provider_org.0.narrative', []), $defaultLanguage);
            $data[$i]['Planned Disbursement Receiver Org Reference'] = Arr::get($activityArray, 'planned_disbursement.' . $i . '.receiver_org.0.ref', '');
            $data[$i]['Planned Disbursement Receiver Org Activity Id'] = Arr::get($activityArray, 'planned_disbursement.' . $i . '.receiver_org.0.receiver_activity_id', '');
            $data[$i]['Planned Disbursement Receiver Org Type'] = Arr::get($activityArray, 'planned_disbursement.' . $i . '.receiver_org.0.type', '');
            $data[$i]['Planned Disbursement Receiver Org Narrative'] = $this->getNarrativeText(Arr::get($activityArray, 'planned_disbursement.' . $i . '.receiver_org.0.narrative', []), $defaultLanguage);
        }

        return $this->removeEmptyData($data);
    }

    /**
     * Returns narrative text of the default language.
     *
     * @param $narratives
     * @param $language
     *
     * @return string|null
     */
    public function getNarrativeText($narratives, $language): ?string
    {
        if (count($narratives)) {
            foreach ($narratives as $narrative) {
                if (Arr::get($narrative, 'language', '') === $language || Arr::get($narrative, 'language', '') === '') {
                    return Arr::get($narrative, 'narrative', '');
                }
            }
        }

        return '';
    }

    /**
     * Returns activity description narrative for particular description type.
     *
     * @param $descriptions
     * @param $language
     * @param $type
     *
     * @return string|null
     */
    public function getDescriptionText($descriptions, $language, $type): ?string
    {
        if (count($descriptions)) {
            foreach ($descriptions as $description) {
                if (Arr::get($description, 'type', $type) === $type) {
                    return $this->getNarrativeText(Arr::get($description, 'narrative', []), $language);
                }
            }
        }

        return '';
    }

    /**
     * Returns activity date according to the type specified.
     *
     * @param $activityDates
     * @param $type
     *
     * @return string|null
     */
    public function getActivityDate($activityDates, $type): ?string
    {
        if (count($activityDates)) {
            foreach ($activityDates as $key => $activityDate) {
                if (Arr::get($activityDate, 'type', '') === $type && !in_array($key, $this->insertedDates, true)) {
                    $this->insertedDates[] = $key;

                    return Arr::get($activityDate, 'date', '');
                }
            }
        }

        return '';
    }

    /**
     * Returns recipient region code based on the vocabulary.
     *
     * @param $regionVocabulary
     * @param $recipientRegion
     *
     * @return string|null
     */
    public function getRecipientRegionCode($regionVocabulary, $recipientRegion): ?string
    {
        if (!empty($regionVocabulary) && $regionVocabulary !== '1') {
            return Arr::get($recipientRegion, 'custom_code', '');
        }

        return Arr::get($recipientRegion, 'region_code', '');
    }

    /**
     * Returns sector code based on vocabulary.
     *
     * @param $sectorVocabulary
     * @param $sector
     *
     * @return string|null
     */
    public function getSectorCode($sectorVocabulary, $sector): ?string
    {
        if (!empty($sectorVocabulary)) {
            return match ($sectorVocabulary) {
                '1' => Arr::get($sector, 'code', ''),
                '2' => Arr::get($sector, 'category_code', ''),
                '7' => Arr::get($sector, 'sdg_goal', ''),
                '8' => Arr::get($sector, 'sdg_target', ''),
                default => Arr::get($sector, 'text', ''),
            };
        }

        return Arr::get($sector, 'text', '');
    }

    /**
     * Returns policy marker code based on the vocabulary.
     *
     * @param $policyMarkerVocabulary
     * @param $policyMarker
     *
     * @return null|string
     */
    public function getPolicyMarkerCode($policyMarkerVocabulary, $policyMarker): ?string
    {
        if (!empty($policyMarkerVocabulary) && $policyMarkerVocabulary !== '1') {
            return Arr::get($policyMarker, 'policy_marker_text', '');
        }

        return Arr::get($policyMarker, 'policy_marker', '');
    }

    /**
     * Return mailing address narrative text.
     *
     * @param $mailingAddresses
     * @param $language
     *
     * @return string|null
     */
    public function getMailingAddressText($mailingAddresses, $language): ?string
    {
        if (count($mailingAddresses)) {
            foreach ($mailingAddresses as $mailingAddress) {
                $narrative = $this->getNarrativeText(Arr::get($mailingAddress, 'narrative', []), $language);

                if (!empty($narrative)) {
                    return $narrative;
                }
            }
        }

        return '';
    }

    /**
     * Returns tag code based on the vocabulary.
     *
     * @param $tagVocabulary
     * @param $tag
     *
     * @return null|string
     */
    public function getTagCode($tagVocabulary, $tag): ?string
    {
        if (!empty($tagVocabulary)) {
            return match ($tagVocabulary) {
                '2' => Arr::get($tag, 'goals_tag_code', ''),
                '3' => Arr::get($tag, 'targets_tag_code', ''),
                default => Arr::get($tag, 'tag_text', ''),
            };
        }

        return Arr::get($tag, 'tag_text', '');
    }

    /**
     * Returns default aid type code based on the vocabulary.
     *
     * @param $aidTypeVocabulary
     * @param $aidType
     *
     * @return null|string
     */
    public function getDefaultAidTypeCode($aidTypeVocabulary, $aidType): ?string
    {
        if (!empty($aidTypeVocabulary)) {
            return match ($aidTypeVocabulary) {
                '2' => Arr::get($aidType, 'earmarking_category', ''),
                '3' => Arr::get($aidType, 'earmarking_modality', ''),
                '4' => Arr::get($aidType, 'cash_and_voucher_modalities', ''),
                default => Arr::get($aidType, 'default_aid_type', ''),
            };
        }

        return Arr::get($aidType, 'default_aid_type', '');
    }

    /**
     * Removes empty data.
     *
     * @param $data
     *
     * @return array|null
     */
    public function removeEmptyData($data): ?array
    {
        if (is_array($data) && !empty($data)) {
            foreach ($data as $key => $datum) {
                if ($this->isEmpty($datum)) {
                    unset($data[$key]);
                }
            }
        }

        return $data;
    }

    /**
     * Checks if data is empty.
     *
     * @param $array
     *
     * @return bool
     */
    public function isEmpty($array): bool
    {
        if (is_array($array) && !empty($array)) {
            foreach ($array as $data) {
                if (!empty($data)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Returns count of highest no of repeated element.
     *
     * @param $activityArray
     *
     * @return int
     */
    public function getElementCount($activityArray): int
    {
        $count = 1;

        if (is_array($activityArray) && !empty($activityArray)) {
            foreach ($activityArray as $key => $arrayItem) {
                if (is_array($arrayItem) && in_array($key, $this->multipleElements, true) && count($arrayItem) > $count) {
                    $count = count($arrayItem);
                }
            }
        }

        return $count;
    }
}
