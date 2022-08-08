<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

/**
 * Class ParticipatingOrgCompleteTest.
 */
class ParticipatingOrgCompleteTest extends ElementCompleteTest
{
    /**
     * Element participating_org.
     *
     * @var string
     */
    private string $element = 'participating_org';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_participating_org_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, ['organization_role']);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_participating_org_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    /**
     * Empty data test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_participating_org_empty_data(): void
    {
        $participating_orgData = '';

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    /**
     * Empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_participating_org_empty_array(): void
    {
        $participating_orgData = json_decode('[]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    /**
     * Empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_participating_org_empty_json_array(): void
    {
        $participating_orgData = json_decode('[{}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    /**
     * All attribute empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_participating_org_empty_all_attributes(): void
    {
        $participating_orgData = json_decode(
            '[{"organization_role":"","ref":"1","type":"1","identifier":"123","crs_channel_code":"123","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    /**
     * Attribute organization_role empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_participating_org_attribute_empty_organization_role(): void
    {
        $participating_orgData = json_decode(
            '[{"organization_role":"","ref":"1","type":"10","identifier":"1231231","crs_channel_code":"10000","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    /**
     * Attribute organization_role no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_participating_org_attribute_no_organization_role_key(): void
    {
        $participating_orgData = json_decode(
            '[{"ref":"1","type":"10","identifier":"1231231","crs_channel_code":"10000","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $participating_orgData);
    }

    /**
     * Participating Org element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_participating_org_element_complete(): void
    {
        $participating_orgData = json_decode(
            '[{"organization_role":"1","ref":"1","type":"10","identifier":"1231231","crs_channel_code":"10000","narrative":[{"narrative":"participating-org1-narrative1","language":"ab"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_complete($this->element, $participating_orgData);
    }
}
