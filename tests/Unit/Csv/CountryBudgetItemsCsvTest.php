<?php

namespace Tests\Unit\Csv;

use App\CsvImporter\Entities\Activity\Components\Elements\CountryBudgetItem;
use Illuminate\Support\Arr;

class CountryBudgetItemsCsvTest extends CsvBaseTest
{
    /**
     * Collects validation error messages.
     *
     * @throws \JsonException
     */
    public function getErrors($rows): array
    {
        $errors = [];
        foreach ($rows as $row) {
            $element = new CountryBudgetItem($row, $this->validation);
            $element->validate()->withErrors();

            if (!empty($element->errors()) || !empty($element->criticals()) || !empty($element->warnings())) {
                $errors[] = $element->errors() + $element->criticals() + $element->warnings();
            }
        }

        return $errors;
    }

    /**
     * All valid data.
     * @return array
     */
    public function valid_data(): array
    {
        $data = $this->completeData;
        $data[0]['country_budget_item_vocabulary'] = ['2'];
        $data[0]['budget_item_code'] = ['1.1.1'];
        $data[0]['budget_item_percentage'] = ['100'];
        $data[0]['budget_item_description'] = ['narrative one'];

        $data[1]['country_budget_item_vocabulary'] = ['3'];
        $data[1]['budget_item_code'] = ['1.2.1', '1.1.1'];
        $data[1]['budget_item_percentage'] = ['50', '50'];
        $data[1]['budget_item_description'] = ['narrative one', 'narrative two'];

        return $data;
    }

    /**
     * All valid data.
     * @return void
     * @throws \JsonException
     * @test
     */
    public function pass_if_all_valid_data(): void
    {
        $this->signIn();
        $rows = $this->valid_data();
        $errors = $this->getErrors($rows);
        $flattenErrors = Arr::flatten($errors);
        $this->assertEmpty($flattenErrors);
    }

    /**
     * Invalid Country budget items data.
     *
     * @return void
     * @test
     * @throws \JsonException
     */
    public function throw_possible_validation_for_invalid_error(): void
    {
        $this->signIn();
        $rows = $this->invalid_data();
        $errors = $this->getErrors($rows);
        $flattenErrors = Arr::flatten($errors);

        $this->assertContains('The country budget item vocabulary is invalid.', $flattenErrors);
        $this->assertContains('The budget item code in invalid.', $flattenErrors);
        $this->assertContains('The budget item percentage field must be a number.', $flattenErrors);
        $this->assertContains('The sum of percentage with budget items must add up to 100.', $flattenErrors);
        $this->assertContains('The budget item percentage field should be 100 when there is only one budget item.', $flattenErrors);
    }

    /**
     * Invalid Country budget items data.
     * @return array
     */
    public function invalid_data(): array
    {
        $data = $this->completeData;
        $data[0]['country_budget_item_vocabulary'] = ['dfdf']; // invalid budget item vocabulary
        $data[0]['budget_item_code'] = ['1adsf.1.1']; // invalid budget item code
        $data[0]['budget_item_percentage'] = ['afd']; // invalid percentage
        $data[0]['budget_item_description'] = ['narrative one'];

        $data[1]['country_budget_item_vocabulary'] = ['3'];
        $data[1]['budget_item_code'] = ['1.2.1', '1.1.1'];
        $data[1]['budget_item_percentage'] = ['45', '50']; // incomplete percentage
        $data[1]['budget_item_description'] = ['narrative one', 'narrative two'];

        $data[2]['country_budget_item_vocabulary'] = ['3'];
        $data[2]['budget_item_code'] = ['1.2.1'];
        $data[2]['budget_item_percentage'] = ['45']; // incomplete percentage when only one budget item
        $data[2]['budget_item_description'] = ['narrative one'];

        $data[3]['country_budget_item_vocabulary'] = ['3'];
        $data[3]['budget_item_code'] = ['1.2.1'];
        $data[3]['budget_item_percentage'] = ['10000']; // incomplete percentage when only one budget item
        $data[3]['budget_item_description'] = ['narrative one'];

        return $data;
    }
}
