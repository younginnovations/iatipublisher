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
     * @param $iatiOrganization
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function migrateIndicatorPeriod($aidstreamIndicatorId, $iatiIndicatorId, $iatiOrganization): void
    {
        $this->db::connection('aidstream')->table('indicator_periods')->where(
            'indicator_id',
            $aidstreamIndicatorId
        )->orderBy('id')->chunk(10, function ($aidstreamPeriods) use ($aidstreamIndicatorId, $iatiIndicatorId, $iatiOrganization) {
            if (count($aidstreamPeriods)) {
                foreach ($aidstreamPeriods as $aidstreamPeriod) {
                    $this->logInfo(
                        'Migrating indicator period for indicator id: ' . $aidstreamIndicatorId . ' and period id: ' . $aidstreamPeriod->id
                    );
                    $newIatiPeriod = [
                        'indicator_id' => $iatiIndicatorId,
                        'period'       => $this->getNewPeriodData($aidstreamPeriod, $iatiOrganization),
                        'migrated_from_aidstream' => true,
                        'created_at'   => $aidstreamPeriod->created_at,
                        'updated_at'   => $aidstreamPeriod->updated_at,
                    ];
                    $this->periodService->create($newIatiPeriod);
                    $this->logInfo('Completed migrating indicator period for indicator id: ' . $aidstreamIndicatorId . ' and period id: ' . $aidstreamPeriod->id);
                }
            }
        });
    }

    /**
     * Returns new period data.
     *
     * @param $aidstreamPeriod
     * @param $iatiOrganization
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getNewPeriodData($aidstreamPeriod, $iatiOrganization): array
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
                $locations,
                $iatiOrganization
            ),
            'actual'      => $this->getNewPeriodTargetActualData(
                $aidstreamPeriod,
                'period_actuals',
                $this->emptyPeriodTemplate['actual'],
                $dimensions,
                $locations,
                $iatiOrganization
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
     * @param $iatiOrganization
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getNewPeriodTargetActualData($aidstreamPeriod, $tableName, $emptyTemplate, $dimensions, $locations, $iatiOrganization): array
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
                    $emptyTemplate[0]['document_link'],
                    $iatiOrganization
                );
            } else {
                $newData[$key]['document_link'] = $this->getResultIndicatorDocumentLinkData(
                    'period_actual_document_links',
                    'period_actual_id',
                    $aidstreamData->id,
                    $emptyTemplate[0]['document_link'],
                    $iatiOrganization
                );
            }

            $newData[$key]['location'] = $locations;
        }

        return count($newData) ? $newData : $emptyTemplate;
    }
}
