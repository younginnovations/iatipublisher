<?php

namespace Tests\Feature;

use App\IATI\Models\Activity\Activity;
use Tests\TestCase;

class ElementCompleteTest extends TestCase
{
    public Activity $activityObj;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj = new Activity();
    }

    public function arrayStructure($actual, $expected): bool
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

    public function test_title_mandatory_fields()
    {
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $this->assertTrue($this->arrayStructure(['narrative' => ['narrative', 'language']], $this->activityObj->mandatorySubElements($elementSchema['title']['sub_elements'])));
    }

    public function test_title_element_empty()
    {
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $titleData = '';
        $this->activityObj->element = 'title';
        $this->assertFalse($this->activityObj->isSubElementDataCompleted($this->activityObj->mandatorySubElements($elementSchema['title']['sub_elements']), ['narrative' => $titleData]));
    }

    public function test_title_element_empty_array()
    {
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $titleData = json_decode(
            '[]',
            true
        );
        $this->activityObj->element = 'title';
        $this->assertFalse($this->activityObj->isSubElementDataCompleted($this->activityObj->mandatorySubElements($elementSchema['title']['sub_elements']), ['narrative' => $titleData]));
    }

    public function test_title_element_empty_json_array()
    {
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $titleData = json_decode(
            '[{}]',
            true
        );
        $this->activityObj->element = 'title';
        $this->assertFalse($this->activityObj->isSubElementDataCompleted($this->activityObj->mandatorySubElements($elementSchema['title']['sub_elements']), ['narrative' => $titleData]));
    }

    public function test_title_element_narrative_and_title_empty()
    {
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $titleData = json_decode(
            '[{"narrative":"","language":""}]',
            true
        );
        $this->activityObj->element = 'title';
        $this->assertFalse($this->activityObj->isSubElementDataCompleted($this->activityObj->mandatorySubElements($elementSchema['title']['sub_elements']), ['narrative' => $titleData]));
    }

    public function test_title_no_narrative_key()
    {
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $titleData = json_decode(
            '[{"language":"en"}]',
            true
        );
        $this->activityObj->element = 'title';
        $this->assertFalse($this->activityObj->isSubElementDataCompleted($this->activityObj->mandatorySubElements($elementSchema['title']['sub_elements']), ['narrative' => $titleData]));
    }

    public function test_title_no_language_key()
    {
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $titleData = json_decode(
            '[{"narrative":"asdasd"}]',
            true
        );
        $this->activityObj->element = 'title';
        $this->assertFalse($this->activityObj->isSubElementDataCompleted($this->activityObj->mandatorySubElements($elementSchema['title']['sub_elements']), ['narrative' => $titleData]));
    }

    public function test_title_empty_narrative()
    {
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $titleData = json_decode(
            '[{"narrative":"","language":"en"}]',
            true
        );
        $this->activityObj->element = 'title';
        $this->assertFalse($this->activityObj->isSubElementDataCompleted($this->activityObj->mandatorySubElements($elementSchema['title']['sub_elements']), ['narrative' => $titleData]));
    }

    public function test_title_empty_language()
    {
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $titleData = json_decode(
            '[{"narrative":"asdads","language":""}]',
            true
        );
        $this->activityObj->element = 'title';
        $this->assertFalse($this->activityObj->isSubElementDataCompleted($this->activityObj->mandatorySubElements($elementSchema['title']['sub_elements']), ['narrative' => $titleData]));
    }

    public function test_title_element_complete()
    {
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $titleData = json_decode(
            '[{"narrative":"DGGF Track 3 English","language":"en"}]',
            true
        );
        $this->activityObj->element = 'title';

        $this->assertTrue($this->activityObj->isSubElementDataCompleted($this->activityObj->mandatorySubElements($elementSchema['title']['sub_elements']), ['narrative' => $titleData]));
    }
}
