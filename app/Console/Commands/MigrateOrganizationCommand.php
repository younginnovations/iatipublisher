<?php

namespace App\Console\Commands;

use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\Setting\SettingService;
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
        protected SettingService $settingService
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
                    $this->settingService->create($this->getNewSetting($aidStreamOrganizationSetting, $iatiOrganization));
                    $this->info('Completed setting migration for organization id: ' . $aidstreamOrganizationId);
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

        $newOrganization['total_budget'] = $this->getColumnValueArray(
            $aidstreamOrganizationData,
            'total_budget'
        );
        $newOrganization['recipient_org_budget'] = $this->getColumnValueArray(
            $aidstreamOrganizationData,
            'recipient_organization_budget'
        );
        $newOrganization['default_field_values'] = null;
        $newOrganization['recipient_region_budget'] = $this->getColumnValueArray(
            $aidstreamOrganizationData,
            'recipient_region_budget'
        );
        $newOrganization['recipient_country_budget'] = $this->getColumnValueArray(
            $aidstreamOrganizationData,
            'recipient_country_budget'
        );
        $newOrganization['document_link'] = $this->getColumnValueArray(
            $aidstreamOrganizationData,
            'document_link'
        );
        $newOrganization['total_expenditure'] = $this->getColumnValueArray(
            $aidstreamOrganizationData,
            'total_expenditure'
        );
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
        $newOrganization['updated_by'] = null; // Needs to be updated after migrating users

        return $newOrganization;
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
        $newSetting = [];
        $newSetting['organization_id'] = $iatiOrganization->id;
        $newSetting['publishing_info'] = $this->getPublishingInfo(
            $aidstreamOrganizationSetting->registry_info,
            $iatiOrganization->publisher_id
        );
        $newSetting['default_values'] = $this->getDefaultValues($aidstreamOrganizationSetting->default_field_values);
        $newSetting['activity_default_values'] = $this->getActivityDefaultValues(
            $aidstreamOrganizationSetting->default_field_values
        );
        $newSetting['created_at'] = $aidstreamOrganizationSetting->created_at;
        $newSetting['updated_at'] = $aidstreamOrganizationSetting->updated_at;

        return $newSetting;
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
}
