<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Mapper;

use App\IATI\Traits\DataSanitizeTrait;
use App\XlsImporter\Foundation\XlsValidator\Validators\ActivityValidator;
use Illuminate\Support\Arr;

/**
 * Class Activity.
 */
class Activity
{
    use DataSanitizeTrait;

    //activities whose identifier is mentioned on setting sheet
    protected array $activities = [];

    //
    protected array $activitiesIdentifier = [];

    // activities whose identifier is not mentioned on setting
    protected array $invalidActivities = [];

    protected int $rowCount = 2;

    protected string $sheetName = '';

    protected array $columnTracker = [];

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
        // 'Tag' => 'tag',
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

    /**
     * @var array
     */
    protected array $defaultValueElements = [
        'Default Currency' => 'default_currency',
        'Default Language' => 'default_language',
        'Default Hierarchy' => 'default_hierarchy',
        'Default Humanitarian' => 'default_humanitarian',
        'Budget Not Provided' => 'budget_not_provided',
        'Secondary Reporter' => 'secondary_reporter',
    ];

    protected array $enclosedNarrative = [
        'country_budget_items',
        'location',

    ];

    protected string $elementBeingProcessed = '';

    public function map($activityData)
    {
        // logger()->error(json_encode($activityData));
        // file_put_contents(app_path() . '/XlsImporter/Templates/period.json', json_encode($activityData));
        // file_put_contents(app_path() . '/XlsImporter/Templates/indicator.json', json_encode($activityData));
        $activityData = json_decode($activityData, true, 512, 0);

        foreach ($activityData as $sheetName => $content) {
            $this->sheetName = $sheetName;

            if ($sheetName === 'Settings') {
                $this->rowCount = 2;
                $this->defaultValues($content);
            }

            if ($sheetName === 'Element with single field') {
                $this->rowCount = 2;
                $this->singleValuedFields($content);
            }

            if (in_array($sheetName, array_keys($this->activityElements))) {
                $this->rowCount = 2;
                $this->columnToFieldMapper($this->activityElements[$sheetName], $content);
            }
        }

        $this->validateActivityElements();
    }

    public function validateActivityElements()
    {
        $activityValidator = app(ActivityValidator::class);

        foreach ($this->activities as $activityIdentifier => $activities) {
            $errors = $activityValidator
                ->init($activities)
                ->validateData();

            $excelColumnAndRowName = isset($this->columnTracker[$activityIdentifier]) ? Arr::collapse($this->columnTracker[$activityIdentifier]) : null;
            $this->activities[$activityIdentifier]['error'] = $this->appendExcelColumnAndRowDetail($errors, $excelColumnAndRowName);
        }
    }

    public function appendExcelColumnAndRowDetail($errors, $excelColumnAndRowName): array
    {
        foreach ($errors as $errorLevel => $errorData) {
            foreach ($errorData as $element => $error) {
                foreach ($error as $key => $err) {
                    if (isset($excelColumnAndRowName[$key])) {
                        $errors[$errorLevel][$element][$key] .= " ( $excelColumnAndRowName[$key] )";
                    }
                }
            }
        }

        return $errors;
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
        $dropDownFields = $this->getDropDownFields();
        $excelColumnName = $this->getExcelColumnNameMapper();
        $elementActivityIdentifier = null;

        foreach ($data as $row) {
            if ($this->checkRowNotEmpty($row)) {
                $elementActivityIdentifier = Arr::get($row, 'activity_identifier', null) ?? $elementActivityIdentifier;

                foreach ($this->defaultValueElements as $element) {
                    $fieldValue = $row[$element];

                    if (array_key_exists($element, $dropDownFields)) {
                        $elementDropDownFields = $dropDownFields[$element];
                        $fieldValue = $this->mapDropDownValueToKey($row[$element], $elementDropDownFields);
                    }

                    $this->activities[$elementActivityIdentifier]['default_field_values'][$element] = $fieldValue;
                    $this->columnTracker[$element] = $this->sheetName . '!' . Arr::get($excelColumnName, $this->sheetName . '.' . $element) . $this->rowCount;
                }
            } else {
                break;
            }

            $this->rowCount++;
            $secondary_reporter = $this->activities[$elementActivityIdentifier]['default_field_values']['secondary_reporter'];
            $this->activities[$elementActivityIdentifier]['reporting_org'] = $this->getReportingOrganization($secondary_reporter);
            $this->activities[$elementActivityIdentifier]['iati_identifier'] = [
                'activity_identifier' => $elementActivityIdentifier,
            ];
        }
    }

