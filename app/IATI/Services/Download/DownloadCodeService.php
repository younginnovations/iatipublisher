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
        'Result_Mapper' => [
            [
                'Activity Identifier',
                'Result Number',
                'Result Identifier',
            ],
        ],
        'Indicator_Mapper' => [
            [
                'Result Identifier',
                'Indicator Number',
                'Indicator Identifier',
            ],
        ],
        'Period_Mapper' => [
            [
                'Indicator Identifier',
                'Period Number',
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
        $activities = $this->activityRepository->getCodesToDownload(auth()->user()->organization_id, $activityIds);

        foreach ($activities as $activity) {
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
                        $this->xlsFields['Period_Mapper'][] = [
                            $periodIndex === 0 ? $indicatorIdentifier : '',
                            $period->period_code,
                            $indicatorIdentifier . '_' . $period->period_code,
                        ];
                    }

                    $this->xlsFields['Indicator_Mapper'][] = [
                        $indicatorIndex === 0 ? $resultIdentifier : '',
                        $indicator->indicator_code,
                        $resultIdentifier . '_' . $indicator->indicator_code,
                    ];
                }

                $this->xlsFields['Result_Mapper'][] = [
                    $resultIndex === 0 ? $activityIdentifier : '',
                    $result->result_code,
                    $activityIdentifier . '_' . $result->result_code,
                ];
            }
        }

        return $this->xlsFields;
    }
}
