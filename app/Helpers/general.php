<?php

declare(strict_types=1);

use App\Constants\CoreElements;
use App\IATI\Models\User\Role;
use App\IATI\Services\Setting\SettingService;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

if (!function_exists('dashesToCamelCase')) {
    /**
     * Changes dash case string to camelcase.
     *
     * @param      $string
     * @param bool $capitalizeFirstCharacter
     *
     * @return string
     */
    function dashesToCamelCase($string, bool $capitalizeFirstCharacter = false): string
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }
}

if (!function_exists('readJsonFile')) {
    /**
     * Reads JSON file.
     *
     * @param $filePath
     *
     * @return array
     * @throws JsonException
     */
    function readJsonFile($filePath): array
    {
        return json_decode(file_get_contents(app_path($filePath)), true, 512, JSON_THROW_ON_ERROR);
    }
}

if (!function_exists('readElementGroup')) {
    /**
     * Reads ElementGroup json file.
     *
     * @return array
     */
    function readElementGroup(): array
    {
        $completePath = 'AppData/Data/Activity/ElementGroup.json';

        return json_decode(getJsonFromSource($completePath), true);
    }
}

if (!function_exists('readElementJsonSchema')) {
    /**
     * Reads elementJsonSchema.
     *
     * @return array
     * @throws JsonException
     */
    function readElementJsonSchema(): array
    {
        return readJsonFile('IATI/Data/elementJsonSchema.json');
    }
}

if (!function_exists('readOrganizationElementJsonSchema')) {
    /**
     * Reads elementJsonSchema.
     *
     * @return array
     * @throws JsonException
     */
    function readOrganizationElementJsonSchema(): array
    {
        return readJsonFile('IATI/Data/organizationElementJsonSchema.json');
    }
}

if (!function_exists('getElementSchema')) {
    /**
     * Returns element schema.
     *
     * @throws JsonException
     */
    function getElementSchema($element): array
    {
        return getArr(readElementJsonSchema(), $element);
    }
}

if (!function_exists('getOrganizationElementSchema')) {
    /**
     * Returns organization element schema.
     *
     * @throws JsonException
     */
    function getOrganizationElementSchema($element): array
    {
        return getArr(readOrganizationElementJsonSchema(), $element);
    }
}

if (!function_exists('getElements')) {
    /**
     * Returns elements list.
     *
     * @return array
     * @throws JsonException
     */
    function getElements(): array
    {
        $elementJsonSchema = readElementJsonSchema();
        unset($elementJsonSchema['indicator'], $elementJsonSchema['period']);

        return array_keys($elementJsonSchema);
    }
}

if (!function_exists('getOrganizationElements')) {
    /**
     * Returns elements list.
     *
     * @return array
     * @throws JsonException
     */
    function getOrganizationElements(): array
    {
        return array_keys(readOrganizationElementJsonSchema());
    }
}

if (!function_exists('getDefaultElementStatus')) {
    /**
     * Returns Default Elements Status.
     *
     * @return array
     */
    function getDefaultElementStatus(): array
    {
        return [
            'iati_identifier' => false,
            'title' => false,
            'description' => false,
            'activity_status' => false,
            'activity_date' => false,
            'activity_scope' => false,
            'recipient_country' => false,
            'recipient_region' => false,
            'collaboration_type' => false,
            'default_flow_type' => false,
            'default_finance_type' => false,
            'default_aid_type' => false,
            'default_tied_status' => false,
            'capital_spend' => false,
            'related_activity' => false,
            'conditions' => false,
            'sector' => false,
            'humanitarian_scope' => false,
            'legacy_data' => false,
            'tag' => false,
            'policy_marker' => false,
            'other_identifier' => false,
            'country_budget_items' => false,
            'budget' => false,
            'participating_org' => false,
            'document_link' => false,
            'contact_info' => false,
            'location' => false,
            'planned_disbursement' => false,
            'transactions' => false,
            'result' => false,
        ];
    }
}

