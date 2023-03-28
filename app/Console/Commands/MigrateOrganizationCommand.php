<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Elements\Xml\XmlGenerator;
use App\IATI\Repositories\User\RoleRepository;
use App\IATI\Services\Activity\ActivityPublishedService;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\ActivitySnapshotService;
use App\IATI\Services\Activity\IndicatorService;
use App\IATI\Services\Activity\PeriodService;
use App\IATI\Services\Activity\ResultService;
use App\IATI\Services\Activity\TransactionService;
use App\IATI\Services\ApiLog\ApiLogService;
use App\IATI\Services\Document\DocumentService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\OrganizationElementCompleteService;
use App\IATI\Services\Publisher\PublisherService;
use App\IATI\Services\Setting\SettingService;
use App\IATI\Services\User\UserService;
use App\IATI\Traits\MigrateActivityPublishedTrait;
use App\IATI\Traits\MigrateActivityResultsTrait;
use App\IATI\Traits\MigrateActivityTrait;
use App\IATI\Traits\MigrateActivityTransactionTrait;
use App\IATI\Traits\MigrateDocumentFileTrait;
use App\IATI\Traits\MigrateGeneralTrait;
use App\IATI\Traits\MigrateIndicatorPeriodTrait;
use App\IATI\Traits\MigrateOrganizationPublishedTrait;
use App\IATI\Traits\MigrateOrganizationTrait;
use App\IATI\Traits\MigrateResultIndicatorTrait;
use App\IATI\Traits\MigrateSettingTrait;
use App\IATI\Traits\MigrateUserTrait;
use App\IATI\Traits\TrackMigrationErrorTrait;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class MigrateUserCommand.
 */
class MigrateOrganizationCommand extends Command
{
    use MigrateActivityTrait;
    use MigrateOrganizationTrait;
    use MigrateGeneralTrait;
    use MigrateSettingTrait;
    use MigrateUserTrait;
    use MigrateActivityTransactionTrait;
    use MigrateActivityResultsTrait;
    use MigrateResultIndicatorTrait;
    use MigrateIndicatorPeriodTrait;
    use MigrateActivityPublishedTrait;
    use MigrateOrganizationPublishedTrait;
    use MigrateDocumentFileTrait;
    use TrackMigrationErrorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:organization';

    /**
     * Error array to track errors.
     *
     * @var array $errors
     */
    public array $errors = [];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrates organization, its users and their activities from AidStream to IATI Publisher.';

    /**
     * @var object|null
     */
    protected object|null $setting = null;

