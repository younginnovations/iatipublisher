<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Session;

if (!function_exists('getCoreElements')) {
    /**
     * Returns Core Elements.
     *
     * @return array
     */
    function getCoreElements(): array
    {
        return [
            'title'                => true,
            'description'          => true,
            'budget'               => true,
            'transactions'         => true,
            'sector'               => true,
            'participating_org'    => true,
            'activity_status'      => true,
            'activity_date'        => true,
            'recipient_country'    => true,
            'recipient_region'     => true,
            'collaboration_type'   => true,
            'default_flow_type'    => true,
            'default_finance_type' => true,
            'default_aid_type'     => true,
        ];
    }
}

if (!function_exists('coreElementCompleted')) {
    /**
     * Checks if all core elements are complete.
     *
     * @param $elementStatus
     *
     * @return bool
     */
    function coreElementCompleted($elementStatus): bool
    {
        return empty(array_diff_assoc(getCoreElements(), $elementStatus));
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

if (!function_exists('getElementSchema')) {
    /**
     * Returns element schema.
     *
     * @throws JsonException
     */
    function getElementSchema($element): array
    {
        $elementJsonSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true, 512, JSON_THROW_ON_ERROR);

        return getArr($elementJsonSchema, $element);
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

/*
 * Get activity transaction data type
 *
 * @return array
 */
if (!function_exists('getTransactionTypes')) {
    function getTransactionTypes(): array
    {
        return [
            'transactionType'           => getCodeList('TransactionType', 'Activity', false),
            'organizationType'          => getCodeList('OrganizationType', 'Organization', false),
            'disbursementChannel'       => getCodeList('DisbursementChannel', 'Activity', false),
            'sectorVocabulary'          => getCodeList('SectorVocabulary', 'Activity', false),
            'sectorCode'                => getCodeList('SectorCode', 'Activity', false),
            'sectorCategory'            => getCodeList('SectorCategory', 'Activity', false),
            'unsdgGoals'                => getCodeList('UNSDG-Goals', 'Activity', false),
            'unsdgTargets'              => getCodeList('UNSDG-Targets', 'Activity', false),
            'countryCode'               => getCodeList('Country', 'Activity', false),
            'regionCode'                => getCodeList('RegionVocabulary', 'Activity', false),
            'flowType'                  => getCodeList('FlowType', 'Activity', false),
            'financeType'               => getCodeList('FinanceType', 'Activity', false),
            'tiedStatusType'            => getCodeList('TiedStatus', 'Activity', false),
            'aidTypeVocabulary'         => getCodeList('AidTypeVocabulary', 'Activity', false),
            'aidType'                   => getCodeList('AidType', 'Activity', false),
            'cashAndVoucherModalities'  => getCodeList('CashandVoucherModalities', 'Activity', false),
            'earMarkingCategory'        => getCodeList('EarmarkingCategory', 'Activity', false),
            'earMarkingModality'        => getCodeList('EarmarkingModality', 'Activity', false),
            'languages'                 => getCodeList('Language', 'Activity', false),
        ];
    }
}

/*
 * Get activity result data type
 *
 * @return array
 */
if (!function_exists('getResultTypes')) {
    function getResultTypes(): array
    {
        return [
            'resultType'                => getCodeList('ResultType', 'Activity', false),
            'resultVocabulary'          => getCodeList('ResultVocabulary', 'Activity', false),
            'indicatorMeasure'          => getCodeList('IndicatorMeasure', 'Activity', false),
            'language'                  => getCodeList('Language', 'Activity', false),
            'documentCategory'          => getCodeList('DocumentCategory', 'Activity', false),
        ];
    }
}

/*
 * Get activity indicator data type
 *
 * @return array
 */
if (!function_exists('getIndicatorTypes')) {
    function getIndicatorTypes(): array
    {
        return [
            'indicatorVocabulary'       => getCodeList('IndicatorVocabulary', 'Activity'),
            'indicatorMeasure'          => getCodeList('IndicatorMeasure', 'Activity', false),
            'language'                  => getCodeList('Language', 'Activity', false),
            'documentCategory'          => getCodeList('DocumentCategory', 'Activity', false),
            'fileFormat'                => getCodeList('FileFormat', 'Activity', false),
        ];
    }
}

/*
 * Get activity periods data type
 *
 * @return array
 */
if (!function_exists('getPeriodTypes')) {
    function getPeriodTypes(): array
    {
        return [
            'indicatorMeasure'          => getCodeList('IndicatorMeasure', 'Activity', false),
            'language'                  => getCodeList('Language', 'Activity', false),
            'documentCategory'          => getCodeList('DocumentCategory', 'Activity', false),
            'fileFormat'                => getCodeList('FileFormat', 'Activity', false),
        ];
    }
}

    /*
     * Generates toast array.
     *
     * @return array
     */
if (!function_exists('generateToastData')) {
    function generateToastData(): array
    {
        $toast['message'] = Session::exists('error') ? Session::get('error') : (Session::exists('success') ? Session::get('success') : '');
        $toast['type'] = Session::exists('error') ? false : 'success';
        Session::forget('success');
        Session::forget('error');

        return $toast;
    }
}
