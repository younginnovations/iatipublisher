<?php

namespace Tests\Feature\Element;

class RecipientCountryCompleteTest extends ElementCompleteTest
{
    private string $element = 'recipient_country';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_recipient_country_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, ['country_code']);
    }

    public function test_recipient_country_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    public function test_recipient_country_empty_data()
    {
        $recipient_countryData = '';

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $recipient_countryData);
    }

    public function test_recipient_country_empty_array()
    {
        $recipient_countryData = json_decode('[]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $recipient_countryData);
    }

    public function test_recipient_country_empty_json_array()
    {
        $recipient_countryData = json_decode('[{}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $recipient_countryData);
    }

    public function test_recipient_country_attribute_empty_country_code()
    {
        $recipient_countryData = json_decode('[{"country_code":"","percentage":"100","narrative":[{"narrative":"recipient-country1-narrative1","language":"aa"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $recipient_countryData);
    }

    public function test_recipient_country_attribute_no_country_code()
    {
        $recipient_countryData = json_decode('[{"percentage":"100","narrative":[{"narrative":"recipient-country1-narrative1","language":"aa"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $recipient_countryData);
    }

    public function test_recipient_country_element_complete()
    {
        $recipient_countryData = json_decode('[{"country_code":"AF","percentage":"100","narrative":[{"narrative":"recipient-country1-narrative1","language":"aa"}]},{"country_code":"AX","percentage":"100","narrative":[{"narrative":"recipient-country2-narrative1","language":"ab"}]}]', true);

        $this->test_level_one_multi_dimensional_element_complete($this->element, $recipient_countryData);
    }
}
