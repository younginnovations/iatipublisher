<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

use App\IATI\Models\Activity\Activity;
use Illuminate\Support\Arr;
use Tests\Traits\FilterMandatoryItemsTrait;

/**
 * Class SectorCompleteTest.
 */
class SectorCompleteTest extends ElementCompleteTest
{
    use FilterMandatoryItemsTrait;

    /**
     * Element sector.
     *
     * @var string
     */
    private string $element = 'sector';

    /**
     * @var array|string[]
     */
    private array $mandatoryAttributes = [
        'attributes.code.criteria'          => 'mandatory',
        'attributes.text.criteria'          => 'mandatory',
        'attributes.category_code.criteria' => 'mandatory',
        'attributes.sdg_goal.criteria'      => 'mandatory',
        'attributes.sdg_target.criteria'    => 'mandatory',
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
        $sectorSchema = Arr::get(readElementJsonSchema(), $this->element, []);
        $sectorFlattened = flattenArrayWithKeys($sectorSchema);
        $sectorFlattened = getItemsWhereKeyContains($sectorFlattened, '.criteria');
        $mandatoryItemsInSchema = array_filter(
            $sectorFlattened,
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
        $sectorSchema = Arr::get(readElementJsonSchema(), $this->element, []);
        $sectorFlattened = flattenArrayWithKeys($sectorSchema);
        $sectorFlattened = getItemsWhereKeyContains($sectorFlattened, '.criteria');
        $mandatoryItemsInSchema = array_filter(
            $sectorFlattened,
            fn ($item) => !empty($item) && $item == 'mandatory'
        );

        $this->unsetMandatoryAttributes($mandatoryItemsInSchema);

        $this->assertEquals($mandatoryItemsInSchema, $this->mandatorySubelements);
    }

    /**
     * Test incomplete when null.
     *
     * @throws \JsonException
     */
    public function test_incomplete_when_null()
    {
        $actualData = null;
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    /**
     * Test incomplete when null.
     *
     * @throws \JsonException
     */
    public function test_incomplete_when_empty_string()
    {
        $actualData = '';
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    /**
     * Test incomplete when null.
     *
     * @throws \JsonException
     */
    public function test_incomplete_when_empty_array()
    {
        $actualData = [];
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    /**
     * Test incomplete when null.
     *
     * @throws \JsonException
     */
    public function test_incomplete_when_empty_json_array()
    {
        $actualData = json_decode('[{}]', true);
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_null()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":null,"text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_null()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":null,"text":"112","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_1()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"1","code":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_2()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"2","category_code":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_3()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"3","text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_4()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"4","text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_5()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"5","text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_6()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"6","text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_7()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"7","sdg_goal":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_8()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"8","sdg_target":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_9()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"9","text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_10()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"10","text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_11()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"11","text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_12()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"12","text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_99()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"99","vocabulary_uri":null,"text":null,"percentage":null,"narrative":[{"narrative":"Narrative required","language":"ne"}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_98()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"98","vocabulary_uri":null,"text":null,"percentage":null,"narrative":[{"narrative":"Narrative required","language":"ne"}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_1_multiple_when_only_code_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"1","code":"11110","percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"1","code":"11120","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_2_multiple_when_only_code_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"2","category_code":"111","percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"2","category_code":"112","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_3_multiple_when_only_code_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"3","text":"123","percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"3","text":"1234","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_4_multiple_when_only_code_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"4","text":"123","percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"4","text":"1234","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_5_multiple_when_only_code_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"5","text":"123","percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"5","text":"1234","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_6_multiple_when_only_code_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"6","text":"123","percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"6","text":"1234","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_7_multiple_when_only_code_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"7","sdg_goal":"1","percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"7","sdg_goal":"2","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_8_multiple_when_only_code_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"8","sdg_target":"1.1","percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"8","sdg_target":"1.2","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_9_multiple_when_only_code_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"9","text":"123","percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"9","text":"1234","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_10_multiple_when_only_code_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"10","text":"123","percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"10","text":"1234","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_11_multiple_when_only_code_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"11","text":"123","percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"11","text":"1234","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_12_multiple_when_only_code_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"12","text":"123","percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"12","text":"1234","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_99_multiple_when_only_code_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"99","vocabulary_uri":null,"text":"123","percentage":null,"narrative":[{"narrative":"required narr 1","language":"ne"}]},{"sector_vocabulary":"99","vocabulary_uri":null,"text":"1234","percentage":null,"narrative":[{"narrative":"required narr 2","language":"ne"}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_98_multiple_when_only_code_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"98","vocabulary_uri":null,"text":"123","percentage":null,"narrative":[{"narrative":"Narrative required","language":"ne"}]},{"sector_vocabulary":"98","vocabulary_uri":null,"text":"1234","percentage":null,"narrative":[{"narrative":"Narrative required","language":"ne"}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_1_multiple_when_only_percentage_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"1","code":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]}, {"sector_vocabulary":"1","code":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_2_multiple_when_only_percentage_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"2","category_code":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"2","category_code":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_3_multiple_when_only_percentage_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"3","text":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"3","text":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_4_multiple_when_only_percentage_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"4","text":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"4","text":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_5_multiple_when_only_percentage_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"5","text":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"5","text":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_6_multiple_when_only_percentage_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"6","text":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"6","text":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_7_multiple_when_only_percentage_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"7","sdg_goal":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"7","sdg_goal":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_8_multiple_when_only_percentage_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"8","sdg_target":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"8","sdg_target":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_9_multiple_when_only_percentage_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"9","text":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"9","text":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_10_multiple_when_only_percentage_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"10","text":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"10","text":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_11_multiple_when_only_percentage_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"11","text":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"11","text":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_12_multiple_when_only_percentage_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"12","text":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"12","text":null,"percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_99_multiple_when_only_percentage_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"99","vocabulary_uri":null,"text":null,"percentage":"50","narrative":[{"narrative":"Narrative required","language":"ne"}]},{"sector_vocabulary":"99","vocabulary_uri":null,"text":null,"percentage":"50","narrative":[{"narrative":"Narrative required","language":"ne"}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_sector_vocab_98_multiple_when_only_percentage_is_filled()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"98","vocabulary_uri":null,"text":null,"percentage":"50","narrative":[{"narrative":"Narrative required","language":"ne"}]},{"sector_vocabulary":"98","vocabulary_uri":null,"text":null,"percentage":"50","narrative":[{"narrative":"Narrative required","language":"ne"}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_1()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"1","code":"11110","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_2()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"2","category_code":"111","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_3()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"3","text":"123","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_4()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"4","text":"123","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_5()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"5","text":"123","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_6()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"6","text":"123","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_7()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"7","sdg_goal":"1","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_8()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"8","sdg_target":"1.1","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_9()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"9","text":"123","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_10()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"10","text":"123","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_11()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"11","text":"123","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_12()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"12","text":"123","percentage":null,"narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_99()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"99","vocabulary_uri":null,"text":"123","percentage":null,"narrative":[{"narrative":"Narrative required","language":"ne"}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_98()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"98","vocabulary_uri":null,"text":"123","percentage":null,"narrative":[{"narrative":"Narrative required","language":"ne"}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_1_multiple()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"1","code":"11110","percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"1","code":"11120","percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_2_multiple()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"2","category_code":"111","percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"2","category_code":"112","percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_3_multiple()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"3","text":"123","percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"3","text":"1234","percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_4_multiple()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"4","text":"123","percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"4","text":"1234","percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_5_multiple()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"5","text":"123","percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"5","text":"1234","percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_6_multiple()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"6","text":"123","percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"6","text":"1234","percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_7_multiple()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"7","sdg_goal":"1","percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"7","sdg_goal":"2","percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_8_multiple()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"8","sdg_target":"1.1","percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"8","sdg_target":"1.2","percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_9_multiple()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"9","text":"123","percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"9","text":"1234","percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_10_multiple()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"10","text":"123","percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"10","text":"1234","percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_11_multiple()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"11","text":"123","percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"11","text":"1234","percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_12_multiple()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"12","text":"123","percentage":"50","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"12","text":"1234","percentage":"50","narrative":[{"narrative":null,"language":null}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_99_multiple()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"99","vocabulary_uri":null,"text":"123","percentage":"50","narrative":[{"narrative":"required narr 1","language":"ne"}]},{"sector_vocabulary":"99","vocabulary_uri":null,"text":"1234","percentage":"50","narrative":[{"narrative":"required narr 2","language":"ne"}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_sector_vocab_98_multiple()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"98","vocabulary_uri":null,"text":"123","percentage":"50","narrative":[{"narrative":"Narrative required","language":"ne"}]},{"sector_vocabulary":"98","vocabulary_uri":null,"text":"1234","percentage":"50","narrative":[{"narrative":"Narrative required","language":"ne"}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_incomplete_for_mix_all()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"1","code":null,"percentage":"50","narrative":[{"narrative":"required narr 1","language":"ne"}]},{"sector_vocabulary":"2","category_code":null,"percentage":"50","narrative":[{"narrative":"required narr 2","language":"ne"}]},{"sector_vocabulary":"3","text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"4","text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"5","text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"6","text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"7","sdg_goal":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"8","sdg_target":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"9","text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"10","text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"11","text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"12","text":null,"percentage":null,"narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"99","vocabulary_uri":null,"text":null,"percentage":null,"narrative":[{"narrative":"required narr","language":"ne"}]},{"sector_vocabulary":"98","vocabulary_uri":null,"text":null,"percentage":null,"narrative":[{"narrative":"required narr","language":"ne"}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertFalse($this->elementCompleteService->isSectorElementCompleted($activity));
    }

    public function test_sector_is_complete_for_mix_all()
    {
        $actualData = json_decode(
            '[{"sector_vocabulary":"1","code":"11110","percentage":"7.14","narrative":[{"narrative":"required narr 1","language":"ne"}]},{"sector_vocabulary":"2","category_code":"112","percentage":"7.14","narrative":[{"narrative":"required narr 2","language":"ne"}]},{"sector_vocabulary":"3","text":"123","percentage":"7.14","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"4","text":"1234","percentage":"7.14","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"5","text":"12345","percentage":"7.14","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"6","text":"123456","percentage":"7.14","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"7","sdg_goal":"1","percentage":"7.14","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"8","sdg_target":"1.3","percentage":"7.14","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"9","text":"6789","percentage":"7.14","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"10","text":"78910","percentage":"7.14","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"11","text":"891011","percentage":"7.14","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"12","text":"9101112","percentage":"7.14","narrative":[{"narrative":null,"language":null}]},{"sector_vocabulary":"99","vocabulary_uri":null,"text":"99code","percentage":"7.14","narrative":[{"narrative":"required narr","language":"ne"}]},{"sector_vocabulary":"98","vocabulary_uri":null,"text":"98code","percentage":"7.14","narrative":[{"narrative":"required narr","language":"ne"}]}]',
            true
        );
        $activity = new Activity();
        $activity->{$this->element} = $actualData;

        $this->assertTrue($this->elementCompleteService->isSectorElementCompleted($activity));
    }
}
