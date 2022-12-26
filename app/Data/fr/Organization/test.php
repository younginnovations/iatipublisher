<?php

require '/home/momik/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Define the wanted keys

$unwantedFiles = [''];

$wantedKeys = ['name', 'description', 'label'];

// Function to filter the data
function filterData($data, $wantedKeys, &$filteredData, $prefix = '')
{
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            filterData($value, $wantedKeys, $filteredData, $prefix . $key . '.');
        } else {
            if (in_array($key, $wantedKeys)) {
                $filteredData[$prefix . $key] = $value;
            }
        }
    }
}

// Get the list of JSON files in the current folder
$jsonFiles = glob('*.json');
echo count($jsonFiles);

foreach ($jsonFiles as $index => $jsonFile) {
    if (in_array($jsonFile, $unwantedFiles)) {
        unset($jsonFiles[$index]);
    }
}

echo count($jsonFiles);
// Create a new spreadsheet
$spreadsheet = new Spreadsheet();

// Loop through each JSON file
foreach ($jsonFiles as $file) {
    // Load the JSON file
    $json = file_get_contents($file);
    $data = json_decode($json, true);

    // Filter the data to only include the wanted keys
    $filteredData = [];
    filterData($data, $wantedKeys, $filteredData);

    // Create a new sheet for the filtered data
    $sheet = $spreadsheet->createSheet();
    $sheet->setTitle(basename($file, '.json'));

    // Write the filtered dat a to the sheet
    $sheet->setCellValue('A1', 'Keys');
    $sheet->setCellValue('B1', 'English');
    $sheet->setCellValue('C1', 'Spanish');

    $row = 2;
    foreach ($filteredData as $key => $value) {
        $sheet->setCellValue("A$row", $key);
        $sheet->setCellValue("B$row", $value);
        $row++;
    }
}

// Save the spreadsheet as an .xlsx file
$writer = new Xlsx($spreadsheet);
$writer->save('filtered_data.xlsx');

echo 'Data has been successfully written to filtered_data.xlsx.';
