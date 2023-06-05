<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Mapper;

use App\XlsImporter\Foundation\Mapper\Traits\XlsMapperHelper;
use App\XlsImporter\Foundation\XlsValidator\Validators\PeriodValidator;
use Illuminate\Support\Arr;

/**
 * Class Period.
 */
class Period
{
    use XlsMapperHelper;

    /**
     * @var array
     */
    protected array $periods = [];

    /**
     * @var array
     */
    protected array $indicatorIdentifier = [];

    /**
     * @var array
     */
    protected array $periodIdentifier = [];

    /**
     * @var array
     */
    protected array $identifiers = [];

    /**
     * @var int
     */
    protected int $rowCount = 2;

    /**
     * @var string
     */
    protected string $sheetName = '';

    /**
     * @var array
     */
    protected array $targetActualIndexing = [];

    /**
     * @var array
     */
    protected array $actualMapping = [];

    /**
     * @var array
     */
    protected array $columnTracker = [];

    /**
     * @var array
     */
    protected array $tempColumnTracker = [];

    /**
     * @var string
     */
    protected string $statusFilePath = '';

    /**
     * @var string
     */
    protected string $globalErrorFilePath = '';

    /**
     * @var string
     */
    protected string $validatedDataFilePath = '';

    /**
     * @var array
     */
    protected array $existingIdentifier = [];

    /**
     * @var array
     */
    protected array $trackIdentifierBySheet = [];

    /**
     * @var array
     */
    protected array $globalErrors = [];

    /**
     * @var array
     */
    protected array $processingErrors = [];

    /**
     * @var array
     */
    protected array $tempErrors = [];

    /**
     * @var array
     */
    protected array $errorCount = [
        'critical' => 0,
        'warning' => 0,
        'error' => 0,
    ];

    /**
     * @var int
     */
    protected int $totalCount = 0;

    /**
     * @var int
     */
    protected int $processedCount = 0;

    /**
     * @var array
     */
    protected array $periodDivisions = [
        'Period' => 'period',
        'Target' => 'target',
        'Target Document Link' => 'target document_link',
        'Actual' => 'actual',
        'Actual Document Link' => 'actual document_link',
    ];

    /**
     * @var array
     */
    protected array $elementIdentifiers = [
        'period' => 'period_identifier',
        'target' => 'target_identifier',
        'target document_link' => 'target_identifier',
        'actual' => 'actual_identifier',
        'actual document_link' => 'actual_identifier',
    ];

    /**
     * @var array
     */
    protected array $mappers = [
        'Period_Mapper' => [
            'columns' => [
                'parentIdentifier' => 'indicator_identifier',
                'number' => 'period_number',
            ],
            'concatinator' => '_',
            'type' => 'period',
        ],
        'Target_Mapper' => [
            'columns' => [
                'parentIdentifier' => 'period_identifier',
                'number' => 'target_number',
            ],
            'concatinator' => '_t-',
            'type' => 'target',
        ],
        'Actual_Mapper' => [
            'columns' => [
                'parentIdentifier' => 'period_identifier',
                'number' => 'actual_number',
            ],
            'concatinator' => '_a-',
            'type' => 'actual',
        ],
    ];

    /**
     * Map period sheets.
     *
     * @param $periodData
     *
     * @return static
     */
    public function map($periodData): static
    {
        foreach ($periodData as $sheetName => $content) {
            $this->sheetName = $sheetName;
            $this->rowCount = 2;

            if (in_array($sheetName, array_keys($this->mappers))) {
                $this->storePeriodMapper($content, $sheetName);
            }

            if (in_array($sheetName, array_keys($this->periodDivisions))) {
                $this->columnToFieldMapper($this->periodDivisions[$sheetName], $content);
            }
        }

        return $this;
    }

    /**
     * Returns period data for unit test.
     *
     * @return array
     */
    public function getPeriodData(): array
    {
        $periodTestData = [];

        foreach ($this->periods as $indicatorIdentifier => $periods) {
            foreach ($periods as $periodIdentifier => $periodData) {
                $periodTestData[$periodIdentifier] = $periodData['period'];
            }
        }

        return $periodTestData;
    }

