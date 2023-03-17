<?php

namespace App\Console\Commands;

use App\IATI\Repositories\User\RoleRepository;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\ResultService;
use App\IATI\Services\Activity\TransactionService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\Setting\SettingService;
use App\IATI\Services\User\UserService;
use App\IATI\Traits\MigrateActivityResultsTrait;
use App\IATI\Traits\MigrateActivityTrait;
use App\IATI\Traits\MigrateActivityTransactionTrait;
use App\IATI\Traits\MigrateGeneralTrait;
use App\IATI\Traits\MigrateOrganizationTrait;
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
                $this->info('Started organization migration for organization id: ' . $aidstreamOrganizationId);
                $this->databaseManager->beginTransaction();
                $aidStreamOrganization = $this->db::connection('aidstream')->table('organizations')->where(
                    'id',
                    $aidstreamOrganizationId
                )->first();

                if (!$aidStreamOrganization) {
                    $this->error('AidStream organization not found with id: ' . $aidstreamOrganizationId);
                    continue;
                }

                $iatiOrganization = $this->organizationService->create(
                    $this->getNewOrganization($aidStreamOrganization)
                );
                $this->info('Completed organization migration for organization id: ' . $aidstreamOrganizationId);
                $aidStreamOrganizationSetting = $this->db::connection('aidstream')->table('settings')->where(
                    'organization_id',
                    $aidstreamOrganizationId
                )->first();
                if ($aidStreamOrganizationSetting) {
                    $this->info('Started settings migration for organization id: ' . $aidstreamOrganizationId);
                    $this->settingService->create(
                        $this->getNewSetting($aidStreamOrganizationSetting, $iatiOrganization)
                    );

                    $defaultFieldValues = $aidStreamOrganizationSetting->default_field_values;
                    $data = $iatiOrganization->toArray();
                    $updatedData = $this->populateDefaultFields($data, $defaultFieldValues);
//                    $updatedData['status'] = $this->getPublishedStatus($aidStreamOrganization);
//                    $iatiOrganization->updateQuietly($updatedData);
                    $iatiOrganization->update($updatedData);
                    $this->info('Completed setting migration for organization id: ' . $aidstreamOrganizationId);
                }

                $aidstreamUsers = $this->db::connection('aidstream')->table('users')->where(
                    'org_id',
                    $aidstreamOrganizationId
                )->get();

                if (count($aidstreamUsers)) {
                    $mappedUsers = [];

                    foreach ($aidstreamUsers as $aidstreamUser) {
                        $this->info(
                            'Started user migration for user id: ' . $aidstreamUser->id . ' of organization: ' . $aidStreamOrganization->name
                        );
                        $iatiUser = $this->userService->create($this->getNewUser($aidstreamUser, $iatiOrganization));
                        $mappedUsers[$aidstreamOrganizationId][$aidstreamUser->id] = $iatiUser->id;
                        $this->info(
                            'Completed user migration for user id: ' . $aidstreamUser->id . ' of organization: ' . $aidStreamOrganization->name
                        );
                    }

                    $this->updateOrganizationUpdatedBy($aidstreamOrganizationId, $iatiOrganization, $mappedUsers);
                }

                $aidstreamActivities = $this->db::connection('aidstream')->table('activity_data')->where(
                    'organization_id',
                    $aidstreamOrganizationId
                )->get();

                if (count($aidstreamActivities)) {
                    foreach ($aidstreamActivities as $aidstreamActivity) {
                        $this->info(
                            'Started activity migration for activity id: ' . $aidstreamActivity->id . ' of organization: ' . $aidStreamOrganization->name
                        );
                        $iatiActivity = $this->activityService->create($this->getNewActivity($aidstreamActivity, $iatiOrganization));
                        $aidStreamActivityResult = $this->getAidStreamActivityResult($aidstreamActivity->id);

                        foreach ($aidStreamActivityResult as $index => $result) {
                            $result = $this->resultService->create(['activity_id'=>$iatiActivity->id, 'result'=>$result]);
                        }

                        $this->info(
                            'Completed basic activity migration for activity id: ' . $aidstreamActivity->id . ' of organization: ' . $aidStreamOrganization->name
                        );
                        $this->migrateActivityTransactions($aidstreamActivity->id, $iatiActivity->id);
                    }
                }

                $this->databaseManager->commit();
            }
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
            logger()->error($exception);
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
}
