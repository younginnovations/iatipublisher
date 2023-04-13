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
        'contact_info',
    ];

    protected string $elementBeingProcessed = '';

    protected string $statusFilePath = '';
    protected string $validatedDataFilePath = '';

    public function initMapper($validatedDataFilePath, $statusFilePath)
    {
        $this->validatedDataFilePath = $validatedDataFilePath;
        $this->statusFilePath = $statusFilePath;
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

        foreach ($this->activities as $activityIdentifier => $activities) {
            $errors = $activityValidator
                ->init($activities)
                ->validateData();
            $this->processedCount++;

            $excelColumnAndRowName = isset($this->columnTracker[$activityIdentifier]) ? Arr::collapse($this->columnTracker[$activityIdentifier]) : null;
            $error = $this->appendExcelColumnAndRowDetail($errors, $excelColumnAndRowName);
            $this->storeValidatedData($activities, $error);
        }

        $this->updateStatus();
    }

    public function defaultValues($data): void
    {
        $dropDownFields = $this->getDropDownFields();
        $excelColumnName = $this->getExcelColumnNameMapper();
        $elementActivityIdentifier = null;

        foreach ($data as $row) {
            if ($this->checkRowNotEmpty($row)) {
                $elementActivityIdentifier = Arr::get($row, 'activity_identifier', null) ?? $elementActivityIdentifier;

                if (in_array($elementActivityIdentifier, $this->activitiesIdentifier)) {
                    $this->duplicateIdentifiers[] = $elementActivityIdentifier;
                } else {
                    $this->activitiesIdentifier[] = $elementActivityIdentifier;
                }

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
            // $this->activities[$elementActivityIdentifier]['reporting_org'] = $this->getReportingOrganization($secondary_reporter);
            $this->activities[$elementActivityIdentifier]['iati_identifier'] = [
                'activity_identifier' => $elementActivityIdentifier,
            ];
        }
    }

    // /**
    //  * Returns reporting organization data from organization.
    //  *
    //  * @param $secondary_reporter
    //  *
    //  * @return array
    //  */
    // public function getReportingOrganization($secondary_reporter): array
    // {
    //     $organizationReportingOrg = auth()->user()->organization->reporting_org;

    //     if (!empty($organizationReportingOrg)) {
    //         $organizationReportingOrg[0]['secondary_reporter'] = $secondary_reporter;

    //         return $organizationReportingOrg;
    //     }

    //     return [
    //         [
    //             'ref' => '',
    //             'type' => '',
    //             'secondary_reporter' => $secondary_reporter,
    //             'narrative' => [
    //                 [
    //                     'narrative' => '',
    //                     'language' => '',
    //                 ],
    //             ],
    //         ],
    //     ];
    // }

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
                        if (in_array($elementActivityIdentifier, $this->activitiesIdentifier)) {
                            $this->activities[$elementActivityIdentifier][$element] = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $elementActivityIdentifier, $element);
                        }

                        $elementData = [];
                    }

                    $elementActivityIdentifier = Arr::get($row, 'activity_identifier', null) ?? $elementActivityIdentifier;
                }

                foreach ($row as $fieldName => $fieldValue) {
                    if (!empty($fieldName) && $fieldName !== 'activity_identifier') {
                        $systemMappedRow[$elementMapper[$fieldName]] = $fieldValue;
                    }
                }

                $elementData[] = $systemMappedRow;
            } else {
                if (in_array($elementActivityIdentifier, $this->activitiesIdentifier)) {
                    $this->activities[$elementActivityIdentifier][$element] = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $elementActivityIdentifier, $element);
                }
                // $this->activities[$elementActivityIdentifier][$element] = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $elementActivityIdentifier, $element);
                break;
            }
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
                    // dump($element, $dependentOn, $dependentOnValue, 'test', array_fill_keys(array_values($dependentOn), null));
                    $dependentOnValue = array_fill_keys(array_values($dependentOn), null);
                }

                if (array_key_exists($fieldName, $fieldDependency)) {
                    $parentKey = $fieldDependency[$fieldName]['parent'];
                    $peerAttributes = Arr::get($fieldDependency, "$fieldName.peer", []);
                    $parentAddMore = Arr::get($fieldDependency, "$fieldName.add_more", true);

                    if ($fieldValue || $this->checkIfPeerAttributesAreNotEmpty($peerAttributes, $row)) {
                        $parentBaseCount[$parentKey] = is_null($parentBaseCount[$parentKey]) || !$parentAddMore ? 0 : $parentBaseCount[$parentKey] + 1;
                    }
                }
                // dump('----------------',$fieldName);
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
                // dump($elementPositionBasedOnParent);

                if (!Arr::get($elementData, $elementPositionBasedOnParent, null) && !empty($elementPosition)) {
                    Arr::set($elementData, $elementPositionBasedOnParent, $fieldValue);
                    $this->columnTracker[$elementActivityIdentifier][$element][$element . '.' . $elementPositionBasedOnParent] = $this->sheetName . '!' . Arr::get($excelColumnName, $this->sheetName . '.' . $fieldName) . $this->rowCount;
                }
                // dump($elementData);
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
