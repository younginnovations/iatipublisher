<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use Illuminate\Support\Arr;

/*
 * Class MigrateProUserTrait.
 */
trait MigrateProUserTrait
{
    /**
     * @var mixed|string
     */
    public mixed $currentAidstreamOrganizationBeingProcessed = '';

    /**
     * @var array
     */
    public array $proUserCustomVocabArray = [];

    /**
     * @var array
     */
    public array $customVocabCurrentlyUsedByOrganization = [];

    /**
     * @var array
     */
    public array $customVocabCurrentlyUsedByActivity = [];

    /**
     * Returns aws url of custom vocab csv.
     *
     * @return string
     */
    public function getCustomVocabularyUrl(): string
    {
        $filename = strtolower($this->currentAidstreamOrganizationBeingProcessed->user_identifier);
        $filepath = "custom-vocabulary/{$filename}.csv";

        return awsUrl($filepath);
    }

    /**
     * @param $item
     * @param $vocabulary
     * @param $elementName
     * @param bool $onlyCustomCode
     *
     * @return mixed
     */
    public function resolveCustomVocabularyArray($item, $vocabulary, $elementName, bool $onlyCustomCode = false): mixed
    {
        $returnArr = [];

        //Iati code key => Aidstream code key
        $codeMap = [
            'region_vocabulary' => ['custom_code' => 'custom_code'],
            'sector_vocabulary' => ['text'        => 'custom_code'],
            'vocabulary'        => [
                'humanitarian_scope' => ['code'=>'custom_code'],
                'policy_marker'      => ['policy_marker_text' => 'custom_code'],
            ],
        ];

        $vocabularyMap = [
            'policy_marker_vocabulary' => 'vocabulary',
        ];

        $templatesFor99 = [
            'region_vocabulary' => [
                'region_vocabulary' => '',
                'custom_code'       => '',
                'percentage'        => '',
                'vocabulary_uri'    => '',
                'narrative'         => [['narrative' => null, 'language' => null]],
            ],
            'sector_vocabulary' => [
                'sector_vocabulary' => '',
                'text'              => '',
                'percentage'        => '',
                'vocabulary_uri'    => '',
                'narrative'         => [['narrative' => null, 'language' => null]],
            ],
            'vocabulary'        => [
                'humanitarian_scope' => [
                    'type'           => '',
                    'vocabulary'     => '',
                    'vocabulary_uri' => '',
                    'code'           => '',
                    'narrative'         => [['narrative' => null, 'language' => null]],
                ],
                'policy_marker'      => [
                    'policy_marker_vocabulary' => '',
                    'vocabulary_uri'           => '',
                    'significance'             => '',
                    'policy_marker_text'       => '',
                    'narrative'         => [['narrative' => null, 'language' => null]],
                ],
            ],
        ];

        if ($item) {
            $vocabularyCodeMap = [];

            switch($vocabulary) {
                case 'region_vocabulary':
                case 'sector_vocabulary':
                    $selectedTemplate = Arr::get($templatesFor99, $vocabulary, []);
                    $vocabularyCodeMap = Arr::get($codeMap, $vocabulary, []);
                    break;
                default:
                    $selectedTemplate = Arr::get($templatesFor99, "vocabulary.$elementName", []);
                    $vocabularyCodeMap = Arr::get($codeMap, "vocabulary.$elementName", []);
                    break;
            }

            foreach ($selectedTemplate as $key => $value) {
                $aidStreamKey = $key;

                if (array_key_exists($key, $vocabularyMap)) {
                    $aidStreamKey = Arr::get($vocabularyMap, $key);
                }

                if (array_key_exists($key, $vocabularyCodeMap)) {
                    $aidStreamKey = Arr::get($vocabularyCodeMap, $key);
                }

                $returnArr[$key] = Arr::get($item, $aidStreamKey, $value);

                if ($key === 'vocabulary_uri') {
                    $returnArr[$key] = $this->customVocabUrl;
                }
            }

            if ($onlyCustomCode) {
                $plainArray = array_values(array_flip($vocabularyCodeMap));
                $key = Arr::get($plainArray, 0, false);

                return $key ? Arr::get($returnArr, $key, null) : null;
            }
        }

        return $returnArr;
    }

