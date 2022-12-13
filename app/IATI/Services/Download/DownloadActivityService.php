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
        $csvHeader = $this->getCsvHeaderArray('Activity', 'other_fields_transaction');

        foreach ($activities as $activity) {
            $activityArrayData = $this->getActivityArrayData($activity->toArray(), $csvHeader);

            if (count($activityArrayData)) {
                foreach ($activityArrayData as $arrayData) {
                    $data[] = $arrayData;
                }
            }
        }

        //This needs to be modified to get actual data of activities.
        foreach ($this->getCsvHeaderArray('Activity', 'other_fields_transaction') as $csvHeader) {
            $data[0][$csvHeader] = 'Test text';
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

    public function getActivityArrayData($activityArray, $headers)
    {
        $data = [];
        $count = 1;
        $defaultLanguage = Arr::get($activityArray, 'default_field_values.default_language', '');

        foreach ($activityArray as $key => $arrayItem) {
            if (is_array($arrayItem) && in_array($key, $this->multipleElements, true) && count($arrayItem) > $count) {
                $count = count($arrayItem);
            }
        }

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
        }

        dd($data);

        return $data;
    }

    /**
     * Returns narrative text of the default language.
     *
     * @param $narratives
     * @param $currency
     *
     * @return string
     */
    public function getNarrativeText($narratives, $currency): string
    {
        if (count($narratives)) {
            foreach ($narratives as $narrative) {
                if (Arr::get($narrative, 'language', '') === $currency || Arr::get($narrative, 'language', '') === '') {
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
     * @param $currency
     * @param $type
     *
     * @return string
     */
    public function getDescriptionText($descriptions, $currency, $type): string
    {
        if (count($descriptions)) {
            foreach ($descriptions as $description) {
                if (Arr::get($description, 'type', $type) === $type) {
                    return $this->getNarrativeText(Arr::get($description, 'narrative', []), $currency);
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
     * @return string
     */
    public function getActivityDate($activityDates, $type): string
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
     * @return string
     */
    public function getRecipientRegionCode($regionVocabulary, $recipientRegion): string
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
     * @return string
     */
    public function getSectorCode($sectorVocabulary, $sector): string
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
}
