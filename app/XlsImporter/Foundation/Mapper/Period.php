<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Mapper;

use App\XlsImporter\Foundation\Mapper\Traits\XlsMapperHelper;
use App\XlsImporter\Foundation\XlsValidator\Validators\PeriodValidator;
use Illuminate\Support\Arr;

/**
 * Class Activity.
 */
class Period
{
    use XlsMapperHelper;

    //activities whose identifier is mentioned on setting sheet
    protected array $periods = [];

    //
    protected array $indicatorIdentifier = [];

    // activities whose identifier is not mentioned on setting
    protected array $periodIdentifier = [];

    protected array $identifiers = [];

    protected int $rowCount = 2;
    protected string $sheetName = '';

    protected array $targetActualIndexing = [];
    protected array $actualMapping = [];

    protected array $columnTracker = [];
    protected array $tempColumnTracker = [];
    protected string $statusFilePath = '';
    protected string $validatedDataFilePath = '';

    protected array $existingIdentifier = [];

    protected int $totalCount = 0;
    protected int $processedCount = 0;

    public function initMapper($validatedDataFilePath, $statusFilePath, $existingIdentifier)
    {
        $this->validatedDataFilePath = $validatedDataFilePath;
        $this->statusFilePath = $statusFilePath;
        $this->existingIdentifier = $existingIdentifier;
    }

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

    protected array $elementIdentifiers = [
        'period' => 'period_identifier',
        'target' => 'target_identifier',
        'target document_link' => 'target_identifier',
        'actual' => 'actual_identifier',
        'actual document_link' => 'actual_identifier',
    ];

    protected array $mappers = [
        'Period Mapper' => [
            'columns' => [
                'parentIdentifier' => 'indicator_identifier',
                'number' => 'period_number',
            ],
            'concatinator' => '_',
            'type' => 'period',
        ],
        'Target Mapper' => [
            'columns' => [
                'parentIdentifier' => 'period_identifier',
                'number' => 'target_number',
            ],
            'concatinator' => '_t-',
            'type' => 'target',
        ],
        'Actual Mapper' => [
            'columns' => [
                'parentIdentifier' => 'period_identifier',
                'number' => 'actual_number',
            ],
            'concatinator' => '_a-',
            'type' => 'actual',
        ],
    ];

    public function map($periodData): static
    {
        foreach ($periodData as $sheetName => $content) {
            $this->sheetName = $sheetName;
            $this->rowCount = 2;

            if (in_array($sheetName, array_keys($this->mappers))) {
                $this->mapPeriods($content, $sheetName);
            }

            if (in_array($sheetName, array_keys($this->periodDivisions))) {
                $this->columnToFieldMapper($this->periodDivisions[$sheetName], $content);
            }
        }

        return $this;
    }

    public function getPeriodData(): array
    {
        $periodTestData = [];

        foreach ($this->periods as $indicatorIdentifier => $periods) {
            foreach ($periods as $periodIdentifier => $periodData) {
                $periodTestData[$periodIdentifier] = $periodData;
            }
        }

        return $periodTestData;
    }

    public function validateAndStoreData()
    {
        $periodValidator = app(PeriodValidator::class);
        logger()->error('startt validatinggg');
        logger()->error(json_encode($this->periods));

        foreach ($this->periods as $indicatorIdentifier => $periods) {
            foreach ($periods as $periodIdentifier => $periodData) {
                logger()->error('fetchedddd period');
                $errors = $periodValidator
                    ->init($periodData['period'])
                    ->validateData();
                $columnAppendedError = $this->appendExcelColumnAndRowDetail($errors, $this->columnTracker[$indicatorIdentifier][$periodIdentifier]['period']);
                $existingId = Arr::get($this->existingIdentifier, sprintf('%s_%s', $indicatorIdentifier, $periodIdentifier), false);
                $this->processedCount++;
                $this->storeValidatedData($periodData['period'], $columnAppendedError, $existingId, $indicatorIdentifier);
            }
        }
    }

    public function mapPeriods($data, $sheetName)
    {
        $mapperDetails = $this->mappers[$sheetName];
        $parentIdentifierKey = $mapperDetails['columns']['parentIdentifier'];
        $numberKey = $mapperDetails['columns']['number'];
        $parentIdentifierValue = '';

        foreach ($data as $index => $row) {
            if ($this->checkRowNotEmpty($row)) {
                if ((empty($parentIdentifierValue) || $parentIdentifierValue !== $row[$parentIdentifierKey]) && !empty($row[$parentIdentifierKey])) {
                    $parentIdentifierValue = $row[$parentIdentifierKey];
                }

                $this->periodIdentifier[$sheetName][$parentIdentifierValue][] = sprintf('%s%s%s', $parentIdentifierValue, $mapperDetails['concatinator'], $row[$numberKey]);
                $this->identifiers[$mapperDetails['type']][sprintf('%s%s%s', $parentIdentifierValue, $mapperDetails['concatinator'], $row[$numberKey])] = $parentIdentifierValue;
            } else {
                break;
            }
        }

        $this->totalCount = count($this->identifiers['period']);
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
                        $this->pushPeriodData($element, $elementActivityIdentifier, $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $element));
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

