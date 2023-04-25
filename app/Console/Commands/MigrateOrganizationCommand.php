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
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
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

                    $existingAidstreamOrganization = $this->organizationService->getOrganizationByPublisherId(strtolower($aidStreamOrganization->user_identifier));

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

                            $this->migrateActivityTransactions($aidstreamActivity->id, $iatiActivity->id);
                            $this->migrateActivityResults($iatiActivity, $aidstreamActivity, $iatiOrganization);
                            $this->setDefaultValues($iatiActivity, $aidStreamOrganizationSetting);
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
                    $this->clearErrors();

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
     * Updates organization document link.
     *
     * @param $aidStreamOrganizationId
     * @param $iatiOrganization
     *
     * @return void
     */
    public function updateOrganizationDocumentLinkUrl($aidStreamOrganizationId, $iatiOrganization): void
    {
        if (!empty($iatiOrganization) && !empty($aidStreamOrganizationId)) {
            $documentLink = [];
            $orgDocumentLinks = $iatiOrganization->document_link;

            if ($orgDocumentLinks && count($orgDocumentLinks)) {
                foreach ($orgDocumentLinks as $data) {
                    $data['url'] = $this->replaceDocumentLinkUrl($data['url'], $iatiOrganization->id);
                    $documentLink[] = $data;
                }
            }

            $iatiOrganization->document_link = count($documentLink) ? $documentLink : null;
            $iatiOrganization->timestamps = false;
            $iatiOrganization->saveQuietly(['touch'=>false]);
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
                    'activity_id'     => null,
                    'activities'      => $this->fillActivitiesId(
                        $aidDocument->activities,
                        $migratedActivitiesLookupTable
                    ),
                    'organization_id' => $iatiOrganization->id,
                    'filename'        => $aidDocument->filename,
                    'extension'       => getFileNameExtension($aidDocument->filename),
                    'size'            => $aidDocument->file_size,
                    'created_at'      => $aidDocument->created_at,
                    'updated_at'      => $aidDocument->updated_at,
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
    public function fillActivitiesId($aidStreamActivitiesId, $migratedActivitiesLookupTable): null|string
    {
        $aidStreamActivitiesId = !empty($aidStreamActivitiesId) ? json_decode(
            $aidStreamActivitiesId,
            true,
            512,
            JSON_THROW_ON_ERROR
        ) : null;

        $updatedActivityIds = [];

        if (!empty($aidStreamActivitiesId)) {
            if (is_string($aidStreamActivitiesId)) {
                $aidStreamActivitiesId = json_decode($aidStreamActivitiesId, true);
            }

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
                    'org_id'         => $iatiActivity->org_id,
                    'activity_id'    => $iatiActivity->id,
                    'published_data' => $aidActivitySnapshot->published_data,
                    'filename'       => $aidActivitySnapshot->filename,
                    'created_at'     => $aidActivitySnapshot->created_at,
                    'updated_at'     => $aidActivitySnapshot->updated_at,
                ];
            }
            $this->activitySnapshotService->insert($iatiActivitySnapshots);
            $this->logInfo(
                'Completed migrating activity snapshots for organization id ' . $aidstreamActivity->organization_id
            );
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
     * @param $iatiElement
     * @param $aidStreamOrganizationSetting
     * @param bool $activityLevel
     * @return void
     * @throws BindingResolutionException
     */
    private function setDefaultValues($iatiElement, $aidStreamOrganizationSetting, $activityLevel = true): void
    {
        $defaultFieldValues = $aidStreamOrganizationSetting->default_field_values;

        if ($activityLevel) {
            $defaultFieldValues = $iatiElement->default_field_values ? [$iatiElement->default_field_values]: $defaultFieldValues;
            $defaultFieldValues = json_encode($defaultFieldValues);
        }

        if ($defaultFieldValues) {
            $data = $iatiElement->toArray();
            $updatedIatiData = $this->populateDefaultFields($data, $defaultFieldValues);
            $iatiElement->timestamps = false;
            $iatiElement->updateQuietly($updatedIatiData, ['touch'=>false]);
        }
    }

    /**
     * replace aid stream url to s3 bucket url.
     *
     * @param $url
     * @param $iatiOrganizationId
     * @return null|string
     * @parram $iatiOrganizationId
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
        $iatiOrganization->timestamps = false;
        $iatiOrganization->saveQuietly(['touch'=>false]);
    }

    /**
     * Publish files to registry.
     *
     * @param $organizationPublished
     * @param $iatiOrganization
     * @param $aidStreamOrganization
     * @param $activityPublished
     * @param $setting
     *
     * @return void
     *
     * @throws Exception
     */
    public function publishFilesToRegistry(
        $organizationPublished,
        $iatiOrganization,
        $aidStreamOrganization,
        $activityPublished,
        $setting
    ): void {
        if ($organizationPublished) {
            if ($organizationPublished->published_to_registry) {
                if ($setting) {
                    if (Arr::get($setting->publishing_info, 'publisher_verification', false)) {
                        if (Arr::get($setting->publishing_info, 'token_verification', false)) {
                            $settings = $iatiOrganization->settings;
                            $publishingInfo = $settings ? $settings->publishing_info : [];
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
                            $message = "Organization file: {$organizationPublished->filename} not published because 'token_verification' is not valid.'";
                            $this->setGeneralError($message)->setDetailedError(
                                $message,
                                $aidStreamOrganization->id,
                                'organization_published',
                                $organizationPublished->id,
                            );
                            $this->logInfo($message);
                            $timestamp = Carbon::now()->format('y-m-d-H-i-s');
                            awsUploadFile("Migration/Migration-errors-{$aidStreamOrganization->id}-{$timestamp}.json", json_encode($this->errors));

                            throw new PublishException($iatiOrganization->id, $message);
                        }
                    } else {
                        $message = "Organization file: {$organizationPublished->filename} not published because 'publisher_verification' is not valid.'";
                        $this->setGeneralError($message)->setDetailedError(
                            $message,
                            $aidStreamOrganization->id,
                            'organization_published',
                            $organizationPublished->id,
                            $iatiOrganization->id
                        );
                        $this->logInfo($message);
                        $timestamp = Carbon::now()->format('y-m-d-H-i-s');
                        awsUploadFile("Migration/Migration-errors-{$aidStreamOrganization->id}-{$timestamp}.json", json_encode($this->errors));

                        throw new PublishException($iatiOrganization->id, $message);
                    }
                } else {
                    $message = "Organization file: {$organizationPublished->filename} not published because 'organization setting' is not valid.'";
                    $this->setGeneralError($message)->setDetailedError(
                        $message,
                        $aidStreamOrganization->id,
                        'settings',
                        $setting->id,
                        $iatiOrganization->id
                    );
                    $this->logInfo($message);

                    throw new PublishException($iatiOrganization->id, $message);
                }
            } else {
                $message = "Organization file: {$organizationPublished->filename} not published as 'published to registry' is false.";
                $this->setGeneralError($message)->setDetailedError(
                    $message,
                    $aidStreamOrganization->id,
                    'organization_published',
                    $organizationPublished->id,
                    $iatiOrganization->id,
                    '',
                    'Organization file > publishing'
                );
                $this->logInfo($message);
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
                            $settings = $iatiOrganization->settings;
                            $publishingInfo = $settings ? $settings->publishing_info : [];
                            $this->logInfo(
                                "Publishing activity file: {$activityPublished->filename} for Aidstream org: {$aidStreamOrganization->id}."
                            );

                            try {
                                $this->publisherService->publishFile(
                                    $publishingInfo,
                                    $activityPublished,
                                    $iatiOrganization,
                                    false
                                );
                                $this->logInfo(
                                    "Completed publishing activity file: {$activityPublished->filename} with updated at {$activityPublished->updated_at} for Aidstream org: {$aidStreamOrganization->id}."
                                );
                            } catch (Exception $exception) {
                                $message = "Activity file: {$activityPublished->filename} with updated at: {$activityPublished->updated_at} not published with error: {$exception->getMessage()}.";
                                $this->setGeneralError($message)->setDetailedError(
                                    $message,
                                    $aidStreamOrganization->id,
                                    'activity_published',
                                    $activityPublished->id,
                                    $iatiOrganization->id
                                );
                                $this->logInfo($message);

                                throw new PublishException($iatiOrganization->id, $message);
                            }
                            $this->unpublishSegmentedFiles(
                                Arr::get($setting->publishing_info, 'api_token', null),
                                $aidstreamActivityPublished,
                                $aidStreamOrganization->id,
                                $iatiOrganization->id
                            );
                        } else {
                            $message = "Activity file: {$activityPublished->filename} of Organization: {$aidStreamOrganization?->name} not published because 'token_verification' is not valid.";
                            $this->setGeneralError($message)->setDetailedError(
                                $message,
                                $aidStreamOrganization->id,
                                'activity_published',
                                $activityPublished->id,
                                $iatiOrganization->id,
                            );
                            $this->logInfo($message);

                            throw new PublishException($iatiOrganization->id, $message);
                        }
                    } else {
                        $message = "Activity file: {$activityPublished->filename} of Organization: {$aidStreamOrganization?->name} not published because 'publisher_verification' is not valid.";
                        $this->setGeneralError($message)->setDetailedError(
                            $message,
                            $aidStreamOrganization->id,
                            'activity_published',
                            $activityPublished->id,
                            $iatiOrganization->id,
                        );
                        $this->logInfo($message);

                        throw new PublishException($iatiOrganization->id, $message);
                    }
                } else {
                    $message = "Activity file: {$activityPublished->filename} of Organization : {$aidStreamOrganization?->name} not published because 'organization setting' is not valid. ";
                    $this->setGeneralError($message)->setDetailedError(
                        $message,
                        $aidStreamOrganization->id,
                        'activity_published',
                        $activityPublished->id,
                        $iatiOrganization->id,
                    );
                    $this->logInfo($message);
                    throw new PublishException($iatiOrganization->id, $message);
                }
            } else {
                $message = "Activity file: {$activityPublished->filename} of Organization: {$aidStreamOrganization?->name} not published as 'published to registry' is false.";
                $this->setGeneralError($message)->setDetailedError(
                    $message,
                    $aidStreamOrganization->id,
                    'activity_published',
                    $activityPublished->id,
                    $iatiOrganization->id,
                    '',
                    'Activity file > publishing'
                );
                $this->logInfo($message);
            }
        }
    }

    /**
     * Clears error array
     * Need to clear error array for each org.
     *
     * @return void
     */
    public function clearErrors(): void
    {
        $this->errors = [];
    }

    /**
     * Disable aidstream organization.
     *
     * @param $orgId
     *
     * @return void
     */
    public function disableAidstreamOrg($orgId): void
    {
        $this->db::connection('aidstream')->table('organizations')->where('id', $orgId)->update(['status' => 0]);
    }
}
