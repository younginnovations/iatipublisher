<?php

namespace Tests\Unit\Csv;

use App\CsvImporter\Entities\Activity\Components\Elements\Title;
use Illuminate\Support\Arr;

class TitleCsvTest extends CsvBaseTest
{
    private string $csvFilePath = 'tests/Unit/TestFiles/Csv/';

    /**
     * checks if it throws validation if title empty.
     *
     * @return void
     * @test
     */
    public function check_if_throws_validation_if_title_empty(): void
    {
        $csvFile = $this->csvFilePath . 'title_empty.csv';
        $this->signIn();
        $this->setCsvFilePath($csvFile);
        $this->initializeCsv($this->title_empty_data());
        $rows = $this->getCsvRows($csvFile);
        $errors = [];
        foreach ($rows as $row) {
            $title = new Title($row, $this->validation);
            $title->validate()->withErrors();
            if (!empty($title->errors())) {
                $errors[] = $title->errors();
            }
        }

        $this->assertContains('The activity title is required.', Arr::flatten($errors));
    }

    /**
     * sets of data with empty title.
     *
     * @return array
     */
    public function title_empty_data(): array
    {
        return [
            'Activity Identifier' => ['12345', '67890'],
            'Activity Title' => [],
        ];
    }
}
