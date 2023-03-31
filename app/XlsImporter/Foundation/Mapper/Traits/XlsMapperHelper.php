<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Mapper\Traits;

use Illuminate\Support\Arr;

/**
 * Trait XlsMapperHelper.
 */
trait XlsMapperHelper
{
    /**
     * Returns content of linearized-activity json file which contains mapping of system field name to column name present in xls sheet.
     *
     * @return array
     */
    public function getLinearizedActivity(): array
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/linearized-activity.json'), true, 512, 0);
    }

    /**
     * Returns content of field-dependencies json file which maps the dependency of element and subelement on attributes and other fields.
     *
     * @return array
     */
    public function getDependencies(): array
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/field-dependencies.json'), true, 512, 0);
    }

    /**
     * Returns content of dropdown-field which contains list of all the select fields and corresponding file that contains the dropdown options.
     *
     * @return array
     */
    public function getDropDownFields(): array
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/dropdown-fields.json'), true, 512, 0);
    }

    /**
     * Returns content of excel-column-name-mapper which contains column name and column position in excel file.
     *
     * @return array
     */
    public function getExcelColumnNameMapper(): array
    {
        return json_decode(file_get_contents(app_path('/XlsImporter/Templates/excel-column-name-mapper.json')), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Returns content of activity-template which contains basic structure of element and subelement in the system.
     *
     * @return array
     */
    public function getActivityTemplate(): array
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/activity-template.json'), true, 512, 0);
    }

    /**
     * Maps the dropdown values to their corresponding keys.
     *
     * @return mixed
     */
    public function mapDropDownValueToKey($value, $location): mixed
    {
        // should we consider case(capital and lower)?
        if (is_null($value)) {
            return $value;
        }

        if (is_array($location)) {
            return Arr::get($location, $value, $value);
        }

        $locationArr = explode('/', $location);

        $dropDownValues = array_flip(getCodeList(explode('.', $locationArr[1])[0], $locationArr[0]));
        $key = Arr::get($dropDownValues, $value, $value);

        return $key;
    }

    /**
     * Checks if the peer attributes of an attributes are not empty.
     *
     * @return bool
     */
    public function checkIfPeerAttributesAreNotEmpty(array $peerAttributes, array $rowContent): bool
    {
        foreach ($peerAttributes as $attributeName) {
            if (Arr::get($rowContent, $attributeName, null)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if excel row is not empty.
     *
     * @return bool
     */
    public function checkRowNotEmpty($row): bool
    {
        if (implode('', array_values($row))) {
            return true;
        }

        return false;
    }

    /**
     * Returns position of a field in the element.
     *
     * @return string
     */
    public function getElementPosition($fieldDependency, $dependencies): string
    {
        $position = '';
        $dependency = explode(' ', $dependencies);
        $expected_position = '';

        foreach ($dependency as $key) {
            $expected_position = empty($expected_position) ? $key : "$expected_position $key";

            if (in_array($expected_position, array_keys($fieldDependency))) {
                $key = $key === 'narrative' ? '0.narrative' : $key;
                $positionValue = $fieldDependency[$expected_position] ?? 0;
                $position = empty($position) ? $key . '.' . $positionValue : "$position.$key.$positionValue";
            } else {
                $position = empty($position) ? "$key" : "$position.$key";
            }
        }

        return $position;
    }
}
