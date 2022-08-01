<?php

namespace Tests\Feature\Element;

use App\IATI\Models\Activity\Activity;
use Tests\TestCase;

/**
 * Class ElementCompleteTest.
 */
class ElementCompleteTest extends TestCase
{
    protected Activity $activityObj;

    /**
     * @param string|null $name
     * @param array       $data
     * @param string      $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj = new Activity();
    }

    /**
     * Compares arrays.
     *
     * @param $actual
     * @param $expected
     *
     * @return bool
     */
    protected function arrayStructure($actual, $expected): bool
    {
        if (!is_array($expected) || !is_array($actual)) {
            return $actual === $expected;
        }

        foreach ($expected as $key => $value) {
            if (!$this->arrayStructure($actual[$key], $value)) {
                return false;
            }
        }
        foreach ($actual as $key => $value) {
            if (!$this->arrayStructure($value, $expected[$key])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns specific element schema.
     *
     * @param $element
     *
     * @return mixed
     * @throws \JsonException
     */
    public function elementSchema($element): mixed
    {
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true, 512, JSON_THROW_ON_ERROR);

        return $elementSchema[$element];
    }

    /**
     * Mandatory attribute test.
     *
     * @param $element
     * @param $actualAttributes
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_mandatory_attributes($element, $actualAttributes): void
    {
        $elementSchema = $this->elementSchema($element);

        $this->assertTrue($this->arrayStructure($actualAttributes, $this->activityObj->mandatoryAttributes($elementSchema['attributes'])));
    }

    /**
     * Mandatory sub element test.
     *
     * @param $element
     * @param $actualSubElement
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_mandatory_sub_elements($element, $actualSubElement): void
    {
        $elementSchema = $this->elementSchema($element);

        $this->assertTrue($this->arrayStructure($actualSubElement, $this->activityObj->mandatorySubElements($elementSchema['sub_elements'])));
    }

    /**
     * Empty sub element test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_sub_element_empty($element, $actualData): void
    {
        $elementSchema = $this->elementSchema($element);

        $this->assertFalse($this->activityObj->isSubElementDataCompleted($this->activityObj->mandatorySubElements($elementSchema['sub_elements']), $actualData));
    }

    /**
     * Sub element complete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_sub_element_complete($element, $actualData): void
    {
        $elementSchema = $this->elementSchema($element);

        $this->assertTrue($this->activityObj->isSubElementDataCompleted($this->activityObj->mandatorySubElements($elementSchema['sub_elements']), $actualData));
    }

    /**
     * Level one multi dimensional element incomplete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_level_one_multi_dimensional_element_incomplete($element, $actualData): void
    {
        $this->assertFalse($this->activityObj->isLevelOneMultiDimensionElementCompleted($element, $actualData));
    }

    /**
     * Level one multi dimensional element complete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_level_one_multi_dimensional_element_complete($element, $actualData): void
    {
        $this->assertTrue($this->activityObj->isLevelOneMultiDimensionElementCompleted($element, $actualData));
    }

    /**
     * Level two single dimensional element incomplete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_level_two_single_dimensional_element_incomplete($element, $actualData): void
    {
        $this->assertFalse($this->activityObj->isLevelTwoSingleDimensionElementCompleted($element, $actualData));
    }

    /**
     * Level two single dimensional element complete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_level_two_single_dimensional_element_complete($element, $actualData): void
    {
        $this->assertTrue($this->activityObj->isLevelTwoSingleDimensionElementCompleted($element, $actualData));
    }

    /**
     * Level two multi dimensional element incomplete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_level_two_multi_dimensional_element_incomplete($element, $actualData): void
    {
        $this->assertFalse($this->activityObj->isLevelTwoMultiDimensionElementCompleted($element, $actualData));
    }

    /**
     * Level two multi dimensional element complete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_level_two_multi_dimensional_element_complete($element, $actualData): void
    {
        $this->assertTrue($this->activityObj->isLevelTwoMultiDimensionElementCompleted($element, $actualData));
    }

    /**
     * Level three single dimensional element incomplete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_level_three_single_dimensional_element_incomplete($element, $actualData): void
    {
        $this->assertFalse($this->activityObj->isLevelThreeSingleDimensionElementCompleted($element, $actualData));
    }

    /**
     * Level three single dimensional element complete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_level_three_single_dimensional_element_complete($element, $actualData): void
    {
        $this->assertTrue($this->activityObj->isLevelThreeSingleDimensionElementCompleted($element, $actualData));
    }

    /**
     * Transaction element complete test.
     *
     * @param $subElements
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_transaction_data_complete($subElements, $actualData): void
    {
        $this->assertTrue($this->activityObj->checkTransactionData($subElements, $actualData));
    }

    /**
     * Result element complete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_result_data_complete($element, $actualData): void
    {
        if ($element == 'result') {
            $this->assertTrue($this->activityObj->isResultElementCompleted($element, $actualData));
        } elseif ($element == 'indicator') {
            $this->assertTrue($this->activityObj->isIndicatorElementCompleted($element, $actualData));
        } elseif ($element == 'period') {
            $this->assertTrue($this->activityObj->isPeriodElementCompleted($element, $actualData));
        }
    }
}
