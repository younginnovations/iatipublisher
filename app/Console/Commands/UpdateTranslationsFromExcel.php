<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Class UpdateTranslationsFromExcel.
 */
class UpdateTranslationsFromExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:update-from-excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update translation files from the latest Excel file in S3.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            $this->info('Retrieving files from S3');
            $latestFile = $this->getLatestFileFromS3();

            // Download the file locally
            $this->info('Downloading latest file from S3');
            $tempFilePath = storage_path('app/temp_translation_file.xlsx');
            Storage::put('temp_translation_file.xlsx', Storage::disk('s3')->get($latestFile));

            // Load the Excel file
            $spreadsheet = IOFactory::load($tempFilePath);
            $sheetNames = $spreadsheet->getSheetNames();

            foreach ($spreadsheet->getAllSheets() as $sheetIndex => $sheet) {
                $folderName = $sheetNames[$sheetIndex];
                $this->info("Working for sheet {$folderName}");
                $sheetData = $sheet->toArray();

                if (empty($sheetData)) {
                    continue;
                }

                $translations = [];
                $this->info("Generating translations for {$folderName}");

                foreach ($sheetData as $index => $row) {
                    if ($index === 0) {
                        // Skip the header row
                        continue;
                    }

                    [$key, $filename, $englishTranslation, $spanishTranslation, $frenchTranslation] = $row;

                    $translations[$filename]['en'][$key] = $englishTranslation;
                    $translations[$filename]['es'][$key] = $spanishTranslation;
                    $translations[$filename]['fr'][$key] = $frenchTranslation;
                }

                $this->info("Updating language files for {$folderName}");

                foreach ($translations as $filename => $languageTranslations) {
                    foreach ($languageTranslations as $language => $translationData) {
                        $filePath = lang_path("{$language}/{$folderName}/{$filename}.php");

                        if ($folderName === 'general') {
                            $filePath = lang_path("{$language}/{$filename}.php");
                        }

                        $this->updateLanguageFile($filePath, $translationData);
                    }
                }

                $this->info("Updated language files for {$folderName}");
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            logger()->error($e);
        }
    }

    /**
     * Returns the latest file from S3.
     *
     * @return mixed|void
     */
    protected function getLatestFileFromS3()
    {
        $files = Storage::disk('s3')->files('New Translation');

        if (empty($files)) {
            $this->error('No translation files found in S3 "New Translation" folder.');

            exit();
        }

        // Sort files by last modified time and get the latest file
        usort($files, static function ($a, $b) {
            return Storage::disk('s3')->lastModified($b) <=> Storage::disk('s3')->lastModified($a);
        });

        return $files[0];
    }

    /**
     * Update the language file with new translations.
     *
     * @param $filePath
     * @param $translationData
     *
     * @return void
     */
    protected function updateLanguageFile($filePath, $translationData): void
    {
        if (!file_exists($filePath)) {
            // Initialize file with an empty array if it doesn't exist
            file_put_contents($filePath, "<?php\n\nreturn [];\n");
        }

        // Load the language file as an array
        $languageArray = include $filePath;

        foreach ($translationData as $key => $translation) {
            // Update the translation key using your setDotNotationValue method
            $this->setDotNotationValue($languageArray, $key, $translation);
        }

        // Prepare the contents to write back to the file
//        $fileContents = "<?php\n\nreturn " . var_export($languageArray, true) . ";\n";
        $fileContents = "<?php\n\nreturn " . $this->arrayToPhpString($languageArray) . ";\n";

        // Save the updated language array back to the file
        file_put_contents($filePath, $fileContents);
    }

    /**
     * Convert an array to a PHP string representation.
     *
     * @param  array  $array
     * @param  int  $indentation
     *
     * @return string
     */
    protected function arrayToPhpString(array $array, int $indentation = 0): string
    {
        $indent = str_repeat('    ', $indentation); // Four spaces for indentation
        $result = "[\n";

        foreach ($array as $key => $value) {
            $formattedKey = is_string($key) ? "'$key'" : $key; // Handle keys

            if (is_array($value)) {
                $result .= $indent . "    $formattedKey => " . $this->arrayToPhpString($value, $indentation + 1) . ",\n";
            } else {
                $escapedValue = $this->escapeString($value); // Escape the value
                $result .= $indent . "    $formattedKey => '$escapedValue',\n";
            }
        }

        $result .= $indent . ']';

        return $result;
    }

    /**
     * Escapes string values.
     *
     * @param $string
     *
     * @return string
     */
    protected function escapeString($string): string
    {
        return addslashes($string);
    }

    /**
     * Set a value in a multi-dimensional array using dot notation.
     *
     * @param $array
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setDotNotationValue(&$array, $key, $value): void
    {
        $keys = explode('.', $key);
        $temp = &$array;

        foreach ($keys as $part) {
            if (!isset($temp[$part])) {
                $temp[$part] = [];
            }

            $temp = &$temp[$part];
        }

        $temp = $value;
    }
}