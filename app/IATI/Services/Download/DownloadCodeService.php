<?php

declare(strict_types=1);

namespace App\IATI\Services\Download;

use App\IATI\Elements\Xml\XmlGenerator;
use App\IATI\Repositories\Activity\ActivityRepository;

/**
 * Class DownloadCodeService.
 */
class DownloadCodeService
{
    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    protected $xlsFields = [
        'Result Mapper' => [
            [
                'Activity Identifier',
                'Result Code',
                'Result Identifier',
            ],
        ],
        'Indicator Mapper' => [
            [
                'Result Identifier',
                'Indicator Code',
                'Indicator Identifier',
            ],
        ],
        'Period Mapper' => [
            [
                'Indicator Identifier',
                'Period Code',
                'Period Identifier',
            ],
        ],
    ];

    /**
     * @var array
     */
    protected array $insertedDates = [];

    /**
     * DownloadCodeService Constructor.
     *
     * @param ActivityRepository $activityRepository
     * @param XmlGenerator $xmlGenerator
     */
    public function __construct(
        ActivityRepository $activityRepository,
        XmlGenerator $xmlGenerator
    ) {
        $this->activityRepository = $activityRepository;
    }

    /**
     * Returns activities having given ids for downloading.
     *
     * @param $activityIds
     *
     * @return object
     */
    public function getActivitiesToDownload($activityIds): array
    {
        $activities = $this->activityRepository->getAllActivitiesToDownload(auth()->user()->organization_id, []);

        foreach ($activities as $index => $activity) {
            // $resultMapperRow
            // dd($activity);
            $results = $activity->results;
            $activityIdentifier = $activity->iati_identifier['activity_identifier'];

            foreach ($results as $resultIndex => $result) {
                $resultCode = $result->result_code;
                $resultIdentifier = $activityIdentifier . '_' . $resultCode;
                $indicators = $result->indicators;

                foreach ($indicators as $indicatorIndex => $indicator) {
                    $indicatorCode = $result->result_code;
                    $indicatorIdentifier = $resultIdentifier . '_' . $indicatorCode;
                    $periods = $indicator->periods;

                    foreach ($periods as $periodIndex => $period) {
                        $this->xlsFields['Period Mapper'][] = [
                            $periodIndex === 0 ? $indicatorIdentifier : '',
                            $period->period_code,
                            $indicatorIdentifier . '_' . $period->period_code,
                        ];
                    }

                    $this->xlsFields['Indicator Mapper'][] = [
                        $indicatorIndex === 0 ? $resultIdentifier : '',
                        $indicator->indicator_code,
                        $resultIdentifier . '_' . $indicator->indicator_code,
                    ];
                }

                $this->xlsFields['Result Mapper'][] = [
                    $resultIndex === 0 ? $activityIdentifier : '',
                    $result->result_code,
                    $activityIdentifier . '_' . $result->result_code,
                ];
            }
        }

        // dd($this->xlsFields);

        return $this->xlsFields;
    }

    /**
     * Returns formatted csv data for downloading.
     *
     * @param $activities
     *
     * @return array
     */
    public function getXlsData($activities): array
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
    }

// /**
//  * Returns all activities of an organization.
//  *
//  * @param $queryParams
//  *
//  * @return object
//  */
// public function getAllActivitiesToDownload($queryParams): object
// {
//     $activities = $this->activityRepository->getAllActivitiesToDownload(auth()->user()->organization_id, $queryParams);

//     foreach($activities as $index => $activity){

//     }
// }
}
