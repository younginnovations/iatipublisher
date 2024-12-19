<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

use App\IATI\Models\Activity\Activity;
use Illuminate\Support\Arr;
use Tests\Traits\FilterMandatoryItemsTrait;

/**
 * Class TagCompleteTest.
 */
class TagCompleteTest extends ElementCompleteTest
{
    use FilterMandatoryItemsTrait;

    /**
     * Element tag.
     *
     * @var string
     */
    private string $element = 'tag';

    /**
     * @var array|string[]
     */
    private array $mandatoryAttributes = [
        'attributes.tag_vocabulary.criteria'   => 'mandatory',
        'attributes.goals_tag_code.criteria'   => 'mandatory',
        'attributes.targets_tag_code.criteria' => 'mandatory',
        'attributes.tag_text.criteria'         => 'mandatory',
    ];

    /**
     * @var array
     */
    private array $mandatorySubelements = [];

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_sector_type_mandatory_attributes(): void
    {
        $tagSchema = Arr::get(readElementJsonSchema(), $this->element, []);
        $tagFlattened = flattenArrayWithKeys($tagSchema);
        $tagFlattened = getItemsWhereKeyContains($tagFlattened, '.criteria');
        $mandatoryItemsInSchema = array_filter(
            $tagFlattened,
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
    public function test_sector_subelements_have_not_changed(): void
    {
        $tagSchema = Arr::get(readElementJsonSchema(), $this->element, []);
        $tagFlattened = flattenArrayWithKeys($tagSchema);
        $tagFlattened = getItemsWhereKeyContains($tagFlattened, '.criteria');
        $mandatoryItemsInSchema = array_filter(
            $tagFlattened,
            fn ($item) => !empty($item) && $item == 'mandatory'
        );

        $this->unsetMandatoryAttributes($mandatoryItemsInSchema);

        $this->assertEquals($mandatoryItemsInSchema, $this->mandatorySubelements);
    }

    public function test_tag_is_incomplete_when_null()
    {
        $actualData = null;
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_when_empty_string()
    {
        $actualData = '';
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_when_empty_array()
    {
        $actualData = [];
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_when_empty_json_array()
    {
        $actualData = json_decode('[{}]');
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_null()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":null,"tag_text":null,"narrative":[{"narrative":null,"language":null}]}]'
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_1_when_only_vocab_is_filled()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"1","tag_text":null,"narrative":[{"narrative":null,"language":null}]}]'
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_complete_for_vocab_1_when_only_vocab_is_filled()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"1","tag_text":"1234","narrative":[{"narrative":null,"language":null}]}]'
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_2_when_only_vocab_is_null()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":null,"goals_tag_code":null,"narrative":[{"narrative":null,"language":null}]}]'
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_2_when_only_vocab_is_filled()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"2","goals_tag_code":null,"narrative":[{"narrative":null,"language":null}]}]'
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_complete_for_vocab_2_both_are_filled()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"2","goals_tag_code":"1","narrative":[{"narrative":null,"language":null}]}]'
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_3_when_only_vocab_is_null()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":null,"targets_tag_code":null,"narrative":[{"narrative":null,"language":null}]}]'
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_3_when_only_vocab_is_filled()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"3","targets_tag_code":null,"narrative":[{"narrative":null,"language":null}]}]'
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_complete_for_vocab_3_both_are_filled()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"3","targets_tag_code":"1.1","narrative":[{"narrative":null,"language":null}]}]'
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_4_when_only_vocab_is_null()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":null,"tag_text":null,"narrative":[{"narrative":null,"language":null}]}]'
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_4_when_only_vocab_is_filled()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"4","tag_text":null,"narrative":[{"narrative":null,"language":null}]}]'
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_complete_for_vocab_4_both_are_filled()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"4","tag_text":"1ab","narrative":[{"narrative":null,"language":null}]}]'
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_99_when_only_vocab_is_null()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":null","tag_text":null,"narrative":[{"narrative":null,"language":null}]}]'
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_99_when_only_vocab_is_filled()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"99","tag_text":null,"narrative":[{"narrative":null,"language":null}]}]'
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_complete_for_vocab_99_both_are_filled()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"99","tag_text":"1ab","narrative":[{"narrative":null,"language":null}]}]'
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_null_multiple()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":null,"tag_text":null,"narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":null,"tag_text":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_1_when_only_vocab_is_filled_multiple()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"1","tag_text":null,"narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":"1","tag_text":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_complete_for_vocab_1_when_only_vocab_is_filled_multiple()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"1","tag_text":"1234","narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":"1","tag_text":"1234","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_2_when_only_vocab_is_null_multiple()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":null,"goals_tag_code":null,"narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":null,"goals_tag_code":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_2_when_only_vocab_is_filled_multiple()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"2","goals_tag_code":null,"narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":"2","goals_tag_code":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_complete_for_vocab_2_both_are_filled_multiple()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"2","goals_tag_code":"1","narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":"2","goals_tag_code":"1","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_3_when_only_vocab_is_null_multiple()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":null,"targets_tag_code":null,"narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":null,"targets_tag_code":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_3_when_only_vocab_is_filled_multiple()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"3","targets_tag_code":null,"narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":"3","targets_tag_code":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_complete_for_vocab_3_both_are_filled_multiple()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"3","targets_tag_code":"1.1","narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":"3","targets_tag_code":"1.1","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_4_when_only_vocab_is_null_multiple()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":null,"tag_text":null,"narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":null,"tag_text":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_4_when_only_vocab_is_filled_multiple()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"4","tag_text":null,"narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":"4","tag_text":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_complete_for_vocab_4_both_are_filled_multiple()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"4","tag_text":"1ab","narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":"4","tag_text":"1ab","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_99_when_only_vocab_is_null_multiple()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":null","tag_text":null,"narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":null","tag_text":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_incomplete_for_vocab_99_when_only_vocab_is_filled_multiple()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"99","tag_text":null,"narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":"99","tag_text":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isTagElementCompleted($activity));
    }

    public function test_tag_is_complete_for_vocab_99_both_are_filled_multiple()
    {
        $actualData = json_decode(
            '[{"tag_vocabulary":"99","tag_text":"1ab","narrative":[{"narrative":null,"language":null}]},{"tag_vocabulary":"99","tag_text":"1ab","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isTagElementCompleted($activity));
    }
}
