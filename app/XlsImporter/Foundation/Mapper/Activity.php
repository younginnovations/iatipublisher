<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Mapper;

use App\XlsImporter\Foundation\Mapper\Traits\XlsMapperHelper;
use App\XlsImporter\Foundation\XlsValidator\Validators\ActivityValidator;
use Illuminate\Support\Arr;

/**
 * Class Activity.
 */
class Activity
{
    use XlsMapperHelper {
        getElementPosition as getElementPosition;
    }

    //activities whose identifier is mentioned on setting sheet
    protected array $activities = [];

    /**
     * total number of activities.
     */
    protected int $totalCount = 0;

    /**
     * total number of processed count.
     */
    protected int $processedCount = 0;

    /**
     * @var array
     */
    protected array $activitiesIdentifier = [];

    protected array $existingIdentifier = [];

    /**
     * @var array
     */
    protected array $duplicateIdentifiers = [];

    /**
     * @var int
     */
    protected int $rowCount = 2;

    /**
     * name of sheet currently being processed.
     *
     * @var string
     */
    protected string $sheetName = '';

    /**
     * @var array
     */
    protected array $columnTracker = [];

    /**
     * @var array
     */
    protected array $activityElements = [
        'Title' => 'title',
        'Other Identifier' => 'other_identifier',
        'Description' => 'description',
        'Activity Date' => 'activity_date',
        'Recipient Country' => 'recipient_country',
        'Recipient Region' => 'recipient_region',
        'Sector' => 'sector',
        'Tag' => 'tag',
        'Policy Marker' => 'policy_marker',
        'Default Aid Type' => 'default_aid_type',
        'Country Budget Items' => 'country_budget_items',
        'Humanitarian Scope' => 'humanitarian_scope',
        'Related Activity' => 'related_activity',
        'Conditions' => 'conditions',
        'Legacy Data' => 'legacy_data',
        'Document Link' => 'document_link',
        'Contact Info' => 'contact_info',
        'Location' => 'location',
        'Planned Disbursement' => 'planned_disbursement',
        'Participating Org' => 'participating_org',
        'Budget' => 'budget',
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
        'default_currency',
        'default_language',
        'hierarchy',
        'humanitarian',
        'budget_not_provided',
    ];

    protected array $enclosedNarrative = [
        'country_budget_items',
        'location',
        'contact_info',
        'document_link',
        'transaction',
    ];

    protected string $elementBeingProcessed = '';

    protected string $statusFilePath = '';
    protected string $validatedDataFilePath = '';
    protected array $organizationReportingOrg = [];

    public function initMapper($validatedDataFilePath, $statusFilePath, $existingIdentifier)
    {
        $this->validatedDataFilePath = $validatedDataFilePath;
        $this->statusFilePath = $statusFilePath;
        $this->existingIdentifier = $existingIdentifier;
    }

    public function fillOrganizationReportingOrg($organizationReportingOrg = []): static
    {
        $this->organizationReportingOrg = $organizationReportingOrg;

        return $this;
    }

    public function getActivityData(): array
    {
        return $this->activities[array_key_first($this->activities)];
    }

    public function map($activityData): static
    {
        foreach ($activityData as $sheetName => $content) {
            $this->sheetName = $sheetName;
            $this->rowCount = 2;

            if ($sheetName === 'Settings') {
                $this->defaultValues($content);
            }

            if ($sheetName === 'Element with single field') {
                $this->singleValuedFields($content);
            }

            if (in_array($sheetName, array_keys($this->activityElements))) {
                $this->columnToFieldMapper($this->activityElements[$sheetName], $content);
            }
        }

        return $this;
    }

    public function validateAndStoreData(): void
    {
        $activityValidator = app(ActivityValidator::class);
        $this->totalCount = count($this->activities);

        foreach ($this->activities as $activityIdentifier => $activity) {
            $errors = $activityValidator
                ->init($activity)
                ->validateData();
            $this->processedCount++;

            $excelColumnAndRowName = isset($this->columnTracker[$activityIdentifier]) ? Arr::collapse($this->columnTracker[$activityIdentifier]) : null;
            $error = $this->appendExcelColumnAndRowDetail($errors, $excelColumnAndRowName);
            // $existingId = in_array($activityIdentifier, array_keys($this->existingIdentifier, false);
            $existingId = Arr::get($this->existingIdentifier, $activityIdentifier, false);

            if (in_array($activityIdentifier, array_keys($this->duplicateIdentifiers))) {
                $error['critical']['iati_identifier'][] = 'The activity identifier has been duplicated';
            }

            if (!in_array($activityIdentifier, $this->activitiesIdentifier)) {
                $error['critical']['iati_identifier'][] = 'The activity identifier has not been mentioned on setting sheet.';
            }

            $this->storeValidatedData($activity, $error, $existingId);
        }

        $this->updateStatus();
    }