    /**
     * MigrateOrganizationCommand Constructor.
     *
     * @return void
     */
    public function __construct(
        protected DB $db,
        protected DatabaseManager $databaseManager,
        protected OrganizationService $organizationService,
        protected SettingService $settingService,
        protected RoleRepository $roleRepository,
        protected UserService $userService,
        protected ActivityService $activityService,
        protected TransactionService $transactionService,
        protected ResultService $resultService,
        protected IndicatorService $indicatorService,
        protected PeriodService $periodService,
        protected ActivitySnapshotService $activitySnapshotService,
        protected DocumentService $documentService,
        protected ActivityPublishedService $activityPublishedService,
        protected XmlGenerator $xmlGenerator,
        protected PublisherService $publisherService,
        protected ApiLogService $apiLogService,
        protected OrganizationElementCompleteService $organizationElementCompleteService,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function handle(): void
    {
        try {
            $aidstreamOrganizationIdString = $this->askValid(
                'Please enter the organization ids which you want to migrate separated by comma (Compulsory)',
                'aidstreamOrganizationIdString',
                ['required']
            );

            $aidstreamOrganizationIds = explode(',', $aidstreamOrganizationIdString);
            //initialize or create migration error file.

            // Convert all the values to integer.
            foreach ($aidstreamOrganizationIds as $key => $aidstreamOrganizationId) {
                $aidstreamOrganizationIds[$key] = (int) $aidstreamOrganizationId;
            }

            $organizationLookUpTable = [];

            foreach ($aidstreamOrganizationIds as $aidstreamOrganizationId) {
                $this->logInfo('Started organization migration for organization id: ' . $aidstreamOrganizationId);
                $this->databaseManager->beginTransaction();
                $aidStreamOrganization = $this->db::connection('aidstream')->table('organizations')->where(
                    'id',
                    $aidstreamOrganizationId
                )->first();

                if (!$aidStreamOrganization) {
                    $message = 'AidStream organization not found with id: ' . $aidstreamOrganizationId;
                    $this->setGeneralError($message, $aidstreamOrganizationId);
                    $this->error($message);
                    continue;
                }

                if ($this->organizationService->getOrganizationByPublisherId($aidStreamOrganization->user_identifier)) {
                    $message = 'Organization already exists with publisher id: ' . $aidStreamOrganization->user_identifier;
                    $this->setGeneralError($message, $aidstreamOrganizationId);
                    $this->error($message);
                    continue;
                }

                $iatiOrganization = $this->organizationService->create(
                    $this->getNewOrganization($aidStreamOrganization)
                );

                $organizationLookUpTable[$aidStreamOrganization->id] = $iatiOrganization;

                $this->logInfo('Completed organization migration for organization id: ' . $aidstreamOrganizationId);
                $aidStreamOrganizationSetting = $this->db::connection('aidstream')->table('settings')->where(
                    'organization_id',
                    $aidstreamOrganizationId
                )->first();

                if ($aidStreamOrganizationSetting) {
                    $this->logInfo('Started settings migration for organization id: ' . $aidstreamOrganizationId);
                    $this->setting = $this->settingService->create(
                        $this->getNewSetting($aidStreamOrganizationSetting, $iatiOrganization)
                    );

                    $this->setDefaultValues($iatiOrganization, $aidStreamOrganizationSetting);
                    $this->updateOrganizationCompleteStatus($iatiOrganization);
                    $this->syncPublisherIdInSettingAndOrganizationLevel(
                        $iatiOrganization,
                        $aidStreamOrganizationSetting,
                        $aidStreamOrganization
                    );
                    $this->logInfo('Completed setting migration for organization id: ' . $aidstreamOrganizationId);
                }

                $aidstreamUsers = $this->db::connection('aidstream')->table('users')->where(
                    'org_id',
                    $aidstreamOrganizationId
                )->get();

                if (count($aidstreamUsers)) {
                    $mappedUsers = [];

                    foreach ($aidstreamUsers as $aidstreamUser) {
                        $this->logInfo(
                            'Started user migration for user id: ' . $aidstreamUser->id . ' of organization: ' . $aidStreamOrganization->name
                        );
                        $iatiUser = $this->userService->create($this->getNewUser($aidstreamUser, $iatiOrganization));
                        $mappedUsers[$aidstreamOrganizationId][$aidstreamUser->id] = $iatiUser->id;
                        $this->logInfo(
                            'Completed user migration for user id: ' . $aidstreamUser->id . ' of organization: ' . $aidStreamOrganization->name
                        );
                    }

                    $this->updateOrganizationUpdatedBy($aidstreamOrganizationId, $iatiOrganization, $mappedUsers);
                }

                $aidstreamActivities = $this->db::connection('aidstream')->table('activity_data')->where(
                    'organization_id',
                    $aidstreamOrganizationId
                )->get();
                $migratedActivitiesLookupTable = [];

                if (count($aidstreamActivities)) {
                    foreach ($aidstreamActivities as $aidstreamActivity) {
                        $this->logInfo(
                            'Started activity migration for activity id: ' . $aidstreamActivity->id . ' of organization: ' . $aidStreamOrganization->name
                        );

                        $iatiActivity = $this->activityService->create($this->getNewActivity($aidstreamActivity, $iatiOrganization, $aidStreamOrganization));
                        $migratedActivitiesLookupTable[$aidstreamActivity->id] = $iatiActivity->id;

                        $this->logInfo(
                            'Completed basic activity migration for activity id: ' . $aidstreamActivity->id . ' of organization: ' . $aidStreamOrganization->name
                        );

                        $this->migrateActivityTransactions($aidstreamActivity->id, $iatiActivity->id);
                        $this->migrateActivityResults($iatiActivity, $aidstreamActivity, $iatiOrganization);
                        $this->migrateActivitySnapshot($iatiActivity, $aidstreamActivity);
                    }

                    $this->migrateActivitiesPublishedFiles(
                        $aidStreamOrganization,
                        $iatiOrganization,
                        $migratedActivitiesLookupTable
                    );
                    $this->migrateActivityPublishedTable(
                        $aidStreamOrganization,
                        $iatiOrganization,
                        $migratedActivitiesLookupTable
                    );
                    $this->migrateActivityMergedFile($aidStreamOrganization, $iatiOrganization, $this->setting);
                }

                $this->migrateDocumentFiles($aidStreamOrganization, $iatiOrganization);
                $this->migrateDocuments($aidstreamOrganizationId, $iatiOrganization, $migratedActivitiesLookupTable);
                $this->migrateOrganizationPublishedFile($aidStreamOrganization, $iatiOrganization);
                $this->migrateOrganizationPublishedTable($aidStreamOrganization, $iatiOrganization, $this->setting);
            }

            $this->updateOrganizationDocumentLinkUrl($organizationLookUpTable);
            $this->trackMigrationErrors($this->errors);
            $this->databaseManager->commit();
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
            logger()->channel('migration')->error($exception);
            $this->error($exception->getMessage());
        }
    }

    /**
     * Updates organization document link.
     *
     * @param $organizationLookUpTable
     *
     * @return void
     */
    public function updateOrganizationDocumentLinkUrl($organizationLookUpTable): void
    {
        foreach ($organizationLookUpTable as $orgData) {
            $documentLink = [];
            $orgDocumentLinks = $orgData->document_link;

            if ($orgDocumentLinks && count($orgDocumentLinks)) {
                foreach ($orgDocumentLinks as $data) {
                    $data['url'] = $this->replaceDocumentLinkUrl($data['url'], $orgData->id);
                    $documentLink[] = $data;
                }
            }

            $orgData->document_link = count($documentLink) ? $documentLink : null;
            $orgData->save();
        }
    }

    /**
     * Migrates Aid stream document data to iati document table.
     *
     * @param $aidstreamOrganizationId
     * @param $iatiOrganization
     * @param $migratedActivitiesLookupTable
     *
     * @return void
     * @throws \JsonException
     */
    public function migrateDocuments($aidstreamOrganizationId, $iatiOrganization, $migratedActivitiesLookupTable): void
    {
        $aidStreamDocument = $this->db::connection('aidstream')->table('documents')
                                        ->where('org_id', $aidstreamOrganizationId)
                                        ->get();

        if (count($aidStreamDocument)) {
            $iatiDocuments = [];

            foreach ($aidStreamDocument as $aidDocument) {
                $iatiDocuments[] = [
                    'activity_id' => null,
                    'activities' => $this->fillActivitiesId($aidDocument->activities, $migratedActivitiesLookupTable),
                    'organization_id' => $iatiOrganization->id,
                    'filename' => $aidDocument->filename,
                    'extension' => getFileNameExtension($aidDocument->filename),
                    'size' => $aidDocument->file_size,
                    'created_at' => $aidDocument->created_at,
                    'updated_at' => $aidDocument->updated_at,
                ];
            }

            $this->documentService->insert($iatiDocuments);
            $this->logInfo('Completed migrating documents for organization id ' . $aidstreamOrganizationId);
        }
    }

    /**
     * Map new activity id into json format.
     *
     * @param $aidStreamActivitiesId
     * @param $migratedActivitiesLookupTable
     *
     * @return string|null
     * @throws \JsonException
     */
    public function fillActivitiesId($aidStreamActivitiesId, $migratedActivitiesLookupTable) : null|string
    {
        $aidStreamActivitiesId = !empty($aidStreamActivitiesId) ? json_decode($aidStreamActivitiesId, true, 512, JSON_THROW_ON_ERROR) : null;

        $updatedActivityIds = [];

        if (!empty($aidStreamActivitiesId)) {
            foreach ($aidStreamActivitiesId as $aidActivityId => $identifier) {
                if (!isset($migratedActivitiesLookupTable[$aidActivityId])) {
                    continue;
                }

                $updatedActivityIds[] = $migratedActivitiesLookupTable[$aidActivityId];
            }
        }

        return count($updatedActivityIds) ? json_encode($updatedActivityIds, JSON_THROW_ON_ERROR) : null;
    }

    /**
     * Migrated aid stream activity snapshot to iati activity snapshot table.
     *
     * @param $iatiActivity
     * @param $aidstreamActivity
     *
     * @return void
     */
    public function migrateActivitySnapshot($iatiActivity, $aidstreamActivity): void
    {
        $aidStreamActivitySnapshots = $this->db::connection('aidstream')->table('activity_snapshots')->where(
            'activity_id',
            $aidstreamActivity->id
        )->get();

        if (count($aidStreamActivitySnapshots)) {
            $iatiActivitySnapshots = [];

            foreach ($aidStreamActivitySnapshots as $aidActivitySnapshot) {
                $iatiActivitySnapshots[] = [
                    'org_id' => $iatiActivity->org_id,
                    'activity_id' => $iatiActivity->id,
                    'published_data' => $aidActivitySnapshot->published_data,
                    'filename' => $aidActivitySnapshot->filename,
                    'created_at'  => $aidActivitySnapshot->created_at,
                    'updated_at'  => $aidActivitySnapshot->updated_at,
                ];
            }
            $this->activitySnapshotService->insert($iatiActivitySnapshots);
            $this->logInfo('Completed migrating activity snapshots for organization id ' . $aidstreamActivity->organization_id);
        }
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
     * Set default values where empty.
     *
     * @param $iatiOrganization
     * @param $aidStreamOrganizationSetting
     *
     * @return void
     */
    private function setDefaultValues($iatiOrganization, $aidStreamOrganizationSetting): void
    {
        $defaultFieldValues = $aidStreamOrganizationSetting->default_field_values;
        $data = $iatiOrganization->toArray();
        $updatedIatiData = $this->populateDefaultFields($data, $defaultFieldValues);
        $iatiOrganization->updateQuietly($updatedIatiData);
    }

    /**
     * replace aid stream url to s3 bucket url.
     *
     * @param $url
     * @parram $iatiOrganizationId
     *
     * @return null|string
     */
    public function replaceDocumentLinkUrl($url, $iatiOrganizationId): ?string
    {
        if ($url) {
            $parsedUrl = parse_url($url);

            if (isset($parsedUrl['host']) && in_array($parsedUrl['host'], ['www.aidstream.org', 'aidstream.org'])) {
                $explodedPath = explode('/', $parsedUrl['path']);
                $fileName = end($explodedPath);
                $path = '/document-link/' . $iatiOrganizationId . '/' . $fileName;
                $url = awsUrl($path);
            }

            return $url;
        }

        return null;
    }

    /**
     * Saves the organization complete status.
     *
     * @param $iatiOrganization
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function updateOrganizationCompleteStatus($iatiOrganization): void
    {
        $this->setElementStatus($iatiOrganization);
        $iatiOrganization->saveQuietly();
    }
}
