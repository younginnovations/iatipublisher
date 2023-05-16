<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Mapper;

use App\XlsImporter\Foundation\Mapper\Traits\XlsMapperHelper;
use App\XlsImporter\Foundation\XlsValidator\Validators\IndicatorValidator;
use Illuminate\Support\Arr;

/**
 * Class Indicator.
 */
class Indicator
{
    use XlsMapperHelper;

    /**
     * array containing all indicator data.
     *
     * @var array
     */
    protected array $indicators = [];

    protected array $indicatorIdentifier = [];

    protected array $periodIdentifier = [];

    protected array $baselineIndexing = [];

    protected array $identifiers = [];

    protected int $rowCount = 2;

    /**
     * Name of the sheet that is currently being processed.
     *
     * @var string
     */
    protected string $sheetName = '';

    /**
     * column Tracker for all the elements.
     *
     * @var array
     */
    protected array $columnTracker = [];

    /**
     * Temporary column tracker for each element group.
     *
     * @var array
     */
    protected array $tempColumnTracker = [];
    protected string $statusFilePath = '';
    protected string $validatedDataFilePath = '';
    protected string $globalErrorFilePath = '';

    protected array $existingIdentifier = [];
    protected array $trackIdentifierBySheet = [];

    protected array $globalErrors = [];

    protected array $processingErrors = [];
    protected array $tempErrors = [];

    protected int $totalCount = 0;
    protected int $processedCount = 0;

    public function initMapper($validatedDataFilePath, $statusFilePath, $globalErrorFilePath, $existingIdentifier)
    {
        $this->validatedDataFilePath = $validatedDataFilePath;
        $this->statusFilePath = $statusFilePath;
        $this->globalErrorFilePath = $globalErrorFilePath;
        $this->existingIdentifier = $existingIdentifier;
    }

    /**
     * Division of indicator data based on sheet names.
     *
     * @var array
     */
    protected array $indicatorDivision = [
        'Indicator' => 'indicator',
        'Indicator Document Link' => 'indicator document_link',
        'Indicator Baseline' => 'indicator_baseline',
        'Baseline Document Link' => 'baseline document_link',
    ];

    /**
     * Identifier column for each indicator data sheet.
     *
     * @var array
     */
    protected array $elementIdentifiers = [
        'indicator' => 'indicator_identifier',
        'indicator document_link' => 'indicator_identifier',
        'indicator_baseline' => 'indicator_baseline_identifier',
        'baseline document_link' => 'indicator_baseline_identifier',
    ];

    /**
     * Mapper sheets and their details.
     *
     * @var array
     */
    protected array $mappers = [
        'Indicator Mapper' => [
            'columns' => [
                'parentIdentifier' => 'result_identifier',
                'number' => 'indicator_number',
            ],
            'concatinator' => '_',
            'type' => 'indicator',
        ],
        'Indicator Baseline Mapper' => [
            'columns' => [
                'parentIdentifier' => 'indicator_identifier',
                'number' => 'baseline_number',
            ],
            'concatinator' => '_b-',
            'type' => 'baseline',
        ],
    ];

    /**
     * Maps sheet data based on their type and validates them.Result.
     *
     * @param $indicatorData
     *
     * @return static
     */
    public function map($indicatorData): static
    {
        foreach ($indicatorData as $sheetName => $content) {
            $this->sheetName = $sheetName;
            $this->rowCount = 2;

            if (array_key_exists($sheetName, $this->mappers)) {
                $this->mapMapperSheets($content, $sheetName);
            }

            if (array_key_exists($sheetName, $this->indicatorDivision)) {
                $this->columnToFieldMapper($this->indicatorDivision[$sheetName], $content);
            }
        }

        return $this;
    }

    public function getIndicatorData(): array
    {
        $indicatorTestData = [];

        foreach ($this->indicators as $resultIdentifier => $indicators) {
            foreach ($indicators as $indicatorIdentifier => $indicatorData) {
                $indicatorTestData[$indicatorIdentifier] = $indicatorData['indicator'];
            }
        }

        return $indicatorTestData;
    }