if (!function_exists('getDefaultOrganizationElementStatus')) {
    /**
     * Returns Default Elements Status.
     *
     * @return array
     */
    function getDefaultOrganizationElementStatus(): array
    {
        return [
            'identifier' => false,
            'name' => false,
            'reporting_org' => false,
            'total_budget' => false,
            'total_expenditure' => false,
            'recipient_org_budget' => false,
            'recipient_country_budget' => false,
            'recipient_region_budget' => false,
            'document_link' => false,
        ];
    }
}

if (!function_exists('getMandatoryElements')) {
    /**
     * Returns Core Elements.
     *
     * @return array
     */
    function getMandatoryElements(): array
    {
        return [
            'identifier',
            'name',
            'reporting_org',
            'total_budget',
            'total_expenditure',
            'recipient_org_budget',
            'recipient_country_budget',
            'recipient_region_budget',
            'document_link',
        ];
    }
}

if (!function_exists('getMandatoryElementsWithTrueValue')) {
    /**
     * Returns Core Elements with true value.
     *
     * @return array
     */
    function getMandatoryElementsWithTrueValue(): array
    {
        return [
            'identifier' => true,
            'name' => true,
            'reporting_org' => true,
            'total_budget' => true,
            'total_expenditure' => true,
            'recipient_org_budget' => true,
            'recipient_country_budget' => true,
            'recipient_region_budget' => true,
            'document_link' => true,
        ];
    }
}

if (!function_exists('isCoreElementCompleted')) {
    /**
     * Checks if all core elements are complete.
     *
     * @param $elementStatus
     *
     * @return bool
     */
    function isCoreElementCompleted($elementStatus): bool
    {
        return empty(array_diff_assoc(CoreElements::getCoreElementsWithTrueValue(), $elementStatus));
    }
}

if (!function_exists('isMandatoryElementCompleted')) {
    /**
     * Checks if all core elements are complete.
     *
     * @param $elementStatus
     *
     * @return bool
     */
    function isMandatoryElementCompleted($elementStatus): bool
    {
        return Arr::get($elementStatus, 'name', false) && Arr::get($elementStatus, 'reporting_org', false);
    }
}

if (!function_exists('getArr')) {
    /**
     * Checks if array key exists.
     *
     * @param $data
     * @param $key
     *
     * @return array
     */
    function getArr($data, $key): array
    {
        return array_key_exists($key, $data) ? $data[$key] : [];
    }
}

if (!function_exists('getCodeList')) {
    /**
     * return codeList array from json codeList.
     *
     * @param      $listName
     * @param      $listType
     * @param bool $code
     *
     * @return array
     * @throws JsonException
     */
    function getCodeList($listName, $listType, bool $code = true): array
    {
        $completePath = "AppData/Data/$listType/$listName.json";
        $codeListFromFile = getJsonFromSource($completePath);
        $codeLists = json_decode($codeListFromFile, true, 512, JSON_THROW_ON_ERROR);
        $codeList = $codeLists[$listName];
        $data = [];

        foreach ($codeList as $list) {
            $data[$list['code']] = ($code) ? $list['code'] . (array_key_exists('name', $list) ? ' - ' . $list['name'] : '') : $list['name'];
        }

        return $data;
    }
}

if (!function_exists('getCodeListArray')) {
    /**
     * return codeList array from codeList.
     *
     * @param      $listName
     * @param      $listType
     * @param bool $code
     *
     * @return array
     */
    function getCodeListArray($listName, $listType, bool $code = true): array
    {
        $completePath = "AppData/Data/$listType/$listName.json";
        $content = getJsonFromSource($completePath);
        $codeListFromFile = json_decode($content);
        $data = [];

        foreach ($codeListFromFile as $key => $value) {
            $data[$key] = ($code) ? $key . ' - ' . $value : $value;
        }

        return $data;
    }
}

