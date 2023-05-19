<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Mapper;

use App\XlsImporter\Foundation\Mapper\Traits\XlsMapperHelper;
use App\XlsImporter\Foundation\XlsValidator\Validators\ResultValidator;
use Illuminate\Support\Arr;

/**
 * Class Result.
 */
class Result
{
    use XlsMapperHelper;

    /**
     * @var array
     */
    protected array $results = [];

    protected string $destinationFilePath = '';

    protected array $resultIdentifier = [];
    protected array $identifiers = [];

    /**
     * @var array
     */
    protected array $resultDocumentLink = [];

    protected int $totalCount = 0;
    protected int $processedCount = 0;

    protected array $columnTracker = [];
    protected array $tempColumnTracker = [];

    /**
     * @var array
     */
    protected array $activityResultMapper = [];

    protected int $rowCount = 2;
    protected string $sheetName = '';
    protected string $statusFilePath = '';
    protected string $globalErrorFilePath = '';
    protected string $validatedDataFilePath = '';

    protected array $existingIdentifier = [];

    protected array $trackIdentifierBySheet = [];

    protected array $globalErrors = [];

    protected array $processingErrors = [];
    protected array $tempErrors = [];

    /**
     * Division of indicator data based on sheet names.
     *
     * @var array
     */
    protected array $resultDivision = [
        'Result' => 'result',
        'Result Document Link' => 'result document_link',
    ];

    /**
     * Identifier column for each indicator data sheet.
     *
     * @var array
     */
    protected array $elementIdentifiers = [
        'result' => 'result_identifier',
        'result document_link' => 'result_identifier',
    ];

    public function initMapper($validatedDataFilePath, $statusFilePath, $globalErrorFilePath, $existingIdentifier)
    {
        $this->validatedDataFilePath = $validatedDataFilePath;
        $this->statusFilePath = $statusFilePath;
        $this->existingIdentifier = $existingIdentifier;
        $this->globalErrorFilePath = $globalErrorFilePath;
    }

    public function getResultData(): array
    {
        $resultTestData = [];
        $errors = [];

        foreach ($this->results as $activityIdentifier => $results) {
            foreach ($results as $resultIdentifier => $resultData) {
                $resultTestData[$resultIdentifier] = $resultData['results'];
            }
        }

        return $resultTestData;
    }

    public function map($resultData): static
    {
        foreach ($resultData as $sheetName => $content) {
            $this->sheetName = $sheetName;
            $this->rowCount = 2;

            if ($sheetName === 'Result_Mapper') {
                $this->mapResultMapperSheets($content, $sheetName);
            }

            if (array_key_exists($sheetName, $this->resultDivision)) {
                $this->columnToFieldMapper($this->resultDivision[$sheetName], $content);
            }
        }

        return $this;
    }

    /**
     * Map mapper sheets and store them in $identifiers.
     *
     * @return void
     */
    public function mapResultMapperSheets($data, $sheetName): void
    {
        $parentIdentifierValue = '';

        foreach ($data as $index => $row) {
            if ($this->checkRowNotEmpty($row)) {
                if ($index === 0 && is_null($row['activity_identifier'])) {
                    $this->globalErrors[] = 'Error detected on ' . $this->sheetName . ' sheet, cell A' . $this->rowCount . ': Identifier is missing.';
                }

                if ((empty($parentIdentifierValue) || $parentIdentifierValue !== $row['activity_identifier']) && !empty($row['activity_identifier'])) {
                    $parentIdentifierValue = $row['activity_identifier'];

                    $this->isIdentifierDuplicate($parentIdentifierValue, 'Result_Mapper');
                }

                $this->resultIdentifier[$sheetName][$parentIdentifierValue][] = sprintf('%s_%s', $parentIdentifierValue, $row['result_number']);
                $this->identifiers[sprintf('%s_%s', $parentIdentifierValue, $row['result_number'])] = $parentIdentifierValue;
            } else {
                break;
            }
        }
    }

