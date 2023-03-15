<?php

namespace App\Console\Commands;

use App\IATI\Repositories\User\RoleRepository;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\Setting\SettingService;
use App\IATI\Services\User\UserService;
use App\IATI\Traits\MigrateOrganizationActivityTrait;
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
    use MigrateOrganizationActivityTrait;

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
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
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
                        $iatiActivity = $this->getNewActivity($aidstreamActivity, $iatiOrganization);
                        $this->info(
                            'Completed activity migration for activity id: ' . $aidstreamActivity->id . ' of organization: ' . $aidStreamOrganization->name
                        );
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

    /**
     * Returns required data for creating new IATI organization.
     *
     * @param $aidstreamOrganization
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getNewOrganization($aidstreamOrganization): array
    {
        $newOrganization = [];
        $newOrganization['publisher_id'] = $aidstreamOrganization->user_identifier;
        $newOrganization['publisher_name'] = $aidstreamOrganization->name;
        $newOrganization['publisher_type'] = $this->getReportingOrgData(
            $aidstreamOrganization->reporting_org,
            'reporting_organization_type'
        ) ? (int) $this->getReportingOrgData(
            $aidstreamOrganization->reporting_org,
            'reporting_organization_type'
        ) : null;
        $newOrganization['identifier'] = $this->getReportingOrgData(
            $aidstreamOrganization->reporting_org,
            'reporting_organization_identifier'
        );
        $newOrganization['address'] = $aidstreamOrganization->address;
        $newOrganization['telephone'] = $aidstreamOrganization->telephone;
        $newOrganization['reporting_org'] = $this->getColumnValueArray(
            $aidstreamOrganization,
            'reporting_org'
        );

        $aidstreamOrganizationData = $this->db::connection('aidstream')->table('organization_data')->where(
            'organization_id',
            $aidstreamOrganization->id
        )->where('is_reporting_org', true)->first();

        $newOrganization['total_budget'] = $aidstreamOrganizationData ? $this->getOrganizationBudget(
            $aidstreamOrganizationData->total_budget,
            'total_budget_status',
            'budget_line'
        ) : null;
        $newOrganization['recipient_org_budget'] = $aidstreamOrganizationData ? $this->getOrganizationBudget(
            $aidstreamOrganizationData->recipient_organization_budget,
            'recipient_org',
            'budget_line'
        ) : null;
        $newOrganization['default_field_values'] = null;
        $newOrganization['recipient_region_budget'] = $aidstreamOrganizationData ? $this->getOrganizationRecipientRegionBudget(
            $aidstreamOrganizationData->recipient_region_budget,
        ) : null;
        $newOrganization['recipient_country_budget'] = $aidstreamOrganizationData ? $this->getOrganizationBudget(
            $aidstreamOrganizationData->recipient_country_budget,
            'recipient_country',
            'budget_line'
        ) : null;
        $newOrganization['document_link'] = $this->getColumnValueArray(
            $aidstreamOrganizationData,
            'document_link'
        );
        $newOrganization['total_expenditure'] = $aidstreamOrganizationData ? $this->getOrganizationBudget(
            $aidstreamOrganizationData->total_expenditure,
            'total_expenditure',
            'expense_line'
        ) : null;
        $newOrganization['name'] = $this->getColumnValueArray(
            $aidstreamOrganizationData,
            'name'
        );
        $newOrganization['country'] = $aidstreamOrganization->country;
        $newOrganization['logo_url'] = $aidstreamOrganization->logo_url;
        $newOrganization['organization_url'] = $aidstreamOrganization->organization_url;
        $newOrganization['status'] = $aidstreamOrganizationData ? ($aidstreamOrganizationData->status === 3 ? 'published' : 'draft') : 'draft';
        $newOrganization['iati_status'] = 'pending';
        $newOrganization['is_published'] = $aidstreamOrganizationData && ($aidstreamOrganizationData->status === 3);
        $newOrganization['registration_agency'] = $aidstreamOrganization->registration_agency;
        $newOrganization['registration_number'] = $aidstreamOrganization->registration_number;
        $newOrganization['element_status'] = null; // Will be updated by observer
        $newOrganization['created_at'] = $aidstreamOrganization->created_at;
        $newOrganization['updated_at'] = $aidstreamOrganization->updated_at;
        $newOrganization['org_status'] = 'active';
        $newOrganization['updated_by'] = null; // Updated after migrating users
        $newOrganization['migrated_from_aidstream'] = true;

        return $newOrganization;
    }

    /**
     * Returns required budget data for IATI organization.
     *
     * @param $orgBudget
     * @param $firstKey
     * @param $secondKey
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getOrganizationBudget($orgBudget, $firstKey, $secondKey): ?array
    {
        if (!$orgBudget) {
            return null;
        }

        $newOrgBudget = [];
        $orgBudgetArray = json_decode($orgBudget, true, 512, JSON_THROW_ON_ERROR);

        if ($orgBudgetArray && count($orgBudgetArray)) {
            foreach (array_values($orgBudgetArray) as $key => $array) {
                $newOrgBudget[$key] = match ($firstKey) {
                    'total_budget_status' => [
                        'total_budget_status' => Arr::get($array, 'status', null),
                        'period_start'        => Arr::get($array, 'period_start', null),
                        'period_end'          => Arr::get($array, 'period_end', null),
                        'value'               => Arr::get($array, 'value', null),
                    ],
                    'recipient_org' => [
                        'status'        => Arr::get($array, 'status', null),
                        'recipient_org' => Arr::get($array, 'recipient_organization', null),
                        'period_start'  => Arr::get($array, 'period_start', null),
                        'period_end'    => Arr::get($array, 'period_end', null),
                        'value'         => Arr::get($array, 'value', null),
                    ],
                    'recipient_country' => [
                        'recipient_country' => Arr::get($array, 'recipient_country', null),
                        'period_start'      => Arr::get($array, 'period_start', null),
                        'period_end'        => Arr::get($array, 'period_end', null),
                        'value'             => Arr::get($array, 'value', null),
                    ],
                    default => [
                        'period_start' => Arr::get($array, 'period_start', null),
                        'period_end'   => Arr::get($array, 'period_end', null),
                        'value'        => Arr::get($array, 'value', null),
                    ],
                };

                foreach (array_values(Arr::get($array, $secondKey, [])) as $innerKey => $innerArray) {
                    $newOrgBudget[$key][$secondKey][$innerKey] = [
                        'ref'       => Arr::get($innerArray, 'reference', null),
                        'value'     => Arr::get($innerArray, 'value', null),
                        'narrative' => Arr::get($innerArray, 'narrative', null),
                    ];
                }
            }
        }

        return count($newOrgBudget) ? $newOrgBudget : null;
    }

    /**
     * Returns required recipient region budget for IATI organization.
     *
     * @param $recipientRegionBudget
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getOrganizationRecipientRegionBudget($recipientRegionBudget): ?array
    {
        if (!$recipientRegionBudget) {
            return null;
        }

        $newRecipientRegionBudget = [];
        $recipientRegionBudgetArray = json_decode($recipientRegionBudget, true, 512, JSON_THROW_ON_ERROR);

        if ($recipientRegionBudgetArray && count($recipientRegionBudgetArray)) {
            foreach (array_values($recipientRegionBudgetArray) as $key => $array) {
                $newRecipientRegionBudget[$key] = [
                    'status'           => Arr::get($array, 'status', null),
                    'recipient_region' => $this->getOrganizationRecipientRegionData(
                        Arr::get($array, 'recipient_region', [])
                    ),
                    'period_start'     => Arr::get($array, 'period_start', null),
                    'period_end'       => Arr::get($array, 'period_end', null),
                    'value'            => Arr::get($array, 'value', null),
                ];

                foreach (array_values(Arr::get($array, 'budget_line', [])) as $innerKey => $innerArray) {
                    $newRecipientRegionBudget[$key]['budget_line'][$innerKey] = [
                        'ref'       => Arr::get($innerArray, 'reference', null),
                        'value'     => Arr::get($innerArray, 'value', null),
                        'narrative' => Arr::get($innerArray, 'narrative', null),
                    ];
                }
            }
        }

        return count($newRecipientRegionBudget) ? $newRecipientRegionBudget : null;
    }

    /**
     * Returns required recipient region data for IATI organization.
     *
     * @param $recipientRegions
     *
     * @return array
     */
    public function getOrganizationRecipientRegionData($recipientRegions): array
    {
        $array = [];

        foreach (array_values($recipientRegions) as $key => $recipientRegion) {
            $array[$key]['region_vocabulary'] = Arr::get($recipientRegion, 'vocabulary', null);

            if (Arr::get($recipientRegion, 'vocabulary', null) === '1') {
                $array[$key]['region_code'] = Arr::get($recipientRegion, 'code', null);
            } else {
                $array[$key]['code'] = Arr::get($recipientRegion, 'code', null);

                if (Arr::get($recipientRegion, 'vocabulary', null) === '99') {
                    $array[$key]['vocabulary_uri'] = Arr::get($recipientRegion, 'vocabulary_uri', null);
                }
            }
        }

        return $array;
    }

    /**
     * Returns reporting org data.
     *
     * @param $reportingOrg
     * @param $key
     *
     * @return string|null
     *
     * @throws \JsonException
     */
    public function getReportingOrgData($reportingOrg, $key): ?string
    {
        if (!$reportingOrg) {
            return null;
        }

        $reportingOrg = json_decode($reportingOrg, true, 512, JSON_THROW_ON_ERROR);

        if (!$reportingOrg) {
            return null;
        }

        return Arr::get($reportingOrg, '0.' . $key, null);
    }

    /**
     * Returns column value in array format.
     *
     * @param $object
     * @param $column
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getColumnValueArray($object, $column): ?array
    {
        if (!$object || !$object->{$column}) {
            return null;
        }

        return json_decode($object->{$column}, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Returns setting data for IATI organization.
     *
     * @param $aidstreamOrganizationSetting
     * @param $iatiOrganization
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getNewSetting($aidstreamOrganizationSetting, $iatiOrganization): array
    {
        return [
            'organization_id'         => $iatiOrganization->id,
            'publishing_info'         => $this->getPublishingInfo(
                $aidstreamOrganizationSetting->registry_info,
                $iatiOrganization->publisher_id
            ),
            'default_values'          => $this->getDefaultValues($aidstreamOrganizationSetting->default_field_values),
            'activity_default_values' => $this->getActivityDefaultValues(
                $aidstreamOrganizationSetting->default_field_values
            ),
            'created_at'              => $aidstreamOrganizationSetting->created_at,
            'updated_at'              => $aidstreamOrganizationSetting->updated_at,
        ];
    }

    /**
     * Returns publishing info information for IATI organization setting.
     *
     * @param $registryInfo
     * @param $iatiPublisherId
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getPublishingInfo($registryInfo, $iatiPublisherId): ?array
    {
        if (!$registryInfo) {
            return null;
        }

        $registryInfoArray = json_decode($registryInfo, true, 512, JSON_THROW_ON_ERROR);

        if (!$registryInfoArray) {
            return null;
        }

        return [
            'publisher_id'           => !empty(Arr::get($registryInfoArray, '0.publisher_id', null)) ? Arr::get(
                $registryInfoArray,
                '0.publisher_id',
                null
            ) : $iatiPublisherId,
            'api_token'              => Arr::get($registryInfoArray, '0.api_id', null),
            'publisher_verification' => Arr::get($registryInfoArray, '0.publisher_id_status', null) === 'Correct',
            'token_verification'     => Arr::get($registryInfoArray, '0.api_id_status', null) === 'Correct',
        ];
    }

    /**
     * Returns default values for IATI Organization settings.
     *
     * @param $aidstreamDefaultValues
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getDefaultValues($aidstreamDefaultValues): ?array
    {
        if (!$aidstreamDefaultValues) {
            return null;
        }

        $aidstreamDefaultValuesArray = json_decode($aidstreamDefaultValues, true, 512, JSON_THROW_ON_ERROR);

        if (!$aidstreamDefaultValuesArray) {
            return null;
        }

        return [
            'default_currency' => Arr::get($aidstreamDefaultValuesArray, '0.default_currency', null),
            'default_language' => Arr::get($aidstreamDefaultValuesArray, '0.default_language', null),
        ];
    }

    /**
     * Returns activity default values for IATI Organization settings.
     *
     * @param $aidstreamDefaultValues
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityDefaultValues($aidstreamDefaultValues): ?array
    {
        if (!$aidstreamDefaultValues) {
            return null;
        }

        $aidstreamDefaultValuesArray = json_decode($aidstreamDefaultValues, true, 512, JSON_THROW_ON_ERROR);

        if (!$aidstreamDefaultValuesArray) {
            return null;
        }

        return [
            'hierarchy'           => !is_null(
                Arr::get($aidstreamDefaultValuesArray, '0.default_hierarchy', null)
            ) ? Arr::get(
                $aidstreamDefaultValuesArray,
                '0.default_hierarchy',
                null
            ) : '1',
            'humanitarian'        => !is_null(
                Arr::get($aidstreamDefaultValuesArray, '0.humanitarian', null)
            ) ? Arr::get(
                $aidstreamDefaultValuesArray,
                '0.humanitarian',
                null
            ) : '1',
            'budget_not_provided' => '',
        ];
    }

    /**
     * Returns new IATI user data.
     *
     * @param $aidstreamUser
     * @param $iatiOrganization
     *
     * @return array
     */
    public function getNewUser($aidstreamUser, $iatiOrganization): array
    {
        return [
            'username'                => $aidstreamUser->username,
            'full_name'               => sprintf('%s %s', $aidstreamUser->first_name, $aidstreamUser->last_name),
            'email'                   => $aidstreamUser->email,
            'address'                 => $iatiOrganization->address,
            'organization_id'         => $iatiOrganization->id,
            'is_active'               => true,
            'email_verified_at'       => $aidstreamUser->verification_created_at,
            'password'                => $aidstreamUser->password,
            'remember_token'          => null,
            'created_at'              => $aidstreamUser->created_at,
            'updated_at'              => $aidstreamUser->updated_at,
            'role_id'                 => $this->getRoleId($aidstreamUser->role_id),
            'status'                  => true,
            'registration_method'     => $aidstreamUser->role_id === 1 ? 'existing_org' : 'user_create',
            'language_preference'     => 'en',
            'created_by'              => null,
            'updated_by'              => null,
            'deleted_at'              => null,
            'migrated_from_aidstream' => true,
        ];
    }

    /**
     * Returns role id for IATI user.
     *
     * @param $roleId
     *
     * @return int
     */
    public function getRoleId($roleId): int
    {
        if ($roleId === 1 || $roleId === 5) {
            return $this->roleRepository->getOrganizationAdminId();
        }

        return $this->roleRepository->getGeneralUserId();
    }

    /**
     * Updates organization updated by.
     *
     * @param $aidstreamOrganizationId
     * @param $iatiOrganization
     * @param $mappedUsers
     *
     * @return void
     */
    public function updateOrganizationUpdatedBy($aidstreamOrganizationId, $iatiOrganization, $mappedUsers): void
    {
        $orgUpdated = $this->db::connection('aidstream')->table('user_activities')
                               ->where('organization_id', $aidstreamOrganizationId)
                               ->where('action', 'LIKE', 'organization%')
                               ->orderBy('updated_at', 'desc')
                               ->first();

        if ($orgUpdated) {
            if (array_key_exists($orgUpdated->user_id, $mappedUsers[$aidstreamOrganizationId])) {
                $iatiOrganization->updated_by = $mappedUsers[$aidstreamOrganizationId][$orgUpdated->user_id];
            } else {
                $adminUser = $this->db::connection('aidstream')->table('users')
                                      ->where('role_id', 1)
                                      ->where('org_id', $aidstreamOrganizationId)
                                      ->first();

                $iatiOrganization->updated_by = $mappedUsers[$aidstreamOrganizationId][$adminUser->id];
            }

            $iatiOrganization->save();
        }
    }

    /**
     * Returns IATI activity data.
     *
     * @param $aidstreamActivity
     * @param $iatiOrganization
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getNewActivity($aidstreamActivity, $iatiOrganization)
    {
        $newActivity = [];
        $newActivity['iati_identifier'] = $aidstreamActivity->identifier ? [
            'activity_identifier' => Arr::get(
                json_decode($aidstreamActivity->identifier, true, 512, JSON_THROW_ON_ERROR),
                'activity_identifier',
                null
            ),
        ] : null;
        $newActivity['other_identifier'] = $aidstreamActivity ? $this->getActivityOtherIdentifier(
            $aidstreamActivity->other_identifier
        ) : null;
        $newActivity['title'] = $this->getColumnValueArray($aidstreamActivity, 'title');
        $newActivity['description'] = $this->getColumnValueArray($aidstreamActivity, 'description');
        $newActivity['activity_status'] = $aidstreamActivity ? $this->getIntSelectValue(
            $aidstreamActivity->activity_status,
            'ActivityStatus',
            'Activity'
        ) : null;
        $newActivity['status'] = ($aidstreamActivity && $aidstreamActivity->activity_workflow === 3 && $aidstreamActivity->published_to_registry === 1) ? 'published' : 'draft';
        $newActivity['activity_date'] = $this->getColumnValueArray($aidstreamActivity, 'activity_date');
        $newActivity['contact_info'] = $aidstreamActivity ? $this->getActivityFirstLevelData(
            $aidstreamActivity->contact_info,
            $this->contactInfoReplaceArray
        ) : null;
        $newActivity['activity_scope'] = $aidstreamActivity ? $this->getIntSelectValue(
            $aidstreamActivity->activity_scope,
            'ActivityScope',
            'Activity'
        ) : null;
        $newActivity['participating_organization'] = $aidstreamActivity ? $this->getActivityFirstLevelData(
            $aidstreamActivity->participating_organization,
            $this->participatingOrgReplaceArray,
            $this->participatingOrgRemoveArray
        ) : null;
        $newActivity['recipient_country'] = $this->getColumnValueArray($aidstreamActivity, 'recipient_country');
        $newActivity['recipient_region'] = $aidstreamActivity ? $this->getActivityUpdatedVocabularyData(
            $aidstreamActivity->recipient_region,
            'region_vocabulary',
            $this->recipientRegionReplaceArray,
            $this->recipientRegionRemoveArray
        ) : null;
        $newActivity['location'] = $aidstreamActivity ? $this->getActivityLocationData(
            $aidstreamActivity->location
        ) : null;
        $newActivity['sector'] = $aidstreamActivity ? $this->getActivityUpdatedVocabularyData(
            $aidstreamActivity->sector,
            'sector_vocabulary',
            $this->sectorReplaceArray,
            $this->sectorRemoveArray
        ) : null;
        $newActivity['country_budget_items'] = $aidstreamActivity ? $this->getActivityCountryBudgetItemsData(
            $aidstreamActivity->country_budget_items
        ) : null;
        $newActivity['humanitarian_scope'] = $aidstreamActivity ? $this->getActivityUpdatedVocabularyData(
            $aidstreamActivity->humanitarian_scope,
            'vocabulary',
            [],
            $this->humanitarianScopeRemoveArray
        ) : null;
    }

    /**
     * Returns activity other identifier data.
     *
     * @param $aidstreamOtherIdentifiers
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityOtherIdentifier($aidstreamOtherIdentifiers): ?array
    {
        if (!$aidstreamOtherIdentifiers) {
            return null;
        }

        $newOtherIdentifiers = [];
        $otherIdentifiersArray = json_decode($aidstreamOtherIdentifiers, true, 512, JSON_THROW_ON_ERROR);

        if ($otherIdentifiersArray && count($otherIdentifiersArray)) {
            foreach (array_values($otherIdentifiersArray) as $key => $otherIdentifier) {
                $newOtherIdentifiers[$key]['reference'] = Arr::get($otherIdentifier, 'reference', null);
                $newOtherIdentifiers[$key]['reference_type'] = Arr::get($otherIdentifier, 'type', null);

                foreach (Arr::get($otherIdentifier, 'owner_org', []) as $innerKey => $ownerOrg) {
                    $newOtherIdentifiers[$key]['owner_org'][$innerKey]['ref'] = Arr::get($ownerOrg, 'reference', null);
                    $newOtherIdentifiers[$key]['owner_org'][$innerKey]['narrative'] = Arr::get(
                        $ownerOrg,
                        'narrative',
                        null
                    );
                }
            }
        }

        return count($newOtherIdentifiers) ? $newOtherIdentifiers : null;
    }

    /**
     * Returns updated activity first level data.
     *
     * @param $object
     * @param $replaceArray
     * @param  array  $removeArray
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityFirstLevelData($object, $replaceArray, array $removeArray = []): ?array
    {
        if (!$object) {
            return null;
        }

        $newArray = [];
        $array = json_decode($object, true, 512, JSON_THROW_ON_ERROR);

        if ($array && count($array)) {
            foreach (array_values($array) as $key => $item) {
                foreach ($item as $innerKey => $innerItem) {
                    if (!in_array($innerKey, $removeArray, true)) {
                        if (array_key_exists($innerKey, $replaceArray)) {
                            $newArray[$key][$replaceArray[$innerKey]] = $innerItem;
                            continue;
                        }

                        $newArray[$key][$innerKey] = $innerItem;
                    }
                }
            }
        }

        return count($newArray) ? $newArray : null;
    }

    /**
     * Checks if select value is valid and returns after typecasting into integer.
     *
     * @param $value
     * @param $listName
     * @param $listType
     *
     * @return int|null
     *
     * @throws \JsonException
     */
    public function getIntSelectValue($value, $listName, $listType): ?int
    {
        if (is_null($value)) {
            return null;
        }

        if (is_string($value)) {
            $value = json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        }

        if (is_null($value)) {
            return null;
        }

        $validKeys = array_keys(getCodeList($listName, $listType, false));
        $value = (int) $value;

        if (in_array($value, $validKeys, true)) {
            return $value;
        }

        return null;
    }

    /**
     * Updates activity element vocabulary data.
     *
     * @param $object
     * @param $vocabulary
     * @param $replaceArray
     * @param  array  $removeArray
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityUpdatedVocabularyData(
        $object,
        $vocabulary,
        $replaceArray,
        array $removeArray = []
    ): ?array {
        if (!$object) {
            return null;
        }

        $newArray = [];
        $array = json_decode($object, true, 512, JSON_THROW_ON_ERROR);

        if ($array && count($array)) {
            foreach (array_values($array) as $key => $item) {
                $newArray[$key] = $this->formatUpdatedVocabularyData(
                    $item,
                    Arr::get($replaceArray, Arr::get($item, $vocabulary, null), []),
                    Arr::get($removeArray, Arr::get($item, $vocabulary, null), [])
                );
            }
        }

        return count($newArray) ? $newArray : null;
    }

    /**
     * Formats updated vocabulary data.
     *
     * @param $item
     * @param $replaceArray
     * @param $removeArray
     *
     * @return array
     */
    public function formatUpdatedVocabularyData($item, $replaceArray, $removeArray): array
    {
        $newArray = [];

        if ($item && count($item)) {
            foreach ($item as $innerKey => $innerItem) {
                if (!in_array($innerKey, $removeArray, true)) {
                    if (array_key_exists($innerKey, $replaceArray)) {
                        $newArray[$replaceArray[$innerKey]] = $innerItem;
                        continue;
                    }

                    $newArray[$innerKey] = $innerItem;
                } elseif (array_key_exists($innerKey, $replaceArray)) {
                    $newArray[$replaceArray[$innerKey]] = $innerItem;
                }
            }
        }

        return $newArray;
    }

    /**
     * Returns activity location data.
     * @param $locations
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityLocationData($locations): ?array
    {
        if (!$locations) {
            return null;
        }

        $newLocations = [];
        $locationsArray = json_decode($locations, true, 512, JSON_THROW_ON_ERROR);

        if ($locationsArray && count($locationsArray)) {
            foreach (array_values($locationsArray) as $key => $locationArray) {
                $newLocations[$key]['ref'] = $this->locationReferenceValue(Arr::get($locationArray, 'reference', null));
                $newLocations[$key]['location_reach'] = Arr::get($locationArray, 'location_reach', null);
                $newLocations[$key]['location_id'] = Arr::get($locationArray, 'location_id', null);
                $newLocations[$key]['name'] = Arr::get($locationArray, 'name', null);
                $newLocations[$key]['description'] = Arr::get($locationArray, 'location_description', null);
                $newLocations[$key]['activity_description'] = Arr::get($locationArray, 'activity_description', null);
                $newLocations[$key]['administrative'] = $this->getLocationAdministrativeData(
                    Arr::get($locationArray, 'administrative', null)
                );
                $newLocations[$key]['point'] = [
                    'srs_name' => Arr::get($locationArray, 'point.0.srs_name', null),
                    'pos'      => Arr::get($locationArray, 'point.0.position', null),
                ];
                $newLocations[$key]['exactness'] = Arr::get($locationArray, 'exactness', null);
                $newLocations[$key]['location_class'] = Arr::get($locationArray, 'location_class', null);
                $newLocations[$key]['feature_designation'] = Arr::get($locationArray, 'feature_designation', null);
            }
        }

        return count($newLocations) ? $newLocations : null;
    }

    /**
     * Returns location reference value using id.
     *
     * @param $locationReferenceId
     *
     * @return string|null
     */
    public function locationReferenceValue($locationReferenceId): ?string
    {
        if (!$locationReferenceId) {
            return null;
        }

        $locationReference = $this->db::connection('aidstream')->table('location_references')->find(
            $locationReferenceId
        );

        return $locationReference ? $locationReference->reference : null;
    }

    /**
     * Checks if location administrative code is valid.
     * Since AidStream has open text field and IATI Publisher has select field, we need to check if the code is valid.
     *
     * @param $administratives
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getLocationAdministrativeData($administratives): array
    {
        if (count($administratives)) {
            foreach (array_values($administratives) as $key => $administrative) {
                if (!empty(Arr::get($administrative, 'code', null)) && !array_key_exists(
                    strtoupper(Arr::get($administrative, 'code', null)),
                    getCodeList('Country', 'Activity', false)
                )) {
                    unset($administratives[$key]);
                } elseif (!empty(Arr::get($administrative, 'code', null))) {
                    $administratives[$key]['code'] = strtoupper(Arr::get($administrative, 'code', null));
                }
            }
        }

        return count($administratives) ? array_values($administratives) : $this->locationAdministrativeEmptyTemplate;
    }

    /**
     * Returns country budget items data.
     *
     * @param $countryBudgetItems
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityCountryBudgetItemsData($countryBudgetItems): ?array
    {
        if (!$countryBudgetItems) {
            return null;
        }

        $newCountryBudgetItem = [];
        $countryBudgetItemsArray = json_decode($countryBudgetItems, true, 512, JSON_THROW_ON_ERROR);

        if ($countryBudgetItemsArray && count($countryBudgetItemsArray) && Arr::get(
            $countryBudgetItemsArray,
            '0.vocabulary',
            '1'
        ) !== '1') {
            $newCountryBudgetItem = [
                'country_budget_vocabulary' => Arr::get(
                    $countryBudgetItemsArray,
                    '0.vocabulary',
                    null
                ),
                'budget_item'               => $this->getBudgetItemsData(
                    Arr::get($countryBudgetItemsArray, '0.budget_item', null)
                ),
            ];
        }

        return !empty($newCountryBudgetItem) ? $newCountryBudgetItem : null;
    }

    /**
     * Returns budget items array.
     *
     * @param $budgetItems
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getBudgetItemsData($budgetItems): array
    {
        $newBudgetItems = [];

        foreach (array_values($budgetItems) as $key => $budgetItem) {
            if (array_key_exists(
                Arr::get($budgetItem, 'code_text', null),
                getCodeList('BudgetIdentifier', 'Activity', false)
            )) {
                $newBudgetItems[$key] = [
                    'code'        => Arr::get($budgetItem, 'code_text', null),
                    'percentage'  => Arr::get($budgetItem, 'percentage', null),
                    'description' => Arr::get($budgetItem, 'description', null),
                ];
            }
        }

        return count($newBudgetItems) ? $newBudgetItems : $this->emptyBudgetItemTemplate;
    }
}
