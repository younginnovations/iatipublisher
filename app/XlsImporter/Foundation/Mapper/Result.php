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
     * @var array|string[]
     */
    protected array $resultElements = [
        'Result' => 'result',
        'Result Document Link' => 'result_document_link',
    ];

    public function map($data)
    {
        $resultData = json_decode($data, true, 512, 0);

        foreach ($resultData as $sheetName => $content) {
            if ($sheetName === 'Result') {
                $this->columnToFieldMapper($this->resultElements[$sheetName], $content);
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
                        Arr::get($row, 'activity_identifier', null) &&
                        Arr::get($row, 'activity_identifier', null) !== $elementResultIdentifier
                    )
                ) {
                    if (!empty($elementData)) {
//                        $this->results[$elementResultIdentifier][$element] = $this->getElementData($elementData, $dependency[$element], $elementDropDownFields);
                        $elementData = [];
                    }

                    $elementActivityIdentifier = Arr::get($row, 'activity_identifier', null) ?? $elementActivityIdentifier;
                }
            }
        }
    }

    public function checkRowNotEmpty($row)
    {
        if (!is_array_value_empty($row)) {
            return true;
        }

        return false;
    }
}
