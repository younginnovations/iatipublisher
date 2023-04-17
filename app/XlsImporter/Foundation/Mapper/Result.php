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
    protected string $elementBeingProcessed = '';

    protected string $statusFilePath = '';
    protected string $validatedDataFilePath = '';

    protected array $existingIdentifier = [];

    /**
     * Division of indicator data based on sheet names.
     *
     * @var array
     */
    protected array $resultDivision = [
        'Result' => 'result',
        'Result Document Link' => 'result_document_link',
    ];

    /**
     * Identifier column for each indicator data sheet.
     *
     * @var array
     */
    protected array $elementIdentifiers = [
        'result' => 'result_identifier',
        'result_document_link' => 'result_identifier',
    ];

    /**
     * Mapper sheets and their details.
     *
     * @var array
     */
    protected array $mappers = [
        'Result Mapper' => [
            'columns' => [
                'parentIdentifier' => 'result_identifier',
                'number' => 'result_number',
            ],
            'concatinator' => '_',
            'type' => 'result',
        ],
    ];

    public function initMapper($validatedDataFilePath, $statusFilePath, $existingIdentifier)
    {
        $this->validatedDataFilePath = $validatedDataFilePath;
        $this->statusFilePath = $statusFilePath;
        $this->existingIdentifier = $existingIdentifier;
    }

    public function map($resultData)
    {
        foreach ($resultData as $sheetName => $content) {
            $this->sheetName = $sheetName;
            $this->rowCount = 2;

            if (array_key_exists($sheetName, $this->mappers)) {
                $this->mapMapperSheets($content, $sheetName);
            }

            if (array_key_exists($sheetName, $this->resultDivision)) {
                $this->columnToFieldMapper($this->resultDivision[$sheetName], $content);
            }
        }
        dd($this->results, $this->identifiers);

        return $this;
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

                $this->resultIdentifier[$sheetName][$parentIdentifierValue][] = sprintf('%s%s%s', $parentIdentifierValue, $mapperDetails['concatinator'], $row[$numberKey]);
                $this->identifiers[$mapperDetails['type']][sprintf('%s%s%s', $parentIdentifierValue, $mapperDetails['concatinator'], $row[$numberKey])] = $parentIdentifierValue;
            } else {
                break;
            }
        }
    }

    public function validateResult()
    {
        $errors = [];
        $resultValidator = app(ResultValidator::class);

        foreach ($this->results as $activityIdentifier => $results) {
            foreach ($results as $resultIdentifier => $resultData) {
                $errors[$resultIdentifier] = $resultValidator
                    ->init($resultData)
                    ->validateData();
                $excelColumnAndRowName = isset($this->columnTracker[$activityIdentifier]) ? Arr::collapse($this->columnTracker[$activityIdentifier]) : null;
                $columnAppendedError = $this->appendExcelColumnAndRowDetail($errors, $excelColumnAndRowName);
                $existingId = Arr::get($this->existingIdentifier, sprintf('%s_%s', $activityIdentifier, $resultIdentifier), false);
                $this->processedCount++;
                $this->storeValidatedData($resultData, $columnAppendedError, $existingId, $activityIdentifier);
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
        // dump($dependency, 'element',$element);

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
                        $this->appendResultData($element, $elementActivityIdentifier, $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $element));
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
                // $this->appendResultData($element, $elementActivityIdentifier, $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $element));
                break;
            }

            if (!empty($elementData)) {
                $this->appendResultData($element, $elementActivityIdentifier, $this->getElementData($elementData, $dependency[$element], $elementDropDownFields, $element));
                $elementData = [];
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

                if (!Arr::get($elementData, $elementPositionBasedOnParent, null)) {
                    Arr::set($elementData, $elementPositionBasedOnParent, $fieldValue);
                    $this->tempColumnTracker[$elementPositionBasedOnParent] = $this->sheetName . '!' . Arr::get($excelColumnName, $this->sheetName . '.' . $fieldName) . $this->rowCount;
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
            'result_document_link' => 'appendResultDocumentLink',
        ];

        call_user_func([$this, $periodElementFunctions[$element]], $identifier, $data);
        $this->tempColumnTracker = [];
    }

    protected function appendResult($identifier, $data): void
    {
        $activityIdentifier = Arr::get($this->identifiers, "activity.$identifier", null);

        $this->results[$activityIdentifier][$identifier]['results'] = $data;
        $this->columnTracker[$activityIdentifier][$identifier]['results'] = $this->tempColumnTracker;
    }

    protected function appendResultDocumentLink($identifier, $data): void
    {
        $activityIdentifier = Arr::get($this->identifiers, "activity.$identifier", null);
        $this->results[$activityIdentifier][$identifier]['results']['document_link'] = $data;

        $this->updateColumnTracker($activityIdentifier, $identifier, 'results.document_link');
    }

    protected function updateColumnTracker($activityIdentifier, $identifier, $keyPrefix)
    {
        foreach ($this->tempColumnTracker as $columnPosition => $columnIndex) {
            $this->columnTracker[$activityIdentifier][$identifier]["$keyPrefix.$columnPosition"] = $columnIndex;
        }
    }

    // public function checkIfPeerAttributesAreNotEmpty(array $peerAttributes, array $rowContent): bool
    // {
    //     foreach ($peerAttributes as $attributeName) {
    //         if (Arr::get($rowContent, $attributeName, null)) {
    //             return true;
    //         }
    //     }

    //     return false;
    // }
}
