<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use JsonException;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

/**
 * Class XlsExport.
 */
class XlsExport implements FromView, WithTitle, WithEvents, ShouldAutoSize, WithColumnFormatting
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
     * Identifiers so that it can be used to get its dropdown range in xls
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
     * DropdownRange.json contains "type" field
     * but there are also field like activity_date type which consist of extra character besides type.
     *
     * @var array
     */
    protected array $specialCaseTypeColumn = [
        'activity_date.type' => 'activity_date type',
        'contact_info.type' => 'contact_info type',
        'humanitarian_scope.type' => 'humanitarian_scope type',
        'participating_org.type' => 'participating_org type',
    ];

    /**
     * Mapper Concatenator for concatenating the identifier using formula.
     *
     * @var array|string[]
     */
    protected array $mapperConcatenator = [
      'Result_Mapper' => '_',
      'Indicator_Mapper' => '_',
      'Indicator_Baseline_Mapper' => '_b-',
      'Period_Mapper' => '_',
      'Actual_Mapper' => '_a-',
      'Target_Mapper' => '_t-',
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
        return view('Export.xlsExport', ['activities' => $this->data, 'headers' => $this->sheetHeaders]);
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

    /**
     * Checks if dropdown exists and then populate the rows with dropdown
     * Color Code sheet header cell as well as sheet tab.
     *
     * @return mixed
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->freezePane('A2');
                $excelColumnIndex = readJsonFile('XlsImporter/Templates/excel-column-name-mapper.json');
                $excelColumnIndex = $excelColumnIndex[ucwords($this->workSheetName) . ' ' . $this->sheetName] ?? $excelColumnIndex[$this->sheetName] ?? null;

                if (!empty($excelColumnIndex)) {
                    foreach ($excelColumnIndex as $columnName => $selectOptionCol) {
                        $columnName = $this->hasDropdownValue($columnName);

                        if (!empty($columnName)) {
                            $this->setDropdownValue($columnName, $sheet, $selectOptionCol);
                        } elseif (in_array($this->sheetName, ['Result_Mapper', 'Indicator_Mapper', 'Indicator_Baseline_Mapper', 'Period_Mapper', 'Actual_Mapper', 'Target_Mapper'])) {
                            // Set the formula for each cell in the range
                            $concatenation = $this->mapperConcatenator[$this->sheetName];

                            for ($row = 2; $row <= 5000; $row++) {
                                $cellCoordinate = 'C' . $row;
                                $formula = '=IFERROR(IF(B' . $row . '<>"",CONCATENATE(xlookup("*",$A$2:A' . $row . ',$A$2:A' . $row . ',"",2,-1),"' . $concatenation . '",B' . $row . '),""),IF(B' . $row . '<>"",CONCATENATE(LOOKUP(2,1/($A$2:A' . $row . '<>""),$A$2:A' . $row . '),"' . $concatenation . '",B' . $row . '),""))';
                                $sheet->setCellValueExplicit($cellCoordinate, $formula, DataType::TYPE_FORMULA);
                            }
                        }
                    }
                }

                $this->sheetTabColorCode($event->sheet);
                $this->xlsHeaderColorCode($excelColumnIndex, $event->sheet);
            },
        ];
    }

    /**
     * Checks if the column has dropdown.
     *
     * @param $columnName
     *
     * @throws JsonException
     *
     * @return mixed|string|null
     */
    public function hasDropdownValue($columnName): mixed
    {
        $dropdownFields = readJsonFile('XlsImporter/Templates/dropdown-fields.json');

        if (isset($dropdownFields[$columnName]) && !is_array($dropdownFields[$columnName])) {
            $location = $dropdownFields[$columnName];
        } else {
            $searchFor = ' ';
            $replaceWith = '_';
            $mainString = $this->sheetName === 'Transaction' ? 'transactions' : strtolower($this->sheetName);
            $stringPosition = strrpos($mainString, $searchFor);
            $newString = !empty($stringPosition) ? substr_replace($mainString, $replaceWith, $stringPosition, strlen($searchFor)) : $mainString;

            $getNewString = [
                'default aid_type' => 'default_aid_type',
                'country budget_items' => 'country_budget_items',
                'element with single_field' => 'element_with_single_field',
            ];
            $newString = $getNewString[$newString] ?? $newString;
            $location = Arr::get($dropdownFields, $newString . '.' . $columnName);

            if (array_key_exists($newString . '.' . $columnName, $this->specialCaseTypeColumn)) {
                $columnName = $this->specialCaseTypeColumn[$newString . '.' . $columnName];
            }
        }

        if (!empty($location)) {
            return $columnName;
        }

        return null;
    }

    /**
     * sets dropdown from a range using formula.
     *
     * @param $columnName
     * @param $sheet
     * @param $selectOptionCol
     *
     * @throws JsonException
     *
     * @return void
     */
    public function setDropdownValue($columnName, $sheet, $selectOptionCol): void
    {
        $dropDownRange = readJsonFile('Exports/XlsExportTemplate/dropdownRange.json')[$this->workSheetName];

        if (isset($this->identifiers[$columnName])) {
            $this->setIdentifierDropdown($dropDownRange, $columnName, $selectOptionCol, $sheet, $this->identifiers[$columnName]);
        } else {
            $this->setSheetCellDropdown($dropDownRange, $columnName, $selectOptionCol, $sheet);
        }
    }

    /**
     * sets dropdown from a range using formula.
     *
     * @param $dropDownRange
     * @param $columnName
     * @param $selectOptionCol
     * @param $sheet
     *
     * @return void
     */
    public function setSheetCellDropdown($dropDownRange, $columnName, $selectOptionCol, $sheet): void
    {
        $startRow = 2;
        $endRow = 5000;
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

    /**
     * Sets color code for a header in xls.
     *
     * @param $excelColumnIndex
     * @param $sheet
     *
     * @return void
     */
    public function xlsHeaderColorCode($excelColumnIndex, $sheet): void
    {
        foreach (array_combine($excelColumnIndex, $this->sheetHeaders) as $columnIndex => $detail) {
            $styleArray = [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => $detail['color_code'] ?? '',
                    ],
                ],
            ];

            $sheet->getDelegate()->getStyle("${columnIndex}1")->applyFromArray(isset($detail['color_code']) ? $styleArray : []);
        }
    }

    /**
     * Sets color for a sheet.
     *
     * @param $sheet
     *
     * @throws JsonException
     *
     * @return void
     */
    public function sheetTabColorCode($sheet): void
    {
        $sheetColorCode = readJsonFile('Exports/XlsExportTemplate/xls-sheet-color-code-mapper.json');

        if (isset($sheetColorCode[$this->sheetName])) {
            $sheet->getTabColor()->setRGB($sheetColorCode[$this->sheetName]);
        }
    }

    /**
     * Sets dropdown for a identifier.
     *
     * @param $dropDownRange
     * @param $columnName
     * @param $selectOptionCol
     * @param $sheet
     * @param $dropdownFromSheetName
     *
     * @return void
     */
    public function setIdentifierDropdown($dropDownRange, $columnName, $selectOptionCol, $sheet, $dropdownFromSheetName): void
    {
        $startRow = 2;
        $endRow = 5000;
        $dropDownColumnIndex = $dropDownRange[$columnName]['index'];
        $validation = $sheet->getDataValidation("$selectOptionCol$startRow:$selectOptionCol$$endRow");
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
        $validation->setFormula1("$dropdownFromSheetName!$$dropDownColumnIndex$2:$$dropDownColumnIndex$$endRow");
    }

    /**
     * Formats Certain column.
     *
     * @return array
     */
    public function columnFormats(): array
    {
        if ($this->sheetName === 'Contact Info') {
            return [
               'K' => NumberFormat::FORMAT_NUMBER,
            ];
        }

        if (array_key_exists($this->sheetName, $this->mapperConcatenator)) {
            return [
                'B' => NumberFormat::FORMAT_NUMBER,
            ];
        }

        return [];
    }
}
