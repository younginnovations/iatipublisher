<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use Illuminate\Support\Arr;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/*
 * Class TrackMigrationErrorTrait.
 */
trait TrackMigrationErrorTrait
{
    /**
     * ErrorArray template.
     *
     * @var array|array[]
     */
    public array $errorsArrayTemplate = [
        'file-migration-errors'  => [
            [
                'error-msg'          => '',
                'aidstream-org-id'   => '',
                'iati-org-id'        => '',
                'aidstream-filename' => '',
                'iati-filename'      => '',
                'aidstream-id'       => '',
                'iati-id'            => '',
            ],
        ],
        'table-migration-errors' => [
            [
                'error-msg'        => '',
                'aidstream-org-id' => '',
                'iati-org-id'      => '',
                'aidstream-id'     => '',
                'iati-id'          => '',
            ],
        ],
        'general-errors'         => [
            [
                'error-msg'        => '',
                'aidstream-org-id' => '',
                'iati-org-id'      => '',
                'aidstream-id'     => '',
                'iati-id'          => '',
            ],
        ],
    ];

    /**
     * Information about each worksheet and columns.
     *
     * @var array|array[]
     */
    public array $worksheetInfo = [
        'file-migration-errors' => [
            'error-msg'          => 'A',
            'aidstream-org-id'   => 'B',
            'iati-org-id'        => 'C',
            'aidstream-filename' => 'D',
            'iati-filename'      => 'E',
            'aidstream-id'       => 'F',
            'iati-id'            => 'G',
        ],
        'table-migration-errors' => [
            'error-msg'        => 'A',
            'aidstream-org-id' => 'B',
            'iati-org-id'      => 'C',
            'aidstream-id'     => 'D',
            'iati-id'          => 'E',
        ],
        'general-errors' => [
            'error-msg'        => 'A',
            'aidstream-org-id' => 'B',
            'iati-org-id'      => 'C',
            'aidstream-id'     => 'D',
            'iati-id'          => 'E',
        ],
    ];

    /**
     * Populates spreadsheet with errors and saves it.
     *
     * @param array $errorsArray
     *
     * @return void
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function trackMigrationErrors(array $errorsArray = []): void
    {
        $spreadsheet = $this->openSpreadSheet();

        if (empty($errorsArray)) {
            $errorsArray = $this->errorsArrayTemplate;
        }

        foreach ($this->worksheetInfo as $key => $sheetHeaders) {
            $worksheet = $spreadsheet->getSheetByName($key);
            $this->populateMigrationXlsx($worksheet, Arr::get($errorsArray, $key, []), $sheetHeaders);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save(storage_path('app/Migration/Migration-errors.xlsx'));
    }

    /**
     * Returns xlsx spreadsheet instance.
     *
     * @return Spreadsheet
     * @throws Exception
     */
    public function openSpreadSheet(): Spreadsheet
    {
        $filename = 'Migration-errors.xlsx';
        $reader = IOFactory::createReader('Xlsx');

        return $reader->load(storage_path("app/Migration/{$filename}"));
    }

    /**
     * Populates worksheet.
     * 1 sheet in a spreadsheet is called a worksheet.
     *
     * @param $worksheet
     * @param $errors
     * @param array $tableHeaders
     *
     * @return void
     */
    public function populateMigrationXlsx($worksheet, $errors, array $tableHeaders): void
    {
        $highestRow = $worksheet->getHighestDataRow();
        $startRow = (int) $highestRow + 1;
        $count = count($errors);

        if ($errors) {
            for ($i = 0; $i < $count; $i++) {
                $insertRow = $startRow + $i;
                $this->insertRow($worksheet, $errors[$i], $tableHeaders, $insertRow);
            }
        }
    }

    /**
     * Populates a row.
     *
     * @param $worksheet
     * @param $error
     * @param array $tableHeaders
     * @param $insertRow
     *
     * @return void
     */
    public function insertRow($worksheet, $error, array $tableHeaders, $insertRow): void
    {
        foreach ($tableHeaders as $key=>$column) {
            $worksheet->setCellValue("{$column}{$insertRow}", $error[$key]);
        }
    }

    /**
     * Push error into errors['general-errors'] array.
     *
     * @param string $message
     * @param int|string $aidstreamOrgId
     * @param int|string $iatiOrgId
     * @param int|string $aidstreamActivityId
     * @param int|string $iatiActivityId
     *
     * @return void
     */
    public function setGeneralError(
        string $message,
        int | string $aidstreamOrgId = '',
        int | string $iatiOrgId = '',
        int | string $aidstreamActivityId = '',
        int | string $iatiActivityId = ''
    ): void {
        $this->errors['general-errors'][] = [
            'error-msg'        => $message,
            'aidstream-org-id' => $aidstreamOrgId,
            'iati-org-id'      => $iatiOrgId,
            'aidstream-id'     => $aidstreamActivityId,
            'iati-id'          => $iatiActivityId,
        ];
    }

    /**
     * Push error into errors['table-migration-errors'] array.
     *
     * @param string $message
     * @param int|string $aidstreamOrgId
     * @param int|string $iatiOrgId
     * @param int|string $aidstreamActivityId
     * @param int|string $iatiActivityId
     *
     * @return void
     */
    public function setTableMigrationError(
        string $message,
        int | string $aidstreamOrgId = '',
        int | string $iatiOrgId = '',
        int | string $aidstreamActivityId = '',
        int | string $iatiActivityId = ''
    ): void {
        $this->errors['table-migration-errors'][] = [
            'error-msg'        => $message,
            'aidstream-org-id' => $aidstreamOrgId,
            'iati-org-id'      => $iatiOrgId,
            'aidstream-id'     => $aidstreamActivityId,
            'iati-id'          => $iatiActivityId,
        ];
    }

    /**
     * Push error into errors['table-migration-errors'] array.
     *
     * @param string $message
     * @param int|string $aidstreamOrgId
     * @param int|string $iatiOrgId
     * @param int|string $aidstreamFilename
     * @param int|string $iatiFilename
     * @param int|string $aidstreamActivityId
     * @param int|string $iatiActivityId
     *
     * @return void
     */
    public function setFileMigrationError(
        string $message,
        int | string $aidstreamOrgId = '',
        int | string $iatiOrgId = '',
        int | string $aidstreamFilename = '',
        int | string $iatiFilename = '',
        int | string $aidstreamActivityId = '',
        int | string $iatiActivityId = ''
    ): void {
        $this->errors['file-migration-errors'][] = [
            'error-msg'          => $message,
            'aidstream-org-id'   => $aidstreamOrgId,
            'iati-org-id'        => $iatiOrgId,
            'aidstream-filename' => $aidstreamFilename,
            'iati-filename'      => $iatiFilename,
            'aidstream-id'       => $aidstreamActivityId,
            'iati-id'            => $iatiActivityId,
        ];
    }
}
