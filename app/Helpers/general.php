<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Session;

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
if (!function_exists('getDefaultElementStatus')) {
    /**
     * Returns Default Elements Status.
     *
     * @return array
     */
    function getDefaultElementStatus(): array
    {
        return [
            'iati_identifier'      => false,
            'title'                => false,
            'description'          => false,
            'activity_status'      => false,
            'activity_date'        => false,
            'activity_scope'       => false,
            'recipient_country'    => false,
            'recipient_region'     => false,
            'collaboration_type'   => false,
            'default_flow_type'    => false,
            'default_finance_type' => false,
            'default_aid_type'     => false,
            'default_tied_status'  => false,
            'capital_spend'        => false,
            'related_activity'     => false,
            'conditions'           => false,
            'sector'               => false,
            'humanitarian_scope'   => false,
            'legacy_data'          => false,
            'tag'                  => false,
            'policy_marker'        => false,
            'other_identifier'     => false,
            'country_budget_items' => false,
            'budget'               => false,
            'participating_org'    => false,
            'document_link'        => false,
            'contact_info'         => false,
            'location'             => false,
            'planned_disbursement' => false,
            'transactions'         => false,
            'result'               => false,
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

if (!function_exists('getCoreElementsWithTrueValue')) {
    /**
     * Returns Core Elements with true value.
     *
     * @return array
     */
    function getCoreElementsWithTrueValue(): array
    {
        return [
            'reporting_org'        => true,
            'iati_identifier'      => true,
            'title'                => true,
            'description'          => true,
            'participating_org'    => true,
            'activity_status'      => true,
            'activity_date'        => true,
            'recipient_country'    => true,
            'recipient_region'     => true,
            'sector'               => true,
            'collaboration_type'   => true,
            'default_flow_type'    => true,
            'default_finance_type' => true,
            'default_aid_type'     => true,
            'budget'               => true,
            'transactions'         => true,
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
            $data[$list['code']] = ($code) ? $list['code'] . (array_key_exists(
                'name',
                $list
            ) ? ' - ' . $list['name'] : '') : $list['name'];
        }

        return $data;
    }
}

if (!function_exists('getTransactionTypes')) {
    /*
     * Get activity transaction data type
     *
     * @return array
     */
    function getTransactionTypes(): array
    {
        return [
            'transactionType'          => getCodeList('TransactionType', 'Activity', false),
            'organizationType'         => getCodeList('OrganizationType', 'Organization', false),
            'disbursementChannel'      => getCodeList('DisbursementChannel', 'Activity', false),
            'sectorVocabulary'         => getCodeList('SectorVocabulary', 'Activity', false),
            'sectorCode'               => getCodeList('SectorCode', 'Activity', false),
            'sectorCategory'           => getCodeList('SectorCategory', 'Activity', false),
            'unsdgGoals'               => getCodeList('UNSDG-Goals', 'Activity', false),
            'unsdgTargets'             => getCodeList('UNSDG-Targets', 'Activity', false),
            'countryCode'              => getCodeList('Country', 'Activity', false),
            'regionCode'               => getCodeList('RegionVocabulary', 'Activity', false),
            'flowType'                 => getCodeList('FlowType', 'Activity', false),
            'financeType'              => getCodeList('FinanceType', 'Activity', false),
            'tiedStatusType'           => getCodeList('TiedStatus', 'Activity', false),
            'aidTypeVocabulary'        => getCodeList('AidTypeVocabulary', 'Activity', false),
            'aidType'                  => getCodeList('AidType', 'Activity', false),
            'cashAndVoucherModalities' => getCodeList('CashandVoucherModalities', 'Activity', false),
            'earMarkingCategory'       => getCodeList('EarmarkingCategory', 'Activity', false),
            'earMarkingModality'       => getCodeList('EarmarkingModality', 'Activity', false),
            'languages'                => getCodeList('Language', 'Activity', false),
        ];
    }
}

if (!function_exists('getResultTypes')) {
    /*
     * Get activity result data type
     *
     * @return array
     */
    function getResultTypes(): array
    {
        return [
            'resultType'       => getCodeList('ResultType', 'Activity', false),
            'resultVocabulary' => getCodeList('ResultVocabulary', 'Activity', false),
            'indicatorMeasure' => getCodeList('IndicatorMeasure', 'Activity', false),
            'language'         => getCodeList('Language', 'Activity', false),
            'documentCategory' => getCodeList('DocumentCategory', 'Activity', false),
        ];
    }
}

if (!function_exists('getIndicatorTypes')) {
    /*
     * Get activity indicator data type
     *
     * @return array
     */
    function getIndicatorTypes(): array
    {
        return [
            'indicatorVocabulary' => getCodeList('IndicatorVocabulary', 'Activity'),
            'indicatorMeasure'    => getCodeList('IndicatorMeasure', 'Activity', false),
            'language'            => getCodeList('Language', 'Activity', false),
            'documentCategory'    => getCodeList('DocumentCategory', 'Activity', false),
            'fileFormat'          => getCodeList('FileFormat', 'Activity', false),
        ];
    }
}

if (!function_exists('getPeriodTypes')) {
    /*
     * Get activity periods data type
     *
     * @return array
     */
    function getPeriodTypes(): array
    {
        return [
            'indicatorMeasure' => getCodeList('IndicatorMeasure', 'Activity', false),
            'language'         => getCodeList('Language', 'Activity', false),
            'documentCategory' => getCodeList('DocumentCategory', 'Activity', false),
            'fileFormat'       => getCodeList('FileFormat', 'Activity', false),
        ];
    }
}

if (!function_exists('generateToastData')) {
    /*
     * Generates toast array.
     *
     * @return array
     */
    function generateToastData(): array
    {
        $toast['message'] = Session::exists('error') ? Session::get('error') : (Session::exists('success') ? Session::get('success') : '');
        $toast['type'] = Session::exists('error') ? false : 'success';
        Session::forget('success');
        Session::forget('error');

        return $toast;
    }
}

if (!function_exists('isCoreElement')) {
    /*
     * Checks if an activity element is a core element
     *
     * @return bool
     */
    function isCoreElement($element): bool
    {
        return in_array($element, getCoreElements());
    }
}

/**
 * Removes empty values.
 *
 * @param $data
 */
function removeEmptyValues(&$data)
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