    /**
     * Validate period and store data in json files.
     *
     * @return void
     */
    public function validateAndStoreData(): void
    {
        $periodValidator = app(PeriodValidator::class);

        foreach ($this->periods as $indicatorIdentifier => $periods) {
            foreach ($periods as $periodIdentifier => $periodData) {
                $parentId = Arr::get($this->existingIdentifier['parent'], $indicatorIdentifier, null);
                $errors = $periodValidator
                    ->init(['period' => $periodData['period'], 'indicatorId' => $parentId])
                    ->validateData();
                $error = $this->appendExcelColumnAndRowDetail($errors, $this->columnTracker[$indicatorIdentifier][$periodIdentifier]['period']);
                $existingId = Arr::get($this->existingIdentifier, sprintf('period.%s', $periodIdentifier), false);

                if (!$parentId) {
                    $error['critical']['indicator_identifier']['indicator_identifier'] = "The indicator identifier $indicatorIdentifier doesn't exist in the system";
                    $this->errorCount['critical']++;
                }

                if (Arr::get($this->processingErrors, "$indicatorIdentifier.$periodIdentifier", null)) {
                    $error['critical']['period'] = Arr::get($this->processingErrors, "$indicatorIdentifier.$periodIdentifier");
                    $this->errorCount['critical'] += count(Arr::get($this->processingErrors, "$indicatorIdentifier.$periodIdentifier"));
                }

                $this->processedCount++;
                $this->storeValidatedData($periodData['period'], $error, $existingId, $periodIdentifier, $indicatorIdentifier, str_replace($indicatorIdentifier . '_', '', $periodIdentifier));
            }
        }

        $this->storeGlobalErrors();
        $this->updateStatus();
    }

    /**
     * Store mapper of period (period, baseline, target and actual).
     *
     * @param $data
     * @param $sheetName
     *
     * @return void
     */
    public function storePeriodMapper($data, $sheetName): void
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

