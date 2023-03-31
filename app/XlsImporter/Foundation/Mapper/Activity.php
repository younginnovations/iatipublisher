<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Mapper;

use App\XlsImporter\Foundation\XlsValidator\Validators\ActivityValidator;
use Illuminate\Support\Arr;

/**
 * Class Activity.
 */
class Activity
{
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
        // 'Title' => 'title',
        // 'Other Identifier' => 'other_identifier',
        // 'Description' => 'description',
        // 'Activity Date' => 'activity_date',
        // 'Recipient Country' => 'recipient_country',
        // 'Recipient Region' => 'recipient_region',
        // 'Sector' => 'sector',
        'Tag' => 'tag',
        // 'Policy Marker' => 'policy_marker',
        // 'Default Aid Type' => 'default_aid_type',
        // 'Country Budget Items' => 'country_budget_items',
        // 'Humanitarian Scope' => 'humanitarian_scope',
        // 'Related Activity' => 'related_activity',
        // 'Conditions' => 'conditions',
        // 'Legacy Data' => 'legacy_data',
        // 'Document Link' => 'document_link',
        // 'Contact Info' => 'contact_info',
        // 'Location' => 'location',
        // 'Planned Disbursement' => 'planned_disbursement',
        // 'Participating Org' => 'participating_org',
        // 'Budget' => 'budget',
        // 'Transaction' => 'transactions',
    ];

    protected array $singleValuedElements = [
        'activity_status',
        'activity_scope',
        'collaboration_type',
        'default_flow_type',
        'default_finance_type',
        'default_tied_status',
        'capital_spend',
    ];

    public function map($activityData)
    {
        // logger()->error(json_encode($activityData));
        // file_put_contents(app_path() . '/XlsImporter/Templates/period.json', json_encode($activityData));
        // file_put_contents(app_path() . '/XlsImporter/Templates/indicator.json', json_encode($activityData));
        $activityData = json_decode($activityData, true, 512, 0);

        foreach ($activityData as $sheetName => $content) {
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

        $this->validateActivityElements();
    }

    public function validateActivityElements()
    {
        $activityValidator = app(ActivityValidator::class);
        $errors = [];

        foreach ($this->activities as $activityIdentifier => $activities) {
            dump($activities);
            dump(json_encode($activities));
            $errors[] = $activityValidator
                ->init($activities)
                ->validateData();
        }

        dd($errors);
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

    public function columnToFieldMapper($element, $data = [])
    {
        $elementData = [];
        $columnMapper = $this->getLinearizedActivity();
        $dependency = $this->getDependencies();
        $dropDownFields = $this->getDropDownFields();
        $elementMapper = array_flip($columnMapper[$element]);
        $elementDropDownFields = $dropDownFields[$element];
        $elementActivityIdentifier = null;

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
        $dependentOnValue = '';

        foreach (array_values($fieldDependency) as $dependents) {
            $parentBaseCount[$dependents['parent']] = null;
        }

        foreach ($data as $row) {
            foreach ($row as $fieldName => $fieldValue) {
                if (($fieldName === $elementBase && $fieldValue)) {
                    $dependentOnValue = '';
                    $baseCount = is_null($baseCount) ? 0 : $baseCount + 1;
                } elseif ($fieldName === $elementBase && $this->checkIfPeerAttributesAreNotEmpty($elementBasePeer, $row)) {
                    $dependentOnValue = '';
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

                // dump($fieldName, $codeDependentField);
                if ($fieldName === $codeDependentField) {
                    dump('-------------------', $fieldName, 'dependentOnValue', $dependentOnValue, 'dependency', $codeDependencyConditions, 'fieldName', $fieldName);
                    $fieldName = in_array($dependentOnValue, array_keys($codeDependencyConditions)) ? Arr::get($codeDependencyConditions, $dependentOnValue, $defaultCodeField) : $defaultCodeField;
                    dump($fieldName, '---------');
                }

                if (in_array($fieldName, array_keys($elementDropDownFields))) {
                    $fieldValue = $this->mapDropDownValueToKey($fieldValue, $elementDropDownFields[$fieldName]);
                }

                // check for non empty.. including zero
                if ($fieldName === $codeDependentOn && $fieldValue) {
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
                // $key = $key === 'narrative' ? '0.narrative' : $key;
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
