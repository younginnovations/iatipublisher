<?php

namespace Tests\Feature\Element;

use App\IATI\Models\Activity\Activity;
use Tests\TestCase;

class ElementCompleteTest extends TestCase
{
    protected Activity $activityObj;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj = new Activity();
    }

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

    public function elementSchema($element)
    {
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);

        return $elementSchema[$element];
    }

    protected function test_mandatory_attributes($element, $actualAttributes)
    {
        $elementSchema = $this->elementSchema($element);

        $this->assertTrue($this->arrayStructure($actualAttributes, $this->activityObj->mandatoryAttributes($elementSchema['attributes'])));
    }

    protected function test_mandatory_sub_elements($element, $actualSubElement)
    {
        $elementSchema = $this->elementSchema($element);

        $this->assertTrue($this->arrayStructure($actualSubElement, $this->activityObj->mandatorySubElements($elementSchema['sub_elements'])));
    }

    protected function test_sub_element_empty($element, $actualData)
    {
        $elementSchema = $this->elementSchema($element);

        $this->assertFalse($this->activityObj->isSubElementDataCompleted($this->activityObj->mandatorySubElements($elementSchema['sub_elements']), $actualData));
    }

    protected function test_sub_element_complete($element, $actualData)
    {
        $elementSchema = $this->elementSchema($element);

        $this->assertTrue($this->activityObj->isSubElementDataCompleted($this->activityObj->mandatorySubElements($elementSchema['sub_elements']), $actualData));
    }

    protected function test_level_one_multi_dimensional_element_incomplete($element, $actualData)
    {
        $this->assertFalse($this->activityObj->isLevelOneMultiDimensionElementCompleted($element, $actualData));
    }

    protected function test_level_one_multi_dimensional_element_complete($element, $actualData)
    {
        $this->assertTrue($this->activityObj->isLevelOneMultiDimensionElementCompleted($element, $actualData));
    }

    protected function test_level_two_single_dimensional_element_incomplete($element, $actualData)
    {
        $this->assertFalse($this->activityObj->isLevelTwoSingleDimensionElementCompleted($element, $actualData));
    }

    protected function test_level_two_single_dimensional_element_complete($element, $actualData)
    {
        $this->assertTrue($this->activityObj->isLevelTwoSingleDimensionElementCompleted($element, $actualData));
    }
}