if (!function_exists('getList')) {
    /**
     * Return codeList array from json codeList.
     *
     * @param string $filePath
     * @param bool   $code
     *
     * @return array
     * @throws JsonException
     */
    function getList(string $filePath, bool $code = true): array
    {
        $completePath = "AppData/Data/$filePath";
        $codeListFromFile = getJsonFromSource($completePath);
        $codeLists = json_decode($codeListFromFile, true, 512, JSON_THROW_ON_ERROR);
        $codeList = last($codeLists);
        $data = [];

        foreach ($codeList as $list) {
            $data[$list['code']] = ($code) ? $list['code'] . (
                array_key_exists(
                    'name',
                    $list
                ) ? ' - ' . $list['name'] : ''
            ) : $list['name'];
        }

        return $data;
    }
}

if (!function_exists('getTransactionTypes')) {
    /**
     * Get activity transaction data type.
     *
     * @return array
     * @throws JsonException
     */
    function getTransactionTypes(): array
    {
        return [
            'transactionType' => getCodeList('TransactionType', 'Activity', false),
            'organizationType' => getCodeList('OrganizationType', 'Organization', false),
            'disbursementChannel' => getCodeList('DisbursementChannel', 'Activity', false),
            'sectorVocabulary' => getCodeList('SectorVocabulary', 'Activity', false),
            'sectorCode' => getCodeList('SectorCode', 'Activity', false),
            'sectorCategory' => getCodeList('SectorCategory', 'Activity', false),
            'unsdgGoals' => getCodeList('UNSDG-Goals', 'Activity', false),
            'unsdgTargets' => getCodeList('UNSDG-Targets', 'Activity', false),
            'countryCode' => getCodeList('Country', 'Activity', false),
            'regionVocabulary' => getCodeList('RegionVocabulary', 'Activity', false),
            'regionCode' => getCodeList('Region', 'Activity', false),
            'flowType' => getCodeList('FlowType', 'Activity', false),
            'financeType' => getCodeList('FinanceType', 'Activity', false),
            'tiedStatusType' => getCodeList('TiedStatus', 'Activity', false),
            'aidTypeVocabulary' => getCodeList('AidTypeVocabulary', 'Activity', false),
            'aidType' => getCodeList('AidType', 'Activity', false),
            'cashAndVoucherModalities' => getCodeList('CashandVoucherModalities', 'Activity', false),
            'earMarkingCategory' => getCodeList('EarmarkingCategory', 'Activity', false),
            'earMarkingModality' => getCodeList('EarmarkingModality', 'Activity', false),
            'languages' => getCodeList('Language', 'Activity', false),
        ];
    }
}

if (!function_exists('getResultTypes')) {
    /**
     * Get activity result data type.
     *
     * @return array
     * @throws JsonException
     */
    function getResultTypes(): array
    {
        return [
            'resultType' => getCodeList('ResultType', 'Activity', false),
            'resultVocabulary' => getCodeList('ResultVocabulary', 'Activity', false),
            'indicatorMeasure' => getCodeList('IndicatorMeasure', 'Activity', false),
            'language' => getCodeList('Language', 'Activity', false),
            'documentCategory' => getCodeList('DocumentCategory', 'Activity', false),
        ];
    }
}

if (!function_exists('getIndicatorTypes')) {
    /**
     * Get activity indicator data type.
     *
     * @return array
     * @throws JsonException
     */
    function getIndicatorTypes(): array
    {
        return [
            'indicatorVocabulary' => getCodeList('IndicatorVocabulary', 'Activity'),
            'indicatorMeasure' => getCodeList('IndicatorMeasure', 'Activity', false),
            'language' => getCodeList('Language', 'Activity', false),
            'documentCategory' => getCodeList('DocumentCategory', 'Activity', false),
            'fileFormat' => getCodeList('FileFormat', 'Activity', false),
        ];
    }
}

