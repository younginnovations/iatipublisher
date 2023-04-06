<?php

declare(strict_types=1);

namespace App\IATI\Services\Download;

use App\CsvImporter\Traits\ChecksCsvHeaders;
use App\IATI\Elements\Xml\XmlGenerator;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Traits\DownloadActivityComplexElementTrait;
use App\IATI\Traits\DownloadActivitySimpleElementTrait;
use App\IATI\Traits\DownloadTransactionTrait;
use Illuminate\Support\Arr;

/**
 * Class DownloadActivityService.
 */
class DownloadCodeService
{
    use ChecksCsvHeaders, DownloadActivitySimpleElementTrait, DownloadActivityComplexElementTrait, DownloadTransactionTrait;

    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    protected $xlsFields = [
        'Result Mapper' => [
            'Activity Identifier',
            'Result Code',
            'Result Identifier',
        ],
        'Indicator Mapper' => [
            'Result Identifier',
            'Indicator Code',
            'Indicator Identifier',
        ],
        'Period Mapper' => [
            'Indicator Identifier',
            'Period Code',
            'Period Identifier',
        ],
    ];

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
        'humanitarian_scope',
        'policy_marker',
        'default_aid_type',
        'budget',
        'planned_disbursement',
        'document_link',
        'related_activity',
        'legacy_data',
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
     * Returns required data in array format.
     *
     * @param $activityArray
     *
     * @return array
     */
    public function getActivityArrayData($activityArray): array
    {
        $data = [];
        $count = $this->getElementCount($activityArray);
        $headers = $this->getCsvHeaderArray('Activity', 'other_fields_transaction');

        for ($i = 0; $i < $count; $i++) {
            foreach ($headers as $header) {
                $function = 'get' . str_replace([' ', '(', ')'], '', $header);
                $data[$i][$header] = $this->$function($activityArray, $i);
            }
        }

        return $this->removeEmptyData($data);
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
     * Returns count of the highest no of repeated element.
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
                } elseif ($key === 'conditions' && count(Arr::get($activityArray, 'conditions.condition', [])) > $count) {
                    $count = count(Arr::get($activityArray, 'conditions.condition', []));
                } elseif ($key === 'country_budget_items' && count(Arr::get($activityArray, 'country_budget_items.budget_item', [])) > $count) {
                    $count = count(Arr::get($activityArray, 'country_budget_items.budget_item', []));
                }
            }
        }

        return $count;
    }

    /**
     * Returns all activities of an organization.
     *
     * @param $queryParams
     *
     * @return object
     */
    public function getAllActivitiesToDownload($queryParams): object
    {
        return $this->activityRepository->getAllActivitiesToDownload(auth()->user()->organization_id, $queryParams);
    }
}
