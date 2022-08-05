<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

/**
 * Class TitleCompleteTest.
 */
class TitleCompleteTest extends ElementCompleteTest
{
    /**
     * Element title.
     *
     * @var string
     */
    private string $element = 'title';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_title_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, []);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_title_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, ['narrative' => ['narrative', 'language']]);
    }

    /**
     * Empty title data test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_title_empty_data(): void
    {
        $this->test_sub_element_empty($this->element, ['narrative' => '']);
    }

    /**
     * Empty title array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_title_empty_array(): void
    {
        $titleData = json_decode('[]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    /**
     * Empty title json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_title_empty_json_array(): void
    {
        $titleData = json_decode('[{}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    /**
     * Empty narrative and language test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_title_sub_element_empty_narrative_and_language(): void
    {
        $titleData = json_decode('[{"narrative":"","language":""}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    /**
     * No narrative key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_title_sub_element_no_narrative_key(): void
    {
        $titleData = json_decode('[{"language":"en"}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    /**
     * No language key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_title_sub_element_no_language_key(): void
    {
        $titleData = json_decode('[{"narrative":"asdad"}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    /**
     * Empty sub element narrative test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_title_sub_element_empty_narrative(): void
    {
        $titleData = json_decode('[{"narrative":"", "language":""}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    /**
     * Empty attribute language test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_title_sub_element_empty_language(): void
    {
        $titleData = json_decode('[{"narrative":"asdad", "language":""}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_sub_element_empty($this->element, ['narrative' => $titleData]);
    }

    /**
     * Complete title test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_title_element_complete(): void
    {
        $titleData = json_decode('[{"narrative":"asdad", "language":"en"}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_sub_element_complete($this->element, ['narrative' => $titleData]);
    }
}
