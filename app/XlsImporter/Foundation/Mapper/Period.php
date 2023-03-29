<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Mapper;

use Illuminate\Support\Arr;

/**
 * Class Activity.
 */
class Period
{
    // public string $templatePath = app_path().'XlsImporter/Templates';

    //activities whose identifier is mentioned on setting sheet
    protected array $periods = [];

    //
    protected array $indicatorIdentifier = [];

    // activities whose identifier is not mentioned on setting
    protected array $periodIdentifier = [];

    protected array $identifiers = [];

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

    public function map($periodData)
    {
        $periodData = json_decode($periodData, true, 512, 0);

        foreach ($periodData as $sheetName => $content) {
            if (in_array($sheetName, array_keys($this->mappers))) {
                $this->mapPeriods($content, $sheetName);
            }

            if (in_array($sheetName, array_keys($this->periodDivisions))) {
                $this->columnToFieldMapper($this->periodDivisions[$sheetName], $content);
            }
        }

        $this->removeUnwantedData();
    }

    public function removeUnwantedData()
    {
        foreach ($this->periods as $indicatorIdentifier => $periods) {
            foreach ($periods as $periodIdentifier => $periodData) {
                $this->periods[$indicatorIdentifier][$periodIdentifier]['period']['target'] = array_values($periodData['period']['target']);
                $this->periods[$indicatorIdentifier][$periodIdentifier]['period']['actual'] = array_values($periodData['period']['actual']);
            }
        }
    }

    public function getLinearizedActivity()
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/linearized-activity.json'), true, 512, 0);
    }

    public function getDependencies()
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/field-dependencies.json'), true, 512, 0);
    }

    public function getDropDownFields()
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/dropdown-fields.json'), true, 512, 0);
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
                        $this->pushPeriodData($element, $elementActivityIdentifier, $this->getElementData($elementData, $dependency[$element], $elementDropDownFields));
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
                $this->pushPeriodData($element, $elementActivityIdentifier, $this->getElementData($elementData, $dependency[$element], $elementDropDownFields));
                break;
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
    }

    protected function pushPeriod($identifier, $data): void
    {
        $indicatorIdentifier = Arr::get($this->identifiers, "period.$identifier", null);

        $this->periods[$indicatorIdentifier][$identifier]['period'] = $data;
    }

    protected function pushPeriodTarget($identifier, $data): void
    {
        $periodIdentifier = Arr::get($this->identifiers, 'target.' . $identifier, null);
        $indicatorIdentifier = Arr::get($this->identifiers, "period.$periodIdentifier", null);

        $this->periods[$indicatorIdentifier][$periodIdentifier]['period']['target'][$identifier] = $data;
    }

    protected function pushPeriodActual($identifier, $data): void
    {
        $periodIdentifier = Arr::get($this->identifiers, "actual.$identifier", null);
        $indicatorIdentifier = Arr::get($this->identifiers, "period.$periodIdentifier", null);

        $this->periods[$indicatorIdentifier][$periodIdentifier]['period']['actual'][$identifier] = $data;
    }

    protected function pushTargetDocumentLink($identifier, $data): void
    {
        $periodIdentifier = Arr::get($this->identifiers, "target.$identifier", null);
        $indicatorIdentifier = Arr::get($this->identifiers, "period.$periodIdentifier", null);

        $this->periods[$indicatorIdentifier][$periodIdentifier]['period']['target'][$identifier]['document_link'] = $data;
    }

    protected function pushActualDocumentLink($identifier, $data): void
    {
        $periodIdentifier = Arr::get($this->identifiers, "actual.$identifier", null);
        $indicatorIdentifier = Arr::get($this->identifiers, "period.$periodIdentifier", null);

        $this->periods[$indicatorIdentifier][$periodIdentifier]['period']['actual'][$identifier]['document_link'] = $data;
    }

    public function mapDropDownValueToKey($value, $location)
    {
        // should we consider case?
        if (is_null($value)) {
            return $value;
        }

        if (is_array($location)) {
            return Arr::get($location, $value, $value);
        }

        $locationArr = explode('/', $location);

        $dropDownValues = array_flip(getCodeList(explode('.', $locationArr[1])[0], $locationArr[0]));
        $key = Arr::get($dropDownValues, $value, $value);

        return $key;
    }

    public function getElementData($data, $dependency, $elementDropDownFields): array
    {
        $elementData = [];
        $elementBase = Arr::get($dependency, 'elementBase', null);
        $elementBasePeer = Arr::get($dependency, 'elementBasePeer', []);
        $baseCount = null;
        $fieldDependency = $dependency['fieldDependency'];
        $parentBaseCount = [];

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

    public function checkRowNotEmpty($row)
    {
        if (implode('', array_values($row))) {
            return true;
        }

        return false;
    }
}
