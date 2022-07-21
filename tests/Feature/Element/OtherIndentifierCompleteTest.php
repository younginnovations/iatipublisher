<?php

namespace Tests\Feature\Element;

class OtherIndentifierCompleteTest extends ElementCompleteTest
{
    private string $element = 'other_identifier';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_other_identifier_first_level_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, ['reference', 'reference_type']);
    }

    public function test_other_identifier_empty_data()
    {
        $actualData = '';

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_other_identifier_empty_json()
    {
        $actualData = json_decode('{}', true);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_other_identifier_attribute_no_reference_key()
    {
        $actualData = json_decode('{"reference_type":"A1","owner_org":[{"ref":"OwnerOrg Ref-1","narrative":[{"narrative":"","language":"aa"},{"narrative":"asdsasdasd","language":"ab"}]},{"ref":"OwnerOrg Ref-2","narrative":[{"narrative":"asdasd","language":"af"}]}]}', true);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_other_identifier_attribute_no_reference_type_key()
    {
        $actualData = json_decode('{"reference":"1","owner_org":[{"ref":"OwnerOrg Ref-1","narrative":[{"narrative":"","language":"aa"},{"narrative":"asdsasdasd","language":"ab"}]},{"ref":"OwnerOrg Ref-2","narrative":[{"narrative":"asdasd","language":"af"}]}]}', true);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_other_identifier_attribute_empty_reference_and_reference_type()
    {
        $actualData = json_decode('{"reference":"","reference_type":"","owner_org":[{"ref":"OwnerOrg Ref-1","narrative":[{"narrative":"","language":"aa"},{"narrative":"asdsasdasd","language":"ab"}]},{"ref":"OwnerOrg Ref-2","narrative":[{"narrative":"asdasd","language":"af"}]}]}', true);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_other_identifier_attribute_empty_reference()
    {
        $actualData = json_decode('{"reference":"","reference_type":"A1","owner_org":[{"ref":"OwnerOrg Ref-1","narrative":[{"narrative":"","language":"aa"},{"narrative":"asdsasdasd","language":"ab"}]},{"ref":"OwnerOrg Ref-2","narrative":[{"narrative":"asdasd","language":"af"}]}]}', true);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_other_identifier_attribute_empty_reference_type()
    {
        $actualData = json_decode('{"reference":"1","reference_type":"","owner_org":[{"ref":"OwnerOrg Ref-1","narrative":[{"narrative":"","language":"aa"},{"narrative":"asdsasdasd","language":"ab"}]},{"ref":"OwnerOrg Ref-2","narrative":[{"narrative":"asdasd","language":"af"}]}]}', true);

        $this->test_level_two_single_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_other_identifier_element_complete()
    {
        $actualData = json_decode('{"reference":"1","reference_type":"A1","owner_org":[{"ref":"OwnerOrg Ref-1","narrative":[{"narrative":"","language":"aa"},{"narrative":"asdsasdasd","language":"ab"}]},{"ref":"OwnerOrg Ref-2","narrative":[{"narrative":"asdasd","language":"af"}]}]}', true);

        $this->test_level_two_single_dimensional_element_complete($this->element, $actualData);
    }
}
