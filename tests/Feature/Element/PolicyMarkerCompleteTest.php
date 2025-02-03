<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

use App\IATI\Models\Activity\Activity;
use Illuminate\Support\Arr;
use Tests\Traits\FilterMandatoryItemsTrait;

/**
 * @class PolicyMarkerCompleteTest.
 */
class PolicyMarkerCompleteTest extends ElementCompleteTest
{
    use FilterMandatoryItemsTrait;

    protected array $mandatorySubelements = [];

    protected array $mandatoryAttributes = [
        'attributes.policy_marker.criteria'      => 'mandatory',
        'attributes.policy_marker_text.criteria' => 'mandatory',
    ];

    /**
     * Mandatory attributes have not changed.
     *
     * @var string
     */
    private string $element = 'policy_marker';

    public function test_policy_marker_mandatory_attributes_have_not_changed(): void
    {
        $policyMarkerSchema = Arr::get(readElementJsonSchema(), $this->element, []);
        $policyMarkerFlattened = flattenArrayWithKeys($policyMarkerSchema);
        $policyMarkerFlattened = getItemsWhereKeyContains($policyMarkerFlattened, '.criteria');
        $mandatoryItemsInSchema = array_filter(
            $policyMarkerFlattened,
            fn ($item) => !empty($item) && $item == 'mandatory'
        );

        $this->unsetMandatorySubelements($mandatoryItemsInSchema);

        $this->assertEquals($mandatoryItemsInSchema, $this->mandatoryAttributes);
    }