                $this->periodIdentifier[$sheetName][$parentIdentifierValue][] = sprintf('%s%s%s', $parentIdentifierValue, $mapperDetails['concatinator'], $row[$numberKey]);
                $this->identifiers[$mapperDetails['type']][sprintf('%s%s%s', $parentIdentifierValue, $mapperDetails['concatinator'], $row[$numberKey])] = $parentIdentifierValue;
            } else {
                break;
            }
        }
    }

    /**
     * Group period data based on identifier and map them to specific periods.
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
                        $this->pushPeriodData($element, $elementActivityIdentifier, $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $element, $elementActivityIdentifier));
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
            $this->pushPeriodData($element, $elementActivityIdentifier, $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $element, $elementActivityIdentifier));
            $elementData = [];
        }
    }

    /**
     * Map period values to specific fields.
     *
     * @param $data
     * @param $dependency
     * @param $elementDropDownFields
     * @param $element
     * @param $elementActivityIdentifier
     *
     * @return array
     */
    public function getElementData($data, $dependency, $elementDropDownFields, $element, $elementActivityIdentifier): array
    {
        if (is_null($elementActivityIdentifier)) {
            $this->globalErrors[] = 'Error detected on ' . $this->sheetName . ' sheet, cell A' . $this->rowCount . ': Identifier is missing.';

            return [];
        }

        $periodElementParent = [
            'actual document_link' => 'actual',
            'target document_link' => 'target',
        ];

        $this->isIdentifierDuplicate($elementActivityIdentifier, $element, true, Arr::get($periodElementParent, $element, $element));
        $elementBase = Arr::get($dependency, 'elementBase', null);
        $elementBasePeer = Arr::get($dependency, 'elementBasePeer', []);
        $elementAddMore = Arr::get($dependency, 'add_more', true);
        $baseCount = null;
        $fieldDependency = $dependency['fieldDependency'];
        $parentBaseCount = [];
        $excelColumnName = $this->getExcelColumnNameMapper();
        $activityTemplate = $this->getActivityTemplate();
        $elementData = Arr::get($activityTemplate, $element, []);

        foreach (array_values($fieldDependency) as $dependents) {
            $parentBaseCount[$dependents['parent']] = null;
        }

        foreach ($data as $row) {
            foreach ($row as $fieldName => $fieldValue) {
                list($baseCount, $parentBaseCount) = $this->checkElementAddMore($elementBase, $elementBasePeer, $elementAddMore, [], $fieldName, $fieldValue, $baseCount, $parentBaseCount, $row, $element);
                list($parentBaseCount) = $this->checkSubElementAddMore($fieldDependency, $parentBaseCount, [], [], $fieldName, $fieldValue, $row);

                if (in_array($fieldName, array_keys($elementDropDownFields))) {
                    $fieldValue = $this->mapDropDownValueToKey($fieldValue, $elementDropDownFields[$fieldName], $fieldName);
                }

                $elementData = $this->setValueToField($elementBase, $elementAddMore, $elementData, $baseCount, $parentBaseCount, $fieldName, $fieldValue, $elementActivityIdentifier, $element, Arr::get($excelColumnName, $this->sheetName . '.' . $fieldName));
            }
            $this->rowCount++;
        }

        return $elementData;
    }

    /**
     * Appends period data to periods.
     *
     * @param $element
     * @param $identifier
     * @param $data
     *
     * @return void
     */
    protected function pushPeriodData($element, $identifier, $data): void
    {
        $periodElementFunctions = [
            'period' => 'pushPeriod',
            'target' => 'pushPeriodActualTarget',
            'actual' => 'pushPeriodActualTarget',
            'actual document_link' => 'pushActualTargetDocumentLink',
            'target document_link' => 'pushActualTargetDocumentLink',
        ];
        $periodElementParent = [
            'actual document_link' => 'actual',
            'target document_link' => 'target',
        ];
        $targetElement = Arr::get($periodElementParent, $element, $element);

        if (!empty($data)) {
            call_user_func([$this, $periodElementFunctions[$element]], $identifier, $data, $targetElement);
        }

        $this->tempColumnTracker = [];
        $this->tempErrors = [];
    }

    /**
     * Appends period sheet data to periods.
     *
     * @param $identifier
     * @param $data
     * @param $element
     *
     * @return void
     */
    protected function pushPeriod($identifier, $data, $element): void
    {
        $indicatorIdentifier = Arr::get($this->identifiers, "period.$identifier", null);

        $this->periods[$indicatorIdentifier][$identifier]['period'] = $data;
        $this->columnTracker[$indicatorIdentifier][$identifier]['period'] = $this->tempColumnTracker;
        $this->addProcessingErrors($indicatorIdentifier, $identifier);
        $this->totalCount++;
    }

    /**
     * Appends actual and target sheet data to periods.
     *
     * @param $identifier
     * @param $data
     * @param $type
     *
     * @return void
     */
    protected function pushPeriodActualTarget($identifier, $data, $type): void
    {
        $periodIdentifier = Arr::get($this->identifiers, "$type.$identifier", null);
        $indicatorIdentifier = Arr::get($this->identifiers, "period.$periodIdentifier", null);
        $this->checkIfPeriodExists($indicatorIdentifier, $periodIdentifier);

        if (isset($this->targetActualIndexing[$indicatorIdentifier][$periodIdentifier]['period'][$type])) {
            $this->periods[$indicatorIdentifier][$periodIdentifier]['period'][$type][] = $data;
        } else {
            $this->periods[$indicatorIdentifier][$periodIdentifier]['period'][$type][0] = $data;
        }

        $currentIdentifierPosition = array_key_last($this->periods[$indicatorIdentifier][$periodIdentifier]['period'][$type]);
        $this->targetActualIndexing[$indicatorIdentifier][$periodIdentifier]['period'][$type][$identifier] = $currentIdentifierPosition;
        $this->updateColumnTracker($indicatorIdentifier, $periodIdentifier, "$type.$currentIdentifierPosition");
        $this->addProcessingErrors($indicatorIdentifier, $periodIdentifier);
    }

    /**
     * Appends actual and target document link sheet data to periods.
     *
     * @param $identifier
     * @param $data
     * @param $type
     *
     * @return void
     */
    protected function pushActualTargetDocumentLink($identifier, $data, $type): void
    {
        $periodIdentifier = Arr::get($this->identifiers, "$type.$identifier", null);
        $indicatorIdentifier = Arr::get($this->identifiers, "period.$periodIdentifier", null);
        $this->checkIfPeriodExists($indicatorIdentifier, $periodIdentifier);
        $actualTargetIndex = Arr::get($this->targetActualIndexing, "$indicatorIdentifier.$periodIdentifier.period.$type.$identifier", 0);

        $this->periods[$indicatorIdentifier][$periodIdentifier]['period'][$type][$actualTargetIndex]['document_link'] = $data;
        $this->updateColumnTracker($indicatorIdentifier, $periodIdentifier, "$type.$actualTargetIndex.document_link");
        $this->addProcessingErrors($indicatorIdentifier, $periodIdentifier);
    }

    /**
     * Adds column mapping data to columnTracker.
     *
     * @param $indicatorIdentifier
     * @param $periodIdentifier
     * @param $keyPrefix
     *
     * @return void
     */
    protected function updateColumnTracker($indicatorIdentifier, $periodIdentifier, $keyPrefix): void
    {
        foreach ($this->tempColumnTracker as $columnPosition => $columnIndex) {
            $this->columnTracker[$indicatorIdentifier][$periodIdentifier]['period']["$keyPrefix.$columnPosition"] = $columnIndex;
        }
    }

    /**
     * Checks if period data exists in periods and add total count if it doesn't exist.
     *
     * @param $indicatorIdentifier
     * @param $periodIdentifier
     *
     * @return void
     */
    protected function checkIfPeriodExists($indicatorIdentifier, $periodIdentifier): void
    {
        if (!isset($this->periods[$indicatorIdentifier][$periodIdentifier]['period'])) {
            $activityTemplate = $this->getActivityTemplate();
            $this->periods[$indicatorIdentifier][$periodIdentifier]['period'] = $activityTemplate['period'];
            $this->totalCount++;
        }
    }
}
