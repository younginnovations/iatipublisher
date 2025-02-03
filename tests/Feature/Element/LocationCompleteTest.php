<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

use App\IATI\Models\Activity\Activity;
use Illuminate\Support\Arr;
use Tests\Traits\FilterMandatoryItemsTrait;

/**
 * Class LocationCompleteTest.
 */
class LocationCompleteTest extends ElementCompleteTest
{
    use FilterMandatoryItemsTrait;

    /**
     * Element location.
     *
     * @var string
     */
    private string $element = 'location';

    /**
     * @var array
     */
    private array $mandatoryAttributes = [];

    /**
     * @var array
     */
    private array $mandatorySubelements = [];

    /**
     * Test that mandatory attributes for location have not changed since the time of writing this test.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_location_mandatory_attributes_have_not_changed(): void
    {
        $locationSchema = Arr::get(readElementJsonSchema(), $this->element, []);
        $locationFlattened = flattenArrayWithKeys($locationSchema);
        $locationFlattened = getItemsWhereKeyContains($locationFlattened, '.criteria');
        $mandatoryItemsInSchema = array_filter($locationFlattened, fn ($item) => !empty($item) && $item == 'mandatory');

        $this->unsetMandatorySubelements($mandatoryItemsInSchema);

        $this->assertEquals($mandatoryItemsInSchema, $this->mandatoryAttributes);
    }

    /**
     * Test that mandatory subelements for location have not changed since the time of writing this test.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_location_sub_elements_have_not_changed(): void
    {
        $locationSchema = Arr::get(readElementJsonSchema(), $this->element, []);
        $locationFlattened = flattenArrayWithKeys($locationSchema);
        $locationFlattened = getItemsWhereKeyContains($locationFlattened, '.criteria');
        $mandatoryItemsInSchema = array_filter($locationFlattened, fn ($item) => !empty($item) && $item == 'mandatory');

        $this->unsetMandatoryAttributes($mandatoryItemsInSchema);

        $this->assertEquals($mandatoryItemsInSchema, $this->mandatorySubelements);
    }

    /**
     * Test that 'location' is not complete when data is empty.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_location_is_not_complete_in_empty_data(): void
    {
        $actualData = [];

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Test that 'location' is not complete when the data is an empty JSON array.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_location_empty_json_array(): void
    {
        $actualData = json_decode('[{}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Test that 'location' is incomplete when an attribute is filled.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_location_is_incomplete_when_attribute_is_filled(): void
    {
        $activity = new Activity();

        $actualData = json_decode(
            '[{"ref":null,"location_reach":[{"code":null}],"location_id":null,"name":[{"narrative":[{"narrative":null,"language":null}]}],"description":[{"narrative":[{"narrative":null,"language":null}]}],"activity_description":[{"narrative":[{"narrative":null,"language":null}]}],"administrative":[{"vocabulary":null,"code":null,"level":null}],"point":[{"srs_name":null,"pos":[{"latitude":null,"longitude":null}]}],"exactness":[{"code":null}],"location_class":[{"code":null}],"feature_designation":[{"code":null}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->location = $actualData;

        $this->assertFalse($this->elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * Test that 'location' is complete when an attribute is filled.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_location_is_complete_when_attribute_is_filled(): void
    {
        $activity = new Activity();

        $actualData = json_decode(
            '[{"ref":"this is reference text","location_reach":[{"code":null}],"location_id":null,"name":[{"narrative":[{"narrative":null,"language":null}]}],"description":[{"narrative":[{"narrative":null,"language":null}]}],"activity_description":[{"narrative":[{"narrative":null,"language":null}]}],"administrative":[{"vocabulary":null,"code":null,"level":null}],"point":[{"srs_name":null,"pos":[{"latitude":null,"longitude":null}]}],"exactness":[{"code":null}],"location_class":[{"code":null}],"feature_designation":[{"code":null}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->location = $actualData;

        $this->assertTrue($this->elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * Test that 'location' is complete when any sub-element is filled - 1.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_is_complete_when_any_sub_element_is_filled_1(): void
    {
        $activity = new Activity();

        $actualData = json_decode(
            '[{"ref":null,"location_reach":[{"code":"1"}],"location_id":null,"name":[{"narrative":[{"narrative":null,"language":null}]}],"description":[{"narrative":[{"narrative":null,"language":null}]}],"activity_description":[{"narrative":[{"narrative":null,"language":null}]}],"administrative":[{"vocabulary":null,"code":null,"level":null}],"point":[{"srs_name":null,"pos":[{"latitude":null,"longitude":null}]}],"exactness":[{"code":null}],"location_class":[{"code":null}],"feature_designation":[{"code":null}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->location = $actualData;

        $this->assertTrue($this->elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * Test that 'location' is complete when any sub-element is filled - 2.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_location_is_complete_when_any_sub_element_is_filled_2(): void
    {
        $activity = new Activity();

        $actualData = json_decode(
            '[{"ref":null,"location_reach":[{"code":null}],"location_id":[{"vocabulary": "A1", "code":"123"}],"name":[{"narrative":[{"narrative":null,"language":null}]}],"description":[{"narrative":[{"narrative":null,"language":null}]}],"activity_description":[{"narrative":[{"narrative":null,"language":null}]}],"administrative":[{"vocabulary":null,"code":null,"level":null}],"point":[{"srs_name":null,"pos":[{"latitude":null,"longitude":null}]}],"exactness":[{"code":null}],"location_class":[{"code":null}],"feature_designation":[{"code":null}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->location = $actualData;

        $this->assertTrue($this->elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * Test that 'location' is complete when any sub-element is filled - 3.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_location_is_complete_when_any_sub_element_is_filled_3(): void
    {
        $activity = new Activity();

        $actualData = json_decode(
            '[{"ref":"","location_reach":[{"code":""}],"location_id":[{"vocabulary":"","code":""}],"name":[{"narrative":[{"narrative":"Place","language":"ng"}]}],"description":[{"narrative":[{"narrative":"","language":""}]}],"activity_description":[{"narrative":[{"narrative":"","language":""}]}],"administrative":[{"vocabulary":"","code":"","level":""}],"point":[{"srs_name":"","pos":[{"latitude":null,"longitude":null}]}],"exactness":[{"code":""}],"location_class":[{"code":""}],"feature_designation":[{"code":""}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->location = $actualData;

        $this->assertTrue($this->elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * Test that 'location' is complete when any sub-element is filled - 4.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_location_is_complete_when_any_sub_element_is_filled_4(): void
    {
        $activity = new Activity();

        $actualData = json_decode(
            '[{"ref": null,"location_reach": [{"code": null}],"location_id": [{"vocabulary": null,"code": null}],"name": [{"narrative": [{"narrative": null,"language": null}]}],"description": [{"narrative": [{"narrative": "Description narr","language": "ng"}]}],"activity_description": [{"narrative": [{"narrative": null,"language": null}]}],"administrative": [{"vocabulary": null,"code": null,"level": null}],"point": [{"srs_name": null,"pos": [{"latitude": null,"longitude": null}]}],"exactness": [{"code": null}],"location_class": [{"code": null}],"feature_designation": [{"code": null}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->location = $actualData;

        $this->assertTrue($this->elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * Test that 'location' is complete when any sub-element is filled - 5.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_location_is_complete_when_any_sub_element_is_filled_5(): void
    {
        $activity = new Activity();

        $actualData = json_decode(
            '[{"ref":"","location_reach":[{"code":""}],"location_id":[{"vocabulary":"","code":""}],"name":[{"narrative":[{"narrative":"","language":""}]}],"description":[{"narrative":[{"narrative":"","language":""}]}],"activity_description":[{"narrative":[{"narrative":"Act desc","language":"ng"}]}],"administrative":[{"vocabulary":"","code":"","level":""}],"point":[{"srs_name":"","pos":[{"latitude":0.0,"longitude":0.0}]}],"exactness":[{"code":""}],"location_class":[{"code":""}],"feature_designation":[{"code":""}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->location = $actualData;

        $this->assertTrue($this->elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * Test that 'location' is complete when any sub-element is filled - 6.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_location_is_complete_when_any_sub_element_is_filled_6(): void
    {
        $activity = new Activity();

        $actualData = json_decode(
            '[{"ref":"","location_reach":[{"code":""}],"location_id":[{"vocabulary":"","code":""}],"name":[{"narrative":[{"narrative":"","language":""}]}],"description":[{"narrative":[{"narrative":"","language":""}]}],"activity_description":[{"narrative":[{"narrative":"","language":""}]}],"administrative":[{"vocabulary":"A1","code":"AF","level":""}],"point":[{"srs_name":"","pos":[{"latitude":0.0,"longitude":0.0}]}],"exactness":[{"code":""}],"location_class":[{"code":""}],"feature_designation":[{"code":""}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->location = $actualData;

        $this->assertTrue($this->elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * Test that 'location' is complete when any sub-element is filled - 7.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_location_is_complete_when_any_sub_element_is_filled_7(): void
    {
        $activity = new Activity();

        $actualData = json_decode(
            '[{"ref":"","location_reach":[{"code":""}],"location_id":[{"vocabulary":"","code":""}],"name":[{"narrative":[{"narrative":"","language":""}]}],"description":[{"narrative":[{"narrative":"","language":""}]}],"activity_description":[{"narrative":[{"narrative":"","language":""}]}],"administrative":[{"vocabulary":"","code":"","level":""}],"point":[{"srs_name":"asd","pos":[{"latitude":84.2,"longitude":28.1}]}],"exactness":[{"code":""}],"location_class":[{"code":""}],"feature_designation":[{"code":""}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->location = $actualData;

        $this->assertTrue($this->elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * Test that 'location' is complete when any sub-element is filled - 8.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_location_is_complete_when_any_sub_element_is_filled_8(): void
    {
        $activity = new Activity();

        $actualData = json_decode(
            '[{"ref":"","location_reach":[{"code":""}],"location_id":[{"vocabulary":"","code":""}],"name":[{"narrative":[{"narrative":"","language":""}]}],"description":[{"narrative":[{"narrative":"","language":""}]}],"activity_description":[{"narrative":[{"narrative":"","language":""}]}],"administrative":[{"vocabulary":"","code":"","level":""}],"point":[{"srs_name":"","pos":[{"latitude":null,"longitude":null}]}],"exactness":[{"code":"1"}],"location_class":[{"code":""}],"feature_designation":[{"code":""}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->location = $actualData;

        $this->assertTrue($this->elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * Test that 'location' is complete when any sub-element is filled - 9.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_location_is_complete_when_any_sub_element_is_filled_9(): void
    {
        $activity = new Activity();

        $actualData = json_decode(
            '[{"ref":"","location_reach":[{"code":""}],"location_id":[{"vocabulary":"","code":""}],"name":[{"narrative":[{"narrative":"","language":""}]}],"description":[{"narrative":[{"narrative":"","language":""}]}],"activity_description":[{"narrative":[{"narrative":"","language":""}]}],"administrative":[{"vocabulary":"","code":"","level":""}],"point":[{"srs_name":"","pos":[{"latitude":null,"longitude":null}]}],"exactness":[{"code":""}],"location_class":[{"code":"1"}],"feature_designation":[{"code":""}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->location = $actualData;

        $this->assertTrue($this->elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * Test that 'location' is complete when any sub-element is filled - 10.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_location_is_complete_when_any_sub_element_is_filled_10(): void
    {
        $activity = new Activity();

        $actualData = json_decode(
            '[{"ref":null,"location_reach":[{"code":null}],"location_id":[{"vocabulary":null,"code":null}],"name":[{"narrative":[{"narrative":null,"language":null}]}],"description":[{"narrative":[{"narrative":null,"language":null}]}],"activity_description":[{"narrative":[{"narrative":null,"language":null}]}],"administrative":[{"vocabulary":null,"code":null,"level":null}],"point":[{"srs_name":null,"pos":[{"latitude":null,"longitude":null}]}],"exactness":[{"code":null}],"location_class":[{"code":null}],"feature_designation":[{"code":"AIRQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->location = $actualData;

        $this->assertTrue($this->elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * Test location is incomplete when one of many location instance is incomplete.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_multiple_location_is_incomplete_when_one_is_incomplete(): void
    {
        $activity = new Activity();

        $actualData = json_decode(
            '[{"ref":null,"location_reach":[{"code":null}],"location_id":[{"vocabulary":null,"code":null}],"name":[{"narrative":[{"narrative":null,"language":null}]}],"description":[{"narrative":[{"narrative":null,"language":null}]}],"activity_description":[{"narrative":[{"narrative":null,"language":null}]}],"administrative":[{"vocabulary":null,"code":null,"level":null}],"point":[{"srs_name":null,"pos":[{"latitude":null,"longitude":null}]}],"exactness":[{"code":null}],"location_class":[{"code":null}],"feature_designation":[{"code":"AIRQ"}]}, {"ref":null,"location_reach":[{"code":null}],"location_id":[{"vocabulary":null,"code":null}],"name":[{"narrative":[{"narrative":null,"language":null}]}],"description":[{"narrative":[{"narrative":null,"language":null}]}],"activity_description":[{"narrative":[{"narrative":null,"language":null}]}],"administrative":[{"vocabulary":null,"code":null,"level":null}],"point":[{"srs_name":null,"pos":[{"latitude":null,"longitude":null}]}],"exactness":[{"code":null}],"location_class":[{"code":null}],"feature_designation":[{"code":null}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->location = $actualData;

        $this->assertFalse($this->elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * Test location is complete when all of the location instances are incomplete.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_multiple_location_is_complete_when_all_are_complete(): void
    {
        $activity = new Activity();

        $actualData = json_decode(
            '[{"ref":null,"location_reach":[{"code":null}],"location_id":[{"vocabulary":null,"code":null}],"name":[{"narrative":[{"narrative":null,"language":null}]}],"description":[{"narrative":[{"narrative":null,"language":null}]}],"activity_description":[{"narrative":[{"narrative":null,"language":null}]}],"administrative":[{"vocabulary":null,"code":null,"level":null}],"point":[{"srs_name":null,"pos":[{"latitude":null,"longitude":null}]}],"exactness":[{"code":null}],"location_class":[{"code":null}],"feature_designation":[{"code":"AIRQ"}]}, {"ref":null,"location_reach":[{"code":null}],"location_id":[{"vocabulary":null,"code":null}],"name":[{"narrative":[{"narrative":null,"language":null}]}],"description":[{"narrative":[{"narrative":null,"language":null}]}],"activity_description":[{"narrative":[{"narrative":null,"language":null}]}],"administrative":[{"vocabulary":null,"code":null,"level":null}],"point":[{"srs_name":null,"pos":[{"latitude":null,"longitude":null}]}],"exactness":[{"code":null}],"location_class":[{"code":null}],"feature_designation":[{"code":"AIRQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->location = $actualData;

        $this->assertTrue($this->elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * Test location is incomplete when null.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_is_incomplete_when_contact_info_element_is_missing()
    {
        $activity = new Activity();
        $activity->location = null;

        $this->assertFalse($this->elementCompleteService->isContactInfoElementCompleted($activity));
    }
}
