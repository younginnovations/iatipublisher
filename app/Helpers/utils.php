<?php

declare(strict_types=1);

use App\Constants\Enums;
use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Organization\Organization;
use Illuminate\Support\Arr;

if (!function_exists('trimInput')) {
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
}

if (!function_exists('dateFormat')) {
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
}

if (!function_exists('isDate')) {
    /**
     * Returns formatted date.
     *
     * @param $format
     * @param $date
     *
     * @return false
     */
    function isDate($date): bool
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
                return true;
            }

            return false;
        }

        return false;
    }
}

if (!function_exists('dateStrToTime')) {
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

if (!function_exists('is_array_value_empty')) {
    /**
     * Checks if array | nested array values are null or empty string.
     *
     * @param $array
     *
     * @return bool
     */
    function is_array_value_empty($array): bool
    {
        $array = empty($array) || !is_array($array) ? [] : $array;
        $flatArray = Arr::flatten($array);
        $value = array_filter($flatArray, static function ($q) {
            return $q;
        });

        return empty($value);
    }
}

if (!function_exists('group_by')) {
    /**
     * Function that groups an array of associative arrays by some key.
     *
     * @param {String} $key Property to sort by.
     * @param {Array} $data Array that stores multiple associative arrays.
     */
    function group_by($key, $data)
    {
        $result = [];

        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                $result[$val[$key]] = $val;
            } else {
                $result[''] = $val;
            }
        }

        return $result;
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

if (!function_exists('getEncodingType')) {
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
        } catch (Exception $exception) {
            return 'UTF-8';
        }
    }
}

if (!function_exists('generateRandomCharacters')) {
    /**
     * Function to generate random characters mix of digit and alphabets.
     *
     * @param $length
     *
     * @return string
     */
    function generateRandomCharacters($length): string
    {
        return substr(str_shuffle('0123456789abcdefghilkmnopqrstuvwxyz'), 0, $length);
    }
}

if (!function_exists('removeSingleActivityXmlFromMergedActivitiesXml')) {
    /**
     * Given mergedXml and iati-identifier of undesired(to be unpublished) activity, it removes corresponding activity from mergedXml and return the mergedXml.
     *
     * @param SimpleXMLElement $mergedXml
     * @param $targetedIatiIdentifier
     *
     * @return SimpleXMLElement
     */
    function removeSingleActivityXmlFromMergedActivitiesXml(SimpleXMLElement $mergedXml, $targetedIatiIdentifier): SimpleXMLElement
    {
        $matchingActivitiesUntrimmed = $mergedXml->xpath("//iati-activity[normalize-space(iati-identifier) = '$targetedIatiIdentifier']");

        if (!empty($matchingActivitiesUntrimmed)) {
            foreach ($matchingActivitiesUntrimmed as $matchingActivity) {
                $dom = dom_import_simplexml($matchingActivity);
                $dom->parentNode->removeChild($dom);
            }
        }

        $trimmedTargetIdentifierText = trim($targetedIatiIdentifier);
        $matchingActivitiesTrimmed = $mergedXml->xpath("//iati-activity[normalize-space(iati-identifier) = '$trimmedTargetIdentifierText']");

        if (!empty($matchingActivitiesTrimmed)) {
            foreach ($matchingActivitiesTrimmed as $matchingActivity) {
                $dom = dom_import_simplexml($matchingActivity);
                $dom->parentNode->removeChild($dom);
            }
        }

        return $mergedXml;
    }
}

if (!function_exists('getFileIdentifier')) {
    /**
     * Returns the suffix of filename if syntax is: publisher_identifier-SUFFIX.xml.
     *
     * @param string $filename
     * @return string
     */
    function getFileIdentifier(string $filename): string
    {
        $lastHyphenPosition = strrpos($filename, '-');
        $dotXmlPosition = strpos($filename, '.xml');
        $fileIdentifier = '';

        if ($lastHyphenPosition !== false && $dotXmlPosition !== false) {
            $fileIdentifier = substr($filename, $lastHyphenPosition + 1, $dotXmlPosition - $lastHyphenPosition - 1);
        }

        return $fileIdentifier;
    }
}

if (!function_exists('removeClosingIatiActivitiesTag')) {
    /**
     * Remove the last '</iati-activities>' from merged xml.
     *
     * @param string $xmlContent
     *
     * @return string
     */
    function removeClosingIatiActivitiesTag(string $xmlContent): string
    {
        $lastPos = strrpos($xmlContent, '</iati-activities>');

        if ($lastPos !== false) {
            $xmlContent = substr_replace($xmlContent, '', $lastPos, strlen('</iati-activities>'));
        }

        return trim($xmlContent);
    }
}

if (!function_exists('getOldActivityIdentifierTexts')) {
    /**
     * Generates all possible old activity identifiers if $organization->old_identifier is not empty.
     *
     * @param Organization $organization
     * @param Activity $activity
     *
     * @return array
     */
    function getOldActivityIdentifierTexts(Organization $organization, Activity $activity): array
    {
        $oldActivityIdentifiers = [];
        $oldOrgIdentifiers = $organization->old_identifiers;

        if (empty($oldOrgIdentifiers)) {
            return $oldActivityIdentifiers;
        }

        foreach ($oldOrgIdentifiers as $oldOrgIdentifier) {
            $orgIdentifier = $oldOrgIdentifier['identifier'];
            $activityIdentifier = $activity->iati_identifier['activity_identifier'];
            $oldActivityIdentifiers[] = "$orgIdentifier-$activityIdentifier";
        }

        return $oldActivityIdentifiers;
    }
}

if (!function_exists('preventMalformedXmlIfNoActivityNode')) {
    /**
     * For some reason, `iati-activities` in xml is being converted to a single tagged element when there are 0 child nodes.
     * Since `iati-activities` is expected to be a paired tagged element, we return a new empty iati-activities if there's no child node.
     *
     * @param string $xmlContent
     *
     * @return string
     */
    function preventMalformedXmlIfNoActivityNode(string $xmlContent): string
    {
        $hasNoActivity = !str_contains($xmlContent, '<iati-activity');

        if ($hasNoActivity) {
            return getEmptyIatiActivitiesXml();
        }

        return $xmlContent;
    }
}

if (!function_exists('getEmptyIatiActivitiesXml')) {
    /**
     * Returns an empty <iati-activities></iati-activities> as string.
     *
     * @return string
     */
    function getEmptyIatiActivitiesXml(): string
    {
        return "<?xml version='1.0' encoding='UTF-8'?>
                    <iati-activities version='" . Enums::IATI_XML_VERSION . "' generated-datetime='" . gmdate('c') . "' >
                    </iati-activities>
        ";
    }
}

if (!function_exists('hasOnlyEmptyValues')) {
    /**
     * Checks if array has empty string or null values in every index or depth.
     *
     * @param array $arr
     *
     * @return bool
     */
    function hasOnlyEmptyValues(array $arr): bool
    {
        foreach ($arr as $value) {
            if (is_array($value)) {
                if (!hasOnlyEmptyValues($value)) {
                    return false;
                }
            } elseif (trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }
}
