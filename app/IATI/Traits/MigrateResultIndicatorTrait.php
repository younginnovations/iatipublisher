<?php

declare(strict_types=1);

namespace App\IATI\Traits;

/**
 * Class MigrateResultIndicatorTrait.
 */
trait MigrateResultIndicatorTrait
{
    /**
     * Empty result indicator template.
     *
     * @var array
     */
    protected array $emptyIndicatorTemplate
        = [
            'measure'            => null,
            'ascending'          => null,
            'aggregation_status' => null,
            'title'              => [
                [
                    'narrative' => [
                        [
                            'narrative' => null,
                            'language'  => null,
                        ],
                    ],
                ],
            ],
            'description'        => [
                [
                    'narrative' => [
                        [
                            'narrative' => null,
                            'language'  => null,
                        ],
                    ],
                ],
            ],
            'document_link'      => [
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
            'reference'          => [
                [
                    'vocabulary' => null,
                    'code'       => null,
                ],
            ],
            'baseline'           => [
                [
                    'year'          => null,
                    'date'          => null,
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
     * Migrates result indicators from AidStream to IATI Publisher.
     *
     * @param $aidstreamResultId
     * @param $iatiResultId
     * @param $iatiOrganization
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function migrateResultIndicator($aidstreamResultId, $iatiResultId, $iatiOrganization): void
    {
        $this->db::connection('aidstream')->table('activity_result_indicators_new')->where(
            'result_id',
            $aidstreamResultId
        )->orderBy('id')->chunk(10, function ($aidstreamIndicators) use ($aidstreamResultId, $iatiResultId, $iatiOrganization) {
            if (count($aidstreamIndicators)) {
                foreach ($aidstreamIndicators as $aidstreamIndicator) {
                    $this->logInfo('Migrating result indicator for result id: ' . $aidstreamResultId) . ' with indicator id: ' . $aidstreamIndicator->id;
                    $newIatiIndicator = [
                        'result_id'  => $iatiResultId,
                        'indicator'  => $this->getNewIndicatorData($aidstreamIndicator, $iatiOrganization),
                        'migrated_from_aidstream' => true,
                        'created_at' => $aidstreamIndicator->created_at,
                        'updated_at' => $aidstreamIndicator->updated_at,
                    ];

                    $iatiIndicator = $this->indicatorService->create($newIatiIndicator);
                    $this->logInfo('Completed migrating result indicator for result id: ' . $aidstreamResultId . ' with indicator id: ' . $aidstreamIndicator->id);

                    $this->migrateIndicatorPeriod($aidstreamIndicator->id, $iatiIndicator->id, $iatiOrganization);
                }
            }
        });
    }

    /**
     * Returns indicator data.
     *
     * @param $aidstreamIndicator
     * @param $iatiOrganization
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getNewIndicatorData($aidstreamIndicator, $iatiOrganization): array
    {
        $newIndicatorData = [];
        $newIndicatorData['measure'] = !is_null(
            $aidstreamIndicator->measure
        ) ? (string) $aidstreamIndicator->measure : null;
        $newIndicatorData['ascending'] = !is_null(
            $aidstreamIndicator->ascending
        ) ? (string) $aidstreamIndicator->ascending : null;
        $newIndicatorData['aggregation_status'] = !is_null(
            $aidstreamIndicator->aggregation_status
        ) ? (string) $aidstreamIndicator->aggregation_status : null;
        $newIndicatorData['title'] = !is_null($aidstreamIndicator->title) ? json_decode(
            $aidstreamIndicator->title,
            true,
            512,
            JSON_THROW_ON_ERROR
        ) : $this->emptyIndicatorTemplate['title'];
        $newIndicatorData['description'] = !is_null($aidstreamIndicator->description) ? json_decode(
            $aidstreamIndicator->description,
            true,
            512,
            JSON_THROW_ON_ERROR
        ) : $this->emptyIndicatorTemplate['description'];
        $newIndicatorData['document_link'] = $this->getResultIndicatorDocumentLinkData(
            'indicator_document_links',
            'indicator_id',
            $aidstreamIndicator->id,
            $this->emptyIndicatorTemplate['document_link'],
            $iatiOrganization
        );
        $newIndicatorData['reference'] = $this->getResultIndicatorReferenceData(
            $aidstreamIndicator->id,
            $this->emptyIndicatorTemplate['reference']
        );
        $newIndicatorData['baseline'] = $this->getResultIndicatorBaselineData(
            $aidstreamIndicator->id,
            $this->emptyIndicatorTemplate['baseline'],
            $iatiOrganization
        );

        $newIndicatorData['created_at'] = $aidstreamIndicator->created_at;
        $newIndicatorData['updated_at'] = $aidstreamIndicator->updated_at;

        return $newIndicatorData;
    }

    /**
     * Returns indicator document links.
     *
     * @param $tableName
     * @param $idColumn
     * @param $id
     * @param $emptyTemplate
     * @param $iatiOrganization
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getResultIndicatorDocumentLinkData($tableName, $idColumn, $id, $emptyTemplate, $iatiOrganization): array
    {
        $aidstreamDocumentLinks = $this->db::connection('aidstream')->table($tableName)->where($idColumn, $id)->get();

        if (!count($aidstreamDocumentLinks)) {
            return $emptyTemplate;
        }

        $newDocumentLinks = [];

        foreach ($aidstreamDocumentLinks as $documentLink) {
            $newDocumentLinks[] = [
                'url'           => !empty($documentLink->url) ? $this->replaceDocumentLinkUrl($documentLink->url, $iatiOrganization->id) : null,
                'format'        => $documentLink->format,
                'title'         => !is_null($documentLink->title) ? json_decode(
                    $documentLink->title,
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                ) : $emptyTemplate[0]['title'],
                'description'   => !is_null($documentLink->description) ? json_decode(
                    $documentLink->description,
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                ) : $emptyTemplate[0]['description'],
                'category'      => (!is_null($documentLink->category) && !empty(
                    json_decode(
                        $documentLink->category,
                        true,
                        512,
                        JSON_THROW_ON_ERROR
                    )
                )) ? json_decode(
                    $documentLink->category,
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                ) : $emptyTemplate[0]['category'],
                'language'      => (!is_null($documentLink->language) && !empty(
                    json_decode(
                        $documentLink->language,
                        true,
                        512,
                        JSON_THROW_ON_ERROR
                    )
                )) ? json_decode(
                    $documentLink->language,
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                ) : $emptyTemplate[0]['language'],
                'document_date' => [
                    [
                        'date' => $documentLink->publication_date,
                    ],
                ],
            ];
        }

        return count($newDocumentLinks) ? $newDocumentLinks : $emptyTemplate;
    }

    /**
     * Returns indicator reference data.
     *
     * @param $aidstreamIndicatorId
     * @param $emptyTemplate
     *
     * @return array
     */
    public function getResultIndicatorReferenceData($aidstreamIndicatorId, $emptyTemplate): array
    {
        $aidstreamReferences = $this->db::connection('aidstream')->table('indicator_references')->where(
            'indicator_id',
            $aidstreamIndicatorId
        )->get();

        if (!count($aidstreamReferences)) {
            return $emptyTemplate;
        }

        $newReferences = [];

        foreach ($aidstreamReferences as $key => $reference) {
            $newReferences[$key] = [
                'vocabulary' => $reference->vocabulary,
                'code'       => $reference->code,
            ];

            if ($reference->vocabulary === '99') {
                $newReferences[$key]['indicator_uri'] = $reference->url;
            }
        }

        return count($newReferences) ? $newReferences : $emptyTemplate;
    }

    /**
     * Returns indicator baseline data.
     *
     * @param $aidstreamIndicatorId
     * @param $emptyTemplate
     * @param $iatiOrganization
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getResultIndicatorBaselineData($aidstreamIndicatorId, $emptyTemplate, $iatiOrganization): array
    {
        $aidstreamBaselines = $this->db::connection('aidstream')->table('indicator_baselines')->where(
            'indicator_id',
            $aidstreamIndicatorId
        )->get();

        if (!count($aidstreamBaselines)) {
            return $emptyTemplate;
        }

        $newBaselines = [];

        foreach ($aidstreamBaselines as $key => $baseline) {
            $newBaselines[$key] = [
                'year'          => $baseline->year,
                'date'          => $baseline->iso_date,
                'value'         => $baseline->value,
                'comment'       => !is_null($baseline->comments) ? json_decode(
                    $baseline->comments,
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                ) : $emptyTemplate[0]['comment'],
                'dimension'     => $this->getDimensionData($baseline->dimension, $emptyTemplate[0]['dimension']),
                'document_link' => $this->getResultIndicatorDocumentLinkData(
                    'baseline_document_links',
                    'baseline_id',
                    $baseline->id,
                    $emptyTemplate[0]['document_link'],
                    $iatiOrganization
                ),
                'location'      => $this->getLocationData($baseline->location, $emptyTemplate[0]['location']),
            ];
        }

        return count($newBaselines) ? $newBaselines : $emptyTemplate;
    }

    /**
     * Returns dimension data in required format.
     *
     * @param $dimensions
     * @param $template
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getDimensionData($dimensions, $template): array
    {
        if (!$dimensions) {
            return $template;
        }

        $dimensionsArray = json_decode($dimensions, true, 512, JSON_THROW_ON_ERROR);

        if (empty($dimensionsArray)) {
            return $template;
        }

        $newDimension = [];
        $dimensionValues = $this->db::connection('aidstream')->table('dimension_name_values')->join(
            'dimension_names',
            'dimension_name_values.dimension_name_id',
            '=',
            'dimension_names.id'
        )->whereIn('dimension_name_values.id', $dimensionsArray)->get();

        foreach ($dimensionValues as $data) {
            $newDimension[] = [
                'name'  => $data->name,
                'value' => $data->value,
            ];
        }

        return count($newDimension) ? $newDimension : $template;
    }

    /**
     * Returns location data in required format.
     *
     * @param $locations
     * @param $template
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getLocationData($locations, $template): array
    {
        if (!$locations) {
            return $template;
        }

        $locationArray = json_decode($locations, true, 512, JSON_THROW_ON_ERROR);

        if (empty($locationArray)) {
            return $template;
        }

        $newLocation = [];
        $locationValues = $this->db::connection('aidstream')->table('location_references')->whereIn(
            'id',
            $locationArray
        )->get();

        foreach ($locationValues as $data) {
            $newLocation[] = [
                'reference' => $data->reference,
            ];
        }

        return count($newLocation) ? $newLocation : $template;
    }
}