    public function validateAndStoreData(): void
    {
        $errors = [];
        $resultValidator = app(ResultValidator::class);

        foreach ($this->results as $activityIdentifier => $results) {
            foreach ($results as $resultIdentifier => $resultData) {
                $errors = $resultValidator
                    ->init(
                        [
                            'result' => $resultData['results'],
                            'resultId' => Arr::get($this->existingIdentifier, sprintf('result.%s', $resultIdentifier), null),
                        ]
                    )
                    ->validateData();

                $existingId = Arr::get($this->existingIdentifier, sprintf('result.%s', $resultIdentifier), false);
                $error = $this->appendExcelColumnAndRowDetail($errors, $this->columnTracker[$activityIdentifier][$resultIdentifier]['results']);

                if (!in_array($activityIdentifier, array_keys($this->existingIdentifier['parent']))) {
                    $error['critical']['activity_identifier']['activity_identifier'] = "The activity identifier doesn't exist in the system";
                }

                if (!empty(Arr::get($this->processingErrors, "$activityIdentifier.$resultIdentifier", []))) {
                    $error['critical']['result_identifier'] = Arr::get($this->processingErrors, "$activityIdentifier.$resultIdentifier");
                }

                $this->processedCount++;
                $this->storeValidatedData($resultData['results'], $error, $existingId, $resultIdentifier, $activityIdentifier, str_replace($activityIdentifier . '_', '', $resultIdentifier));
            }
        }

        $this->storeGlobalErrors();
        $this->updateStatus();
    }

    public function columnToFieldMapper($element, $data = []): void
    {
        $elementData = [];
        $columnMapper = $this->getLinearizedActivity();
        $dependency = $this->getDependencies();
        $dropDownFields = $this->getDropDownFields();
        $elementMapper = array_flip($columnMapper[$element]);
        $elementDropDownFields = $dropDownFields[$element];
        $elementActivityIdentifier = null;
        $elementIdentifier = $this->elementIdentifiers[$element];

        foreach ($data as $row) {
            if ($this->checkRowNotEmpty($row)) {
                if (
                    is_null($elementActivityIdentifier) || (
                        Arr::get($row, $elementIdentifier, null) &&
                        Arr::get($row, $elementIdentifier, null) !== $elementActivityIdentifier
                    )
                ) {
                    if (!empty($elementData)) {
                        $processedData = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $element, $elementActivityIdentifier);
                        $this->appendResultData($element, $elementActivityIdentifier, $processedData);
                        $elementData = [];
                    }

                    $elementActivityIdentifier = Arr::get($row, $elementIdentifier, null) ?? $elementActivityIdentifier;
                }

                $systemMappedRow = [];

                foreach ($elementMapper as $xlsColumnName => $systemName) {
                    $systemMappedRow[$systemName] = $row[$xlsColumnName];
                }

                $elementData[] = $systemMappedRow;
            } else {
                break;
            }
        }