    /**
     * Migrate custom vocab csv file to s3.
     *
     * @param $aidStreamOrganization
     *
     * @return void
     */
    public function migrateCustomVocabularyCsvFileToS3($aidStreamOrganization): void
    {
        $this->currentAidstreamOrganizationBeingProcessed = $aidStreamOrganization;
        $customVocabCollection = $this->db::connection('aidstream')->table('custom_vocab_new')->where('org_id', $aidStreamOrganization->id)?->get() ?? false;

        if ($customVocabCollection) {
            $this->setProUserCustomVocabArray($customVocabCollection);
            $csvData = $this->generateCsvData($customVocabCollection);
            $filename = strtolower($aidStreamOrganization->user_identifier);
            $filepath = "custom-vocabulary/{$filename}.csv";

            if (awsUploadFile($filepath, $csvData)) {
                $this->hasCustomVocab = true;
                $this->customVocabUrl = awsUrl($filepath);
                $this->logInfo('Successfully migrated custom vocabulary csv.');
            } else {
                $message = "Failed migrating Custom Vocabulary csv file of Aidstream organization: {$aidStreamOrganization->name}";
                $this->setGeneralError($message)->setDetailedError($message, $aidStreamOrganization->id, 'custom_vocab_new');
                $this->logInfo($message);
            }
        } else {
            $this->logInfo('No custom vocab to migrate.');
        }
    }

    /**
     * Returns custom vocab in csv string.
     *
     * @param $customVocabCollection
     *
     * @return string
     */
    public function generateCsvData($customVocabCollection): string
    {
        $csv = '';
        $data = [];
        $header = ['vocabulary_type', 'code', 'description'];
        $data[] = $header;

        foreach ($customVocabCollection as $customVocab) {
            $row = [
                $customVocab->vocabulary_type,
                $customVocab->code,
                $customVocab->description,
            ];
            $data[] = $row;
        }

        foreach ($data as $row) {
            $csv = $csv . implode(',', $row) . "\n";
        }

        return $csv;
    }

    /**
     * Returns custom code from id.
     *
     * @param $customVocabId
     *
     * @return string
     */
    public function getCustomCodeFromId($customVocabId): string
    {
        return $this->db::connection('aidstream')->table('custom_vocab_new')->where('id', $customVocabId)?->first()?->code ?? '';
    }

    /**
     * Sets proUserCustomVocabArray.
     *
     * @param $customVocabCollection
     *
     * @return void
     */
    public function setProUserCustomVocabArray($customVocabCollection): void
    {
        $this->proUserCustomVocabArray = [];

        foreach ($customVocabCollection as $customVocab) {
            $this->proUserCustomVocabArray[$customVocab->id]['code'] = $customVocab->code;
            $this->proUserCustomVocabArray[$customVocab->id]['description'] = $customVocab->description;
            $this->proUserCustomVocabArray[$customVocab->id]['vocabulary_type'] = $customVocab->vocabulary_type;
        }
    }

    /**
     * Returns specific element from proUserCustomVocabArray.
     *
     * @param $id
     * @param $key
     *
     * @return string
     */
    public function getProUserCustomVocabArrayValue($id, $key): string
    {
        return Arr::get($this->proUserCustomVocabArray, "{$id}.{$key}", '');
    }

    /**
     * Clears custom vocab tracking arrays.
     *
     * @param $level
     *
     * @return void
     */
    public function resetCustomVocabTracking($level): void
    {
        if ($level === 'organization') {
            $this->customVocabCurrentlyUsedByOrganization = [];
        } else {
            $this->customVocabCurrentlyUsedByActivity = [];
        }
    }

    /**
     * Track error if elements use custom vocab deleted by organization.
     *
     * @param array $customVocabCurrentlyUsedByOrganization
     *
     * @return void
     */
    public function checkForCustomVocabularyMismatchInFile(array $customVocabCurrentlyUsedByOrganization): void
    {
        $allCodesArray = $this->extractOnlyCode($this->proUserCustomVocabArray);

        foreach ($customVocabCurrentlyUsedByOrganization as $activityId => $elementCodeArray) {
            foreach ($elementCodeArray as $elementName => $valueArray) {
                foreach ($valueArray as $value) {
                    if (!in_array($value, $allCodesArray)) {
                        $message = "Organization: '{$this->currentAidstreamOrganizationBeingProcessed->name}' no longer uses custom code: {$value}. This will affect : {$elementName}";
                        $this->setGeneralError($message)
                            ->setDetailedError(
                                $message,
                                $this->currentAidstreamOrganizationBeingProcessed->id,
                                'Activity',
                                $activityId,
                                '',
                                '',
                                $elementName
                            );

                        $this->info("[!!IMPORTANT!!] {$message}");
                    }
                }
            }
        }
    }

    /**
     * Returns array of custom codes.
     *
     * @param array $proUserCustomVocabArray
     *
     * @return array
     */
    public function extractOnlyCode(array $proUserCustomVocabArray): array
    {
        $codeArray = [];

        foreach ($proUserCustomVocabArray as $index => $element) {
            $codeArray[] = Arr::get($element, 'code', false);
        }

        return $codeArray;
    }
}
