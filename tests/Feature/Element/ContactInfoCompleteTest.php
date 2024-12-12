<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

use App\IATI\Models\Activity\Activity;
use App\IATI\Services\ElementCompleteService;
use Illuminate\Support\Arr;

/**
 * Class LocationCompleteTest.
 */
class ContactInfoCompleteTest extends ElementCompleteTest
{
    /**
     * Element location.
     *
     * @var string
     */
    private string $element = 'contact_info';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_mandatory_attributes_have_not_changed(): void
    {
        $mandatoryAttributes = ['type'];
        $this->test_mandatory_attributes($this->element, $mandatoryAttributes);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_elements_have_not_changed(): void
    {
        $mandatorySubelements = [];

        $contactInfoSchema = Arr::get(readElementJsonSchema(), $this->element, []);
        $contactInfoFlattened = flattenArrayWithKeys($contactInfoSchema);
        $contactInfoFlattened = getItemsWhereKeyContains($contactInfoFlattened, '.criteria');
        unset($contactInfoFlattened['attributes.type.criteria']);
        $mandatorySubelementsInSchema = array_filter($contactInfoFlattened, fn ($item) => !empty($item));

        $this->assertEquals($mandatorySubelements, $mandatorySubelementsInSchema, 'Mandatory attributes have changed.');
    }

    /**
     * Empty data test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_is_not_complete_in_empty_data(): void
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
    public function test_contact_info_empty_json_array(): void
    {
        $actualData = json_decode('[{}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_is_incomplete_without_type()
    {
        $activity = new Activity();
        $data = '[{"type": null,"organisation": [{"narrative": [{"narrative": "Org name","language": "ng"}]}],"department": [{"narrative": [{"narrative": "Dept","language": "ng"}]}],"person_name": [{"narrative": [{"narrative": "John","language": "ng"}]}],"job_title": [{"narrative": [{"narrative": "PM","language": "ng"}]}],"telephone": [{"telephone": "9860123456"}],"email": [{"email": "superadmin@yipl.com.np"}],"website": [{"website": "https://iatipublisher-staging.yipl.com.np"}],"mailing_address": [{"narrative": [{"narrative": "Mahalaxmi-sthan, Patan","language": "ng"}]}]]';
        $actualData = json_decode(
            $data,
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->contact_info = $actualData;

        $elementCompleteService = new ElementCompleteService();

        $this->assertFalse($elementCompleteService->isContactInfoElementCompleted($activity));
    }

    public function test_contact_info_is_complete_with_type()
    {
        $activity = new Activity();
        $data = '[{"type": "1","organisation": [{"narrative": [{"narrative": "Org name","language": "ng"}]}],"department": [{"narrative": [{"narrative": "Dept","language": "ng"}]}],"person_name": [{"narrative": [{"narrative": "John","language": "ng"}]}],"job_title": [{"narrative": [{"narrative": "PM","language": "ng"}]}],"telephone": [{"telephone": "9860123456"}],"email": [{"email": "superadmin@yipl.com.np"}],"website": [{"website": "https://iatipublisher-staging.yipl.com.np"}],"mailing_address": [{"narrative": [{"narrative": "Mahalaxmi-sthan, Patan","language": "ng"}]}]]';
        $actualData = json_decode(
            $data,
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->contact_info = $actualData;

        $elementCompleteService = new ElementCompleteService();

        $this->assertTrue($elementCompleteService->isContactInfoElementCompleted($activity));
    }

    /**
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_is_incomplete_when_attribute_is_filled(): void
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

        $this->assertFalse($elementCompleteService->isContactInfoElementCompleted($activity));
    }
}