    /**
     * Returns reporting organization data from organization.
     *
     * @param $secondary_reporter
     *
     * @return array
     */
    public function getReportingOrganization($secondary_reporter): array
    {
        $organizationReportingOrg = auth()->user()->organization->reporting_org;

        if (!empty($organizationReportingOrg)) {
            $organizationReportingOrg[0]['secondary_reporter'] = $secondary_reporter;

            return $organizationReportingOrg;
        }

        return [
            [
                'ref' => '',
                'type' => '',
                'secondary_reporter' => $secondary_reporter,
                'narrative' => [
                    [
                        'narrative' => '',
                        'language' => '',
                    ],
                ],
            ],
        ];
    }

    public function singleValuedFields($data)
    {
        $dropDownFields = $this->getDropDownFields();
        $elementActivityIdentifier = null;
        foreach ($data as $row) {
            if ($this->checkRowNotEmpty($row)) {
                $elementActivityIdentifier = Arr::get($row, 'activity_identifier', null) ?? $elementActivityIdentifier;

                foreach ($this->singleValuedElements as $element) {
                    $fieldValue = $row[$element];

                    if (array_key_exists($element, $dropDownFields)) {
                        $elementDropDownFields = $dropDownFields[$element];
                        $fieldValue = $this->mapDropDownValueToKey($row[$element], $elementDropDownFields);
                    }
                    $this->activities[$elementActivityIdentifier][$element] = $fieldValue;
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
        $this->elementBeingProcessed = $element;

        foreach ($data as $row) {
            if ($this->checkRowNotEmpty($row)) {
                if (
                    is_null($elementActivityIdentifier) || (
                        Arr::get($row, 'activity_identifier', null) &&
                        Arr::get($row, 'activity_identifier', null) !== $elementActivityIdentifier
                    )
                ) {
                    if (!empty($elementData)) {
                        $this->activities[$elementActivityIdentifier][$element] = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $elementActivityIdentifier, $element);
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
                $this->activities[$elementActivityIdentifier][$element] = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $elementActivityIdentifier, $element);
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

        return Arr::get($dropDownValues, $value, $value);
    }

    public function getElementData($data, $dependency, $elementDropDownFields, $elementActivityIdentifier, $element): array
    {
        $elementData = [];
        $elementBase = Arr::get($dependency, 'elementBase', null);
        $elementBasePeer = Arr::get($dependency, 'elementBasePeer', []);
        $baseCount = null;
        $fieldDependency = $dependency['fieldDependency'];
        $parentBaseCount = [];
        $excelColumnName = $this->getExcelColumnNameMapper();

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
                if ($elementBase && ($fieldName === $elementBase && $fieldValue)) {
                    $dependentOnValue = '';
                    $baseCount = is_null($baseCount) ? 0 : $baseCount + 1;
                } elseif ($elementBase && ($fieldName === $elementBase && $this->checkIfPeerAttributesAreNotEmpty($elementBasePeer, $row))) {
                    $dependentOnValue = '';
                    $baseCount = is_null($baseCount) ? 0 : $baseCount + 1;
                }

                if (array_key_exists($fieldName, $fieldDependency)) {
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

                if (array_key_exists($fieldName, $elementDropDownFields)) {
                    $fieldValue = $this->mapDropDownValueToKey($fieldValue, $elementDropDownFields[$fieldName]);
                }

                // check for non empty.. including zero
                if ($fieldName === $codeDependentOn && $fieldValue) {
                    $dependentOnValue = $fieldValue;
                }

                $elementPosition = $this->getElementPosition($parentBaseCount, $fieldName);
                $elementPositionBasedOnParent = $elementBase ? (empty($elementPosition) ? $baseCount : $baseCount . '.' . $elementPosition) : $elementPosition;

                if (!Arr::get($elementData, $elementPositionBasedOnParent, null)) {
                    Arr::set($elementData, $elementPositionBasedOnParent, $fieldValue);
                    $this->columnTracker[$elementActivityIdentifier][$element][$element . '.' . $elementPositionBasedOnParent] = $this->sheetName . '!' . Arr::get($excelColumnName, $this->sheetName . '.' . $fieldName) . $this->rowCount;
                }
            }
            $this->rowCount++;
        }

        return $this->sanitizeData($elementData);
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
                if (in_array($this->elementBeingProcessed, $this->enclosedNarrative)) {
                    $key = $key === 'narrative' ? '0.narrative' : $key;
                }

                $positionValue = $fieldDependency[$expected_position];
                $position = empty($position) ? $key . '.' . $positionValue : "$position.$key.$positionValue";
            } else {
                $position = empty($position) ? "$key" : "$position.$key";
            }
        }

        return $position;
    }

    public function getExcelColumnNameMapper()
    {
        return json_decode(file_get_contents(app_path('/XlsImporter/Templates/excel-column-name-mapper.json')), true, 512, JSON_THROW_ON_ERROR);
    }

    public function checkRowNotEmpty($row)
    {
        if (implode('', array_values($row))) {
            return true;
        }

        return false;
    }
}
