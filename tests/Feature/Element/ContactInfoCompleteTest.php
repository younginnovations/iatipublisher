<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

use App\IATI\Models\Activity\Activity;
use Illuminate\Support\Arr;
use Tests\Traits\FilterMandatoryItemsTrait;

/**
 * Class LocationCompleteTest.
 */
class ContactInfoCompleteTest extends ElementCompleteTest
{
    use FilterMandatoryItemsTrait;

    /**
     * Element location.
     *
     * @var string
     */
    private string $element = 'contact_info';

    /**
     * @var array|string[]
     */
    private array $mandatoryAttributes = ['attributes.type.criteria' => 'mandatory'];

    /**
     * @var array
     */
    private array $mandatorySubelements = [];

    /**
     * Test for ensuring mandatory attributes have not changed since the time of writing this test.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_mandatory_attributes_have_not_changed(): void
    {
        $contactInfoSchema = Arr::get(readElementJsonSchema(), $this->element, []);
        $contactInfoFlattened = flattenArrayWithKeys($contactInfoSchema);
        $contactInfoFlattened = getItemsWhereKeyContains($contactInfoFlattened, '.criteria');
        $mandatoryItemsInSchema = array_filter(
            $contactInfoFlattened,
            fn ($item) => !empty($item) && $item == 'mandatory'
        );

        $this->unsetMandatorySubelements($mandatoryItemsInSchema);

        $this->assertEquals($mandatoryItemsInSchema, $this->mandatoryAttributes);
    }

    /**
     * Test for ensuring mandatory subelements have not changed since the time of writing this test.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_subelements_have_not_changed(): void
    {
        $contactInfoSchema = Arr::get(readElementJsonSchema(), $this->element, []);
        $contactInfoFlattened = flattenArrayWithKeys($contactInfoSchema);
        $contactInfoFlattened = getItemsWhereKeyContains($contactInfoFlattened, '.criteria');
        $mandatoryItemsInSchema = array_filter(
            $contactInfoFlattened,
            fn ($item) => !empty($item) && $item == 'mandatory'
        );

        $this->unsetMandatoryAttributes($mandatoryItemsInSchema);

        $this->assertEquals($mandatoryItemsInSchema, $this->mandatorySubelements);
    }

    /**
     * Test for ensuring the contact info is not complete with empty data.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_is_not_complete_in_empty_data(): void
    {
        $actualData = [];

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Test for ensuring the contact info is not complete with an empty JSON array.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_empty_json_array(): void
    {
        $actualData = json_decode('[{}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     *  Test for checking if contact info is incomplete when all sub-elements are filled except for the type attribute.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_is_incomplete_when_all_subelements_are_filled_except_type_attribute()
    {
        $activity = new Activity();
        $data = '[{"type":null,"organisation":[{"narrative":[{"narrative":"Org name","language":"ng"}]}],"department":[{"narrative":[{"narrative":"Dept","language":"ng"}]}],"person_name":[{"narrative":[{"narrative":"John","language":"ng"}]}],"job_title":[{"narrative":[{"narrative":"PM","language":"ng"}]}],"telephone":[{"telephone":"9860123456"}],"email":[{"email":"superadmin@yipl.com.np"}],"website":[{"website":"https://iatipublisher-staging.yipl.com.np"}],"mailing_address":[{"narrative":[{"narrative":"Mahalaxmi-sthan, Patan","language":"ng"}]}]}]';
        $actualData = json_decode(
            $data,
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->contact_info = $actualData;

        $this->assertFalse($this->elementCompleteService->isContactInfoElementCompleted($activity));
    }

    /**
     * Test for checking if contact info is incomplete when the type attribute is filled but no sub-elements are filled.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_is_incomplete_when_type_attribute_is_filled_but_no_subelement_is_filled()
    {
        $activity = new Activity();
        $data = '[{"type":"1","organisation":[{"narrative":[{"narrative":null,"language":null}]}],"department":[{"narrative":[{"narrative":null,"language":null}]}],"person_name":[{"narrative":[{"narrative":null,"language":null}]}],"job_title":[{"narrative":[{"narrative":null,"language":null}]}],"telephone":[{"telephone":null}],"email":[{"email":null}],"website":[{"website":null}],"mailing_address":[{"narrative":[{"narrative":null,"language":null}]}]}]';
        $actualData = json_decode(
            $data,
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->contact_info = $actualData;

        $this->assertFalse($this->elementCompleteService->isContactInfoElementCompleted($activity));
    }

    /**
     * Test for checking if contact info is complete when the type attribute plus any sub-element is filled.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_is_complete_when_type_attribute_plus_any_subelement_is_filled()
    {
        $activity = new Activity();
        $data = '[{"type":"1","organisation":[{"narrative":[{"narrative":"narr 1","language":"en"}]}],"department":[{"narrative":[{"narrative":null,"language":null}]}],"person_name":[{"narrative":[{"narrative":null,"language":null}]}],"job_title":[{"narrative":[{"narrative":null,"language":null}]}],"telephone":[{"telephone":null}],"email":[{"email":null}],"website":[{"website":null}],"mailing_address":[{"narrative":[{"narrative":null,"language":null}]}]}]';
        $actualData = json_decode(
            $data,
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $activity->contact_info = $actualData;

        $this->assertTrue($this->elementCompleteService->isContactInfoElementCompleted($activity));
    }

    /**
     * Test for checking if contact info is complete when the type attribute plus multiple sub-elements are filled.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_is_complete_when_type_attribute_plus_multiple_subelements_are_filled()
    {
        $activity = new Activity();
        $data = '[{"type":"1","organisation":[{"narrative":[{"narrative":"Org name","language":"en"}]}],"department":[{"narrative":[{"narrative":"Dept","language":"en"}]}],"person_name":[{"narrative":[{"narrative":null,"language":null}]}],"job_title":[{"narrative":[{"narrative":null,"language":null}]}],"telephone":[{"telephone":"123456789"}],"email":[{"email":"test@example.com"}],"website":[{"website":"https://example.com"}],"mailing_address":[{"narrative":[{"narrative":"Address","language":"en"}]}]}]';
        $actualData = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        $activity->contact_info = $actualData;

        $this->assertTrue($this->elementCompleteService->isContactInfoElementCompleted($activity));
    }

    /**
     * Test for checking if contact info is incomplete when the type attribute is missing.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_is_incomplete_when_type_attribute_is_missing()
    {
        $activity = new Activity();
        $data = '[{"organisation":[{"narrative":[{"narrative":"Org name","language":"en"}]}]}]';
        $actualData = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        $activity->contact_info = $actualData;

        $this->assertFalse($this->elementCompleteService->isContactInfoElementCompleted($activity));
    }

    /**
     * Test for checking if contact info is incomplete when the contact info element is missing.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_is_incomplete_when_contact_info_element_is_missing()
    {
        $activity = new Activity();
        $activity->contact_info = null;

        $this->assertFalse($this->elementCompleteService->isContactInfoElementCompleted($activity));
    }

    /**
     * Test for checking if contact info is complete with the type attribute and all sub-elements filled.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_contact_info_is_complete_with_type_attributes_and_all_sub_elements_filled()
    {
        $activity = new Activity();
        $data = '[{"type":"1","organisation":[{"narrative":[{"narrative":"Org name","language":"en"}]}],"department":[{"narrative":[{"narrative":"Dept","language":"en"}]}],"person_name":[{"narrative":[{"narrative":"John Doe","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"Manager","language":"en"}]}],"telephone":[{"telephone":"123456789"}],"email":[{"email":"test@example.com"}],"website":[{"website":"https://example.com"}],"mailing_address":[{"narrative":[{"narrative":"Address","language":"en"}]}]}]';
        $actualData = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        $activity->contact_info = $actualData;

        $this->assertTrue($this->elementCompleteService->isContactInfoElementCompleted($activity));
    }

    /**
     * Test for checking if multiple contact info elements are incomplete when one instance is incomplete.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_multiple_contact_info_is_incomplete_when_one_is_incomplete()
    {
        $activity = new Activity();
        $data = '[{"type":"1","organisation":[{"narrative":[{"narrative":"Org name","language":"en"}]}],"department":[{"narrative":[{"narrative":"Dept","language":"en"}]}],"person_name":[{"narrative":[{"narrative":"John","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"PM","language":"en"}]}],"telephone":[{"telephone":"123456789"}],"email":[{"email":"test@example.com"}],"website":[{"website":"https://example.com"}],"mailing_address":[{"narrative":[{"narrative":"Address","language":"en"}]}]}, {"type":"2","organisation":[],"department":[],"person_name":[],"job_title":[],"telephone":[{"telephone":null}],"email":[{"email":null}],"website":[{"website":null}],"mailing_address":[]}]';
        $actualData = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        $activity->contact_info = $actualData;

        $this->assertFalse($this->elementCompleteService->isContactInfoElementCompleted($activity));
    }

    /**
     *Test for checking if multiple contact info elements with all contact info instances complete.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_multiple_contact_info_elements_with_one_complete()
    {
        $activity = new Activity();
        $data = '[{"type":"1","organisation":[{"narrative":[{"narrative":"Org name","language":"en"}]}],"department":[{"narrative":[{"narrative":"Dept","language":"en"}]}],"person_name":[{"narrative":[{"narrative":"John","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"PM","language":"en"}]}],"telephone":[{"telephone":"123456789"}],"email":[{"email":"test@example.com"}],"website":[{"website":"https://example.com"}],"mailing_address":[{"narrative":[{"narrative":"Address","language":"en"}]}]}, {"type":"1","organisation":[{"narrative":[{"narrative":"narr 1","language":"en"}]}],"department":[{"narrative":[{"narrative":null,"language":null}]}],"person_name":[{"narrative":[{"narrative":null,"language":null}]}],"job_title":[{"narrative":[{"narrative":null,"language":null}]}],"telephone":[{"telephone":null}],"email":[{"email":null}],"website":[{"website":null}],"mailing_address":[{"narrative":[{"narrative":null,"language":null}]}]}]';
        $actualData = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        $activity->contact_info = $actualData;

        $this->assertTrue($this->elementCompleteService->isContactInfoElementCompleted($activity));
    }
}