if (!function_exists('getPeriodTypes')) {
    /**
     * Get activity periods data type.
     *
     * @return array
     * @throws JsonException
     */
    function getPeriodTypes(): array
    {
        return [
            'indicatorMeasure' => getCodeList('IndicatorMeasure', 'Activity', false),
            'language' => getCodeList('Language', 'Activity', false),
            'documentCategory' => getCodeList('DocumentCategory', 'Activity', false),
            'fileFormat' => getCodeList('FileFormat', 'Activity', false),
        ];
    }
}

if (!function_exists('generateToastData')) {
    /**
     * Generates toast array.
     *
     * @return array
     */
    function generateToastData(): array
    {
        $toast['message'] = Session::exists('error') ? Session::get('error') : (Session::exists('success') ? Session::get('success') : '');
        $toast['type'] = Session::exists('error') ? false : true;
        Session::forget('success');
        Session::forget('error');

        return $toast;
    }
}

if (!function_exists('isCoreElement')) {
    /**
     * Checks if an activity element is a core element.
     *
     * @param $element
     *
     * @return bool
     */
    function isCoreElement($element): bool
    {
        return in_array($element, CoreElements::all(), true);
    }
}

if (!function_exists('isMandatoryElement')) {
    /**
     * Checks if an activity element is a core element.
     *
     * @param $element
     *
     * @return bool
     */
    function isMandatoryElement($element): bool
    {
        $mandatory_elements = [
            'indicator',
        ];

        return in_array($element, $mandatory_elements, true);
    }
}

if (!function_exists('getTableConfig')) {
    /**
     * Gets the table config of activity.
     *
     * @param $module
     *
     * @return string[][]
     */
    function getTableConfig($module): array
    {
        $tableConfig = [
            'activity' => ['orderBy' => ['updated_at', 'complete_percentage'], 'direction' => ['asc', 'desc']],
            'organisation' => [
                'orderBy'   => ['updated_at', 'all_activities_count', 'name', 'registered_on', 'publisher_type', 'data_license', 'country', 'last_logged_in'],
                'direction' => ['asc', 'desc'],
                'filters' => [
                    'completeness'      => 'single',
                    'registration_type' => 'single',
                    'country'           => 'multiple',
                    'publisher_type'    => 'multiple',
                    'data_license'      => 'multiple',
                ],
            ],
            'user' => ['orderBy' => ['username', 'publisher_name', 'created_at', 'organisation', 'admin', 'general', 'active', 'deactivated', 'total', 'last_logged_in'], 'direction' => ['asc', 'desc']],
            'audit' => ['orderBy' => ['user_id', 'user_type', 'event', 'auditable_type', 'created_at'], 'direction' => ['asc', 'desc']],
        ];

        return $tableConfig[$module];
    }
}

if (!function_exists('getDefaultLanguage')) {
    /**
     * Gets the default language.
     *
     * @param $defaultValues
     *
     * @return string
     */
    function getDefaultLanguage($defaultValues): string
    {
        if (!empty($defaultValues) && array_key_exists('default_language', $defaultValues) && !empty($defaultValues['default_language'])) {
            return $defaultValues['default_language'];
        }

        return '';
    }
}

if (!function_exists('removeEmptyValues')) {
    /**
     * Removes empty values.
     *
     * @param $data
     */
    function removeEmptyValues(&$data): void
    {
        foreach ($data as &$subData) {
            if (is_array($subData)) {
                removeEmptyValues($subData);
            }
        }

        $data = array_filter(
            $data,
            function ($value) {
                return $value !== '' && $value != [];
            }
        );
    }
}

if (!function_exists('getNonArrayElements')) {
    /**
     * Returns array of elements which do not store data as array.
     *
     * @return array
     */
    function getNonArrayElements(): array
    {
        return ['activity_status', 'activity_scope', 'default_flow_type', 'default_finance_type', 'default_tied_status', 'capital_spend', 'collaboration_type', 'identifier', 'org_id', 'default_field_values', 'updated_at', 'created_at', 'id', 'iati_identifier', 'element_status', 'updated_by'];
    }
}

