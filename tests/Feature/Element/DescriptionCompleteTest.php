<?php

namespace Tests\Feature\Element;

/**
 * Class DescriptionCompleteTest.
 */
class DescriptionCompleteTest extends ElementCompleteTest
{
    private string $element = 'description';

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
     * @throws \JsonException
     */
    public function test_description_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, []);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_description_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, ['narrative' => ['narrative', 'language']]);
    }

    /**
     * Description data empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_description_empty_data(): void
    {
        $descriptionData = '';

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    /**
     * Description empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_description_empty_array(): void
    {
        $descriptionData = json_decode('[]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    /**
     * Description empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_description_empty_json_array(): void
    {
        $descriptionData = json_decode('[{}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    /**
     * Empty narrative and language test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_description_empty_narrative_and_language(): void
    {
        $descriptionData = json_decode('[{"type":"123","narrative":[{"narrative":"","language":""}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    /**
     * No narrative key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_description_sub_element_no_narrative_key(): void
    {
        $descriptionData = json_decode('[{"type":"1"}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    /**
     * Empty narrative test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_description_sub_element_empty_narrative(): void
    {
        $descriptionData = json_decode('[{"type":"1","narrative":""}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    /**
     * Sub element narrative empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_description_sub_element_empty_narrative_array(): void
    {
        $descriptionData = json_decode('[{"type":"1","narrative":[]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    /**
     * Sub element narrative empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_description_sub_element_narrative_empty_narrative_json_array(): void
    {
        $descriptionData = json_decode('[{"type":"","narrative":[{}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    /**
     * Sub element narrative empty narrative and language test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_description_sub_element_narrative_empty_narrative_and_language(): void
    {
        $descriptionData = json_decode('[{"type":"1","narrative":[{"narrative":"","language":""}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    /**
     * Sub element narrative no narrative key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_description_sub_element_narrative_no_narrative_key(): void
    {
        $descriptionData = json_decode('[{"type":"1", "narrative":[{"language":"en"}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    /**
     * Sub element narrative no language key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_description_sub_element_narrative_no_language_key(): void
    {
        $descriptionData = json_decode('[{"type":"1", "narrative":[{"narrative":"test-narrative"}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    /**
     * Sub element narrative empty narrative test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_description_sub_element_narrative_empty_narrative(): void
    {
        $descriptionData = json_decode('[{"type":"1","narrative":[{"narrative":"","language":"en"}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    /**
     * Sub element narrative empty language test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_description_sub_element_narrative_empty_language(): void
    {
        $descriptionData = json_decode('[{"type":"1","narrative":[{"narrative":"asdasd","language":""}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $descriptionData);
    }

    /**
     * Description element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_description_element_complete(): void
    {
        $descriptionData = json_decode(
            '[{"type":"1","narrative":[{"narrative":"DGGF Track 3 English","language":"en"},{"narrative":"DGGF Track 3 French","language":"fr"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_complete($this->element, $descriptionData);
    }
}