    /**
     * Validates indicator data and store them to valid.json file.
     *
     * @return void
     */
    public function validateAndStoreData(): void
    {
        $indicatorValidator = app(IndicatorValidator::class);

        foreach ($this->indicators as $resultIdentifier => $indicators) {
            foreach ($indicators as $indicatorIdentifier => $indicatorData) {
                $parentId = Arr::get($this->existingIdentifier['parent'], $resultIdentifier, null);
                $errors = $indicatorValidator
                    ->init(
                        [
                            'indicator' => $indicatorData['indicator'] ?? [],
                            'resultId' => $parentId,
                        ]
                    )
                    ->validateData();

                $error = $this->appendExcelColumnAndRowDetail($errors, $this->columnTracker[$resultIdentifier][$indicatorIdentifier]['indicator']);
                $existingId = Arr::get($this->existingIdentifier, sprintf('indicator.%s', $indicatorIdentifier), false);

                if (!$parentId) {
                    $error['critical']['result_identifier']['result_identifier'] = "The result identifier doesn't exist in the system";
                }

                if (!empty(Arr::get($this->processingErrors, "$resultIdentifier.$indicatorIdentifier", []))) {
                    $error['critical']['indicator_identifier'] = Arr::get($this->processingErrors, "$resultIdentifier.$indicatorIdentifier");
                }

                $this->processedCount++;

                $this->storeValidatedData($indicatorData['indicator'], $error, $existingId, $indicatorIdentifier, $resultIdentifier, str_replace($resultIdentifier . '_', '', $indicatorIdentifier));
            }
        }

        $this->storeGlobalErrors();
        $this->updateStatus();
    }

    /**
     * Map mapper sheets and store them in $identifiers.
     *
     * @return void
     */
    public function mapMapperSheets($data, $sheetName): void
    {
        $mapperDetails = $this->mappers[$sheetName];
        $parentIdentifierKey = $mapperDetails['columns']['parentIdentifier'];
        $numberKey = $mapperDetails['columns']['number'];
        $parentIdentifierValue = '';

        foreach ($data as $index => $row) {
            if ($this->checkRowNotEmpty($row)) {
                if ($index === 0 && is_null($row[$parentIdentifierKey])) {
                    $this->globalErrors[] = 'Error detected on ' . $this->sheetName . ' sheet, cell A' . $this->rowCount . ': Identifier is missing.';
                }

                if ((empty($parentIdentifierValue) || $parentIdentifierValue !== $row[$parentIdentifierKey]) && !empty($row[$parentIdentifierKey])) {
                    $parentIdentifierValue = $row[$parentIdentifierKey];

                    $this->isIdentifierDuplicate($parentIdentifierValue, $sheetName);
                }

                $this->indicatorIdentifier[$sheetName][$parentIdentifierValue][] = sprintf('%s%s%s', $parentIdentifierValue, $mapperDetails['concatinator'], $row[$numberKey]);
                $this->identifiers[$mapperDetails['type']][sprintf('%s%s%s', $parentIdentifierValue, $mapperDetails['concatinator'], $row[$numberKey])] = $parentIdentifierValue;
            } else {
                break;
            }
        }
    }