            if (!empty($elementData)) {
                $this->pushPeriodData($element, $elementActivityIdentifier, $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $element));
                $elementData = [];
            }
        }
    }

    protected function pushPeriodData($element, $identifier, $data)
    {
        $periodElementFunctions = [
            'period' => 'pushPeriod',
            'target' => 'pushPeriodTarget',
            'actual' => 'pushPeriodActual',
            'actual document_link' => 'pushActualDocumentLink',
            'target document_link' => 'pushTargetDocumentLink',
        ];

        call_user_func([$this, $periodElementFunctions[$element]], $identifier, $data);
        $this->tempColumnTracker = [];
    }

    public function getElementData($data, $dependency, $elementDropDownFields, $element): array
    {
        $elementBase = Arr::get($dependency, 'elementBase', null);
        $elementBasePeer = Arr::get($dependency, 'elementBasePeer', []);
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
                if ($elementBase && ($fieldName === $elementBase && $fieldValue)) {
                    $baseCount = is_null($baseCount) ? 0 : $baseCount + 1;
                } elseif ($elementBase && $fieldName === $elementBase && $this->checkIfPeerAttributesAreNotEmpty($elementBasePeer, $row)) {
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

                if (in_array($fieldName, array_keys($elementDropDownFields))) {
                    $fieldValue = $this->mapDropDownValueToKey($fieldValue, $elementDropDownFields[$fieldName]);
                }

                $elementPosition = $this->getElementPosition($parentBaseCount, $fieldName);
                $elementPositionBasedOnParent = $elementBase ? (empty($elementPosition) ? $baseCount : $baseCount . '.' . $elementPosition) : $elementPosition;

                if (is_null(Arr::get($elementData, $elementPositionBasedOnParent, null))) {
                    Arr::set($elementData, $elementPositionBasedOnParent, $fieldValue);
                    $this->tempColumnTracker[$elementPositionBasedOnParent] = $this->sheetName . '!' . Arr::get($excelColumnName, $this->sheetName . '.' . $fieldName) . $this->rowCount;
                }
            }
            $this->rowCount++;
        }

        return $elementData;
    }

    protected function pushPeriod($identifier, $data): void
    {
        $indicatorIdentifier = Arr::get($this->identifiers, "period.$identifier", null);

        $this->periods[$indicatorIdentifier][$identifier]['period'] = $data;
        $this->columnTracker[$indicatorIdentifier][$identifier]['period'] = $this->tempColumnTracker;
    }

    protected function pushPeriodTarget($identifier, $data): void
    {
        $periodIdentifier = Arr::get($this->identifiers, 'target.' . $identifier, null);
        $indicatorIdentifier = Arr::get($this->identifiers, "period.$periodIdentifier", null);

        if (isset($this->targetActualIndexing[$indicatorIdentifier][$periodIdentifier]['period']['target'])) {
            $this->periods[$indicatorIdentifier][$periodIdentifier]['period']['target'][] = $data;
        } else {
            $this->periods[$indicatorIdentifier][$periodIdentifier]['period']['target'][0] = $data;
        }

        $currentIdentifierPosition = array_key_last($this->periods[$indicatorIdentifier][$periodIdentifier]['period']['target']);
        $this->targetActualIndexing[$indicatorIdentifier][$periodIdentifier]['period']['target'][$identifier] = $currentIdentifierPosition;
        $this->updateColumnTracker($indicatorIdentifier, $periodIdentifier, "target.$currentIdentifierPosition");
    }

    protected function pushPeriodActual($identifier, $data): void
    {
        $periodIdentifier = Arr::get($this->identifiers, "actual.$identifier", null);
        $indicatorIdentifier = Arr::get($this->identifiers, "period.$periodIdentifier", null);

        if (isset($this->targetActualIndexing[$indicatorIdentifier][$periodIdentifier]['period']['actual'])) {
            $this->periods[$indicatorIdentifier][$periodIdentifier]['period']['actual'][] = $data;
        } else {
            $this->periods[$indicatorIdentifier][$periodIdentifier]['period']['actual'][0] = $data;
        }

        $currentIdentifierPosition = array_key_last($this->periods[$indicatorIdentifier][$periodIdentifier]['period']['actual']);
        $this->targetActualIndexing[$indicatorIdentifier][$periodIdentifier]['period']['actual'][$identifier] = $currentIdentifierPosition;
        $this->updateColumnTracker($indicatorIdentifier, $periodIdentifier, "actual.$currentIdentifierPosition");
    }

    protected function pushTargetDocumentLink($identifier, $data): void
    {
        $periodIdentifier = Arr::get($this->identifiers, "target.$identifier", null);
        $indicatorIdentifier = Arr::get($this->identifiers, "period.$periodIdentifier", null);
        $targetIndex = $this->targetActualIndexing[$indicatorIdentifier][$periodIdentifier]['period']['target'][$identifier];

        $this->periods[$indicatorIdentifier][$periodIdentifier]['period']['target'][$targetIndex]['document_link'] = $data;
        $this->updateColumnTracker($indicatorIdentifier, $periodIdentifier, "target.$targetIndex.document_link");
    }

    protected function pushActualDocumentLink($identifier, $data): void
    {
        $periodIdentifier = Arr::get($this->identifiers, "actual.$identifier", null);
        $indicatorIdentifier = Arr::get($this->identifiers, "period.$periodIdentifier", null);
        $actualIndex = $this->targetActualIndexing[$indicatorIdentifier][$periodIdentifier]['period']['actual'][$identifier];
        $this->periods[$indicatorIdentifier][$periodIdentifier]['period']['actual'][$actualIndex]['document_link'] = $data;
        $this->updateColumnTracker($indicatorIdentifier, $periodIdentifier, "actual.$actualIndex.document_link");
    }

    protected function updateColumnTracker($indicatorIdentifier, $periodIdentifier, $keyPrefix)
    {
        foreach ($this->tempColumnTracker as $columnPosition => $columnIndex) {
            $this->columnTracker[$indicatorIdentifier][$periodIdentifier]['period']["$keyPrefix.$columnPosition"] = $columnIndex;
        }
    }
}
