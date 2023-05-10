<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Exceptions\PublishException;
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
use App\IATI\Services\Audit\AuditService;
use App\IATI\Services\Document\DocumentService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\OrganizationElementCompleteService;
use App\IATI\Services\Publisher\PublisherService;
use App\IATI\Services\Setting\SettingService;
use App\IATI\Services\User\UserService;
use App\IATI\Traits\LogFunctionTrait;
use App\IATI\Traits\MigrateActivityPublishedTrait;
use App\IATI\Traits\MigrateActivityResultsTrait;
use App\IATI\Traits\MigrateActivityTrait;
use App\IATI\Traits\MigrateActivityTransactionTrait;
use App\IATI\Traits\MigrateDocumentFileTrait;
use App\IATI\Traits\MigrateGeneralTrait;
use App\IATI\Traits\MigrateIndicatorPeriodTrait;
use App\IATI\Traits\MigrateOrganizationPublishedTrait;
use App\IATI\Traits\MigrateOrganizationTrait;
use App\IATI\Traits\MigrateProUserTrait;
use App\IATI\Traits\MigrateResultIndicatorTrait;
use App\IATI\Traits\MigrateSettingTrait;
use App\IATI\Traits\MigrateUserTrait;
use App\IATI\Traits\TrackMigrationErrorTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Arr;
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
    use MigrateProUserTrait;
    use LogFunctionTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:organization';

    /**
     * Error array to track errors.
     *
     * @var array
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
     * @var string|object
     */
    public string|object $currentAidstreamOrganizationBeingProcessed = '';

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
        protected AuditService $auditService
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

            // Convert all the values to integer.
            foreach ($aidstreamOrganizationIds as $key => $aidstreamOrganizationId) {
                $aidstreamOrganizationIds[$key] = (int) $aidstreamOrganizationId;
            }

            foreach ($aidstreamOrganizationIds as $aidstreamOrganizationId) {
                try {
                    $this->resetCustomVocabTracking('organization');

                    $this->logInfo('Started organization migration for organization id: ' . $aidstreamOrganizationId);
                    $this->databaseManager->beginTransaction();
                    $aidStreamOrganization = $this->db::connection('aidstream')->table('organizations')->where(
                        'id',
                        $aidstreamOrganizationId
                    )->first();

                    if (!$aidStreamOrganization) {
                        $message = 'AidStream organization not found with id: ' . $aidstreamOrganizationId;
                        $this->setGeneralError($message)->setDetailedError(
                            $message,
                            $aidstreamOrganizationId,
                            'organization_data',
                            $aidstreamOrganizationId
                        );
                        $this->error($message);
                        $timestamp = Carbon::now()->format('y-m-d-H-i-s');
                        awsUploadFile("Migration/Migration-errors-{$aidstreamOrganizationId}-{$timestamp}.json", json_encode($this->errors));
                        $this->clearErrors();
                        throw new \RuntimeException(
                            $message
                        );
                    }

                    $aidStreamOrganizationSetting = $this->db::connection('aidstream')->table('settings')->where(
                        'organization_id',
                        $aidstreamOrganizationId
                    )->first();

                    $aidstreamPublisherId = $aidStreamOrganization->user_identifier;

                    if ($aidStreamOrganizationSetting) {
                        $aidstreamPublisherId = $this->getSettingsPublisherId(
                            $aidStreamOrganizationSetting,
                            $aidStreamOrganization->user_identifier
                        );
                    }

                    $existingAidstreamOrganization = $this->organizationService->getOrganizationByPublisherId(strtolower($aidstreamPublisherId));

                    if ($existingAidstreamOrganization) {
                        $message = "Organization with publisher name {$existingAidstreamOrganization->publisher_name} already exists.";
                        $this->setGeneralError($message)->setDetailedError(
                            $message,
                            $aidstreamOrganizationId,
                            'organization_data',
                            $aidstreamOrganizationId
                        );
                        $timestamp = Carbon::now()->format('y-m-d-H-i-s');
                        awsUploadFile("Migration/Migration-errors-{$aidstreamOrganizationId}-{$timestamp}.json", json_encode($this->errors));
                        $this->clearErrors();
                        throw new \RuntimeException(
                            $message
                        );
                    }

                    $iatiOrganization = $this->organizationService->create(
                        $this->getNewOrganization($aidStreamOrganization)
                    );

                    $this->migrateCustomVocabularyCsvFileToS3($aidStreamOrganization);

                    $this->logInfo('Completed organization migration for organization id: ' . $aidstreamOrganizationId);

                    $this->setting = null;

                    if ($aidStreamOrganizationSetting) {
                        $this->logInfo('Started settings migration for organization id: ' . $aidstreamOrganizationId);
                        $this->setting = $this->settingService->create(
                            $this->getNewSetting($aidStreamOrganizationSetting, $iatiOrganization)
                        );

                        $this->setDefaultValues($iatiOrganization, $aidStreamOrganizationSetting, false);
                        $this->updateOrganizationCompleteStatus($iatiOrganization);
                        $this->syncPublisherIdInSettingAndOrganizationLevel(
                            $iatiOrganization,
                            $aidStreamOrganizationSetting,
                            $aidStreamOrganization
                        );
                        $this->auditService->setAuditableId($this->setting->id)->auditMigrationEvent($this->setting, 'migrated-settings');

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
                            $iatiUser = $this->userService->create(
                                $this->getNewUser($aidstreamUser, $iatiOrganization)
                            );
                            $this->auditService->setAuditableId($iatiUser->id)->auditMigrationEvent($iatiUser, 'migrated-user');
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
                    $activityPublished = null;

                    if (count($aidstreamActivities)) {
                        foreach ($aidstreamActivities as $aidstreamActivity) {
                            $this->logInfo(
                                'Started activity migration for activity id: ' . $aidstreamActivity->id . ' of organization: ' . $aidStreamOrganization->name
                            );

                            $iatiActivity = $this->activityService->create($this->getNewActivity($aidstreamActivity, $iatiOrganization, $aidStreamOrganization));
                            $this->auditService->setAuditableId($iatiActivity->id)->auditMigrationEvent($iatiActivity, 'migrated-activity');
                            $migratedActivitiesLookupTable[$aidstreamActivity->id] = $iatiActivity->id;

                            $this->logInfo(
                                'Completed basic activity migration for activity id: ' . $aidstreamActivity->id . ' of organization: ' . $aidStreamOrganization->name
                            );

                            $this->setDefaultValues($iatiActivity, $aidStreamOrganizationSetting);
                            $this->migrateActivityTransactions($aidstreamActivity, $iatiActivity);
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
                        $activityPublished = $this->migrateActivityMergedFile(
                            $aidStreamOrganization,
                            $iatiOrganization,
                        );
                    }

                    $this->migrateDocumentFiles($aidStreamOrganization, $iatiOrganization);
                    $this->migrateDocuments(
                        $aidstreamOrganizationId,
                        $iatiOrganization,
                        $migratedActivitiesLookupTable
                    );
                    $this->migrateOrganizationPublishedFile($aidStreamOrganization, $iatiOrganization);
                    $organizationPublished = $this->migrateOrganizationPublishedTable(
                        $aidStreamOrganization,
                        $iatiOrganization
                    );
                    $this->updateOrganizationDocumentLinkUrl($aidStreamOrganization->id, $iatiOrganization);

                    $this->publishFilesToRegistry(
                        $organizationPublished,
                        $iatiOrganization,
                        $aidStreamOrganization,
                        $activityPublished,
                        $this->setting
                    );

                    $this->disableAidstreamOrg($aidstreamOrganizationId);
                    $this->auditService->setAuditableId($iatiOrganization->id)->auditMigrationEvent($iatiOrganization, 'migrated-organization');

                    $this->databaseManager->commit();

                    if (!$this->checkIfKeysAreNull($this->customVocabCurrentlyUsedByOrganization)) {
                        $this->checkForCustomVocabularyMismatchInFile($this->customVocabCurrentlyUsedByOrganization);
                    }

                    if ($this->hasErrors()) {
                        $timestamp = Carbon::now()->format('y-m-d-H-i-s');
                        awsUploadFile("Migration/Migration-errors-{$aidstreamOrganizationId}-{$timestamp}.json", json_encode($this->errors));
                    }

                    $this->clearErrors();
                } catch (PublishException $publishException) {
                    logger()->channel('migration')->error($publishException->getMessage());
                    $this->error($publishException->getMessage());

                    $iatiOrganization = $this->organizationService->getOrganizationData($publishException->getIatiOrganizationId());
                    $iatiOrganization->updateQuietly([
                        'org_status' => 'disabled',
                    ]);
                    $iatiOrganization->users()->update([
                        'status' => false,
                    ]);
                    $this->databaseManager->commit();
                    continue;
                } catch (Exception $exception) {
                    $this->databaseManager->rollBack();
                    logger()->channel('migration')->error($exception);
                    $this->error($exception->getMessage());
                    continue;
                }
            }
        } catch (Exception $exception) {
            logger()->channel('migration')->error($exception);
            $this->error($exception->getMessage());
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
     * Publish files to registry.
     *
     * @param $organizationPublished
     * @param $iatiOrganization
     * @param $aidStreamOrganization
     * @param $activityPublished
     * @param $setting
     * @param bool  $publishOrganization
     *
     * @return void
     *
     * @throws PublishException
     */
    public function publishFilesToRegistry(
        $organizationPublished,
        $iatiOrganization,
        $aidStreamOrganization,
        $activityPublished,
        $setting,
        bool $publishOrganization = true
    ): void {
        if ($organizationPublished && $publishOrganization) {
            if ($organizationPublished->published_to_registry) {
                if ($setting) {
                    if (Arr::get($setting->publishing_info, 'publisher_verification', false)) {
                        if (Arr::get($setting->publishing_info, 'token_verification', false)) {
                            $settings = $iatiOrganization->settings;
                            $publishingInfo = $settings ? $settings->publishing_info : [];

                            $this->logInfo('Searching to un-publish AidStream organization file.');
                            $aidstreamOrganizationPublished = $this->db::connection('aidstream')->table('organization_published')->where(
                                'organization_id',
                                $aidStreamOrganization->id
                            )->first();

                            if ($aidstreamOrganizationPublished) {
                                $this->logInfo("Starting to un-publish AidStream organization file {$aidstreamOrganizationPublished->filename}.");

                                try {
                                    $this->publisherService->unPublishOrganizationFile(
                                        $publishingInfo,
                                        $aidstreamOrganizationPublished,
                                        false
                                    );

                                    $this->logInfo('AidStream organization file un-published.');
                                } catch (Exception $exception) {
                                    $message = "Organization file: {$aidstreamOrganizationPublished->filename} not published with error: {$exception->getMessage()}.";
                                    $this->setGeneralError($message)->setDetailedError(
                                        $message,
                                        $aidStreamOrganization->id,
                                        'organization_published',
                                        $organizationPublished->id,
                                    );
                                    $this->logInfo($message);

                                    throw new PublishException($iatiOrganization->id, $message);
                                }
                            } else {
                                $this->logInfo('No AidStream organization published data to un-publish.');
                            }

                            $this->logInfo("Publishing organization file: {$organizationPublished->filename}.");

                            try {
                                $this->publisherService->publishOrganizationFile(
                                    $publishingInfo,
                                    $organizationPublished,
                                    $iatiOrganization,
                                    false
                                );
                                $this->logInfo(
                                    "Organization file: {$organizationPublished->filename} with updated at: {$organizationPublished->updated_at} published."
                                );
                            } catch (Exception $exception) {
                                $message = "Organization file: {$organizationPublished->filename} with updated at: {$organizationPublished->updated_at} not published with error: {$exception->getMessage()}.";
                                $this->setGeneralError($message)->setDetailedError(
                                    $message,
                                    $aidStreamOrganization->id,
                                    'organization_published',
                                    $organizationPublished->id,
                                );
                                $this->logInfo($message);

                                throw new PublishException($iatiOrganization->id, $message);
                            }
                        } else {
                            $this->logOrganizationNotPublishedBecauseTokenVerification($aidStreamOrganization, $iatiOrganization, $organizationPublished);
                        }
                    } else {
                        $this->logOrganizationNotPublishedBecausePublisherVerification($aidStreamOrganization, $iatiOrganization, $organizationPublished);
                    }
                } else {
                    $this->logOrganizationNotPublishedBecauseOrganizationSettingIsNotValid($aidStreamOrganization, $iatiOrganization, $organizationPublished, $setting);
                }
            } else {
                $this->logOrganizationNotPublishedBecausePublishedToRegistryIsFalse($aidStreamOrganization, $iatiOrganization, $organizationPublished);
            }
        }

        if ($activityPublished) {
            $aidstreamActivityPublished = $this->db::connection('aidstream')->table('activity_published')
                ->where('organization_id', $aidStreamOrganization->id)->where(
                    'published_to_register',
                    1
                )->get();

            //Publish activity to registry if needed.
            if ($activityPublished->published_to_registry) {
                if ($setting) {
                    if (Arr::get($setting->publishing_info, 'publisher_verification', false)) {
                        if (Arr::get($setting->publishing_info, 'token_verification', false)) {
                            $this->tryPublishingActivityFile($aidStreamOrganization, $iatiOrganization, $activityPublished);
                            $this->unpublishSegmentedFiles(
                                Arr::get($setting->publishing_info, 'api_token', null),
                                $aidstreamActivityPublished,
                                $aidStreamOrganization->id,
                                $iatiOrganization->id
                            );
                        } else {
                            $this->logActivityNotPublishedBecauseOfTokenVerification($aidStreamOrganization, $iatiOrganization, $activityPublished);
                        }
                    } else {
                        $this->logActivityNotPublishedBecauseOfPublisherVerification($aidStreamOrganization, $iatiOrganization, $activityPublished);
                    }
                } else {
                    $this->logActivityNotPublishedBecauseOrganizationSettingNotValid($aidStreamOrganization, $iatiOrganization, $activityPublished);
                }
            } else {
                $this->logActivityNotPublishedBecausePublishedToRegistryIsFalse($aidStreamOrganization, $iatiOrganization, $activityPublished);
            }
        }
    }

    /**
     * Checks if errors are set.
     *
     * @return bool
     */
    protected function hasErrors(): bool
    {
        return !$this->checkIfKeysAreNull($this->errors);
    }
}
