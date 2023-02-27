<?php

namespace Tests\Unit\Csv;

class TitleCsvTest extends CsvBaseTest
{
    private string $csvFile = 'tests/TestFiles/csv/file.csv';

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example(): void
    {
        $this->signIn();
        $this->initializeCsv($this->title_empty_data());
        dd('nice');
        $this->assertTrue(true);
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
            'Activity Title' => ['title one', 'title two'],
        ];
    }
}
