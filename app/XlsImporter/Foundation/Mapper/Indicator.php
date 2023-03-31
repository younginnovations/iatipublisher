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

    //indicators
    protected array $indicators = [];

    //
    protected array $indicatorIdentifier = [];

    protected array $periodIdentifier = [];

    protected array $baselineIndexing = [];

    protected array $identifiers = [];

    protected int $rowCount = 2;
    protected string $sheetName = '';

    protected array $columnTracker = [];
    protected array $tempColumnTracker = [];

    /**
     * @var array
     */
    protected array $indicatorDivision = [
        'Indicator' => 'indicator',
        'Indicator Document Link' => 'indicator document_link',
        'Indicator Baseline' => 'baseline',
        'Indicator Baseline Document Link' => 'baseline document_link',
    ];

    protected array $elementIdentifiers = [
        'indicator' => 'indicator_identifier',
        'indicator document_link' => 'indicator_identifier',
        'baseline' => 'indicator_baseline_identifier',
        'baseline document_link' => 'indicator_baseline_identifier',
    ];

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

    public function map($indicatorData)
    {
        $indicatorData = json_decode($indicatorData, true, 512, JSON_THROW_ON_ERROR | 0);

        foreach ($indicatorData as $sheetName => $content) {
            $this->sheetName = $sheetName;

            if (array_key_exists($sheetName, $this->mappers)) {
                $this->rowCount = 2;
                $this->mapIndicators($content, $sheetName);
            }

            if (array_key_exists($sheetName, $this->indicatorDivision)) {
                $this->rowCount = 2;
                $this->columnToFieldMapper($this->indicatorDivision[$sheetName], $content);
            }
        }

        $this->validateIndicator();
    }

    public function validateIndicator()
    {
        $indicatorValidator = app(IndicatorValidator::class);

        foreach ($this->indicators as $resultIdentifier => $indicators) {
            foreach ($indicators as $indicatorIdentifier => $indicatorData) {
                $errors = $indicatorValidator
                    ->init($indicatorData['indicator'])
                    ->validateData();

                $this->indicators[$resultIdentifier][$indicatorIdentifier]['errors'] = $this->appendExcelColumnAndRowDetail($errors, $this->columnTracker[$resultIdentifier][$indicatorIdentifier]['indicator']);
            }
        }
    }

    public function appendExcelColumnAndRowDetail($errors, $fieldPosition): array
    {
        foreach ($errors as $errorLevel => $errorData) {
            foreach ($errorData as $element => $error) {
                foreach ($error as $key => $err) {
                    $errors[$errorLevel][$element][$key] .= ' ( ' . Arr::get($fieldPosition, $key, 'not found') . ' )';
                }
            }
        }

        return $errors;
    }

    public function mapIndicators($data, $sheetName)
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
                        $this->pushIndicatorData($element, $elementActivityIdentifier, $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $element));
                        $elementData = [];
                    }

                    $elementActivityIdentifier = Arr::get($row, $elementIdentifier, null) ?? $elementActivityIdentifier;
                }

                $systemMappedRow = [];

                foreach ($row as $fieldName => $fieldValue) {
                    if (!empty($fieldName) && $fieldName !== $elementIdentifier) {
                        $systemMappedRow[$elementMapper[$fieldName]] = $fieldValue;
                    }
                }

                $elementData[] = $systemMappedRow;
            } else {
                $this->pushIndicatorData($element, $elementActivityIdentifier, $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $element));
                break;
            }
        }
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
                    $parentBaseCount = array_fill_keys(array_keys($parentBaseCount), null);
                } elseif ($elementBase && $fieldName === $elementBase && $this->checkIfPeerAttributesAreNotEmpty($elementBasePeer, $row)) {
                    $baseCount = is_null($baseCount) ? 0 : $baseCount + 1;
                    $parentBaseCount = array_fill_keys(array_keys($parentBaseCount), null);
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

                if (!Arr::get($elementData, $elementPositionBasedOnParent, null)) {
                    Arr::set($elementData, $elementPositionBasedOnParent, $fieldValue);
                    $this->tempColumnTracker[$elementPositionBasedOnParent] = $this->sheetName . '!' . Arr::get($excelColumnName, $this->sheetName . '.' . $fieldName) . $this->rowCount;
                }
            }
            $this->rowCount++;
        }

        return $elementData;
    }

    protected function pushIndicatorData($element, $identifier, $data)
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
