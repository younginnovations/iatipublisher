<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Organization\Organization;
use App\IATI\Traits\MigrateActivityTrait;
use App\IATI\Traits\MigrateOrganizationTrait;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/*
 * Class FixDocumentLink
 */
class FixDocumentLink extends Command
{
    use MigrateOrganizationTrait;
    use MigrateActivityTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:FixDocumentLink';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command fixes issue #1196 task no.5';

    /**
     * @var array
     */
    public $documentLinkTemplate = [
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
        'category'      => [['code'     => null]],
        'language'      => [['language' => null]],
        'document_date' => [['date'     => null]],
    ];

    /**
     * @var int
     */
    public int $brokenCount = 0;

    /**
     * Constructor
     *
     * @param DB $db
     * @param DatabaseManager $databaseManager
     */
    public function __construct(protected DB $db, protected DatabaseManager $databaseManager) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     *
     * @throws \Throwable
     */
    public function handle(): int
    {
        try {
            $aidstreamOrganizationIdString = $this->askValid(
                'Enter aidstream organization Ids (csv): ',
                'aidstreamOrganizationIdString',
                ['required']
            );

            $aidstreamOrganizationIds = explode(',', $aidstreamOrganizationIdString);

            foreach ($aidstreamOrganizationIds as $key => $aidstreamOrganizationId) {
                $aidstreamOrganizationIds[$key] = (int) $aidstreamOrganizationId;
            }

            $this->databaseManager->beginTransaction();

            $aidstreamOrganizationIdentifierArray = $this->getAidstreamOrganizationIdentifier($aidstreamOrganizationIds);
            $aidstreamOrganizationIdentifierArray = array_map('strtolower', $aidstreamOrganizationIdentifierArray);

            $iatiOrganizations = Organization::whereIn('publisher_id', $aidstreamOrganizationIdentifierArray)->get();
            $iatiOrganizationIdArray = $iatiOrganizations->pluck('id', 'publisher_id');

            $idMap = $this->mapOrganizationIds($aidstreamOrganizationIdentifierArray, $iatiOrganizationIdArray);
            $activities = Activity::whereIn('org_id', $idMap)->get();

            foreach ($activities as $activity) {
                $this->fixActivityResultDocumentLink($activity);
            }

            $this->databaseManager->commit();
            $this->info("Completed fixing {$this->brokenCount} result document link");
        } catch(Exception $e) {
            logger($e);
        }

        return 0;
    }

    /**
     * Ask input from user and return value.
     *
     * @param $question
     * @param $field
     * @param $rules
     *
     * @return string
     */
    protected function askValid($question, $field, $rules): string
    {
        $value = $this->ask($question);
        $message = $this->validateInput($rules, $field, $value);

        if ($message) {
            $this->error($message);

            return $this->askValid($question, $field, $rules);
        }

        return $value;
    }

    /**
     * Validates input given by user.
     *
     * @param $rules
     * @param $fieldName
     * @param $value
     *
     * @return string|null
     */
    protected function validateInput($rules, $fieldName, $value): ?string
    {
        $validator = Validator::make([
            $fieldName => $value,
        ], [
            $fieldName => $rules,
        ]);

        return $validator->fails()
            ? $validator->errors()->first($fieldName)
            : null;
    }

    /**
     * Returns array of [organizationId => organizationIdentifier].
     *
     * @param $aidstreamOrganizationIds
     *
     * @return array
     */
    private function getAidstreamOrganizationIdentifier($aidstreamOrganizationIds): array
    {
        $aidstreamOrganizationsArray = [];
        $aidStreamSettings = $this->db::connection('aidstream')->table('settings')
            ->whereIn('organization_id', $aidstreamOrganizationIds)
            ->get();

        if ($aidStreamSettings) {
            foreach ($aidStreamSettings as $aidStreamSetting) {
                if (in_array($aidStreamSetting->organization_id, $aidstreamOrganizationIds)) {
                    $registryInfo = $aidStreamSetting->registry_info ? json_decode($aidStreamSetting->registry_info) : false;
                    $organizationIdentifier = $registryInfo[0]?->publisher_id;
                    $aidstreamOrganizationsArray[$aidStreamSetting->organization_id] = $organizationIdentifier;
                }
            }
        }

        return $aidstreamOrganizationsArray;
    }

    /**
     * Returns mapped array of ids
     * [aidstreamOrgId => iatiOrgId].
     *
     * @param array $aidstreamOrganizationIdentifierArray
     * @param $iatiOrganizationIdArray
     *
     * @return array
     */
    private function mapOrganizationIds(array $aidstreamOrganizationIdentifierArray, $iatiOrganizationIdArray): array
    {
        $mappedOrganizationsIdArray = [];

        foreach ($aidstreamOrganizationIdentifierArray as $aidstreamId=>$identifier) {
            $mappedOrganizationsIdArray[$aidstreamId] = Arr::get($iatiOrganizationIdArray, $identifier, '');
        }

        return $mappedOrganizationsIdArray;
    }

    /**
     * Fix activity >> result >> document_links.
     *
     * @param Activity $activity
     *
     * @return void
     */
    private function fixActivityResultDocumentLink(Activity $activity): void
    {
        $results = $activity?->results;

        if (count($results)) {
            $this->fixResultDocumentLink($results);
        }
    }

    /**
     * Fixes result document_links if there is any broken document_link.
     *
     * @param mixed $results
     *
     * @return void
     */
    private function fixResultDocumentLink(mixed $results): void
    {
        foreach ($results as $result) {
            $isBroken = false;
            $newArray = [];
            $resultField = $result->result;

            if ($resultField) {
                $documentLinks = Arr::get($resultField, 'document_link', false);

                if ($documentLinks) {
                    foreach ($documentLinks as $index => $documentLink) {
                        $newArray[$index] = $documentLink;
                        $tempDocumentLink = $documentLink;
                        unset($tempDocumentLink['language']);

                        if ($this->checkIfKeysAreNull($tempDocumentLink)) {
                            $this->brokenCount++;
                            $isBroken = true;
                            $newArray[$index] = $this->documentLinkTemplate;
                        }
                    }
                }
            }

            if ($isBroken) {
                $result->timestamps = false;
                $tempResult = $result->result;
                $tempResult['document_link'] = $newArray;
                $result->updateQuietly(['result' => $tempResult], ['touch' => false]);
            }
        }
    }

    /**
     * Returns true if all keys are null.
     *
     * @param mixed $tempDocumentLink
     *
     * @return bool
     */
    private function checkIfKeysAreNull(mixed $tempDocumentLink): bool
    {
        foreach ($tempDocumentLink as $value) {
            if (is_array($value)) {
                if (!$this->checkIfKeysAreNull($value)) {
                    return false;
                }
            } else {
                if (!empty($value) && !is_null($value)) {
                    return false;
                }
            }
        }

        return true;
    }
}
