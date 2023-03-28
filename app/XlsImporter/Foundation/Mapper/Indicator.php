<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Mapper;

use Illuminate\Support\Arr;

/**
 * Class Activity.
 */
class Indicator
{
    // public string $templatePath = app_path().'XlsImporter/Templates';

    //activities whose identifier is mentioned on setting sheet
    protected array $activities = [];

    //
    protected array $activitiesIdentifier = [];

    // activities whose identifier is not mentioned on setting
    protected array $invalidActivities = [];

    /**
     * @var array
     */
    protected array $activityElements = [
    ];

    public function map($activityData)
    {
        // logger()->error(json_encode($activityData));
        file_put_contents(app_path() . '/XlsImporter/Templates/result.json', json_encode($activityData));
        $activityData = json_decode($activityData, true, 512, 0);

        foreach ($activityData as $sheetName => $content) {
            dump($sheetName);
            if ($sheetName === 'Settings') {
                // $this->defaultValues($content);
            }

            if ($sheetName === 'Element with single field') {
                // $this->singleValuedFields($content);
            }

            if (in_array($sheetName, array_keys($this->activityElements))) {
                $this->columnToFieldMapper($this->activityElements[$sheetName], $content);
            }
        }

        dd($this->activities, json_encode($this->activities['289289892']['contact_info']));
    }

