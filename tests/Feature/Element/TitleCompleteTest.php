<?php

namespace Tests\Feature\Element;

/**
 * Class TitleCompleteTest.
 */
class TitleCompleteTest extends ElementCompleteTest
{
    private string $element = 'title';

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
    public function test_title_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, []);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     */
    public function test_title_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, ['narrative' => ['narrative', 'language']]);
    }

    /**
     * Empty title data test.
     *
     * @return void
     */
    public function test_title_empty_data(): void
    {
        $this->test_sub_element_empty($this->element, ['narrative' => '']);
    }

    /**
     * Empty title array test.
     *
     * @return void
     */
    public function test_title_empty_array(): void
    {
        $titleData = json_decode('[]', true);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    /**
     * Empty title json array test.
     *
     * @return void
     */
    public function test_title_empty_json_array(): void
    {
        $titleData = json_decode('[{}]', true);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    /**
     * Empty narrative and language test.
     *
     * @return void
     */
    public function test_title_sub_element_empty_narrative_and_language(): void
    {
        $titleData = json_decode('[{"narrative":"","language":""}]', true);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    /**
     * No narrative key test.
     *
     * @return void
     */
    public function test_title_sub_element_no_narrative_key(): void
    {
        $titleData = json_decode('[{"language":"en"}]', true);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    /**
     * No language key test.
     *
     * @return void
     */
    public function test_title_sub_element_no_language_key(): void
    {
        $titleData = json_decode('[{"narrative":"asdad"}]', true);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    /**
     * Empty sub element narrative test.
     *
     * @return void
     */
    public function test_title_sub_element_empty_narrative(): void
    {
        $titleData = json_decode('[{"narrative":"", "language":""}]', true);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    /**
     * Empty attribute language test.
     *
     * @return void
     */
    public function test_title_sub_element_empty_language(): void
    {
        $titleData = json_decode('[{"narrative":"asdad", "language":""}]', true);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    /**
     * Complete title test.
     *
     * @return void
     */
    public function test_title_element_complete(): void
    {
        $titleData = json_decode('[{"narrative":"asdad", "language":"en"}]', true);

        $this->test_sub_element_complete($this->element, ['narrative' => $titleData]);
    }
}