if (!function_exists('isSuperAdmin')) {
    /**
     * Returns whether user is superadmin or not.
     *
     * @return bool
     */
    function isSuperAdmin(): bool
    {
        $superAdminId = [app(Role::class)->getSuperAdminId(), app(Role::class)->getIatiAdminId()];

        return in_array(auth()->user()->role_id, $superAdminId) || in_array(session()->get('role_id'), $superAdminId);
    }
}

if (!function_exists('isSuperAdminRoute')) {
    /**
     * Checks if the request route contains prefix SuperAdmin.
     *
     * @return bool
     */
    function isSuperAdminRoute(): bool
    {
        if (request()->route()) {
            $superAdminId = [app(Role::class)->getSuperAdminId(), app(Role::class)->getIatiAdminId()];

            return in_array(auth()->user()->role_id, $superAdminId);
        }

        return false;
    }
}

/**
 * Get csv header count.
 *
 * @return int
 */
function getCsvHeaderCount(): int
{
    return 69;
}

if (!function_exists('get_user_status')) {
    /**
     * Returns user status types.
     *
     * @return array
     */
    function getUserStatus(): array
    {
        return [
            1 => 'Active',
            0 => 'Inactive',
        ];
    }
}

if (!function_exists('get_language_preference')) {
    /**
     * Returns language preference types.
     *
     * @return array
     */
    function getLanguagePreference(): array
    {
        return [
            'en' => 'English',
            'fr' => 'French',
            'es' => 'Spanish',
        ];
    }
}

if (!function_exists('get_user_csv_header')) {
    /**
     * Returns user download csv header.
     *
     * @return array
     */
    function getUserCsvHeader(): array
    {
        return ['username' => 'User Name', 'full_name' => 'Full Name', 'organization_id' => 'Organization', 'email' => 'Email', 'role_id' => 'Role', 'created_at' => 'Joined On'];
    }
}

if (!function_exists('get_time_stamped_text')) {
    /**
     * Returns filename with ymdhis.
     *
     * @return array
     */
    function getTimeStampedText(string $filename): string
    {
        return sprintf('%s_%s', $filename, date('Y_m_d_His'));
    }
}

if (!function_exists('generateApiInfo')) {
    /**
     * Generates api log info for API logging.
     *
     * @param $request
     *
     * @return array
     */
    function generateApiInfo($method, $requestURI, $requestOption, $response = null): array
    {
        $responseBody = is_string($response) ? null : $response->getBody();
        $uri = Str::startsWith($requestURI, 'http') ? $requestURI : sprintf('%s/%s', env('IATI_API_ENDPOINT'), $requestURI);

        $requestInfo = [
            'method' => $method,
            'url' => $uri,
            'request' => $requestOption,
            'response' => is_string($response) ? $response : json_decode((string) $response->getBody(), true),
        ];

        if ($responseBody) {
            $responseBody->seek(0);
        }

        return $requestInfo;
    }
}

if (!function_exists('mergeRules')) {
    /**
     * Generates api log info for API logging.
     *
     * @param $request
     *
     * @return array
     */
    function mergeRules($totalRules): array
    {
        $mergedRules = [];

        foreach ($totalRules as $rules) {
            foreach ($rules as $index => $rule) {
                if (is_string($rule)) {
                    $rule = explode('|', $rule);
                }

                if (is_array($rule)) {
                    foreach (array_values($rule) as $ruleValue) {
                        if (!in_array($ruleValue, Arr::get($mergedRules, $index, []))) {
                            $mergedRules[$index][] = $ruleValue;
                        }
                    }
                }
            }
        }

        return $mergedRules;
    }
}

