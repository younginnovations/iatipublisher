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
     * Division of indicator data based on sheet names.
     *
     * @var array
     */
    protected array $indicatorDivision = [
        'Indicator' => 'indicator',
        'Indicator Document Link' => 'indicator document_link',
        'Indicator Baseline' => 'baseline',
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
        'baseline' => 'indicator_baseline_identifier',
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
                $this->mapIndicatorDataSheets($this->indicatorDivision[$sheetName], $content);
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
                $errors = $indicatorValidator
                    ->init($indicatorData['indicator'])
                    ->validateData();

                $error = $this->appendExcelColumnAndRowDetail($errors, $this->columnTracker[$resultIdentifier][$indicatorIdentifier]['indicator']);
                $existingId = Arr::get($this->existingIdentifier, sprintf('%s_%s', $resultIdentifier, $indicatorIdentifier), false);
                $this->processedCount++;

                $this->storeValidatedData($indicatorData['indicator'], $error, $existingId, $resultIdentifier);
            }
        }
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
                if ((empty($parentIdentifierValue) || $parentIdentifierValue !== $row[$parentIdentifierKey]) && !empty($row[$parentIdentifierKey])) {
                    $parentIdentifierValue = $row[$parentIdentifierKey];
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
    public function mapIndicatorDataSheets($element, $data = []): void
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
                        $this->pushIndicatorData($element, $elementActivityIdentifier, $this->convertGroupedDataToSystemData($elementData, $dependency[$element], $elementDropDownFields, $element));
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
            $this->pushIndicatorData($element, $elementActivityIdentifier, $this->convertGroupedDataToSystemData($elementData, $dependency[$element], $elementDropDownFields, $element));
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
    public function convertGroupedDataToSystemData($data, $dependency, $elementDropDownFields, $element): array
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
                if ($elementBase && $fieldName === $elementBase && ($fieldValue || $this->checkIfPeerAttributesAreNotEmpty($elementBasePeer, $row) || ($this->checkIfPeerAttributesAreNotEmpty(array_keys($row), $row) && is_null($baseCount)))) {
                    $baseCount = is_null($baseCount) ? 0 : $baseCount + 1;
                    // empty count of child elements
                    $parentBaseCount = array_fill_keys(array_keys($parentBaseCount), null);
                }

                if (in_array($fieldName, array_keys($fieldDependency))) {
                    $parentKey = $fieldDependency[$fieldName]['parent'];
                    $peerAttributes = Arr::get($fieldDependency, "$fieldName.peer", []);

                    if ($fieldValue || $this->checkIfPeerAttributesAreNotEmpty($peerAttributes, $row)) {
                        $parentBaseCount[$parentKey] = is_null($parentBaseCount[$parentKey]) ? 0 : $parentBaseCount[$parentKey] + 1;
                    }
                }

                // checking and mapping select fields
                if (in_array($fieldName, array_keys($elementDropDownFields))) {
                    dump('------------start------------ "' . $fieldName . $fieldValue);
                    $fieldValue = $this->mapDropDownValueToKey($fieldValue, $elementDropDownFields[$fieldName]);
                    dump('end :' . $fieldValue);
                }

                $elementPosition = $this->getElementPosition($parentBaseCount, $fieldName);
                // dump($elementPosition);
                // map element position from parent
                $elementPositionBasedOnParent = $elementBase ? (empty($elementPosition) ? $baseCount : $baseCount . '.' . $elementPosition) : $elementPosition;
                // dump($elementPositionBasedOnParent, $baseCount);
                if (is_null(Arr::get($elementData, $elementPositionBasedOnParent, null))) {
                    Arr::set($elementData, $elementPositionBasedOnParent, $fieldValue);

                    // if($fieldName === 'ascending')
                    $this->tempColumnTracker[$elementPositionBasedOnParent] = $this->sheetName . '!' . Arr::get($excelColumnName, $this->sheetName . '.' . $fieldName) . $this->rowCount;
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
            'baseline' => 'pushIndicatorBaseline',
            'baseline document_link' => 'pushIndicatorBaselineDocumentLink',
        ];

        call_user_func([$this, $periodElementFunctions[$element]], $identifier, $data);
        $this->tempColumnTracker = [];
    }

    protected function pushIndicator($identifier, $data): void
    {
        $resultIdentifier = Arr::get($this->identifiers, "indicator.$identifier", null);
        $this->indicators[$resultIdentifier][$identifier]['indicator'] = $data;
        $this->columnTracker[$resultIdentifier][$identifier]['indicator'] = $this->tempColumnTracker;
    }

    protected function pushIndicatorDocumentLink($identifier, $data): void
    {
        $resultIdentifier = Arr::get($this->identifiers, "indicator.$identifier", null);

        $this->indicators[$resultIdentifier][$identifier]['indicator']['document_link'] = $data;
        $this->updateColumnTracker($resultIdentifier, $identifier, 'document_link');
    }

    protected function pushIndicatorBaseline($identifier, $data): void
    {
        $indicatorIdentifier = Arr::get($this->identifiers, "baseline.$identifier", null);
        $resultIdentifier = Arr::get($this->identifiers, "indicator.$indicatorIdentifier", null);

        if (isset($this->baselineIndexing[$resultIdentifier][$indicatorIdentifier])) {
            $this->indicators[$resultIdentifier][$indicatorIdentifier]['indicator']['baseline'][] = $data;
        } else {
            $this->indicators[$resultIdentifier][$indicatorIdentifier]['indicator']['baseline'][0] = $data;
        }

        $currentBaselinePosition = array_key_last($this->indicators[$resultIdentifier][$indicatorIdentifier]['indicator']['baseline']);
        $this->baselineIndexing[$resultIdentifier][$indicatorIdentifier][$identifier] = $currentBaselinePosition;
        $this->updateColumnTracker($resultIdentifier, $indicatorIdentifier, "baseline.$currentBaselinePosition");
    }

    protected function pushIndicatorBaselineDocumentLink($identifier, $data): void
    {
        $indicatorIdentifier = Arr::get($this->identifiers, "baseline.$identifier", null);
        $resultIdentifier = Arr::get($this->identifiers, "indicator.$indicatorIdentifier", null);
        $baselineIndex = $this->baselineIndexing[$resultIdentifier][$indicatorIdentifier][$identifier];

        $this->indicators[$resultIdentifier][$indicatorIdentifier]['indicator']['baseline'][$baselineIndex]['document_link'] = $data;
        $this->updateColumnTracker($resultIdentifier, $indicatorIdentifier, "baseline.$baselineIndex.document_link");
    }

    protected function updateColumnTracker($resultIdentifier, $indicatorIdentifier, $keyPrefix)
    {
        foreach ($this->tempColumnTracker as $columnPosition => $columnIndex) {
            $this->columnTracker[$resultIdentifier][$indicatorIdentifier]['indicator']["$keyPrefix.$columnPosition"] = $columnIndex;
        }
    }
}
