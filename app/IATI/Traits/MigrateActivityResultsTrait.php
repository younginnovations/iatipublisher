<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use App\IATI\Models\Activity\Activity;
use Illuminate\Support\Arr;
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
    public array $notNeededKeys = ['id', 'updated_at', 'created_at', 'result_id', 'publication_date', 'custom'];

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
                'language'      => [['language' => null]],
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
     * @param $iatiOrganization
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function migrateActivityResults($iatiActivity, $aidstreamActivity, $iatiOrganization): void
    {
        $aidStreamActivityResult = $this->getAidStreamActivityResult($aidstreamActivity->id, $iatiOrganization);

        foreach ($aidStreamActivityResult as $result) {
            list($aidStreamResultId, $created_at, $updated_at) = $this->extractSpecifiedKeys($result, ['id', 'created_at', 'updated_at']);
            $result = $this->unsetNotNeededKeys($result, ['id', 'created_at', 'updated_at']);

            $this->logInfo("Started migrating AidStream Activity Result for activity id: {$aidstreamActivity->id} and result id: {$aidStreamResultId}");

            $iatiResult = $this->resultService->create([
                'activity_id' => $iatiActivity->id,
                'result'      => $result,
                'created_at'  => $created_at,
                'updated_at'  => $updated_at,
                'migrated_from_aidstream'=> true,
            ]);

            $this->logInfo("Completed migrating AidStream Activity Result for activity id: {$aidstreamActivity->id} and result id: {$aidStreamResultId}");
            $this->migrateResultIndicator($aidStreamResultId, $iatiResult->id, $iatiOrganization);
        }
    }

    /**
     * Returns activity result for iati.
     *
     * @param $id
     * @param $iatiOrganization
     *
     * @return array
     */
    public function getAidStreamActivityResult($id, $iatiOrganization): array
    {
        $this->logInfo("Started fetching AidStream Activity Results for activity id: {$id}");

        $baseResults = $this->getBaseResult($id);

        if ($baseResults->isEmpty()) {
            $this->logInfo("No result were found for activity id: {$id}");

            return [];
        }

        $createdAt = $baseResults->pluck('created_at', 'id');
        $updatedAt = $baseResults->pluck('updated_at', 'id');
        $resultIds = $baseResults->pluck('id');

        $this->logInfo("Started fetching AidStream Reference and Document Link for activity id: {$id}");

        $resultsReference = $this->getResultReference($resultIds);
        $resultsDocumentLink = $this->getResultDocumentLink($resultIds);

        $returnArr = $this->resolveResult($baseResults->toArray(), $resultsReference->toArray(), $resultsDocumentLink->toArray(), $iatiOrganization);
        $returnArr = $this->mapDates($returnArr, $createdAt, $updatedAt);

        $this->logInfo("Completed fetching AidStream Activity Results for activity id: {$id}");

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
     * @param $iatiOrganization
     *
     * @return mixed
     */
    public function resolveResult($baseResults, $resultsReferences, $resultsDocumentLinks, $iatiOrganization): mixed
    {
        $merged = [];
        $resultIds = [];

        foreach ($baseResults as $index => $baseResult) {
            $this->logInfo("Started resolving result for result_id: {$baseResult->id}");

            foreach ($baseResult as $key=>$data) {
                if (in_array($key, $this->neededKeys)) {
                    $merged[$index][$key] = $data;
                }
            }

            $resultIds[$index] = $baseResult->id;
            $merged[$index]['reference'] = $this->resolveResultReferences($baseResult, $resultsReferences, $iatiOrganization);
            $merged[$index]['document_link'] = $this->resolveDocumentLinks($baseResult, $resultsDocumentLinks, $iatiOrganization);
            $merged[$index] = $this->resolveJsonString($merged[$index]);

            $merged[$index]['document_link'][0]['document_date'] = [];
            $publicationDate = ['date' => Arr::get($merged[$index]['document_link'], '0.publication_date', null)];
            $merged[$index]['document_link'][0]['document_date'][] = $publicationDate;

            if (isset($merged[$index]['document_link'][0]['date'])) {
                unset($merged[$index]['document_link'][0]['date']);
            }

            $this->logInfo("Completed resolving result for result_id: {$baseResult->id}");
        }

        $merged = $this->unsetNotNeededKeys($merged, $this->notNeededKeys);

        foreach ($merged as $index => $value) {
            $merged[$index]['id'] = $resultIds[$index];
        }

        return $this->castToString($merged);
    }

    /**
     * Get References for only those result_id that match.
     *
     * @param $baseResult
     * @param $resultReferences
     * @param $iatiOrganization
     *
     * @return array
     */
    public function resolveResultReferences($baseResult, $resultReferences, $iatiOrganization): array
    {
        $referencesThatMatchResultId = [];

        foreach ($resultReferences as $reference) {
            if ($reference->result_id === $baseResult->id) {
                if ($reference->custom) {
                    $this->logInfo("Found custom vocab for reference (id: {$reference->id}) in result id: {$baseResult->id}");
                    $customVocabId = $reference->code;
                    $reference->code = $this->getProUserCustomVocabArrayValue($customVocabId, 'code');
                    $reference->vocabulary_uri = $this->getCustomVocabularyUrl();
                    unset($reference->custom);
                } else {
                    $this->logInfo("Reference of id: {$reference->id} exists in result of id {$baseResult->id}.");
                    $reference->vocabulary_uri = !empty($reference->url) ? $this->replaceDocumentLinkUrl($reference->url, $iatiOrganization) : null;
                }
                unset($reference->url);
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
     * @param $iatiOrganization
     *
     * @return array
     */
    public function resolveDocumentLinks($baseResult, $resultDocumentLinks, $iatiOrganization): array
    {
        $documentLinksThatMatchResultId = [];

        foreach ($resultDocumentLinks as $documentLink) {
            if ($documentLink->result_id === $baseResult->id) {
                $this->logInfo("Document link of id: {$documentLink->id} exists in result of id {$baseResult->id}.");
                $documentLink->url = $this->replaceDocumentLinkUrl($documentLink->url, $iatiOrganization->id);
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
     * @return array|mixed
     */
    public function castToString(&$array): mixed
    {
        $temp = [];

        foreach ($array as $key => &$value) {
            $temp = $array;

            if (is_array($value)) {
                $this->castToString($value);
            } elseif (is_bool($value) || is_int($value)) {
                $temp[$key] = (string) $value;
            }
        }

        return $temp;
    }

    /**
     * Maps each result to the base results created_at and updated_at.
     *
     * @param $resultsArray
     * @param $createdAt
     * @param $updatedAt
     *
     * @return array
     */
    public function mapDates($resultsArray, $createdAt, $updatedAt): array
    {
        foreach ($resultsArray as $index => $result) {
            $resultsArray[$index]['created_at'] = $createdAt[$result['id']];
            $resultsArray[$index]['updated_at'] = $updatedAt[$result['id']];
        }

        return $resultsArray;
    }

    /**
     * Returns specified keys from source array.
     *
     * @param $sourceArray
     * @param $keysArray
     *
     * @return array
     */
    public function extractSpecifiedKeys($sourceArray, $keysArray): array
    {
        $returnArray = [];

        foreach ($keysArray as $key) {
            $returnArray[] = $sourceArray[$key];
        }

        return $returnArray;
    }
}
