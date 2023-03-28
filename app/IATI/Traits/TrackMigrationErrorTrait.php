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
        'detailed-errors'  => [
            [
                'error-msg'        => '',
                'aidstream-org-id' => '',
                'aidstream-table'  => '',
                'primary-id'       => '',
                'iati-org-id'      => '',
                'iati-primary-id'  => '',
                'scope'            => '',
            ],
        ],
        'general-errors'         => [
            [
                'error-msg'        => '',
            ],
        ],
    ];

    /**
     * Information about each worksheet and columns.
     *
     * @var array|array[]
     */
    public array $worksheetInfo = [
        'detailed-errors' => [
            'error-msg'        => 'A',
            'aidstream-org-id' => 'B',
            'aidstream-table'  => 'C',
            'primary-id'       => 'D',
            'iati-org-id'      => 'E',
            'iati-primary-id'  => 'F',
            'scope'            => 'G',

        ],
        'general-errors' => [
            'error-msg'        => 'A',
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
     *
     * @return TrackMigrationErrorTrait
     */
    public function setGeneralError(
        string $message,
    ): static {
        $this->errors['general-errors'][] = [
            'error-msg'        => $message,
        ];

        return $this;
    }

    /**
     * Push error into errors['detailed-errors'] array.
     *
     * @param string $message
     * @param int|string $aidstreamOrgId
     * @param int|string $aidstreamTable
     * @param int|string $primaryId
     * @param int|string $scope
     * @param int|string $iatiOrgId
     * @param int|string $iatiPrimaryId
     *
     * @return TrackMigrationErrorTrait
     */
    public function setDetailedError(
        string $message,
        int | string $aidstreamOrgId = '',
        int | string $aidstreamTable = '',
        int | string $primaryId = '',
        int | string $iatiOrgId = '',
        int | string $iatiPrimaryId = '',
        int | string $scope = '',
    ): static {
        $this->errors['detailed-errors'][] = [
            'error-msg'        => $message,
            'aidstream-org-id' => $aidstreamOrgId,
            'aidstream-table'  => $aidstreamTable,
            'primary-id'       => $primaryId,
            'iati-org-id'      => $iatiOrgId,
            'iati-primary-id'  => $iatiPrimaryId,
            'scope'            => $scope,
        ];

        return $this;
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
