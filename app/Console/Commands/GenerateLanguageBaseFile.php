<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class GenerateLanguageBaseFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:LanguageBaseFile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate XLSX file from lang/en files';

    /**
     * @var Spreadsheet
     */
    public Spreadsheet $spreadsheet;

    /**
     * @var string
     */
    public string $saveFileName = 'languageBaseFile';

    /**
     * @var array
     *
     * Ignore these files
     */
    public array $skipables = ['setting.php', 'auth.php', 'abc.php', 'elements.php', 'pagination.php'];

    /**
     * @var array
     */
    public array $combinedArray = [];

    /**
     * Default base file is english.
     * Params for generating default base file.
     * Change in-case you want to generate base file from other sources like ('en' or 'fr')
     * All there elements of array MUST be changed ACCORDINGLY when changing base file source.
     * NOTE when changing: checkout method createXlsxAndSheets(....) to ensure consistency in generated xlsx file.
     *
     * @var array|string[]
     */
    public array $active = [
        'language'=>'en',
        'columnName'=>'ENGLISH',
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            echo "\n-----XLSX file generation started------\n";

            $this->combinedArray = $this->combineArrays();
            echo "\n-----1. PHP files combined-------------\n";

            $this->createXlsxAndSheets($this->combinedArray);
            echo "\n-----2. Empty SpreadSheet created------\n";

            echo "\n-----[ This may take a while ]---------\n";

            $this->populateSheets($this->combinedArray);
            echo "\n-----3. Each sheet populated-----------\n";
            echo "\n---------------------------------------\n";
            echo "\nFind the file at :storage/app/lang/data\n";
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
        }
    }

    /**
     * Get a list of PHP files in the lang/en folder
     * Read the PHP file and get the associative array returned by it
     * Add the array to the combined array with the filename as the key.
     *
     * @return array
     */
    public function combineArrays(): array
    {
        $combinedArray = [];
        $files = $this->getLanguageFileFilenames();

        foreach ($files as $file) {
            $array = include lang_path("{$this->active['language']}/{$file}");
            if (is_array($array)) {
                $combinedArray[$file] = $array;
            }
        }

        return $combinedArray;
    }

    /**
     * Return filenames of php files that need to be mapped into the xlsx file.
     *
     * @return array
     */
    public function getLanguageFileFilenames(): array
    {
        $files = File::files(lang_path($this->active['language']));
        $filenames = [];

        foreach ($files as $file) {
            if ($file->getExtension() === 'php' && !in_array($file->getFilename(), $this->skipables)) {
                $filenames[] = $file->getFilename();
            }
        }

        return $filenames;
    }

    /**
     * Add a new sheet and set its name
     * Set the values of the first four cells in the sheet
     * Save the spreadsheet as a xlsx file.
     *
     * @param array $combinedArray
     *
     * @return void
     * @throws Exception
     */
    public function createXlsxAndSheets(array $combinedArray): void
    {
        $filePath = storage_path('app/lang/data/' . $this->saveFileName . '_' . $this->active['language'] . '.xlsx');

        $this->spreadsheet = new Spreadsheet();

        foreach ($combinedArray as $key => $value) {
            $sheet = $this->spreadsheet->createSheet();

            $sheet->setTitle($key);
            $sheet->setCellValue('A1', 'Keys');
            $sheet->setCellValue('B1', $this->active['columnName']);
            $sheet->setCellValue('C1', 'FRENCH');
            $sheet->setCellValue('D1', 'SPANISH');
        }

        $writer = new Xlsx($this->spreadsheet);
        $writer->save($filePath);
    }

    /**
     * Populate sheets.
     *
     * @param $combinedArray
     *
     * @return void
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function populateSheets($combinedArray): void
    {
        foreach ($combinedArray as $key => $value) {
            $array = include lang_path("{$this->active['language']}/{$key}");
            $keys = $this->fetchKeys($array);
            $values = $this->fetchValues($array);
            $filename = $key;

            $this->writeToXlsx($filename, $combinedArray[$filename]);
        }
    }

    /**
     * Open the file and the sheet
     * Iterate over each key and write it to the sheet
     * Save the spreadsheet.
     *
     * @param $filename
     * @param $array
     *
     * @return void
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function writeToXlsx($filename, $array): void
    {
        $filePath = storage_path('app/lang/data/' . $this->saveFileName . '_' . $this->active['language'] . '.xlsx');

        $reader = new Reader();
        $spreadsheet = $reader->load($filePath);

        $sheet = $spreadsheet->getSheetByName($filename);
        if ($sheet === null) {
            return;
        }

        $row = 2;
        $keys = $this->fetchKeys($array);
        foreach ($keys as $key) {
            $sheet->setCellValue("A$row", $key);
            $row++;
        }

        $row = 2;
        $values = $this->fetchValues($array);
        foreach ($values as $value) {
            $sheet->setCellValue("B$row", $value);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    /**
     * Return keys, keys of N depth are concatenated to parent with a dot (.).
     *
     * @param $array
     * @param string $prepend
     *
     * @return array
     */
    public function fetchKeys($array, string $prepend = ''): array
    {
        $results = [];

        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $results = array_merge($results, $this->fetchKeys($value, $prepend . $key . '.'));
            } else {
                $results[] = $prepend . $key;
            }
        }

        return $results;
    }

    /**
     * Returns values.
     *
     * @param $array
     *
     * @return array
     */
    public function fetchValues($array): array
    {
        $values = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $values = array_merge($values, $this->fetchValues($value));
            } else {
                $values[] = $value;
            }
        }

        return $values;
    }
}