    /**
     * Mandatory subelements have not changed.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_policy_marker_subelements_have_not_changed(): void
    {
        $policyMarkerSchema = Arr::get(readElementJsonSchema(), $this->element, []);
        $policyMarkerFlattened = flattenArrayWithKeys($policyMarkerSchema);
        $policyMarkerFlattened = getItemsWhereKeyContains($policyMarkerFlattened, '.criteria');
        $mandatoryItemsInSchema = array_filter(
            $policyMarkerFlattened,
            fn ($item) => !empty($item) && $item == 'mandatory'
        );

        $this->unsetMandatoryAttributes($mandatoryItemsInSchema);

        $this->assertEquals($mandatoryItemsInSchema, $this->mandatorySubelements);
    }

    /**
     * Test incomplete when null.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_policy_marker_is_not_complete_when_null(): void
    {
        $actualData = null;

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test incomplete when empty string.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_policy_marker_is_not_complete_when_empty_string(): void
    {
        $actualData = '';

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test incomplete when empty array.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_policy_marker_is_not_complete_when_empty_data(): void
    {
        $actualData = [];

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test incomplete when empty json array.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function test_policy_marker_is_not_complete_when_empty_json_array(): void
    {
        $actualData = json_decode('[{}]');

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test incomplete when policy_marker key is missing.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_is_incomplete_when_not_custom_vocab_and_policy_marker_code_is_missing()
    {
        $actualData = json_decode(
            '[{"policy_marker_vocabulary":"1","significance":"2","narrative":[{"narrative":"Narr onea","language":"ng"}]}]',
            true
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test incomplete when policy_marker value is null.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_is_incomplete_when_not_custom_vocab_and_policy_marker_code_is_null()
    {
        $actualData = json_decode(
            '[{"policy_marker_vocabulary":"1","significance":"2","policy_marker":null,"narrative":[{"narrative":"Narr onea","language":"ng"}]}]',
            true
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test incomplete when policy_marker value is empty string.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_is_incomplete_when_not_custom_vocab_and_policy_marker_code_is_empty_string()
    {
        $actualData = json_decode(
            '[{"policy_marker_vocabulary":"1","significance":"2","policy_marker":"","narrative":[{"narrative":"Narr onea","language":"ng"}]}]',
            true
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test complete when policy_marker value is 0.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_is_complete_when_not_custom_vocab_and_policy_marker_code_is_zero()
    {
        $actualData = json_decode(
            '[{"policy_marker_vocabulary":"1","significance":"2","policy_marker":"0","narrative":[{"narrative":"Narr onea","language":"ng"}]}]',
            true
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test complete when only policy_marker is filled (single).
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_is_complete_when_only_policy_marker_code_is_filled()
    {
        $actualData = json_decode(
            '[{"policy_marker_vocabulary":"1","significance":null,"policy_marker":"2","narrative":[{"narrative":null,"language":null}]}]',
            true
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test complete when only policy_marker is filled (multiple).
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_is_complete_when_only_policy_marker_code_is_filled_multiple()
    {
        $actualData = json_decode(
            '[{"policy_marker_vocabulary":"1","significance":null,"policy_marker":"2","narrative":[{"narrative":null,"language":null}]}, {"policy_marker_vocabulary":"1","significance":null,"policy_marker":"1","narrative":[{"narrative":null,"language":null}]}]',
            true
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test complete when only custom vocab policy_marker_text is filled (multiple).
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_is_complete_when_only_custom_vocab_policy_marker_text_is_filled_multiple()
    {
        $actualData = json_decode(
            '[{"policy_marker_vocabulary":null,"vocabulary_uri":null,"significance":null,"policy_marker_text":"text 1","narrative":[{"narrative":null,"language":null}]},{"policy_marker_vocabulary":null,"vocabulary_uri":null,"significance":null,"policy_marker_text":"text 2","narrative":[{"narrative":null,"language":null}]}]',
            true
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test complete when only custom vocab policy_marker_text is filled (single).
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_is_complete_when_only_custom_vocab_policy_marker_text_is_filled()
    {
        $actualData = json_decode(
            '[{"policy_marker_vocabulary":null,"vocabulary_uri":null,"significance":null,"policy_marker_text":"text 1","narrative":[{"narrative":null,"language":null}]}]',
            true
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test incomplete when policy_marker_text key is missing in custom vocab case.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_is_incomplete_when_custom_vocab_and_policy_marker_text_is_missing()
    {
        $actualData = json_decode(
            '[{"policy_marker_vocabulary":"99","vocabulary_uri":"https://github.com/younginnovations/iatipublisher","significance":"2","narrative":[{"narrative":"Narr one","language":"ng"}]}]',
            true
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test incomplete when policy_marker_text value is null in custom vocab case.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_is_incomplete_when_custom_vocab_and_policy_marker_text_is_null()
    {
        $actualData = json_decode(
            '[{"policy_marker_vocabulary":"99","vocabulary_uri":"https://github.com/younginnovations/iatipublisher","significance":"2","policy_marker_text":null,"narrative":[{"narrative":"Narr one","language":"ng"}]}]',
            true
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test incomplete when policy_marker_text value is empty string in custom vocab case.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_is_incomplete_when_custom_vocab_and_policy_marker_text_is_empty_string()
    {
        $actualData = json_decode(
            '[{"policy_marker_vocabulary":"99","vocabulary_uri":"https://github.com/younginnovations/iatipublisher","significance":"2","policy_marker_text":"","narrative":[{"narrative":"Narr one","language":"ng"}]}]',
            true
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test complete when policy_marker_text value is 0 in custom vocab case.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_is_complete_when_custom_vocab_and_policy_marker_text_is_zero()
    {
        $actualData = json_decode(
            '[{"policy_marker_vocabulary":"99","vocabulary_uri":"https://github.com/younginnovations/iatipublisher","significance":"2","policy_marker_text":"0","narrative":[{"narrative":"Narr one","language":"ng"}]}]',
            true
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test complete when everything is filled.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_is_complete_when_custom_vocab_and_all_filled()
    {
        $actualData = json_decode(
            '[{"policy_marker_vocabulary":"99","vocabulary_uri":"https://github.com/younginnovations/iatipublisher","significance":"2","policy_marker_text":"12345","narrative":[{"narrative":"Narr one","language":"ng"}]}]',
            true
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test complete when everything is filled (multiple).
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_is_complete_when_all_filled_multiple()
    {
        $actualData = json_decode(
            '[{"policy_marker_vocabulary":"99","vocabulary_uri":"https://github.com/younginnovations/iatipublisher","significance":"2","policy_marker_text":"12345","narrative":[{"narrative":"Narr one","language":"ng"}]},{"policy_marker_vocabulary":"1","significance":"2","policy_marker":"1","narrative":[{"narrative":"Another narr","language":"ng"}]}]',
            true
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }

    /**
     * Test complete when only required fields are filled (multiple).
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_is_complete_when_only_required_filled_multiple()
    {
        $actualData = json_decode(
            '[{"policy_marker_vocabulary":"1","significance":null,"policy_marker":"1","narrative":[{"narrative":null,"language":null}]},{"policy_marker_vocabulary":"99","vocabulary_uri":null,"significance":null,"policy_marker_text":"Code 1","narrative":[{"narrative":"Nar required","language":"ng"}]},{"policy_marker_vocabulary":"1","significance":null,"policy_marker":"2","narrative":[{"narrative":null,"language":null}]}]',
            true
        );

        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isPolicyMarkerElementCompleted($activity));
    }
}
