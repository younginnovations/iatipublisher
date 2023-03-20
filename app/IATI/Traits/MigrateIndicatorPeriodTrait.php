<?php

declare(strict_types=1);

namespace App\IATI\Traits;

/**
 * Class MigrateIndicatorPeriodTrait.
 */
trait MigrateIndicatorPeriodTrait
{
    protected array $emptyPeriodTemplate
        = [
            'period_start' => [
                [
                    'date' => null,
                ],
            ],
            'period_end'   => [
                [
                    'date' => null,
                ],
            ],
            'target'       => [
                [
                    'value'         => null,
                    'comment'       => [
                        [
                            'narrative' => [
                                [
                                    'narrative' => null,
                                    'language'  => null,
                                ],
                            ],
                        ],
                    ],
                    'dimension'     => [
                        [
                            'name'  => null,
                            'value' => null,
                        ],
                    ],
                    'document_link' => [
                        [
                            'url'           => null,
                            'format'        => null,
                            'title'         => [
                                [
                                    'narrative' => [
                                        [
                                            'narrative' => null,
                                            'language'  => null,
                                        ],
                                    ],
                                ],
                            ],
                            'description'   => [
                                [
                                    'narrative' => [
                                        [
                                            'narrative' => null,
                                            'language'  => null,
                                        ],
                                    ],
                                ],
                            ],
                            'category'      => [
                                [
                                    'code' => null,
                                ],
                            ],
                            'language'      => [
                                [
                                    'language' => null,
                                ],
                            ],
                            'document_date' => [
                                [
                                    'date' => null,
                                ],
                            ],
                        ],
                    ],
                    'location'      => [
                        [
                            'reference' => null,
                        ],
                    ],
                ],
            ],
            'actual'       => [
                [
                    'value'         => null,
                    'comment'       => [
                        [
                            'narrative' => [
                                [
                                    'narrative' => null,
                                    'language'  => null,
                                ],
                            ],
                        ],
                    ],
                    'dimension'     => [
                        [
                            'name'  => null,
                            'value' => null,
                        ],
                    ],
                    'document_link' => [
                        [
                            'url'           => null,
                            'format'        => null,
                            'title'         => [
                                [
                                    'narrative' => [
                                        [
                                            'narrative' => null,
                                            'language'  => null,
                                        ],
                                    ],
                                ],
                            ],
                            'description'   => [
                                [
                                    'narrative' => [
                                        [
                                            'narrative' => null,
                                            'language'  => null,
                                        ],
                                    ],
                                ],
                            ],
                            'category'      => [
                                [
                                    'code' => null,
                                ],
                            ],
                            'language'      => [
                                [
                                    'language' => null,
                                ],
                            ],
                            'document_date' => [
                                [
                                    'date' => null,
                                ],
                            ],
                        ],
                    ],
                    'location'      => [
                        [
                            'reference' => null,
                        ],
                    ],
                ],
            ],
        ];

    /**
     * Saves indicator periods.
     *
     * @param $aidstreamIndicatorId
     * @param $iatiIndicatorId
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function migrateIndicatorPeriod($aidstreamIndicatorId, $iatiIndicatorId): void
    {
        $aidstreamPeriods = $this->db::connection('aidstream')->table('indicator_periods')->where(
            'indicator_id',
            $aidstreamIndicatorId
        )->get();

        if (count($aidstreamPeriods)) {
            foreach ($aidstreamPeriods as $aidstreamPeriod) {
                $this->logInfo(
                    'Migrating indicator period for indicator id: ' . $aidstreamIndicatorId . ' and period id: ' . $aidstreamPeriod->id
                );
                $newIatiPeriod = [
                    'indicator_id' => $iatiIndicatorId,
                    'period'       => $this->getNewPeriodData($aidstreamPeriod),
                    'created_at'   => $aidstreamPeriod->created_at,
                    'updated_at'   => $aidstreamPeriod->updated_at,
                ];
                $this->periodService->create($newIatiPeriod);
                $this->logInfo('Completed migrating indicator period for indicator id: ' . $aidstreamIndicatorId . ' and period id: ' . $aidstreamPeriod->id);
            }
        }
    }

    /**
     * Returns new period data.
     *
     * @param $aidstreamPeriod
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getNewPeriodData($aidstreamPeriod): array
    {
        $dimensions = $this->getDimensionData(
            $aidstreamPeriod->dimension,
            $this->emptyPeriodTemplate['target'][0]['dimension']
        );

        $locations = $this->getLocationData(
            $aidstreamPeriod->location,
            $this->emptyPeriodTemplate['target'][0]['location']
        );

        return [
            'period_start' => [
                [
                    'date' => $aidstreamPeriod->period_start,
                ],
            ],
            'period_end'   => [
                [
                    'date' => $aidstreamPeriod->period_end,
                ],
            ],
            'target'       => $this->getNewPeriodTargetActualData(
                $aidstreamPeriod,
                'period_targets',
                $this->emptyPeriodTemplate['target'],
                $dimensions,
                $locations
            ),
            'actual'      => $this->getNewPeriodTargetActualData(
                $aidstreamPeriod,
                'period_actuals',
                $this->emptyPeriodTemplate['actual'],
                $dimensions,
                $locations
            ),
        ];
    }

    /**
     * Returns new period target actual data.
     *
     * @param $aidstreamPeriod
     * @param $tableName
     * @param $emptyTemplate
     * @param $dimensions
     * @param $locations
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getNewPeriodTargetActualData($aidstreamPeriod, $tableName, $emptyTemplate, $dimensions, $locations): array
    {
        $aidstreamTargetActual = $this->db::connection('aidstream')->table($tableName)->where(
            'period_id',
            $aidstreamPeriod->id
        )->get();

        if (!count($aidstreamTargetActual)) {
            return $emptyTemplate;
        }

        $newData = [];

        foreach ($aidstreamTargetActual as $key => $aidstreamData) {
            $newData[$key]['value'] = !is_null($aidstreamData->value) ? (string) $aidstreamData->value : null;
            $newData[$key]['comment'] = !is_null(
                $aidstreamData->comments
            ) ? json_decode($aidstreamData->comments, true, 512, JSON_THROW_ON_ERROR) : $emptyTemplate[0]['comment'];
            $newData[$key]['dimension'] = $dimensions;

            if ($tableName === 'period_targets') {
                $newData[$key]['document_link'] = $this->getResultIndicatorDocumentLinkData(
                    'period_target_document_links',
                    'period_target_id',
                    $aidstreamData->id,
                    $emptyTemplate[0]['document_link']
                );
            } else {
                $newData[$key]['document_link'] = $this->getResultIndicatorDocumentLinkData(
                    'period_actual_document_links',
                    'period_actual_id',
                    $aidstreamData->id,
                    $emptyTemplate[0]['document_link']
                );
            }

            $newData[$key]['location'] = $locations;
        }

        return count($newData) ? $newData : $emptyTemplate;
    }
}