    /**
     * Map indicator data sheets and store them in $indicators.
     *
     * @param $element
     * @param $data
     *
     * @return void
     */
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
                        $this->pushIndicatorData($element, $elementActivityIdentifier, $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $element, $elementActivityIdentifier));
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
            $this->pushIndicatorData($element, $elementActivityIdentifier, $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $element, $elementActivityIdentifier));
            $elementData = [];
        }
    }

    /**
     * Convert grouped indicator data to system data.
     *
     * @param $data
     * @param $dependency
     * @param $elementDropDownFields
     * @param $element
     *
     * @return array
     */
    public function getElementData($data, $dependency, $elementDropDownFields, $element, $elementActivityIdentifier): array
    {
        if (is_null($elementActivityIdentifier)) {
            $this->globalErrors[] = sprintf('Error detected on %s sheet, cell A %s: The identifier is missing.', $this->sheetName, $this->rowCount);

            return [];
        }

        $this->isIdentifierDuplicate($elementActivityIdentifier, $element);

        $elementBase = Arr::get($dependency, 'elementBase', null);
        $elementBasePeer = Arr::get($dependency, 'elementBasePeer', []);
        $elementAddMore = Arr::get($dependency, 'add_more', true);
        $baseCount = null;
        $fieldDependency = $dependency['fieldDependency'];
        $parentBaseCount = [];
        $excelColumnName = $this->getExcelColumnNameMapper();
        $activityTemplate = $this->getActivityTemplate();
        $elementData = Arr::get($activityTemplate, $element, []);

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

                        if (!in_array($dependentOnFieldValue, $uriDependencyCondition) || is_null($dependentOnFieldValue)) {
                            $elementPosition = $this->getElementPosition($parentBaseCount, $fieldName);
                            $elementPositionBasedOnParent = $elementBase && $elementAddMore ? (empty($elementPosition) ? $baseCount : $baseCount . '.' . $elementPosition) : $elementPosition;
                            Arr::forget($elementData, $elementPositionBasedOnParent);
                            continue;
                        }
                    }
                }

                // checking and mapping select fields
                if (in_array($fieldName, array_keys($elementDropDownFields))) {
                    $fieldValue = $this->mapDropDownValueToKey($fieldValue, $elementDropDownFields[$fieldName]);
                }

                if (in_array($fieldName, array_keys($dependentOnValue), false) && $fieldValue) {
                    $dependentOnValue[$fieldName] = $fieldValue;
                }

                $elementPosition = $this->getElementPosition($parentBaseCount, $fieldName);
                // map element position from parent
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

    /**
     * Add indicator data to their respective position within $indicators variable.
     *
     * @param $element
     * @param $identifier
     * @param $data
     *
     * @return void
     */
    protected function pushIndicatorData($element, $identifier, $data): void
    {
        $periodElementFunctions = [
            'indicator' => 'pushIndicator',
            'indicator document_link' => 'pushIndicatorDocumentLink',
            'indicator_baseline' => 'pushIndicatorBaseline',
            'baseline document_link' => 'pushIndicatorBaselineDocumentLink',
        ];

        call_user_func([$this, $periodElementFunctions[$element]], $identifier, $data);

        $this->tempColumnTracker = [];
        $this->tempErrors = [];
    }

    protected function pushIndicator($identifier, $data): void
    {
        $resultIdentifier = Arr::get($this->identifiers, "indicator.$identifier", null);

        if (!empty($data)) {
            $this->indicators[$resultIdentifier][$identifier]['indicator'] = $data;
            $this->columnTracker[$resultIdentifier][$identifier]['indicator'] = $this->tempColumnTracker;
            $this->totalCount++;
        }

        $this->addProcessingErrors($resultIdentifier, $identifier);
    }

    protected function pushIndicatorDocumentLink($identifier, $data): void
    {
        $resultIdentifier = Arr::get($this->identifiers, "indicator.$identifier", null);
        $this->checkIfIndicatorExists($resultIdentifier, $identifier);

        if (!empty($data)) {
            $this->indicators[$resultIdentifier][$identifier]['indicator']['document_link'] = $data;
            $this->updateColumnTracker($resultIdentifier, $identifier, 'document_link');
        }

        $this->addProcessingErrors($resultIdentifier, $identifier);
    }

    protected function pushIndicatorBaseline($identifier, $data): void
    {
        $indicatorIdentifier = Arr::get($this->identifiers, "baseline.$identifier", null);
        $resultIdentifier = Arr::get($this->identifiers, "indicator.$indicatorIdentifier", null);

        if (!empty($data)) {
            $this->checkIfIndicatorExists($resultIdentifier, $indicatorIdentifier);
            if (isset($this->baselineIndexing[$resultIdentifier][$indicatorIdentifier])) {
                $this->indicators[$resultIdentifier][$indicatorIdentifier]['indicator']['baseline'][] = $data;
            } else {
                $this->indicators[$resultIdentifier][$indicatorIdentifier]['indicator']['baseline'][0] = $data;
            }

            $currentBaselinePosition = array_key_last($this->indicators[$resultIdentifier][$indicatorIdentifier]['indicator']['baseline']);
            $this->baselineIndexing[$resultIdentifier][$indicatorIdentifier][$identifier] = $currentBaselinePosition;
            $this->updateColumnTracker($resultIdentifier, $indicatorIdentifier, "baseline.$currentBaselinePosition");
        }

        $this->addProcessingErrors($resultIdentifier, $indicatorIdentifier);
    }

    protected function pushIndicatorBaselineDocumentLink($identifier, $data): void
    {
        $indicatorIdentifier = Arr::get($this->identifiers, "baseline.$identifier", null);
        $resultIdentifier = Arr::get($this->identifiers, "indicator.$indicatorIdentifier", null);

        if (!empty($data)) {
            $this->checkIfIndicatorExists($resultIdentifier, $indicatorIdentifier);
            $baselineIndex = Arr::get($this->baselineIndexing, "$resultIdentifier.$indicatorIdentifier.$identifier", '0');

            $this->indicators[$resultIdentifier][$indicatorIdentifier]['indicator']['baseline'][$baselineIndex]['document_link'] = $data;
            $this->updateColumnTracker($resultIdentifier, $indicatorIdentifier, "baseline.$baselineIndex.document_link");
        }

        $this->addProcessingErrors($resultIdentifier, $indicatorIdentifier);
    }

    protected function updateColumnTracker($resultIdentifier, $indicatorIdentifier, $keyPrefix)
    {
        foreach ($this->tempColumnTracker as $columnPosition => $columnIndex) {
            $this->columnTracker[$resultIdentifier][$indicatorIdentifier]['indicator']["$keyPrefix.$columnPosition"] = $columnIndex;
        }
    }

    protected function checkIfIndicatorExists($resultIdentifier, $indicatorIdentifier)
    {
        if (!isset($this->indicators[$resultIdentifier][$indicatorIdentifier]['indicator'])) {
            $activityTemplate = $this->getActivityTemplate();
            $this->indicators[$resultIdentifier][$indicatorIdentifier]['indicator'] = $activityTemplate['indicator'];
            $this->totalCount++;
        }
    }
}
