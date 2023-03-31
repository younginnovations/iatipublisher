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

    /**
     * @var array
     */
    protected array $resultDocumentLink = [];

    /**
     * @var array|string[]
     */
    protected array $resultElements = [
        'Result' => 'result',
        'Result Document Link' => 'result_document_link',
    ];

    /**
     * @var array
     */
    protected array $activityResultMapper = [];

    protected int $rowCount = 2;
    protected string $sheetName = '';
    protected array $columnTracker = [];

    public function map($data)
    {
        $resultData = json_decode($data, true, 512, JSON_THROW_ON_ERROR | 0);
        $resultData['Result Mapper'][0]['result_identifier'] = '289289892-result1';

        if (isset($resultData['Result Mapper'])) {
            $this->setActivityAndResultIdentifier($resultData['Result Mapper']);
        }

        if (isset($resultData['Result'])) {
            $this->sheetName = 'Result';
            $this->rowCount = 2;
            $this->columnToFieldMapper($this->resultElements['Result'], $resultData['Result']);
        }

        if (isset($resultData['Result Document Link'])) {
            $this->sheetName = 'Result Document Link';
            $this->rowCount = 2;
            $this->documentLinkColumnToFieldMapper($this->resultElements['Result Document Link'], $resultData['Result Document Link']);
        }

        $this->results = $this->combineResultAndDocumentLink();
        $this->validateResult();
    }

    public function validateResult()
    {
        $resultValidator = app(ResultValidator::class);
        foreach ($this->results as $activityIdentifier => $results) {
            foreach ($results as $resultIdentifier => $resultData) {
                $this->results[$activityIdentifier][$resultIdentifier] = $resultValidator
                    ->init($resultData)
                    ->validateData();
            }
        }
    }

    public function setActivityAndResultIdentifier($rows)
    {
        $activityIdentifier = null;
        $mapper = [];

        foreach ($rows as $fieldValue) {
            if (!$this->checkRowNotEmpty($fieldValue)) {
                break;
            }
            if ($this->checkRowNotEmpty($fieldValue)) {
                $mapper[$fieldValue['result_identifier']] = $activityIdentifier;

                if (!empty($fieldValue['activity_identifier'])) {
                    $mapper[$fieldValue['result_identifier']] = $fieldValue['activity_identifier'];
                    $activityIdentifier = $fieldValue['activity_identifier'];
                }
            }
        }
        $this->activityResultMapper = $mapper;
    }

    /**
     * @param $element
     * @param array $data
     *
     * @return void
     */
    public function columnToFieldMapper($element, array $data = [])
    {
        $elementData = [];
        $columnMapper = $this->getLinearizedActivity();
        $dropDownFields = $this->getDropDownFields();
        $dependency = $this->getDependencies();
        $elementMapper = array_flip($columnMapper[$element]);
        $elementDropDownFields = $dropDownFields[$element];
        $elementResultIdentifier = null;

        foreach ($data as $row) {
            if ($this->checkRowNotEmpty($row)) {
                if (
                    is_null($elementResultIdentifier) || (
                        Arr::get($row, 'result_identifier', null) &&
                        Arr::get($row, 'result_identifier', null) !== $elementResultIdentifier
                    )
                ) {
                    if (!empty($elementData)) {
                        $this->results[$this->activityResultMapper[$elementResultIdentifier]][$elementResultIdentifier] = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields)[0];
                        $elementData = [];
                    }
                    $elementResultIdentifier = Arr::get($row, 'result_identifier', null) ?? $elementResultIdentifier;
                }

                $systemMappedRow = [];

                foreach ($row as $fieldName => $fieldValue) {
                    if (!empty($fieldName) && $fieldName !== 'result_identifier') {
                        $systemMappedRow[$elementMapper[$fieldName]] = $fieldValue;
                    }
                }

                $elementData[] = $systemMappedRow;
            } else {
                $this->results[$this->activityResultMapper[$elementResultIdentifier]][$elementResultIdentifier] = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields)[0];
                break;
            }
        }
    }

    public function documentLinkColumnToFieldMapper($element, array $data = [])
    {
        $elementData = [];
        $columnMapper = $this->getLinearizedActivity();
        $dropDownFields = $this->getDropDownFields();
        $dependency = $this->getDependencies();
        $elementMapper = array_flip($columnMapper[$element]);
        $elementDropDownFields = $dropDownFields[$element];
        $elementResultIdentifier = null;

        foreach ($data as $row) {
            if ($this->checkRowNotEmpty($row)) {
                if (
                    is_null($elementResultIdentifier) || (
                        Arr::get($row, 'result_identifier', null) &&
                        Arr::get($row, 'result_identifier', null) !== $elementResultIdentifier
                    )
                ) {
                    if (!empty($elementData)) {
                        $this->resultDocumentLink[$elementResultIdentifier] = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields);
                        $elementData = [];
                    }
                    $elementResultIdentifier = Arr::get($row, 'result_identifier', null) ?? $elementResultIdentifier;
                }

                $systemMappedRow = [];

                foreach ($row as $fieldName => $fieldValue) {
                    if (!empty($fieldName) && $fieldName !== 'result_identifier') {
                        $systemMappedRow[$elementMapper[$fieldName]] = $fieldValue;
                    }
                }

                $elementData[] = $systemMappedRow;
            } else {
                $data = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields);

                $this->resultDocumentLink[$elementResultIdentifier] = $data;
                //                $this->resultDocumentLink[$this->activityResultMapper[$elementResultIdentifier]]['document_link'] = [ $data['document_link'] ];
                break;
            }
        }
    }

    public function getElementData($data, $dependency, $elementDropDownFields): array
    {
        $elementData = [];
        $elementBase = $dependency['elementBase'];
        $elementBasePeer = $dependency['elementBasePeer'];
        $baseCount = null;
        $fieldDependency = $dependency['fieldDependency'];
        $parentBaseCount = [];
        $excelColumnName = $this->getExcelColumnNameMapper();

        foreach ($fieldDependency as $dependents) {
            $parentBaseCount[$dependents['parent']] = null;
        }

        foreach ($data as $row) {
            foreach ($row as $fieldName => $fieldValue) {
                if (($fieldName === $elementBase && $fieldValue)) {
                    $baseCount = is_null($baseCount) ? 0 : $baseCount + 1;
                } elseif ($fieldName === $elementBase && $this->checkIfPeerAttributesAreNotEmpty($elementBasePeer, $row)) {
                    $baseCount = is_null($baseCount) ? 0 : $baseCount + 1;
                }

                if (array_key_exists($fieldName, $fieldDependency)) {
                    $parentKey = $fieldDependency[$fieldName]['parent'];
                    $peerAttributes = Arr::get($fieldDependency[$fieldName], 'peer', []);

                    if ($fieldValue) {
                        $parentBaseCount[$parentKey] = is_null($parentBaseCount[$parentKey]) ? 0 : $parentBaseCount[$parentKey] + 1;
                    } elseif ($this->checkIfPeerAttributesAreNotEmpty($peerAttributes, $row)) {
                        $parentBaseCount[$parentKey] = is_null($parentBaseCount[$parentKey]) ? 0 : $parentBaseCount[$parentKey] + 1;
                    }
                }

                if (array_key_exists($fieldName, $elementDropDownFields)) {
                    $fieldValue = $this->mapDropDownValueToKey($fieldValue, $elementDropDownFields[$fieldName]);
                }

                $elementPosition = $this->getElementPosition($parentBaseCount, $fieldName);

                $elementPositionBasedOnParent = empty($elementPosition) ? $baseCount : $baseCount . '.' . $elementPosition;

                if (!Arr::get($elementData, $elementPositionBasedOnParent, null)) {
                    Arr::set($elementData, $elementPositionBasedOnParent, $fieldValue);
                    $this->columnTracker[$elementPositionBasedOnParent] = $this->sheetName . '!' . Arr::get($excelColumnName, $this->sheetName . '.' . $fieldName) . $this->rowCount;
                }
            }
            $this->rowCount++;
        }

        return $elementData;
    }

    public function combineResultAndDocumentLink()
    {
        $results = $this->results;
        $resultDocumentLink = $this->resultDocumentLink;

        $documentLink = [];

        foreach ($resultDocumentLink as $key => $documentLinkData) {
            $documentLink[$key]['document_link'] = array_column($documentLinkData, 'document_link');
        }

        foreach ($results as $activityIdentifier => $resultData) {
            foreach ($resultData as $resultIdentifier => $result) {
                if (array_key_exists($resultIdentifier, $documentLink)) {
                    $results[$activityIdentifier][$resultIdentifier] = $result + $documentLink[$resultIdentifier];
                }
            }
        }

        return $results;
    }
}
