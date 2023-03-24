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
use App\IATI\Services\Document\DocumentService;
use App\IATI\Services\Organization\OrganizationService;
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

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:organization';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrates organization, its users and their activities from AidStream to IATI Publisher.';

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
                $this->logInfo('Started organization migration for organization id: ' . $aidstreamOrganizationId);
                $this->databaseManager->beginTransaction();
                $aidStreamOrganization = $this->db::connection('aidstream')->table('organizations')->where(
                    'id',
                    $aidstreamOrganizationId
                )->first();

                if (!$aidStreamOrganization) {
                    $this->error('AidStream organization not found with id: ' . $aidstreamOrganizationId);
                    continue;
                }

                if ($this->organizationService->getOrganizationByPublisherId($aidStreamOrganization->user_identifier)) {
                    $this->error('Organization already exists with publisher id: ' . $aidStreamOrganization->user_identifier);
                    continue;
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
                    $this->settingService->create(
                        $this->getNewSetting($aidStreamOrganizationSetting, $iatiOrganization)
                    );

                    $this->setDefaultValues($iatiOrganization, $aidStreamOrganizationSetting);
                    $this->syncPublisherIdInSettingAndOrganizationLevel($iatiOrganization, $aidStreamOrganizationSetting);
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

                $this->db::connection('aidstream')->table('activity_data')->where(
                    'organization_id',
                    $aidstreamOrganizationId
                )->orderBy('id')->chunk(2, function ($aidstreamActivities) use ($aidStreamOrganization, $iatiOrganization) {
                    if (count($aidstreamActivities)) {
                        $migratedActivitiesLookupTable = [];

                        foreach ($aidstreamActivities as $aidstreamActivity) {
                            $this->logInfo(
                                'Started activity migration for activity id: ' . $aidstreamActivity->id . ' of organization: ' . $aidStreamOrganization->name
                            );

                            $iatiActivity = $this->activityService->create($this->getNewActivity($aidstreamActivity, $iatiOrganization));
                            $migratedActivitiesLookupTable[$aidstreamActivity->id] = $iatiActivity->id;

                            $this->logInfo(
                                'Completed basic activity migration for activity id: ' . $aidstreamActivity->id . ' of organization: ' . $aidStreamOrganization->name
                            );

                            $this->migrateActivityTransactions($aidstreamActivity->id, $iatiActivity->id);
                            $this->migrateActivityResults($iatiActivity, $aidstreamActivity);
                            $this->migrateActivitySnapshot($iatiActivity, $aidstreamActivity);
                        }

                        $this->migrateActivitiesPublishedFiles($aidStreamOrganization, $iatiOrganization, $migratedActivitiesLookupTable);
                        $this->migrateActivityPublishedTable($aidStreamOrganization, $iatiOrganization, $migratedActivitiesLookupTable);
                    }
                });

                $this->migrateDocuments($aidstreamOrganizationId, $iatiOrganization);
//                $this->migrateDocumentFiles($aidstreamOrganizationId);
                $this->migrateOrganizationPublishedFile($aidStreamOrganization, $iatiOrganization);
                $this->migrateOrganizationPublishedTable($aidStreamOrganization, $iatiOrganization);

                $this->databaseManager->commit();
            }
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
            logger()->error($exception);
            $this->error($exception->getMessage());
        }
    }

    /**
     * Migrates Aid stream document data to iati document table.
     *
     * @param $aidstreamOrganizationId
     * @param $iatiOrganization
     *
     * @return void
     * @throws \JsonException
     */
    public function migrateDocuments($aidstreamOrganizationId, $iatiOrganization): void
    {
        $aidStreamDocument = $this->db::connection('aidstream')->table('documents')
                                        ->where('org_id', $aidstreamOrganizationId)
                                        ->get();

        if (count($aidStreamDocument)) {
            $iatiDocuments = [];

            foreach ($aidStreamDocument as $aidDocument) {
                $iatiDocuments[] = [
                    'activity_id' => null,
                    'organization_id' => $iatiOrganization->id,
                    'filename' => $aidDocument->filename,
                    'extension' => getFileNameExtension($aidDocument->filename),
                    'document_link' => $this->getDocumentLink($aidDocument->url),
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
     * Returns json encoded document link format.
     *
     * @param $documentUrl
     *
     * @return string
     * @throws \JsonException
     */
    public function getDocumentLink($documentUrl): string
    {
        $documentLinkFormat = [
            'url' => !empty($documentUrl) ? $this->replaceDocumentLinkUrl($documentUrl) : '',
            'format' => '',
            'title' => [
                [
                    'narrative' => [
                        [
                            'narrative' => '',
                            'language'  => '',
                        ],
                    ],
                ],
            ],
            'description' => [
                [
                    'narrative' => [
                        [
                            'narrative' => '',
                            'language' => '',
                        ],
                    ],
                ],
            ],
            'category' => [
                [
                    'code' => '',
                ],
            ],
            'language' => [
                [
                    'code' => '',
                ],
            ],
            'document_date' => [
                [
                    'date' => '',
                ],
            ],
            'document' => [],
        ];

        return json_encode($documentLinkFormat, JSON_THROW_ON_ERROR);
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
        $iatiOrganization->update($updatedIatiData);
    }

    /**
     * replace aid stream url to s3 bucket url.
     *
     * @param $url
     *
     * @return string
     */
    public function replaceDocumentLinkUrl($url): string
    {
        $replaceText = ['http://aidstream.org', 'http://www.aidstream.org', 'https://aidstream.org', 'https://www.aidstream.org'];
        $replaceWith = env('AWS_ENDPOINT') . '/' . env('AWS_BUCKET');

        return str_replace($replaceText, $replaceWith, $url);
    }
}
