<?php

namespace Tests\Feature\Element;

/**
 * Class ReportingOrgCompleteTest.
 */
class ReportingOrgCompleteTest extends ElementCompleteTest
{
    private string $element = 'reporting_org';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_reporting_org_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, ['ref', 'type']);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_reporting_org_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, ['narrative' => ['narrative']]);
    }

    /**
     * All element empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_reporting_org_all_element_empty(): void
    {
        $actualData = json_decode('[{"ref":"","type":"","secondary_reporter":"1","narrative":[{"narrative":"","language":"aa"}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Attribute ref no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_reporting_org_attribute_no_ref_key(): void
    {
        $actualData = json_decode(
            '[{"type":"10","secondary_reporter":"1","narrative":[{"narrative":"ref 1 narrative 1","language":"aa"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Attribute ref empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_reporting_org_attribute_empty_ref(): void
    {
        $actualData = json_decode(
            '[{"ref":"","type":"10","secondary_reporter":"1","narrative":[{"narrative":"ref 1 narrative 1","language":"aa"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Attribute type no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_reporting_org_attribute_no_type_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"123","secondary_reporter":"1","narrative":[{"narrative":"ref 1 narrative 1","language":"aa"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Attribute type empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_reporting_org_attribute_empty_type(): void
    {
        $actualData = json_decode(
            '[{"ref":"123","type":"","secondary_reporter":"1","narrative":[{"narrative":"ref 1 narrative 1","language":"aa"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element narrative empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_reporting_org_sub_element_no_narrative_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"123","type":"1","secondary_reporter":"1"}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element narrative empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_reporting_org_sub_element_empty_narrative_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"123","type":"1","secondary_reporter":"1","narrative":[]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element narrative empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_reporting_org_sub_element_empty_narrative_json_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"123","type":"1","secondary_reporter":"1","narrative":[{}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element narrative no narrative key.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_reporting_org_sub_element_narrative_no_narrative_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"123","type":"1","secondary_reporter":"1","narrative":[{"language":"en"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element narrative empty narrative.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_reporting_org_sub_element_narrative_empty_narrative(): void
    {
        $actualData = json_decode(
            '[{"ref":"123","type":"1","secondary_reporter":"1","narrative":[{"narrative":"","language":"en"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Related Activity element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_reporting_org_element_complete(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","type":"10","secondary_reporter":"1","narrative":[{"narrative":"ref 1 narrative 1","language":"aa"},{"narrative":"ref 1 narrative 2","language":"ab"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_complete($this->element, $actualData);
    }
}
