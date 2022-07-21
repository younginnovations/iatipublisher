<?php

namespace Tests\Feature\Element;

class RecipientRegionCompleteTest extends ElementCompleteTest
{
    private string $element = 'recipient_region';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_recipient_region_type_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, ['region_code', 'custom_code']);
    }

    public function test_recipient_region_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    public function test_recipient_region_element_complete()
    {
        $sector_typeData = json_decode('[{"region_vocabulary":"1","region_code":"88","percentage":"100","narrative":[{"narrative":null,"language":null}]},{"region_vocabulary":"2","custom_code":"vocab-2","percentage":"100","narrative":[{"narrative":null,"language":null}]},{"region_vocabulary":"99","custom_code":"vocab-99","vocabulary_uri":"https:\/\/www.google.com","percentage":"100","narrative":[{"narrative":null,"language":null}]}]', true);

        $this->test_level_one_multi_dimensional_element_complete($this->element, $sector_typeData);
    }
}
