<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Mapper;

use Illuminate\Support\Arr;

/**
 * Class Result.
 */
class Result
{
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

    public function map($data)
    {
        $resultData = json_decode($data, true, 512, JSON_THROW_ON_ERROR | 0);
        $resultData['Result Mapper'][0]['result_identifier'] = '289289892-result1';

        if (isset($resultData['Result Mapper'])) {
            $this->setActivityAndResultIdentifier($resultData['Result Mapper']);
        }

        if (isset($resultData['Result'])) {
            $this->columnToFieldMapper($this->resultElements['Result'], $resultData['Result']);
        }

        if (isset($resultData['Result Document Link'])) {
            $this->documentLinkColumnToFieldMapper($this->resultElements['Result Document Link'], $resultData['Result Document Link']);
        }

        $this->combineResultAndDocumentLink();
    }

    public function setActivityAndResultIdentifier($rows)
    {
        foreach ($rows as $fieldValue) {
            if ($this->checkRowNotEmpty($fieldValue)) {
                $this->activityResultMapper = [
                    $fieldValue['result_identifier'] => $fieldValue['activity_identifier'],
                ];
            } else {
                break;
            }
        }
    }

    public function getLinearizedActivity()
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/linearized-activity.json'), true, 512, 0);
    }

    public function getDropDownFields()
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/dropdown-fields.json'), true, 512, 0);
    }

    public function getDependencies()
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/field-dependencies.json'), true, 512, 0);
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
                        $this->results[$elementResultIdentifier][$element] = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields)[0];
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
                $this->results[$elementResultIdentifier][$element] = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields)[0];
                $this->results[$elementResultIdentifier]['activity_identifier'] = $this->activityResultMapper[$elementResultIdentifier];
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
                $data = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields)[0];
                $this->resultDocumentLink[$elementResultIdentifier]['document_link'] = [$data['document_link']];
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
                    $peerAttributes = $fieldDependency[$fieldName]['peer'];

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
                }
            }
        }

        return $elementData;
    }

    public function checkIfPeerAttributesAreNotEmpty(array $peerAttributes, array $rowContent): bool
    {
        foreach ($peerAttributes as $attributeName) {
            if (Arr::get($rowContent, $attributeName, null)) {
                return true;
            }
        }

        return false;
    }

    public function getElementPosition($fieldDependency, $dependencies): string
    {
        $position = '';
        $dependency = explode(' ', $dependencies);
        $expected_position = '';

        foreach ($dependency as $key) {
            $expected_position = empty($expected_position) ? $key : "$expected_position $key";

            if (in_array($expected_position, array_keys($fieldDependency))) {
                $positionValue = $fieldDependency[$expected_position];
                $position = empty($position) ? $key . '.' . $positionValue : "$position.$key.$positionValue";
            } else {
                $position = empty($position) ? "$key" : "$position.$key";
            }
        }

        return $position;
    }

    public function mapDropDownValueToKey($value, $location)
    {
        // should we consider case?
        if (is_null($value)) {
            return $value;
        }

        //
        if (is_array($location)) {
            return Arr::get($location, $value, $value);
        }

        $locationArr = explode('/', $location);
        $dropDownValues = array_flip(getCodeList(explode('.', $locationArr[1])[0], $locationArr[0]));
        $key = Arr::get($dropDownValues, $value, $value);

        return $key;
    }

    public function checkRowNotEmpty($row)
    {
        if (!is_array_value_empty($row)) {
            return true;
        }

        return false;
    }

    public function combineResultAndDocumentLink()
    {
        $results = $this->results;
        $resultDocumentLink = $this->resultDocumentLink;
        $combinedResult = array_merge_recursive($results, $resultDocumentLink);

        foreach ($combinedResult as $key => $result) {
            $combinedResult[$key]['result'] = $result['result'] + ['document_link' => $result['document_link']];
            unset($combinedResult[$key]['document_link']);
        }

        return $combinedResult;
    }
}