if (!function_exists('unsetErrorFields')) {
    /**
     * unset fields from imported activity that contains critical error.
     *
     * @param $request
     *
     * @return array
     */
    function unsetErrorFields($importContent): array
    {
        $importData = json_decode(json_encode($importContent, JSON_THROW_ON_ERROR | 512), true, 512, JSON_THROW_ON_ERROR);
        $activity = $importData['data'];
        $errors = Arr::get($importData, 'errors.error', []);

        if (!empty($errors)) {
            foreach (array_values($errors) as $error) {
                foreach (array_keys($error) as $key) {
                    Arr::set($activity, $key, null);
                }
            }
        }

        $importData['data'] = $activity;

        return $importData;
    }
}

if (!function_exists('compareStringIgnoringWhitespace')) {
    /**
     * Check if 2 strings are exactly same after removing all whitespaces.
     *
     * @param string $string1
     * @param string $string2
     *
     * @return bool
     */
    function compareStringIgnoringWhitespace(string $string1, string $string2): bool
    {
        return preg_replace('/\s+/', '', $string1) === preg_replace('/\s+/', '', $string2);
    }
}

if (!function_exists('getAllocatedPercentageOfRecipientRegion')) {
    /**
     * Returns currently consumed % by recipient region.
     *
     * @param $activity
     *
     * @return float
     */
    function getAllocatedPercentageOfRecipientRegion($activity): float
    {
        $data = $activity->recipient_region;
        $groupedRegion = [];

        if (!empty($data)) {
            foreach ($data as $datum) {
                if (array_key_exists($datum['region_vocabulary'], $groupedRegion)) {
                    $groupedRegion[$datum['region_vocabulary']] += (float) $datum['percentage'];
                } else {
                    $groupedRegion[$datum['region_vocabulary']] = (float) $datum['percentage'];
                }
            }

            if (!empty($groupedRegion)) {
                $groupedRegion = array_values($groupedRegion);

                return $groupedRegion[0];
            }
        }

        return 0.0;
    }
}

if (!function_exists('getAllocatedPercentageOfRecipientCountry')) {
    /**
     * Returns currently consumed % by recipient country.
     *
     * @param $activity
     *
     * @return float
     */
    function getAllocatedPercentageOfRecipientCountry($activity): float
    {
        $data = $activity->recipient_country;
        $total = 0.0;

        if (!empty($data)) {
            foreach ($data as $datum) {
                $total += (float) $datum['percentage'];
            }
        }

        return $total;
    }
}

if (!function_exists('getStringBetween')) {
    /**
     * Returns string between two characters.
     *
     * @param $string
     * @param $start
     * @param $end
     *
     * @return string
     */
    function getStringBetween($string, $start, $end): string
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);

        if (!$ini) {
            return '';
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;

        return substr($string, $ini, $len);
    }
}

if (!function_exists('checkUrlExists')) {
    /**
     * Returns if path exists in project.
     *
     * @param $path
     *
     * @return bool
     */
    function checkUrlExists($path): bool
    {
        $routes = Route::getRoutes();
        $request = Request::create($path);

        try {
            if ($routes->match($request)) {
                return true;
            }

            return false;
        } catch (NotFoundHttpException) {
            return false;
        }
    }
}

