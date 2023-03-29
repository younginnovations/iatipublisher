<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        'general-errors'         => [
            [
                'error-msg'        => '',
                'aidstream-org-id' => '',
                'iati-org-id'      => '',
                'scope'             => '',
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
        'general-errors' => [
            'error-msg'        => 'A',
            'aidstream-org-id' => 'B',
            'iati-org-id'      => 'C',
            'scope'            => 'D',
            'aidstream-id'     => 'E',
            'iati-id'          => 'F',
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
        $this->createMigrationErrorXlsxIfNotExists();

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
     * @param string $scope
     * @param int|string $aidstreamActivityId
     * @param int|string $iatiActivityId
     *
     * @return void
     */
    public function setGeneralError(
        string $message,
        int | string $aidstreamOrgId = '',
        int | string $iatiOrgId = '',
        string $scope = '',
        int | string $aidstreamActivityId = '',
        int | string $iatiActivityId = ''
    ): void {
        $this->errors['general-errors'][] = [
            'error-msg'        => $message,
            'aidstream-org-id' => $aidstreamOrgId,
            'iati-org-id'      => $iatiOrgId,
            'scope'            => $scope,
            'aidstream-id'     => $aidstreamActivityId,
            'iati-id'          => $iatiActivityId,
        ];
    }

    /**
     * Push error into errors['file-migration-errors'] array.
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

    /**
     * Creates templated xlsx if not exists.
     */
    public function createMigrationErrorXlsxIfNotExists(): void
    {
        if (!Storage::exists('Migration/Migration-errors.xlsx')) {
            $filePath = storage_path('app/Migration/Migration-errors.xlsx');
            $spreadsheet = new Spreadsheet();
            $styleArray = [
                'font' => [
                    'bold' => true,
                    'size' => 14,
                ],
            ];

            foreach ($this->worksheetInfo as $key => $columns) {
                $worksheet = $spreadsheet->createSheet();
                $worksheet->setTitle($key);
                $worksheet->getDefaultColumnDimension()->setWidth(2.5, 'in');

                foreach ($columns as $columnHeader => $columnName) {
                    $worksheet->getStyle("{$columnName}1")->applyFromArray($styleArray);
                    $worksheet->setCellValue("{$columnName}1", ucfirst($columnHeader));
                }
            }

            //Remove default worksheet.
            $defaultWorksheet = $spreadsheet->getSheetByName('Worksheet') ?? '';
            if ($defaultWorksheet) {
                $sheetIndex = $spreadsheet->getIndex($defaultWorksheet);
                $spreadsheet->removeSheetByIndex($sheetIndex);
            }

            if (!File::isDirectory(storage_path('app/Migration'))) {
                Storage::makeDirectory('Migration');
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);
        }
    }
}
