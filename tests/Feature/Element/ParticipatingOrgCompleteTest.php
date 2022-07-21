<?php

namespace Tests\Feature\Element;

class ParticipatingOrgCompleteTest extends ElementCompleteTest
{
    private string $element = 'participating_org';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_participating_org_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, ['organization_role']);
    }

    public function test_participating_org_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    public function test_participating_org_empty_data()
    {
        $participating_orgData = '';

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    public function test_participating_org_empty_array()
    {
        $participating_orgData = json_decode('[]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    public function test_participating_org_empty_json_array()
    {
        $participating_orgData = json_decode('[{}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    public function test_participating_org_empty_all_attributes()
    {
        $participating_orgData = json_decode('[{"organization_role":"","ref":"1","type":"1","identifier":"123","crs_channel_code":"123","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    public function test_participating_org_attribute_empty_organization_role()
    {
        $participating_orgData = json_decode('[{"organization_role":"","ref":"1","type":"10","identifier":"1231231","crs_channel_code":"10000","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    public function test_participating_org_attribute_no_organization_role_key()
    {
        $participating_orgData = json_decode('[{"ref":"1","type":"10","identifier":"1231231","crs_channel_code":"10000","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    public function test_participating_org_element_complete()
    {
        $participating_orgData = json_decode('[{"organization_role":"1","ref":"1","type":"10","identifier":"1231231","crs_channel_code":"10000","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]', true);

        $this->test_level_one_multi_dimensional_element_complete($this->element, $participating_orgData);
    }
}
