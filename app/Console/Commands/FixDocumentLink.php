<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Models\Activity\Activity;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Traits\MigrateActivityTrait;
use App\IATI\Traits\MigrateGeneralTrait;
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
    use MigrateGeneralTrait;

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
     * Constructor.
     *
     * @param DB $db
     * @param DatabaseManager $databaseManager
     * @param OrganizationService $organizationService
     * @param ActivityService $activityService
     */
    public function __construct(
        protected DB $db,
        protected DatabaseManager $databaseManager,
        protected OrganizationService $organizationService,
        protected ActivityService $activityService
    ) {
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

            $iatiOrganizations = $this->organizationService->getOrganizationByPublisherIds($aidstreamOrganizationIdentifierArray);
            $iatiOrganizationIdArray = $iatiOrganizations->pluck('id', 'publisher_id');

            $idMap = $this->mapOrganizationIds($aidstreamOrganizationIdentifierArray, $iatiOrganizationIdArray);
            $activities = $this->activityService->getActivitiesByOrgIds($idMap);

            foreach ($activities as $activity) {
                $this->fixActivityResultDocumentLink($activity);
            }

            $this->databaseManager->commit();
            $this->info("Completed fixing {$this->brokenCount} result document link");
        } catch(Exception $e) {
            logger()->error($e);
            $this->logInfo($e->getMessage());
            $this->databaseManager->rollBack();
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
}
