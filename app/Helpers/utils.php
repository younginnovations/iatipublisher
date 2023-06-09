<?php

declare(strict_types=1);

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

if (!function_exists('is_array_value_null')) {
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
    function group_by($key, $data): array
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
        } catch (\Exception $exception) {
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

function sentenceToSnakecase($string)
{
    return str_replace(' ', '_', $string);
}
