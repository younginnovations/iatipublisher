<?php

namespace Tests\Feature\Element;

/**
 * Class RecipientCountryCompleteTest.
 */
class RecipientCountryCompleteTest extends ElementCompleteTest
{
    private string $element = 'recipient_country';

    /**
     * Construct function.
     *
     * @param string|null $name
     * @param array       $data
     * @param string      $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    /**
     * Mandatory attribute test.
     *
     * @return void
     */
    public function test_recipient_country_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, ['country_code']);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     */
    public function test_recipient_country_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    /**
     * Empty data test.
     *
     * @return void
     */
    public function test_recipient_country_empty_data(): void
    {
        $recipient_countryData = '';

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $recipient_countryData);
    }

    /**
     * Empty array test.
     *
     * @return void
     */
    public function test_recipient_country_empty_array(): void
    {
        $recipient_countryData = json_decode('[]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $recipient_countryData);
    }

    /**
     * Empty json array test.
     *
     * @return void
     */
    public function test_recipient_country_empty_json_array(): void
    {
        $recipient_countryData = json_decode('[{}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $recipient_countryData);
    }

    /**
     * Attribute country_code empty test.
     *
     * @return void
     */
    public function test_recipient_country_attribute_empty_country_code(): void
    {
        $recipient_countryData = json_decode('[{"country_code":"","percentage":"100","narrative":[{"narrative":"recipient-country1-narrative1","language":"aa"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $recipient_countryData);
    }

    /**
     * Attribute country_code no key test.
     *
     * @return void
     */
    public function test_recipient_country_attribute_no_country_code(): void
    {
        $recipient_countryData = json_decode('[{"percentage":"100","narrative":[{"narrative":"recipient-country1-narrative1","language":"aa"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $recipient_countryData);
    }

    /**
     * Recipient Country element complete test.
     *
     * @return void
     */
    public function test_recipient_country_element_complete(): void
    {
        $recipient_countryData = json_decode(
            '[{"country_code":"AF","percentage":"100","narrative":[{"narrative":"recipient-country1-narrative1","language":"aa"}]},{"country_code":"AX","percentage":"100","narrative":[{"narrative":"recipient-country2-narrative1","language":"ab"}]}]',
            true
        );

        $this->test_level_one_multi_dimensional_element_complete($this->element, $recipient_countryData);
    }
}