    public function getLinearizedActivity()
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/linearized-activity.json'), true, 512, 0);
    }

    public function getDependencies()
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/field-dependencies.json'), true, 512, 0);
    }

    public function getDropDownFields()
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/dropdown-fields.json'), true, 512, 0);
    }

    public function getActivityTemplate()
    {
        return json_decode(file_get_contents('app/XlsImporter/Templates/activity-template.json'), true, 512, 0);
    }

    public function getActivityJsonSchema()
    {
        return readElementJsonSchema();
    }

    public function defaultValues($data)
    {
        foreach ($data as $row) {
            if ($this->checkRowNotEmpty($row)) {
                $elementActivityIdentifier = Arr::get($row, 'activity_identifier', null) ?? $elementActivityIdentifier;
            } else {
                break;
            }
        }
    }

    public function singleValuedFields($data)
    {
        foreach ($data as $row) {
            if ($this->checkRowNotEmpty($row)) {
                $elementActivityIdentifier = Arr::get($row, 'activity_identifier', null) ?? $elementActivityIdentifier;
                foreach ($this->singleValuedElements as $element) {
                    $this->activities[$elementActivityIdentifier][$element] = $row[$element];
                }
            } else {
                break;
            }
        }
    }

    public function str_replace_first($search, $replace, $subject)
    {
        $search = '/' . preg_quote($search, '/') . '/';

        return preg_replace($search, $replace, $subject, 1);
    }

    public function columnToFieldMapper($element, $data = [])
    {
        $elementData = [];
        $columnMapper = $this->getLinearizedActivity();
        $dependency = $this->getDependencies();
        $dropDownFields = $this->getDropDownFields();
        $elementMapper = array_flip($columnMapper[$element]);
        $elementDropDownFields = $dropDownFields[$element];
        $elementActivityIdentifier = null;

        // dd($dependency);

        foreach ($data as $row) {
            if ($this->checkRowNotEmpty($row)) {
                if (
                    is_null($elementActivityIdentifier) || (
                        Arr::get($row, 'activity_identifier', null) &&
                        Arr::get($row, 'activity_identifier', null) !== $elementActivityIdentifier
                    )
                ) {
                    if (!empty($elementData)) {
                        $this->activities[$elementActivityIdentifier][$element] = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields);
                        $elementData = [];
                    }

                    $elementActivityIdentifier = Arr::get($row, 'activity_identifier', null) ?? $elementActivityIdentifier;
                }

                $systemMappedRow = [];

                foreach ($row as $fieldName => $fieldValue) {
                    if (!empty($fieldName) && $fieldName !== 'activity_identifier') {
                        $systemMappedRow[$elementMapper[$fieldName]] = $fieldValue;
                    }
                }

                $elementData[] = $systemMappedRow;
            } else {
                $this->activities[$elementActivityIdentifier][$element] = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields);
                break;
            }
        }
    }

    public function mapDropDownValueToKey($value, $location)
    {
        // should we consider case?
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

    public function getElementData($data, $dependency, $elementDropDownFields): array
    {
        $elementData = [];
        $elementBase = $dependency['elementBase'];
        $elementBasePeer = Arr::get($dependency, 'elementBasePeer', []);
        $baseCount = null;
        $fieldDependency = $dependency['fieldDependency'];
        $parentBaseCount = [];

        // variables to map code dependency in elements like sector, recipient region and so on
        $codeRelation = Arr::get($dependency, 'codeDependency', []);
        $codeDependencyConditions = Arr::get($codeRelation, 'dependencyRelation', []);
        $codeDependentOn = Arr::get($codeRelation, 'dependentOn', '');
        $codeDependentField = Arr::get($codeRelation, 'dependentField', '');
        $defaultCodeField = Arr::get($codeRelation, 'defaultCodeField', '');

        foreach (array_values($fieldDependency) as $dependents) {
            $parentBaseCount[$dependents['parent']] = null;
        }

        foreach ($data as $row) {
            $dependentOnValue = '';

            foreach ($row as $fieldName => $fieldValue) {
                if (($fieldName === $elementBase && $fieldValue)) {
                    $baseCount = is_null($baseCount) ? 0 : $baseCount + 1;
                } elseif ($fieldName === $elementBase && $this->checkIfPeerAttributesAreNotEmpty($elementBasePeer, $row)) {
                    $baseCount = is_null($baseCount) ? 0 : $baseCount + 1;
                }

                if (in_array($fieldName, array_keys($fieldDependency))) {
                    $parentKey = $fieldDependency[$fieldName]['parent'];
                    $peerAttributes = Arr::get($fieldDependency, "$fieldName.peer", []);

                    if ($fieldValue) {
                        $parentBaseCount[$parentKey] = is_null($parentBaseCount[$parentKey]) ? 0 : $parentBaseCount[$parentKey] + 1;
                    } elseif ($this->checkIfPeerAttributesAreNotEmpty($peerAttributes, $row)) {
                        $parentBaseCount[$parentKey] = is_null($parentBaseCount[$parentKey]) ? 0 : $parentBaseCount[$parentKey] + 1;
                    }
                }

                if ($fieldName === $codeDependentField) {
                    $fieldName = in_array($dependentOnValue, array_keys($codeDependencyConditions)) ? Arr::get($codeDependencyConditions, $dependentOnValue, $defaultCodeField) : $defaultCodeField;
                }

                if (in_array($fieldName, array_keys($elementDropDownFields))) {
                    $fieldValue = $this->mapDropDownValueToKey($fieldValue, $elementDropDownFields[$fieldName]);
                }

                if ($fieldName === $codeDependentOn) {
                    $dependentOnValue = $fieldValue;
                }

                $elementPosition = $this->getElementPosition($parentBaseCount, $fieldName);
                $elementPositionBasedOnParent = empty($elementPosition) ? $baseCount : $baseCount . '.' . $elementPosition;

                if (!Arr::get($elementData, $elementPositionBasedOnParent, null)) {
                    Arr::set($elementData, $elementPositionBasedOnParent, $fieldValue);
                }
            }
        }

        return $elementData;
    }

    public function checkIfPeerAttributesAreNotEmpty(array $peerAttributes, array $rowContent): bool
    {
        foreach ($peerAttributes as $attributeName) {
            if (Arr::get($rowContent, $attributeName, null)) {
                return true;
            }
        }

        return false;
    }

    public function getElementPosition($fieldDependency, $dependencies): string
    {
        $position = '';
        $dependency = explode(' ', $dependencies);
        $expected_position = '';

        foreach ($dependency as $key) {
            $expected_position = empty($expected_position) ? $key : "$expected_position $key";

            if (in_array($expected_position, array_keys($fieldDependency))) {
                $positionValue = $fieldDependency[$expected_position];
                $position = empty($position) ? $key . '.' . $positionValue : "$position.$key.$positionValue";
            } else {
                $position = empty($position) ? "$key" : "$position.$key";
            }
        }

        return $position;
    }

    public function checkRowNotEmpty($row)
    {
        if (implode('', array_values($row))) {
            return true;
        }

        return false;
    }
}
