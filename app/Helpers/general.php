<?php

declare(strict_types=1);

use App\IATI\Models\User\Role;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
     * @throws JsonException
     */
    function readElementGroup(): array
    {
        return readJsonFile('Data/Activity/ElementGroup.json');
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

if (!function_exists('getCoreElements')) {
    /**
     * Returns Core Elements.
     *
     * @return array
     */
    function getCoreElements(): array
    {
        return [
            'reporting_org',
            'iati_identifier',
            'title',
            'description',
            'participating_org',
            'activity_status',
            'activity_date',
            'recipient_country',
            'recipient_region',
            'sector',
            'collaboration_type',
            'default_flow_type',
            'default_finance_type',
            'default_aid_type',
            'budget',
            'transactions',
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

if (!function_exists('getCoreElementsWithTrueValue')) {
    /**
     * Returns Core Elements with true value.
     *
     * @return array
     */
    function getCoreElementsWithTrueValue(): array
    {
        return [
            'reporting_org' => true,
            'iati_identifier' => true,
            'title' => true,
            'description' => true,
            'participating_org' => true,
            'activity_status' => true,
            'activity_date' => true,
            'recipient_country' => true,
            'recipient_region' => true,
            'sector' => true,
            'collaboration_type' => true,
            'default_flow_type' => true,
            'default_finance_type' => true,
            'default_aid_type' => true,
            'budget' => true,
            'transactions' => true,
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
        return empty(array_diff_assoc(getCoreElementsWithTrueValue(), $elementStatus));
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
        $filePath = app_path("Data/$listType/$listName.json");
        $codeListFromFile = file_get_contents($filePath);
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
        $filePath = app_path("Data/$listType/$listName.php");
        $codeListFromFile = include $filePath;
        $data = [];

        foreach ($codeListFromFile as $key => $value) {
            $data[$key] = ($code) ? $key . ' - ' . $value : $value;
        }

        return $data;
    }
}

if (!function_exists('customDecryptString')) {
    /**
     * @param string      $encryptedString
     * @param string|null $key
     *
     * @return bool|string|null
     */
    function customDecryptString(string $encryptedString, string $key = null): bool|string|null
    {
        $frontendEncryptor = new Encrypter($key ?? env('MIX_ENCRYPTION_KEY'), Config::get('app.cipher'));

        return $frontendEncryptor->decrypt($encryptedString);
    }
}

if (!function_exists('customEncryptString')) {
    /**
     * @param string      $string
     * @param string|null $key
     *
     * @return bool|string|null
     */
    function customEncryptString(string $string, string $key = null): bool|string|null
    {
        $frontendEncryptor = new Encrypter($key ?? env('MIX_ENCRYPTION_KEY'), Config::get('app.cipher'));

        return $frontendEncryptor->encrypt($string);
    }
}

if (!function_exists('encryptString')) {
    /**
     * Encrypts string.
     *
     * @param string $string
     *
     * @return bool|string|null
     * @throws Exception
     */
    function encryptString(string $string): bool|string|null
    {
        $iv = random_bytes(16);
        $salt = random_bytes(256);
        $iterations = 999;
        $encryptMethodLength = 256 / 4;
        $hashKey = hash_pbkdf2('sha512', env('MIX_ENCRYPTION_KEY'), $salt, $iterations, $encryptMethodLength);
        $encryptedData = openssl_encrypt($string, 'AES-256-CBC', hex2bin($hashKey), OPENSSL_RAW_DATA, $iv);
        $output = ['ciphertext' => base64_encode($encryptedData), 'iv' => bin2hex($iv), 'salt' => bin2hex($salt), 'iterations' => $iterations];

        return base64_encode(json_encode($output, JSON_THROW_ON_ERROR));
    }
}

if (!function_exists('decryptString')) {
    /**
     * Decrypt encrypted base64 string.
     *
     * @param string $encryptedString
     * @param string $key
     *
     * @return bool|string|null
     * @throws JsonException
     */
    function decryptString(string $encryptedString, string $key): bool|string|null
    {
        $json = json_decode(base64_decode($encryptedString), true, 512, JSON_THROW_ON_ERROR);

        try {
            $salt = hex2bin($json['salt']);
            $iv = hex2bin($json['iv']);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return null;
        }

        $cipherText = base64_decode($json['ciphertext']);
        $iterations = (int) abs($json['iterations']);

        if ($iterations <= 0) {
            $iterations = 999;
        }

        $hashKey = hash_pbkdf2('sha512', $key, $salt, $iterations, (256 / 4));
        unset($iterations, $json, $salt);
        $decrypted = openssl_decrypt($cipherText, 'AES-256-CBC', hex2bin($hashKey), OPENSSL_RAW_DATA, $iv);
        unset($cipherText, $hashKey, $iv);

        return $decrypted;
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
        $filePath = app_path("Data/$filePath");
        $codeListFromFile = file_get_contents($filePath);
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
        return in_array($element, getCoreElements(), true);
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
            'activity' => ['orderBy' => ['updated_at'], 'direction' => ['asc', 'desc']],
            'organisation' => ['orderBy' => ['updated_at', 'all_activities_count', 'name'], 'direction' => ['asc', 'desc']],
            'user' => ['orderBy' => ['username', 'publisher_name', 'created_at'], 'direction' => ['asc', 'desc']],
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
        return ['activity_status', 'activity_scope', 'default_flow_type', 'default_finance_type', 'default_tied_status', 'capital_spend', 'collaboration_type', 'identifier', 'org_id', 'default_field_values', 'updated_at', 'created_at', 'id', 'iati_identifier', 'element_status'];
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
 * Returns encoding type of the file.
 * Returns UTF-8 if any exception or charset is not found.
 *
 * @param $file
 *
 * @return string
 */
function getEncodingType($file): string
{
    try {
        $response = exec('file -i ' . $file->getPathname());
        $charset = strripos($response, 'charset=');

        if ($charset) {
            return strtoupper(substr($response, $charset + strlen('charset=')));
        }

        return 'UTF-8';
    } catch (\Exception $exception) {
        return 'UTF-8';
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

/**
 * trim an input.
 *
 * @param $input
 *
 * @return string
 */
function trimInput($input): string
{
    return trim(preg_replace('/\s+/', ' ', $input));
}

/**
 * Returns formatted date.
 *
 * @param $format
 * @param $date
 *
 * @return false|string
 */
function dateFormat($format, $date): bool|string
{
    if (is_array($date) || is_bool($date)) {
        return false;
    }

    if (is_string($date) && $date !== '') {
        if ((str_contains($date, '/'))) {
            $date = str_replace('/', '-', $date);
        }

        $dateArray = date_parse_from_format('Y-m-d', $date);

        if (checkdate((int) $dateArray['month'], (int) $dateArray['day'], (int) $dateArray['year']) && (bool) strtotime($date)) {
            return date($format, strtotime($date));
        }

        return false;
    }

    return '';
}

/**
 * Returns strtotime date.
 *
 * @param $date
 *
 * @return false|int
 */
function dateStrToTime($date): int|bool
{
    if (is_array($date)) {
        return false;
    }

    if ($date !== '' && is_string($date)) {
        if ((str_contains($date, '/'))) {
            $date = str_replace('/', '-', $date);
        }

        $dateArray = date_parse_from_format('Y-m-d', $date);

        if (checkdate((int) $dateArray['month'], (int) $dateArray['day'], (int) $dateArray['year']) && (bool) strtotime($date)) {
            return strtotime($date);
        }

        return false;
    }

    return false;
}

if (!function_exists('awsHasFile')) {
    /**
     * @param $filePath
     *
     * @return bool
     */
    function awsHasFile($filePath): bool
    {
        return Storage::disk('s3')->exists($filePath);
    }
}

if (!function_exists('awsGetFile')) {
    /**
     * @param $filePath
     *
     * @return string|null
     */
    function awsGetFile($filePath): ?string
    {
        return Storage::disk('s3')->get($filePath);
    }
}

if (!function_exists('awsUploadFile')) {
    /**
     * @param $path
     * @param $content
     *
     * @return bool
     */
    function awsUploadFile($path, $content): bool
    {
        return Storage::disk('s3')->put($path, $content);
    }
}

if (!function_exists('awsUploadFileAs')) {
    /**
     * @param $path
     * @param $content
     * @param $filename
     *
     * @return bool
     */
    function awsUploadFileAs($path, $content, $filename): bool
    {
        return (bool) Storage::disk('s3')->putFileAs($path, $content, $filename);
    }
}

if (!function_exists('awsDeleteFile')) {
    /**
     * @param $filePath
     *
     * @return bool
     */
    function awsDeleteFile($filePath): bool
    {
        if (Storage::disk('s3')->exists($filePath)) {
            return Storage::disk('s3')->delete($filePath);
        }

        return false;
    }
}

if (!function_exists('awsUrl')) {
    /**
     * @param $filePath
     *
     * @return string
     */
    function awsUrl($filePath): string
    {
        return Storage::disk('s3')->url($filePath);
    }
}

if (!function_exists('awsFilePath')) {
    /**
     * @param $path
     *
     * @return string
     */
    function awsFilePath($path): string
    {
        return Storage::disk('s3')->path($path);
    }
}

if (!function_exists('localHasFile')) {
    /**
     * @param $filePath
     *
     * @return bool
     */
    function localHasFile($filePath): bool
    {
        return Storage::disk('local')->exists($filePath);
    }
}

if (!function_exists('localUploadFile')) {
    /**
     * @param $path
     * @param $content
     *
     * @return bool
     */
    function localUploadFile($path, $content): bool
    {
        return Storage::disk('local')->put($path, $content);
    }
}

if (!function_exists('localFilePath')) {
    /**
     * @param $path
     *
     * @return string
     */
    function localFilePath($path): string
    {
        return Storage::disk('local')->path($path);
    }
}

if (!function_exists('localDeleteFile')) {
    /**
     * @param $filePath
     *
     * @return bool
     */
    function localDeleteFile($filePath): bool
    {
        if (Storage::disk('local')->exists($filePath)) {
            return Storage::disk('local')->delete($filePath);
        }

        return false;
    }
}

if (!function_exists('array_values_recursive')) {
    /**
     * Converts multi-dimensional array to single array.
     *
     * @param array $arr
     *
     * @return array
     */
    function array_values_recursive(array $arr): array
    {
        $result = [];

        foreach (array_keys($arr) as $k) {
            $v = $arr[$k];

            if (is_scalar($v)) {
                $result[] = $v;
            } elseif (is_array($v)) {
                $result = array_merge($result, array_values_recursive($v));
            }
        }

        return $result;
    }
}

if (!function_exists('is_array_values_null')) {
    /**
     * Checks if all values in array is empty.
     *
     * @param array $arr
     *
     * @return bool
     */
    function is_array_values_null(array $arr): bool
    {
        return empty(array_values_recursive($arr));
    }
}

if (!function_exists('is_variable_null')) {
    /**
     * Checks if variable is null.
     *
     * @param $var
     *
     * @return bool
     */
    function is_variable_null($var): bool
    {
        return is_array($var) ? is_array_values_null($var) : is_null($var);
    }
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

if (!function_exists('is_array_value_null')) {
    /**
     * Checks if array | nested array values are null or empty string.
     *
     * @param $array
     * @return bool
     */
    function is_array_value_empty($array): bool
    {
        $flatArray = Arr::flatten($array);
        $value = array_filter($flatArray, static function ($q) {
            return $q;
        });

        return empty($value);
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
                    Arr::set($activity, $key, '');
                }
            }
        }

        $importData['data'] = $activity;

        return $importData;
    }
}
