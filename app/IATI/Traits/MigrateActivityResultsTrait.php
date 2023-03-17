<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use Illuminate\Support\Collection;

/**
 * Class MigrateActivityResultsTrait.
 */
trait MigrateActivityResultsTrait
{
    /**
     * Top level keys we need.
     *
     * @var array|string[]
     */
    public array $neededKeys = ['id', 'title', 'type', 'aggregation_status', 'description', 'document_link', 'reference'];

    /**
     * Any level keys we do not need.
     *
     * @var array|string[]
     */
    public array $notNeededKeys = ['id', 'updated_at', 'created_at', 'result_id', 'publication_date'];

    /**
     * Template of a complete result.
     *
     * @var array
     */
    public array $emptyResultTemplate = [
        'type'               => null,
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
                'category'      => [['code' => null]],
                'language'      => [['language' => 'en']],
                'document_date' => [['date' => null]],
            ],
        ],
        'reference'          => [
            [
                'vocabulary'     => null,
                'code'           => null,
                'vocabulary_uri' => null,
            ],
        ],
    ];

    /**
     * Migrates Aidstream activity result to iati activity result.
     *
     * @param $iatiActivity
     * @param $aidstreamActivity
     *
     * @return void
     */
    public function migrateActivityResults($iatiActivity, $aidstreamActivity): void
    {
        $aidStreamActivityResult = $this->getAidStreamActivityResult($aidstreamActivity->id);

        foreach ($aidStreamActivityResult as $result) {
            $iatiResult = $this->resultService->create(['activity_id'=>$iatiActivity->id, 'result'=>$result]);
        }
    }

    /**
     * Returns activity result for iati.
     *
     * @param $id
     *
     * @return array
     */
    public function getAidStreamActivityResult($id): array
    {
        $this->info("Started fetching AidStream Activity Results for activity id: {$id}");

        $baseResults = $this->getBaseResult($id);
        $resultIds = $baseResults->pluck('id');

        $this->info("Started fetching AidStream Reference and Document Link for activity id: {$id}");

        $resultsReference = $this->getResultReference($resultIds);
        $resultsDocumentLink = $this->getResultDocumentLink($resultIds);

        $returnArr = $this->resolveResult($baseResults->toArray(), $resultsReference->toArray(), $resultsDocumentLink->toArray());

        $this->info("Started fetching AidStream Reference and Document Link for activity id: {$id}");
        $this->info("Completed fetching AidStream Activity Results for activity id: {$id}");

        return $returnArr;
    }

    /**
     * Gets base result from aidstream.
     *
     * @param $activityId
     *
     * @return Collection
     */
    public function getBaseResult($activityId): Collection
    {
        return $this->db::connection('aidstream')->table('activity_results_new')->where('activity_id', $activityId)->get();
    }

    /**
     * Get result reference from aidstream.
     *
     * @param $resultIds
     *
     * @return Collection
     */
    public function getResultReference($resultIds): Collection
    {
        return $this->db::connection('aidstream')->table('result_references')->whereIn('result_id', $resultIds)->get();
    }

    /**
     * Get result document links from aidstream.
     *
     * @param $resultIds
     *
     * @return Collection
     */
    public function getResultDocumentLink($resultIds): Collection
    {
        return $this->db::connection('aidstream')->table('result_document_links')->whereIn('result_id', $resultIds)->get();
    }

    /**
     * Returns merged array for iati activity result.
     *
     * @param $baseResults
     * @param $resultsReferences
     * @param $resultsDocumentLinks
     *
     * @return mixed
     */
    public function resolveResult($baseResults, $resultsReferences, $resultsDocumentLinks): mixed
    {
        $merged = [];
        $resultIds = [];

        foreach ($baseResults as $index => $baseResult) {
            $this->info("Started resolving result for result_id: {$baseResult->id}");

            foreach ($baseResult as $key=>$data) {
                if (in_array($key, $this->neededKeys)) {
                    $merged[$index][$key] = $data;
                }
            }

            $resultIds[$index] = $baseResult->id;
            $merged[$index]['reference'] = $this->resolveResultReferences($baseResult, $resultsReferences);
            $merged[$index]['document_link'] = $this->resolveDocumentLinks($baseResult, $resultsDocumentLinks);
            $merged[$index] = $this->resolveJsonString($merged[$index]);

            $merged[$index]['document_link'][0]['document_date'] = [];
            $publicationDate = ['date' => isset($merged[$index]['document_link'][0]['publication_date']) ?? []];
            $merged[$index]['document_link'][0]['document_date'][] = $publicationDate;
            if (isset($merged[$index]['document_link'][0]['date'])) {
                unset($merged[$index]['document_link'][0]['date']);
            }

            $this->info("Completed resolving result for result_id: {$baseResult->id}");
        }

        $merged = $this->unsetNotNeededKeys($merged, $this->notNeededKeys);

        foreach ($merged as $index => $value) {
            +$merged[$index]['id'] = $resultIds[$index];
        }

        return $this->castToString($merged);
    }

    /**
     * Get References for only those result_id that match.
     *
     * @param $baseResult
     * @param $resultReferences
     *
     * @return array
     */
    public function resolveResultReferences($baseResult, $resultReferences): array
    {
        $referencesThatMatchResultId = [];

        foreach ($resultReferences as $reference) {
            if ($reference->result_id === $baseResult->id) {
                $this->info("Reference of id: {$reference->id} exists in result of id {$baseResult->id}.");
                $referencesThatMatchResultId[] = $reference;
            }
        }

        return $referencesThatMatchResultId;
    }

    /**
     * Get Document link for only those result_id that match.
     *
     * @param $baseResult
     * @param $resultDocumentLinks
     *
     * @return array
     */
    public function resolveDocumentLinks($baseResult, $resultDocumentLinks): array
    {
        $documentLinksThatMatchResultId = [];

        foreach ($resultDocumentLinks as $documentLink) {
            if ($documentLink->result_id === $baseResult->id) {
                $this->info("Document link of id: {$documentLink->id} exists in result of id {$baseResult->id}.");
                logger()->info("Document link of id: {$documentLink->id} exists in result of id {$baseResult->id}.");
                $documentLinksThatMatchResultId[] = $documentLink;
            }
        }

        return $documentLinksThatMatchResultId;
    }

    /**
     * Recursively json decode
     * To decode array strings.
     *
     * @param $arr
     *
     * @return mixed
     */
    public function resolveJsonString($arr): mixed
    {
        foreach ($arr as $key => $value) {
            if (empty($value) && array_key_exists($key, $this->emptyResultTemplate)) {
                $arr[$key] = $this->emptyResultTemplate[$key];
            } else {
                if (is_array($value)) {
                    $arr[$key] = $this->resolveJsonString($value);
                } elseif (is_string($value)) {
                    $decoded = json_decode($value, true);
                    if (is_array($decoded)) {
                        $arr[$key] = $this->resolveJsonString($decoded);
                    } else {
                        $arr[$key] = $decoded ?? $value;
                    }
                } elseif (is_object($value)) {
                    $arr[$key] = $this->resolveJsonString((array) $value);
                }
            }
        }

        return $arr;
    }

    /**
     * Unsets keys that do not fit iati keys
     * Unsets keys we do not need.
     *
     * @param $arr
     * @param $notNeededKeys
     *
     * @return mixed
     */
    public function unsetNotNeededKeys($arr, $notNeededKeys): mixed
    {
        foreach ($arr as $key => &$value) {
            if (is_array($value)) {
                $value = $this->unsetNotNeededKeys($value, $notNeededKeys);
            } else {
                if (in_array($key, $notNeededKeys)) {
                    unset($arr[$key]);
                }
            }
        }

        return $arr;
    }

    /**
     * Recursively cast int to string,
     * Bool to "1" or "0".
     *
     * @param $array
     *
     * @return mixed
     */
    public function castToString($array): mixed
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $this->castToString($value);
            } elseif (is_bool($value)) {
                $value = $value ? '1' : '0';
            } elseif (is_int($value)) {
                $value = strval($value);
            }
        }

        return $array;
    }
}