    public function defaultValues($data): void
    {
        $dropDownFields = $this->getDropDownFields();
        $excelColumnName = $this->getExcelColumnNameMapper();
        $elementActivityIdentifier = null;

        foreach ($data as $row) {
            $secondary_reporter = '';
            if ($this->checkRowNotEmpty($row)) {
                $secondary_reporter = $row['secondary_reporter'];

                unset($row['secondary_reporter']);

                $elementActivityIdentifier = Arr::get($row, 'activity_identifier', null) ?? $elementActivityIdentifier;

                if (in_array($elementActivityIdentifier, $this->activitiesIdentifier)) {
                    $this->duplicateIdentifiers[] = $elementActivityIdentifier;
                } else {
                    $this->activitiesIdentifier[] = $elementActivityIdentifier;
                }

                foreach ($this->defaultValueElements as $element) {
                    $fieldValue = $row[$element];

                    if (array_key_exists($element, $dropDownFields['default_field_values'])) {
                        $elementDropDownFields = $dropDownFields['default_field_values'][$element];
                        $fieldValue = $this->mapDropDownValueToKey($row[$element], $elementDropDownFields);
                    }

                    $this->activities[$elementActivityIdentifier]['default_field_values'][$element] = is_numeric($fieldValue) ? (string) $fieldValue : $fieldValue;
                    $this->columnTracker[$element]['sheet'] = $this->sheetName;
                    $this->columnTracker[$element]['cell'] = Arr::get($excelColumnName, $this->sheetName . '.' . $element) . $this->rowCount;
                }
            } else {
                break;
            }

            $this->rowCount++;
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
        if (!empty($this->organizationReportingOrg)) {
            $activityRef = $this->organizationReportingOrg;
            $activityRef[0]['secondary_reporter'] = $secondary_reporter;

            return $activityRef;
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

                foreach ($elementMapper as $xlsColumnName => $systemName) {
                    $systemMappedRow[$systemName] = $row[$xlsColumnName];
                }

                $elementData[] = $systemMappedRow;
            } else {
                $this->activities[$elementActivityIdentifier][$element] = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $elementActivityIdentifier, $element);
                $elementData = [];
                break;
            }
        }

        if (!empty($elementData)) {
            if (in_array($elementActivityIdentifier, $this->activitiesIdentifier)) {
                $this->activities[$elementActivityIdentifier][$element] = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $elementActivityIdentifier, $element);
            }
            $elementData = [];
        }
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
        $codeDependencyCondition = Arr::get($dependency, 'codeDependency.dependencyCondition', []);
        $dependentOn = Arr::get($dependency, 'codeDependency.dependentOn', []);
        $dependentOnValue = array_fill_keys(array_values($dependentOn), null);

        foreach (array_values($fieldDependency) as $dependents) {
            $parentBaseCount[$dependents['parent']] = null;
        }

        foreach ($data as $row) {
            foreach ($row as $fieldName => $fieldValue) {
                if ($elementBase && ($fieldName === $elementBase && ($fieldValue || $this->checkIfPeerAttributesAreNotEmpty($elementBasePeer, $row)))) {
                    $baseCount = is_null($baseCount) ? 0 : $baseCount + 1;
                    $parentBaseCount = array_fill_keys(array_keys($parentBaseCount), null);
                    $dependentOnValue = array_fill_keys(array_values($dependentOn), null);
                }

                if (array_key_exists($fieldName, $fieldDependency)) {
                    $parentKey = $fieldDependency[$fieldName]['parent'];
                    $peerAttributes = Arr::get($fieldDependency, "$fieldName.peer", []);
                    $children = Arr::get($fieldDependency, "$fieldName.children", []);
                    $parentAddMore = Arr::get($fieldDependency, "$fieldName.add_more", true);

                    if ($fieldValue || $this->checkIfPeerAttributesAreNotEmpty($peerAttributes, $row)) {
                        $parentBaseCount[$parentKey] = is_null($parentBaseCount[$parentKey]) || !$parentAddMore ? 0 : $parentBaseCount[$parentKey] + 1;

                        foreach ($children as $child) {
                            $parentBaseCount[$child] = null;
                        }
                    }
                }

                if (!empty($dependentOn) && in_array($fieldName, array_keys($dependentOn), false)) {
                    $dependentOnFieldName = $dependentOn[$fieldName];
                    $dependentOnFieldValue = $dependentOnValue[$dependentOnFieldName];
                    $dependencyCondition = $codeDependencyCondition[$dependentOnFieldName];
                    $defaultField = $dependencyCondition['defaultCodeField'];

                    $fieldName = $dependentOnFieldValue ? Arr::get($dependencyCondition, "dependencyRelation.$dependentOnFieldValue", $defaultField) : $fieldName;
                }

                if (array_key_exists($fieldName, $elementDropDownFields)) {
                    $fieldValue = $this->mapDropDownValueToKey($fieldValue, $elementDropDownFields[$fieldName]);
                }

                // check for non empty.. including zero
                if (in_array($fieldName, array_keys($dependentOnValue), false) && $fieldValue) {
                    $dependentOnValue[$fieldName] = $fieldValue;
                }

                $elementPosition = $this->getActivityElementPosition($parentBaseCount, $fieldName);
                $elementPositionBasedOnParent = $elementBase ? (empty($elementPosition) ? $baseCount : $baseCount . '.' . $elementPosition) : $elementPosition;
                if (is_null(Arr::get($elementData, $elementPositionBasedOnParent, null)) && !empty($elementPosition)) {
                    $fieldValue = is_numeric($fieldValue) ? (string) $fieldValue : $fieldValue;
                    Arr::set($elementData, $elementPositionBasedOnParent, $fieldValue);
                    $this->columnTracker[$elementActivityIdentifier][$element][$element . '.' . $elementPositionBasedOnParent]['sheet'] = $this->sheetName;
                    $this->columnTracker[$elementActivityIdentifier][$element][$element . '.' . $elementPositionBasedOnParent]['cell'] = Arr::get($excelColumnName, $this->sheetName . '.' . $fieldName) . $this->rowCount;
                }
            }

            $this->rowCount++;
        }

        return $elementData;
    }

    public function getActivityElementPosition($fieldDependency, $dependencies): string
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

                $positionValue = $fieldDependency[$expected_position] ?? 0;
                $position = empty($position) ? $key . '.' . $positionValue : "$position.$key.$positionValue";
            } else {
                $position = empty($position) ? "$key" : "$position.$key";
            }
        }

        return $position;
    }
}
