<?php

declare(strict_types=1);

namespace App\IATI\Traits;

/**
 * Class MigrateGeneralTrait.
 */
trait MigrateGeneralTrait
{
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
}
