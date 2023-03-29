<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Mapper;

use Illuminate\Support\Arr;

/**
 * Class Activity.
 */
class Indicator
{
    // public string $templatePath = app_path().'XlsImporter/Templates';

    //activities whose identifier is mentioned on setting sheet
    protected array $indicators = [];

    //
    protected array $indicatorIdentifier = [];

    // activities whose identifier is not mentioned on setting
    protected array $periodIdentifier = [];

    protected array $identifiers = [];

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
        $indicatorData = json_decode($indicatorData, true, 512, 0);

        foreach ($indicatorData as $sheetName => $content) {
            dump($sheetName);
            if (in_array($sheetName, array_keys($this->mappers))) {
                $this->mapIndicators($content, $sheetName);
            }

            if (in_array($sheetName, array_keys($this->indicatorDivision))) {
                $this->columnToFieldMapper($this->indicatorDivision[$sheetName], $content);
            }
        }

        dd($this->identifiers, $this->indicatorIdentifier, $this->indicators);
        $this->removeUnwantedData();
        dd('here', json_encode($this->indicators), $this->identifiers);
    }

    public function removeUnwantedData()
    {
        foreach ($this->indicators as $resultIdentifier => $indicators) {
            foreach ($indicators as $indicatorIdentifier => $indicatorData) {
                // $this->indicators[$resultIdentifier][$indicatorIdentifier]['baseline'] = array_values($indicatorData['period']['target']);
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
                        $this->pushIndicatorData($element, $elementActivityIdentifier, $this->getElementData($elementData, $dependency[$element], $elementDropDownFields));
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
                $this->pushIndicatorData($element, $elementActivityIdentifier, $this->getElementData($elementData, $dependency[$element], $elementDropDownFields));
                break;
            }
        }
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
    }

    protected function pushIndicator($identifier, $data): void
    {
        $resultIdentifier = Arr::get($this->identifiers, "indicator.$identifier", null);

        $this->indicators[$resultIdentifier][$identifier]['indicator'] = $data[0];
    }

    protected function pushIndicatorDocumentLink($identifier, $data): void
    {
        $resultIdentifier = Arr::get($this->identifiers, "indicator.$identifier", null);

        $this->indicators[$resultIdentifier][$identifier]['indicator']['document_link'] = $data;
    }

    protected function pushIndicatorBaseline($identifier, $data): void
    {
        $indicatorIdentifier = Arr::get($this->identifiers, "baseline.$identifier", null);
        $resultIdentifier = Arr::get($this->identifiers, "indicator.$indicatorIdentifier", null);

        $this->indicators[$resultIdentifier][$indicatorIdentifier]['indicator']['baseline'][$identifier] = $data[0];
    }

    protected function pushIndicatorBaselineDocumentLink($identifier, $data): void
    {
        $indicatorIdentifier = Arr::get($this->identifiers, "baseline.$identifier", null);
        $resultIdentifier = Arr::get($this->identifiers, "indicator.$indicatorIdentifier", null);

        $this->indicators[$resultIdentifier][$indicatorIdentifier]['indicator']['baseline'][$identifier]['document_link'] = $data;
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
