<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

use App\IATI\Models\Activity\Activity;
use App\IATI\Services\ElementCompleteService;
use Illuminate\Support\Arr;

/**
 * Class LocationCompleteTest.
 */
class LocationCompleteTest extends ElementCompleteTest
{
    /**
     * Element location.
     *
     * @var string
     */
    private string $element = 'location';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_mandatory_attributes_have_not_changed(): void
    {
        $mandatoryAttributes = [];
        $this->test_mandatory_attributes($this->element, $mandatoryAttributes);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_elements_have_not_changed(): void
    {
        $mandatorySubelements = [];

        $locationSchema = Arr::get(readElementJsonSchema(), $this->element, []);
        $locationFlattened = flattenArrayWithKeys($locationSchema);
        $locationFlattened = getItemsWhereKeyContains($locationFlattened, '.criteria');
        $mandatorySubelementsInSchema = array_filter($locationFlattened, fn ($item) => !empty($item));

        $this->assertEquals($mandatorySubelements, $mandatorySubelementsInSchema, 'Mandatory attributes have changed.');
    }

    /**
     * Empty data test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_is_not_complete_in_empty_data(): void
    {
        $actualData = [];

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_empty_json_array(): void
    {
        $actualData = json_decode('[{}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
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

        $elementCompleteService = new ElementCompleteService();

        $this->assertFalse($elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * Sub element location_id empty test.
     *
     * @return void
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

        $elementCompleteService = new ElementCompleteService();

        $this->assertTrue($elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * Sub element location_id empty test.
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

        $elementCompleteService = new ElementCompleteService();

        $this->assertTrue($elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
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

        $elementCompleteService = new ElementCompleteService();

        $this->assertTrue($elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
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

        $elementCompleteService = new ElementCompleteService();

        $this->assertTrue($elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
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

        $elementCompleteService = new ElementCompleteService();

        $this->assertTrue($elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * @return void
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

        $elementCompleteService = new ElementCompleteService();

        $this->assertTrue($elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * @return void
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

        $elementCompleteService = new ElementCompleteService();

        $this->assertTrue($elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * @return void
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

        $elementCompleteService = new ElementCompleteService();

        $this->assertTrue($elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * @return void
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

        $elementCompleteService = new ElementCompleteService();

        $this->assertTrue($elementCompleteService->isLocationElementCompleted($activity));
    }

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

        $elementCompleteService = new ElementCompleteService();

        $this->assertTrue($elementCompleteService->isLocationElementCompleted($activity));
    }

    /**
     * @return void
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

        $elementCompleteService = new ElementCompleteService();

        $this->assertTrue($elementCompleteService->isLocationElementCompleted($activity));
    }
}
