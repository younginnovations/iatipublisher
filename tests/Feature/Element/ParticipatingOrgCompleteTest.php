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
        $this->test_mandatory_attributes($this->element, ['organization_role', 'ref', 'type', 'identifier', 'crs_channel_code']);
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
        $participating_orgData = json_decode('[{"organization_role":"","ref":"","type":"","identifier":"","crs_channel_code":"","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]', true);

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

    public function test_participating_org_attribute_empty_ref()
    {
        $participating_orgData = json_decode('[{"organization_role":"1","ref":"","type":"10","identifier":"1231231","crs_channel_code":"10000","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    public function test_participating_org_attribute_no_ref_key()
    {
        $participating_orgData = json_decode('[{"organization_role":"1","type":"10","identifier":"1231231","crs_channel_code":"10000","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    public function test_participating_org_attribute_empty_type()
    {
        $participating_orgData = json_decode('[{"organization_role":"1","ref":"1","type":"","identifier":"1231231","crs_channel_code":"10000","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    public function test_participating_org_attribute_no_type_key()
    {
        $participating_orgData = json_decode('[{"organization_role":"1","ref":"1","identifier":"1231231","crs_channel_code":"10000","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    public function test_participating_org_attribute_empty_identifier()
    {
        $participating_orgData = json_decode('[{"organization_role":"1","ref":"1","type":"1","identifier":"","crs_channel_code":"10000","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    public function test_participating_org_attribute_no_identifier_key()
    {
        $participating_orgData = json_decode('[{"organization_role":"1","ref":"1","type":"1","crs_channel_code":"10000","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    public function test_participating_org_attribute_empty_crs_channel_code()
    {
        $participating_orgData = json_decode('[{"organization_role":"1","ref":"1","type":"1","identifier":"123","crs_channel_code":"","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    public function test_participating_org_attribute_no_crs_channel_code_key()
    {
        $participating_orgData = json_decode('[{"organization_role":"1","ref":"1","type":"1","identifier":"10000","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    public function test_participating_org_element_complete()
    {
        $participating_orgData = json_decode('[{"organization_role":"1","ref":"1","type":"10","identifier":"1231231","crs_channel_code":"10000","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]', true);

        $this->test_level_one_multi_dimensional_element_complete($this->element, $participating_orgData);
    }
}