        if (!empty($elementData)) {
            $processedData = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $element, $elementActivityIdentifier);
            $this->appendResultData($element, $elementActivityIdentifier, $processedData);
            $elementData = [];
        }
    }

    public function getElementData($data, $dependency, $elementDropDownFields, $element, $elementActivityIdentifier): array
    {
        if (is_null($elementActivityIdentifier)) {
            $this->globalErrors[] = sprintf('Error detected on %s sheet, cell A %s: The identifier is missing.', $this->sheetName, $this->rowCount);

            return [];
        }

        if ($this->isIdentifierDuplicate($elementActivityIdentifier, $element)) {
            return [];
        }

        $elementBase = Arr::get($dependency, 'elementBase', null);
        $elementBasePeer = Arr::get($dependency, 'elementBasePeer', []);
        $baseCount = null;
        $elementAddMore = Arr::get($dependency, 'add_more', true);
        $fieldDependency = $dependency['fieldDependency'];
        $parentBaseCount = [];
        $activityTemplate = $this->getActivityTemplate();
        $elementData = Arr::get($activityTemplate, $element, []);
        $excelColumnName = $this->getExcelColumnNameMapper();

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

                if (!empty($dependentOn)) {
                    if (in_array($fieldName, array_keys(Arr::get($dependentOn, 'uri', [])))) {
                        $dependentOnFieldName = $dependentOn['uri'][$fieldName];
                        $dependentOnFieldValue = $dependentOnValue[$dependentOnFieldName];
                        $uriDependencyCondition = $codeDependencyCondition[$dependentOnFieldName]['vocabularyUri'];

                        if (!in_array($dependentOnFieldValue, $uriDependencyCondition)) {
                            $elementPosition = $this->getElementPosition($parentBaseCount, $fieldName);
                            $elementPositionBasedOnParent = $elementBase && $elementAddMore ? (empty($elementPosition) ? $baseCount : $baseCount . '.' . $elementPosition) : $elementPosition;
                            Arr::forget($elementData, $elementPositionBasedOnParent);
                            continue;
                        }
                    }
                }

                if (in_array($fieldName, array_keys($elementDropDownFields))) {
                    $fieldValue = $this->mapDropDownValueToKey($fieldValue, $elementDropDownFields[$fieldName], $fieldName);
                }

                if (in_array($fieldName, array_keys($dependentOnValue), false) && $fieldValue) {
                    $dependentOnValue[$fieldName] = $fieldValue;
                }

                $elementPosition = $this->getElementPosition($parentBaseCount, $fieldName);
                $elementPositionBasedOnParent = $elementBase && $elementAddMore ? (empty($elementPosition) ? $baseCount : $baseCount . '.' . $elementPosition) : $elementPosition;

                if (is_null(Arr::get($elementData, $elementPositionBasedOnParent, null))) {
                    $fieldValue = is_numeric($fieldValue) ? (string) $fieldValue : $fieldValue;
                    Arr::set($elementData, $elementPositionBasedOnParent, $fieldValue);
                    $this->tempColumnTracker[$elementPositionBasedOnParent]['sheet'] = $this->sheetName;
                    $this->tempColumnTracker[$elementPositionBasedOnParent]['cell'] = Arr::get($excelColumnName, $this->sheetName . '.' . $fieldName) . $this->rowCount;
                }
            }
            $this->rowCount++;
        }

        return $elementData;
    }

    protected function appendResultData($element, $identifier, $data)
    {
        $periodElementFunctions = [
            'result' => 'appendResult',
            'result document_link' => 'appendResultDocumentLink',
        ];

        // if (!empty($data)) {
        call_user_func([$this, $periodElementFunctions[$element]], $identifier, $data);
        // }

        $this->tempColumnTracker = [];
        $this->tempErrors = [];
    }

    protected function appendResult($identifier, $data): void
    {
        $activityIdentifier = Arr::get($this->identifiers, "$identifier", null);

        if (!empty($data)) {
            $this->results[$activityIdentifier][$identifier]['results'] = $data;
            $this->totalCount++;
            $this->columnTracker[$activityIdentifier][$identifier]['results'] = $this->tempColumnTracker;
        }

        $this->addProcessingErrors($activityIdentifier, $identifier);
    }

    protected function appendResultDocumentLink($identifier, $data): void
    {
        $activityIdentifier = Arr::get($this->identifiers, "$identifier", null);

        if (!empty($data)) {
            if (!isset($this->results[$activityIdentifier][$identifier]['results'])) {
                $activityTemplate = $this->getActivityTemplate();
                $this->results[$activityIdentifier][$identifier]['results'] = $activityTemplate['result'];
            }
            $this->totalCount++;

            $this->results[$activityIdentifier][$identifier]['results']['document_link'] = $data;

            $this->updateColumnTracker($activityIdentifier, $identifier, 'document_link');
        }

        $this->addProcessingErrors($activityIdentifier, $identifier);
    }

    protected function updateColumnTracker($activityIdentifier, $identifier, $keyPrefix)
    {
        foreach ($this->tempColumnTracker as $columnPosition => $columnIndex) {
            $this->columnTracker[$activityIdentifier][$identifier]['results']["$keyPrefix.$columnPosition"] = $columnIndex;
        }
    }
}
