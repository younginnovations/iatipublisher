<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * Class XlsExport.
 */
class XlsExport implements FromView, WithTitle, WithEvents, ShouldAutoSize
{
    /**
     * Holds data from database.
     *
     * @var array
     */
    protected array $data;

    /**
     * Holds Current Sheet name.
     *
     * @var string
     */
    protected string $sheetName;

    /**
     * For Sheet headers.
     *
     * @var array
     */
    protected array $sheetHeaders;

    /**
     * @var string
     */
    protected string $workSheetName;

    /*
     *
     * identifier column in sheet => sheet name
     */
    protected array $identifiers = [
        'activity_identifier' => 'Settings',
        'result_identifier' => 'Result_Mapper',
        'indicator_identifier' => 'Indicator_Mapper',
        'indicator_baseline_identifier' => 'Indicator_Baseline_Mapper',
        'period_identifier' => 'Period_Mapper',
        'actual_identifier' => 'Actual_Mapper',
        'target_identifier' => 'Target_Mapper',
    ];

    /**
     * @param $data
     * @param $sheetName
     * @param $sheetHeaders
     * @param $workSheetName
     */
    public function __construct($data, $sheetName, $sheetHeaders, $workSheetName)
    {
        $this->data = $data;
        $this->sheetName = $sheetName;
        $this->sheetHeaders = $sheetHeaders;
        $this->workSheetName = $workSheetName;
    }

    /**
     * Exports xls file using blade file formatted in table tags.
     *
     * @return View
     */
    public function view(): View
    {
        $totalData = $this->data;
        $headers = $this->sheetHeaders;

        return view('Export.xlsExport', ['activities' => $totalData, 'headers' => $headers]);
    }

    /**
     * Sets Sheet Name.
     *
     * @return string
     */
    public function title(): string
    {
        return $this->sheetName;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $startRow = 2;
                $endRow = 5000;
                $excelColumnIndex = readJsonFile('XlsImporter/Templates/excel-column-name-mapper.json');
                $excelColumnIndex = $excelColumnIndex[ucwords($this->workSheetName) . ' ' . $this->sheetName] ?? $excelColumnIndex[$this->sheetName] ?? null;
                $dropdownFields = readJsonFile('XlsImporter/Templates/dropdown-fields.json');
                $dropDownRange = readJsonFile('Exports/XlsExportTemplate/dropdownRange.json')[$this->workSheetName];

                if (!empty($excelColumnIndex)) {
                    // Apply the data validation to the range of cells
                    foreach ($excelColumnIndex as $columnName => $selectOptionCol) {
                        if (isset($dropdownFields[$columnName]) && !is_array($dropdownFields[$columnName])) {
                            $location = $dropdownFields[$columnName];
                        } else {
                            $searchFor = ' ';
                            $replaceWith = '_';
                            $mainString = $this->sheetName === 'Transaction' ? 'transactions' : strtolower($this->sheetName);
                            $stringPosition = strrpos($mainString, $searchFor);
                            $newString = !empty($stringPosition) ? substr_replace($mainString, $replaceWith, $stringPosition, strlen($searchFor)) : $mainString;
                            $newString = $newString === 'default aid_type' ? 'default_aid_type' : $newString;
                            $newString = $newString === 'country budget_items' ? 'country_budget_items' : $newString;
                            $newString = $newString === 'element with single_field' ? 'element_with_single_field' : $newString;
                            $location = Arr::get($dropdownFields, $newString . '.' . $columnName);
                        }

                        if (!empty($location)) {
                            if (isset($newString) && $newString . '.' . $columnName === 'activity_date.type') {
                                $columnName = $newString === 'activity_date' ? 'activity_date type' : $columnName;
                            }
                            if (isset($newString) && $newString . '.' . $columnName === 'contact_info.type') {
                                $columnName = $newString === 'contact_info' ? 'contact_info type' : $columnName;
                            }
                            if (isset($newString) && $newString . '.' . $columnName === 'humanitarian_scope.type') {
                                $columnName = $newString === 'humanitarian_scope' ? 'humanitarian_scope type' : $columnName;
                            }
                            if (isset($newString) && $newString . '.' . $columnName === 'participating_org.type') {
                                $columnName = $newString === 'participating_org' ? 'participating_org type' : $columnName;
                            }

//                            do something for above if conditions
                            if (isset($this->identifiers[$columnName])) {
                                $this->setIdentifierDropdown($dropDownRange, $columnName, $selectOptionCol, $startRow, $sheet, $this->identifiers[$columnName]);
                            } else {
                                $dropDownColumnIndex = $dropDownRange[$columnName]['index'];
                                $dropdownColumnMaxRow = $dropDownRange[$columnName]['max_row'];
                                $validation = $sheet->getDataValidation("$selectOptionCol$startRow:$selectOptionCol$endRow");
                                $validation->setType(DataValidation::TYPE_LIST);
                                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                                $validation->setAllowBlank(false);
                                $validation->setShowInputMessage(true);
                                $validation->setShowErrorMessage(true);
                                $validation->setShowDropDown(true);
                                $validation->setErrorTitle('Input error');
                                $validation->setError('Value is not in list.');
                                $validation->setPromptTitle('Pick from list');
                                $validation->setPrompt('Please pick a value from the drop-down list.');
                                $validation->setFormula1("Options!$$dropDownColumnIndex$3:$$dropDownColumnIndex$$dropdownColumnMaxRow");
                            }
                        }
                    }
                }

                $event->sheet->freezePane('A2');

                foreach (array_combine($excelColumnIndex, $this->sheetHeaders) as $columnIndex => $detail) {
                    $styleArray = [
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'argb' => $detail['color_code'] ?? '',
                            ],
                        ],
                    ];
                    $event->sheet->getDelegate()->getStyle("${columnIndex}1")->applyFromArray(isset($detail['color_code']) ? $styleArray : []);
                }
            },
        ];
    }

    public function setIdentifierDropdown($dropDownRange, $columnName, $selectOptionCol, $startRow, &$sheet, $dropdownFromSheetName)
    {
        $dropDownColumnIndex = $dropDownRange[$columnName]['index'];
        $validation = $sheet->getDataValidation("$selectOptionCol$startRow:$selectOptionCol$5000");
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $validation->setAllowBlank(false);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setErrorTitle('Input error');
        $validation->setError('Value is not in list.');
        $validation->setPromptTitle('Pick from list');
        $validation->setPrompt('Please pick a value from the drop-down list.');
        $validation->setFormula1("'$dropdownFromSheetName'!$$dropDownColumnIndex$2:$$dropDownColumnIndex$5000");
    }
}
