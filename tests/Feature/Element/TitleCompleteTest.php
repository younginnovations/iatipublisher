<?php

namespace Tests\Feature\Element;

class TitleCompleteTest extends ElementCompleteTest
{
    private string $element = 'title';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_title_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, ['narrative' => ['narrative', 'language']]);
    }

    public function test_title_element_empty()
    {
        $this->test_sub_element_empty($this->element, ['narrative' => '']);
    }

    public function test_title_element_empty_array()
    {
        $titleData = json_decode('[]', true);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    public function test_title_element_empty_json_array()
    {
        $titleData = json_decode('[{}]', true);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    public function test_title_element_narrative_and_title_empty()
    {
        $titleData = json_decode('[{"narrative":"","language":""}]', true);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    public function test_title_no_narrative_key()
    {
        $titleData = json_decode('[{"language":"en"}]', true);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    public function test_title_no_language_key()
    {
        $titleData = json_decode('[{"narrative":"asdad"}]', true);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    public function test_title_empty_narrative()
    {
        $titleData = json_decode('[{"narrative":"", "language":""}]', true);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    public function test_title_empty_language()
    {
        $titleData = json_decode('[{"narrative":"asdad", "language":""}]', true);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    public function test_title_element_complete()
    {
        $titleData = json_decode('[{"narrative":"asdad", "language":"en"}]', true);

        $this->test_sub_element_complete($this->element, ['narrative' => $titleData]);
    }
}
