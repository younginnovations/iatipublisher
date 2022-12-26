<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use SebastianBergmann\Complexity\Exception;

class GenerateLanguageFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:LanguageFiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a set of php files for each translation that exists in the LanguageSourceFile.xlsx';

    public string $sourceFile = 'languageSource.xlsx';
    public $reader;
    public $spreadsheet;
    public array  $languages = ['EN', 'FR', 'ES'];
    public array  $dataColumn = ['B', 'C', 'D'];
    public string $originalSource = 'B';
    public string $keyColumn = 'A';
    public int    $colsBeingUsed = 2;
    public $logger = [];
    public $totalScore = [];
    public $achievedScore = [];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->reader = IOFactory::createReader('Xlsx');
        $this->spreadsheet = $this->reader->load(storage_path('app/lang/data/' . $this->sourceFile));
        $this->removeSheet('Worksheet');

        foreach ($this->languages as $index => $folderName) {
            $this->createFolderIfNotExists($folderName);

            $this->totalScore[$folderName] = 0;
            $this->achievedScore[$folderName] = 0;

            foreach ($this->spreadsheet->getSheetNames() as $sheetName) {
                $worksheet = $this->getWorksheet($sheetName);
                $highestRow = $worksheet->getHighestRow();
                $numberOfRowsMinusHeader = $highestRow - 1;

                $this->totalScore[$folderName] = ($numberOfRowsMinusHeader * $this->colsBeingUsed) + $this->totalScore[$folderName];

                $keys = [];
                $values = [];

                for ($row = 2; $row <= $highestRow; $row++) {
                    if ($this->strictHeaderCheck($worksheet)) {
                        switch ([
                            $this->emptyKeyCheck($worksheet, $row),
                            $this->emptyValueCheck($worksheet, $index, $row),
                        ]) {
                            case [false, false]:
                                $this->achievedScore[$folderName] = $this->achievedScore[$folderName] + 2;
                                break;
                            case [false, true]:
                                $this->logger['warning'][] = [
                                    'folder' => $folderName,
                                    'sheet'  => $sheetName,
                                    'row'    => $row,
                                ];
                                $this->achievedScore[$folderName] = $this->achievedScore[$folderName] + 1;
                                break;
                            case [true, false]:
                            default:
                                $this->logger['error'][] = [
                                    'folder' => $folderName,
                                    'sheet'  => $sheetName,
                                    'row'    => $row,
                                ];
                                break;
                        }

                        list($keys[], $values[]) = $this->resolveCellValuesOfARow($worksheet, $index, $row);
                        $this->createPhpFiles($folderName, $sheetName, $keys, $values);
                    } else {
                        echo "Strict header check failed in [ $sheetName ]. Skipping sheet: [ $sheetName ]" . PHP_EOL;
                    }
                }
            }
        }

        $this->logToJsonFile($this->logger);
        $temp = array_reverse($this->dataColumn);
        $temp[] = $this->originalSource;
        $temp[] = $this->keyColumn;
        $temp = array_reverse($temp);
        $this->logComparison($this->spreadsheet, $this->languages, $temp);
        $this->logToConsole($this->logger, $this->totalScore, $this->achievedScore);
    }

    /**
     * @param string $folderName
     *
     * @return void
     */
    private function createFolderIfNotExists(string $folderName)
    {
        $folderNameWithPath = 'app/lang/' . $folderName;

        if (!Storage::exists($folderNameWithPath)) {
            Storage::makeDirectory('lang/' . $folderName);
        }
    }

    /**
     * @param $sheetName
     *
     * @return mixed
     */
    private function getWorksheet($sheetName)
    {
        return $this->spreadsheet->getSheetByName($sheetName);
    }

    /**
     * @param $worksheet
     * @param $row
     *
     * @return bool
     */
    private function emptyKeyCheck($worksheet, $row): bool
    {
        return empty($worksheet->getCell("{$this->keyColumn}{$row}")->getValue());
    }

    /**
     * @param $worksheet
     * @param $index
     * @param $row
     *
     * @return bool
     */
    private function emptyValueCheck($worksheet, $index, $row): bool
    {
        $column = $this->dataColumn[$index];

        return empty($worksheet->getCell("{$column}{$row}")->getValue());
    }

    /**
     * Check if header row in xlsx file is : Keys| ENGLISH | FRENCH | SPANISH.
     *
     * @param $worksheet
     *
     * @return bool
     */
    private function strictHeaderCheck($worksheet): bool
    {
        $cellA1 = $worksheet->getCell('A1')->getValue();
        $cellB1 = $worksheet->getCell('B1')->getValue();
        $cellC1 = $worksheet->getCell('C1')->getValue();
        $cellD1 = $worksheet->getCell('D1')->getValue();

        return $cellA1 === 'Keys' && $cellB1 === 'ENGLISH' && $cellC1 === 'FRENCH' && $cellD1 === 'SPANISH';
    }

    /**
     * Returns cell values of key and value of same row
     * Example , A1(key cell) , B1(value in english)
     *           A1(key cell) , B2(value in french).
     *
     * @param $worksheet
     * @param int $index
     * @param int $row
     *
     * @return array
     */
    private function resolveCellValuesOfARow($worksheet, int $index, int $row): array
    {
        $keyCell = $worksheet->getCell("{$this->keyColumn}{$row}")->getValue();
        $valueCell = $worksheet->getCell("{$this->dataColumn[$index]}{$row}")->getValue();

        return [$keyCell, $valueCell];
    }

    /**
     * Generates files.
     *
     * @param mixed $folderName
     * @param mixed $sheetName
     * @param array $keys
     * @param array $values
     *
     * @return void
     */
    private function createPhpFiles(mixed $folderName, mixed $sheetName, array $keys, array $values)
    {
        $array = $this->createNestedArray($keys, $values);
        $phpCode = "<?php\nreturn " . var_export($array, true) . ";\n";
        $storagePath = "lang/{$folderName}/{$sheetName}";

        Storage::put($storagePath, $phpCode);
    }

    /**
     * Creates nested array.
     *
     * @param $keys
     * @param $values
     *
     * @return mixed
     */
    private function createNestedArray($keys, $values): mixed
    {
        try {
            $result = [];
            for ($i = 0; $i < count($keys); $i++) {
                $keyParts = explode('.', $keys[$i] ?? '');
                $current = &$result;
                for ($j = 0; $j < count($keyParts); $j++) {
                    $part = $keyParts[$j];
                    if (!isset($current[$part])) {
                        $current[$part] = [];
                    }
                    $current = &$current[$part];
                }
                $current = $values[$i];
            }

            return $result;
        } catch (Exception $e) {
            dd($keys[$i]);
        }
    }

    /**
     * Removes worksheet by name from given spreadsheet.
     *
     * @param string $worksheetName
     *
     * @return void
     */
    private function removeSheet(string $worksheetName): void
    {
        $worksheet = $this->spreadsheet->getSheetByName($worksheetName) ?? '';
        if ($worksheet) {
            $sheetIndex = $this->spreadsheet->getIndex($worksheet);
            $this->spreadsheet->removeSheetByIndex($sheetIndex);
        }
    }

    /**
     * Print to console.
     *
     * @param $logger
     * @param $totalScore
     * @param $achievedScore
     *
     * @return void
     */
    public function logToConsole($logger, $totalScore, $achievedScore)
    {
        if (isset($logger['warning'])) {
            $this->logType('warning', $logger['warning']);
            echo "\n\n";
        }
        if (isset($logger['error'])) {
            $this->logType('error', $logger['error']);
            echo "\n\n";
        }
        $this->logCoverage($totalScore, $achievedScore);
    }

    /**
     * Appends error/warning log to log file (SCRIPT_LOG.json).
     *
     * @param $logger
     *
     * @return void
     */
    public function logToJsonFile($logger)
    {
        $filePath = 'storage/app/lang/SCRIPT_LOG.json';
        $date = str_replace('-', '_', date('Y-m-d'));
        $time = str_replace(':', '_', date('H:i:s'));
        $latestKey = "{$date}_{$time}";

        $latestLog[$latestKey] = $logger;
        if (file_exists($filePath)) {
            $existingLog = (array) json_decode(file_get_contents($filePath), true);
            $existingLog = array_slice($existingLog, 0, 4, true);
            $existingLog = array_reverse($existingLog, true);
            $existingLog[$latestKey] = $logger;
            $existingLog = array_reverse($existingLog, true);

            file_put_contents($filePath, json_encode($existingLog, JSON_PRETTY_PRINT));
        } else {
            file_put_contents($filePath, json_encode($latestLog, JSON_PRETTY_PRINT));
        }
    }

    /**
     * Generate table in console for translated cell count comparision.
     *
     * @param $spreadsheet
     * @param $languages
     * @param $columns
     *
     * @return void
     */
    public function logComparison($spreadsheet, $languages, $columns)
    {
        $values = [];
        foreach ($spreadsheet->getSheetNames() as $sheetName) {
            $sheet = $spreadsheet->getSheetByName($sheetName);
            $highestRow = $sheet->getHighestRow();
            $temp = [];
            foreach ($columns as $index => $column) {
                for ($row = 2; $row <= $highestRow; $row++) {
                    $temp[$column][] = $sheet->getCell("{$column}{$row}")->getValue();
                }
                $size = $this->countNonEmpty($temp[$column]);
                $values[$sheetName][$column] = $size;
            }
        }

        echo "\n\n";
        $this->logLine();
        $this->logHeader('DETAILS');
        $this->logLine();
        $this->logRow(['', 'Col A', 'Col B', 'Col C', 'Col D']);
        $this->logLine();
        foreach ($values as $sheetName => $sheet) {
            $this->logRow(
                [$sheetName, $sheet[$columns[0]], $sheet[$columns[1]], $sheet[$columns[2]], $sheet[$columns[3]]]
            );
            $this->logLine();
        }
    }

    /**
     * Print error or warning in console.
     *
     * @param $type
     * @param $messages
     *
     * @return void
     */
    public function logType($type, $messages): void
    {
        $red = "\033[31m";
        $yellow = "\033[33m";
        $default = "\033[97m";
        if ($type == 'error') {
            echo $red;
        }
        if ($type == 'warning') {
            echo $yellow;
        }
        $this->logLine();
        $this->logHeader($type);
        $this->logLine();
        $missing = $type == 'error' ? 'KEY' : 'VAL';
        foreach ($messages as $message) {
            echo "|{$message['folder']}| " . str_pad(
                " Has missing {$missing} in SHEET:{$message['sheet']}, ROW:{$message['row']}",
                52,
                ' '
            ) . "|\n";
            $this->logLine();
        }
        echo $default;
    }

    /**
     * Print translation coverage in console.
     *
     * @param $totalScore
     * @param $achievedScore
     *
     * @return void
     */
    public function logCoverage($totalScore, $achievedScore)
    {
        $green = "\033[32m";
        $yellow = "\033[33m";
        $default = "\033[97m";

        echo $default;
        $this->logLine();
        $this->logHeader('COVERAGE (1 point = 1 cell exported successfully)');
        $this->logLine();
        foreach ($totalScore as $key => $total) {
            $percentage = ($achievedScore[$key] / $total) * 100;
            $color = $percentage > 75 ? $green : $yellow;

            $percentage = (string) $percentage . '%';
            echo "|{$key}| " . str_pad("Possible points: {$total}", 52, ' ') . "|\n";
            echo "|{$key}| " . str_pad("Achieved points: {$achievedScore[$key]}", 52, ' ') . "|\n";
            echo "{$color}|{$key}| " . str_pad("Coverage: {$percentage}", 52, ' ') . "|\n";
            echo $default;
            $this->logLine();
        }
    }

    /**
     * Print table header in console.
     *
     * @param $type
     *
     * @return void
     */
    public function logHeader($type): void
    {
        echo '|' . str_pad(ucfirst($type), 56, ' ', STR_PAD_BOTH) . "|\n";
    }

    /**
     * Print line in console.
     *
     * @return void
     */
    public function logLine()
    {
        echo '+--------------------------------------------------------+' . "\n";
    }

    /**
     * @param $array
     *
     * @return int
     */
    public function countNonEmpty($array): int
    {
        return count(
            array_filter($array, function ($value) {
                return !empty($value);
            })
        );
    }

    /**
     * Print row in console.
     *
     * @param $cells
     *
     * @return void
     */
    public function logRow($cells): void
    {
        echo '|';
        echo str_pad($cells[0], 24, ' ') . '|';
        echo str_pad("$cells[1]", 7, ' ', STR_PAD_BOTH) . '|';
        echo str_pad("$cells[2]", 7, ' ', STR_PAD_BOTH) . '|';
        echo str_pad("$cells[3]", 7, ' ', STR_PAD_BOTH) . '|';
        echo str_pad("$cells[4]", 7, ' ', STR_PAD_BOTH) . '|';
        echo "\n";
    }
}
