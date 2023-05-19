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
        'Transaction' => 'transactions',
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
        'transactions',
    ];

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
    protected array $trackIdentifierBySheet = [];

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

    protected array $globalErrors = [];

    protected array $processingErrors = [];
    protected array $tempErrors = [];

    protected string $elementBeingProcessed = '';

    protected string $statusFilePath = '';
    protected string $validatedDataFilePath = '';

    protected string $globalErrorFilePath = '';

    protected array $organizationReportingOrg = [];

    public function initMapper($validatedDataFilePath, $statusFilePath, $globalErrorFilePath, $existingIdentifier)
    {
        $this->validatedDataFilePath = $validatedDataFilePath;
        $this->statusFilePath = $statusFilePath;
        $this->globalErrorFilePath = $globalErrorFilePath;
        $this->existingIdentifier = $existingIdentifier;
    }

    public function fillOrganizationReportingOrg($organizationReportingOrg = []): static
    {
        $this->organizationReportingOrg = $organizationReportingOrg ?? [];

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
            $existingId = Arr::get($this->existingIdentifier, $activityIdentifier, false);

            if (!in_array($activityIdentifier, $this->activitiesIdentifier)) {
                $error['critical']['iati_identifier']['settings'] = 'The activity identifier has not been mentioned on setting sheet.';
            }

            if (Arr::get($this->processingErrors, $activityIdentifier, null)) {
                $error['critical'] = Arr::get($this->processingErrors, $activityIdentifier);
            }

            $this->storeValidatedData($activity, $error, $existingId, $activityIdentifier);
        }

        $this->storeGlobalErrors();
        $this->updateStatus();
    }

    public function defaultValues($data): void
    {
        $dropDownFields = $this->getDropDownFields();
        $excelColumnName = $this->getExcelColumnNameMapper();
        $elementActivityIdentifier = null;

        foreach ($data as $index => $row) {
            $secondary_reporter = '';

            if ($this->checkRowNotEmpty($row)) {
                if ($index === 0 && is_null($row['activity_identifier'])) {
                    $this->globalErrors[] = 'Error detected on ' . $this->sheetName . ' sheet, cell A' . $this->rowCount . ': Identifier is missing.';
                    continue;
                }

                $this->isIdentifierDuplicate($row['activity_identifier'], 'settings');

                $secondary_reporter = $row['secondary_reporter'];
                unset($row['secondary_reporter']);

                $elementActivityIdentifier = Arr::get($row, 'activity_identifier', null) ?? $elementActivityIdentifier;

                $this->activitiesIdentifier[] = $elementActivityIdentifier;

                foreach ($this->defaultValueElements as $element) {
                    $fieldValue = Arr::get($row, $element, null);

                    if (array_key_exists($element, $dropDownFields['settings'])) {
                        $elementDropDownFields = $dropDownFields['settings'][$element];
                        $fieldValue = $this->mapDropDownValueToKey($fieldValue, $elementDropDownFields);
                    }

                    if (isset($this->activities[$elementActivityIdentifier]['default_field_values'][$element])) {
                        if (!is_array($this->activities[$elementActivityIdentifier]['default_field_values'][$element])) {
                            $this->activities[$elementActivityIdentifier]['default_field_values'][$element] = [];
                            $this->activities[$elementActivityIdentifier]['default_field_values'][$element][] = $this->activities[$elementActivityIdentifier]['default_field_values'][$element];
                        }
                        $this->activities[$elementActivityIdentifier]['default_field_values'][$element][] = $fieldValue;
                    } else {
                        $this->activities[$elementActivityIdentifier]['default_field_values'][$element] = is_numeric($fieldValue) ? (string) $fieldValue : $fieldValue;
                    }

                    $this->columnTracker[$elementActivityIdentifier]['default_field_values']['default_field_values.' . $element]['sheet'] = $this->sheetName;
                    $this->columnTracker[$elementActivityIdentifier]['default_field_values']['default_field_values.' . $element]['cell'] = Arr::get($excelColumnName, $this->sheetName . '.' . $element) . $this->rowCount;
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
        $secondary_reporter = is_bool($secondary_reporter) ? (int) $secondary_reporter : $secondary_reporter;

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
        $excelColumnName = $this->getExcelColumnNameMapper();

        foreach ($data as $index => $row) {
            if ($this->checkRowNotEmpty($row)) {
                if ($index === 0 && is_null($row['activity_identifier'])) {
                    $this->globalErrors[] = 'Error detected on ' . $this->sheetName . ' sheet, cell A' . $this->rowCount . ': Identifier is missing.';
                    continue;
                }

                $elementActivityIdentifier = Arr::get($row, 'activity_identifier', null) ?? $elementActivityIdentifier;

                foreach ($this->singleValuedElements as $element) {
                    $fieldValue = $row[$element];

                    if (array_key_exists($element, $dropDownFields)) {
                        $elementDropDownFields = $dropDownFields[$element];
                        $fieldValue = $this->mapDropDownValueToKey($row[$element], $elementDropDownFields);
                    }

                    if (isset($this->activities[$elementActivityIdentifier][$element])) {
                        if (!is_array($this->activities[$elementActivityIdentifier][$element])) {
                            $this->activities[$elementActivityIdentifier][$element] = [];
                            $this->activities[$elementActivityIdentifier][$element][] = $this->activities[$elementActivityIdentifier][$element];
                        }
                        $this->activities[$elementActivityIdentifier][$element][] = $fieldValue;
                    } else {
                        $this->activities[$elementActivityIdentifier][$element] = is_numeric($fieldValue) ? $fieldValue : $fieldValue;
                    }

                    $this->columnTracker[$elementActivityIdentifier]["$element"]["$element"]['sheet'] = $this->sheetName;
                    $this->columnTracker[$elementActivityIdentifier]["$element"]["$element"]['cell'] = Arr::get($excelColumnName, $this->sheetName . '.' . $element) . $this->rowCount;
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
                        $processedData = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $elementActivityIdentifier, $element);

                        if (!empty($processedData)) {
                            $this->activities[$elementActivityIdentifier][$element] = $processedData;
                        }

                        $elementData = [];
                    }

                    $elementActivityIdentifier = Arr::get($row, 'activity_identifier', null) ?? $elementActivityIdentifier;
                }

                foreach ($elementMapper as $xlsColumnName => $systemName) {
                    $systemMappedRow[$systemName] = Arr::get($row, $xlsColumnName, null);
                }

                $elementData[] = $systemMappedRow;
            } else {
                break;
            }
        }

        if (!empty($elementData)) {
            if (in_array($elementActivityIdentifier, $this->activitiesIdentifier)) {
                $processedData = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $elementActivityIdentifier, $element);

                if (!empty($processedData)) {
                    $this->activities[$elementActivityIdentifier][$element] = $processedData;
                }
            }
            $elementData = [];
        }
    }

    public function getElementData($data, $dependency, $elementDropDownFields, $elementActivityIdentifier, $element): array
    {
        if (is_null($elementActivityIdentifier)) {
            $this->globalErrors[] = 'Error detected on ' . $this->sheetName . ' sheet, cell A' . $this->rowCount . ': Identifier is missing.';

            return [];
        }

        $this->isIdentifierDuplicate($elementActivityIdentifier, $element);

        $elementBase = Arr::get($dependency, 'elementBase', null);
        $elementBasePeer = Arr::get($dependency, 'elementBasePeer', []);
        $elementAddMore = Arr::get($dependency, 'add_more', true);
        $baseCount = null;
        $fieldDependency = $dependency['fieldDependency'];
        $excelColumnName = $this->getExcelColumnNameMapper();
        $parentBaseCount = [];
        $elementData = [];

        // variables to map code dependency in elements like sector, recipient region and so on
        $codeDependencyCondition = Arr::get($dependency, 'codeDependency.dependencyCondition', []);
        $dependentOn = Arr::get($dependency, 'codeDependency.dependentOn', []);
        $parentDependentOn = Arr::get($dependency, 'codeDependency.parentDependentOn', []);
        $dependentOnValue = [];

        foreach (array_values($dependentOn) as $dependency) {
            foreach (array_values($dependency) as $dependentVocab) {
                $dependentOnValue[$dependentVocab] = null;
            }
        }

        foreach (array_values($fieldDependency) as $dependents) {
            $parentBaseCount[$dependents['parent']] = null;
        }

        foreach ($data as $row) {
            foreach ($row as $fieldName => $fieldValue) {
                list($baseCount, $parentBaseCount, $dependentOnValue) = $this->checkElementAddMore($elementBase, $elementBasePeer, $elementAddMore, $dependentOnValue, $fieldName, $fieldValue, $baseCount, $parentBaseCount, $row, $element);
                list($parentBaseCount, $dependentOnValue) = $this->checkSubElementAddMore($fieldDependency, $parentBaseCount, $parentDependentOn, $dependentOnValue, $fieldName, $fieldValue, $row);
                $originalFieldName = $fieldName;

                if (!empty($dependentOn)) {
                    if (in_array($fieldName, array_keys(Arr::get($dependentOn, 'codes', [])))) {
                        $dependentOnFieldName = $dependentOn['codes'][$fieldName];
                        $dependentOnFieldValue = $dependentOnValue[$dependentOnFieldName];
                        $dependencyCondition = $codeDependencyCondition[$dependentOnFieldName];
                        $defaultField = $dependencyCondition['defaultCodeField'];

                        $fieldName = $dependentOnFieldValue ? Arr::get($dependencyCondition, "dependencyRelation.$dependentOnFieldValue", $defaultField) : $defaultField;
                    }

                    if (in_array($fieldName, array_keys(Arr::get($dependentOn, 'uri', [])))) {
                        $dependentOnFieldName = $dependentOn['uri'][$fieldName];
                        $dependentOnFieldValue = $dependentOnValue[$dependentOnFieldName];
                        $uriDependencyCondition = $codeDependencyCondition[$dependentOnFieldName]['vocabularyUri'];

                        if (!in_array($dependentOnFieldValue, $uriDependencyCondition)) {
                            continue;
                        }
                    }
                }

                if (array_key_exists($fieldName, $elementDropDownFields)) {
                    $fieldValue = $this->mapDropDownValueToKey($fieldValue, $elementDropDownFields[$fieldName]);
                }

                // check for non empty.. including zero
                if (in_array($fieldName, array_keys($dependentOnValue), false) && $fieldValue) {
                    $dependentOnValue[$fieldName] = $fieldValue;
                }

                $elementPosition = $this->getActivityElementPosition($parentBaseCount, $fieldName);
                $elementPositionBasedOnParent = $elementBase && $elementAddMore ? (empty($elementPosition) ? $baseCount : $baseCount . '.' . $elementPosition) : $elementPosition;

                if (is_null(Arr::get($elementData, $elementPositionBasedOnParent, null)) && !empty($elementPosition)) {
                    $fieldValue = is_numeric($fieldValue) ? (string) $fieldValue : $fieldValue;
                    Arr::set($elementData, $elementPositionBasedOnParent, $fieldValue);
                    $this->columnTracker[$elementActivityIdentifier][$element][$element . '.' . $elementPositionBasedOnParent]['sheet'] = $this->sheetName;
                    $this->columnTracker[$elementActivityIdentifier][$element][$element . '.' . $elementPositionBasedOnParent]['cell'] = Arr::get($excelColumnName, $this->sheetName . '.' . $originalFieldName) . $this->rowCount;
                }
            }

            $this->rowCount++;
        }

        if (!empty($this->tempErrors)) {
            foreach ($this->tempErrors as $errorIndex => $error) {
                $this->processingErrors[$elementActivityIdentifier][$element][$errorIndex] = $error;
            }
        }

        $this->tempErrors = [];

        return $elementData;
    }

    public function getActivityElementPosition($fieldDependency, $dependencies): string
    {
        $position = '';
        $dependency = explode(' ', $dependencies);
        $expected_position = '';
        $transactionNarrative = [
            'description narrative',
            'title narrative',
        ];

        foreach ($dependency as $key) {
            $expected_position = empty($expected_position) ? $key : "$expected_position $key";

            if (in_array($expected_position, array_keys($fieldDependency))) {
                if (in_array($this->elementBeingProcessed, $this->enclosedNarrative)) {
                    if ($this->elementBeingProcessed !== 'transactions' || in_array($expected_position, $transactionNarrative)) {
                        $key = $key === 'narrative' ? '0.narrative' : $key;
                    }
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