if (!function_exists('strReplaceLastOccurrence')) {
    /**
     * Replaces string of last occurrence.
     *
     * @param $search
     * @param $replace
     * @param $subject
     *
     * @return string
     */
    function strReplaceLastOccurrence($search, $replace, $subject): String
    {
        $pos = strrpos($subject, $search);

        if ($pos !== false) {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }
}

if (!function_exists('getTimestampFromSingleXml')) {
    /**
     * Returns timestamp from xml file or last updated at if xml not exists.
     *
     * @param string $publisherId
     * @param App\IATI\Models\Activity\Activity $activity
     *
     * @return string
     */
    function getTimestampFromSingleXml(string $publisherId, App\IATI\Models\Activity\Activity $activity): string
    {
        $xmlName = "$publisherId-$activity->id.xml";
        $xmlPath = "xml/activityXmlFiles/$xmlName";

        if (awsHasFile($xmlPath)) {
            $xmlString = awsGetFile($xmlPath);

            if ($xmlString) {
                $xmlContent = new SimpleXMLElement($xmlString);

                $lastUpdatedDatetime = (string) $xmlContent->xpath('//iati-activity/@last-updated-datetime')[0];

                if ($lastUpdatedDatetime) {
                    $carbonDate = Carbon::parse($lastUpdatedDatetime);

                    return $carbonDate->toIso8601String();
                }
            }
        }

        return $activity->updated_at->toIso8601String();
    }
}

if (!function_exists('getJsonFromSource')) {
    /**
     * Returns json string from either cache or public except for OrganizationRegistrationAgency.json.
     * Returns json string for OrganizationRegistrationAgency.json from s3.
     *
     * @param string $completePath
     *
     * @return string
     */
    function getJsonFromSource(string $completePath): string
    {
        $jsonString = Cache::get($completePath);

        if ($jsonString) {
            return $jsonString;
        }

        if ($completePath === 'AppData/Data/Organization/OrganizationRegistrationAgency.json') {
            $jsonString = awsGetFile($completePath);

            if ($jsonString) {
                return $jsonString;
            }
        }

        return file_get_contents(public_path($completePath));
    }
}

if (!function_exists('getDefaultValue')) {
    /**
     * Returns Default value.
     *
     * @param $defaultValueList
     * @param $selectDefaultValueKey
     *
     * @return string|null
     *
     * @throws JsonException
     */
    function getDefaultValue($defaultValueList, $selectDefaultValueKey, $location = []): ?string
    {
        $defaultValueKeys = [
            'language'  => 'default_language',
            'currency'  => 'default_currency',
            'default_aid_type'   => 'default_aid_type',
            'collaboration_type'    => 'default_collaboration_type',
            'default_flow_type'     => 'default_flow_type',
            'default_finance_type'  => 'default_finance_type',
            'default_tied_status'   => 'default_tied_status',
        ];

        if (isset($defaultValueKeys[$selectDefaultValueKey]) && isset($defaultValueList[$defaultValueKeys[$selectDefaultValueKey]])) {
            $explodedLocation = explode('/', $location);
            $type = $explodedLocation[0];
            $jsonFile = str_replace('.json', '', $explodedLocation[1]);
            $codeList = getCodeList($jsonFile, $type);
            $defaultValue = $defaultValueList[$defaultValueKeys[$selectDefaultValueKey]];

            return $codeList[$defaultValue] ?? null;
        }

        return null;
    }
}

if (!function_exists('getSettingDefaultLanguage')) {
    /**
     * Returns default language from settings.
     *
     * @return string|null
     * @throws JsonException
     *
     * @throws BindingResolutionException
     */
    function getSettingDefaultLanguage(): ?string
    {
        $settingService = app()->make(SettingService::class);
        $settingsDefaultValue = $settingService->getSetting()->default_values ?? [];

        return getDefaultValue($settingsDefaultValue, 'language', 'Activity/Language.json' ?? []);
    }
}

if (!function_exists('getTimestampFromOrganizationXml')) {
    /**
     * Returns timestamp from xml file or last updated at if xml not exists.
     *
     * @param string $publisherId
     *
     * @return string
     */
    function getTimestampFromOrganizationXml(string $publisherId, App\IATI\Models\Organization\Organization $organization): string
    {
        $xmlName = "$publisherId-organisation.xml";
        $xmlPath = "organizationXmlFiles/$xmlName";

        if (awsHasFile($xmlPath)) {
            $xmlString = awsGetFile($xmlPath);

            if ($xmlString) {
                $xmlContent = new SimpleXMLElement($xmlString);

                $lastUpdatedDatetime = (string) $xmlContent->xpath('//iati-organisation/@last-updated-datetime')[0];

                if ($lastUpdatedDatetime) {
                    $carbonDate = Carbon::parse($lastUpdatedDatetime);

                    return $carbonDate->toIso8601String();
                }
            }
        }

        return $organization->updated_at->toIso8601String();
    }
}
