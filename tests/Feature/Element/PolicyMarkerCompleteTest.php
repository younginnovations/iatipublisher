<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

/**
 * Class PolicyMarkerCompleteTest.
 */
class PolicyMarkerCompleteTest extends ElementCompleteTest
{
    /**
     * Element policy_marker.
     *
     * @var string
     */
    private string $element = 'policy_marker';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_type_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, ['policy_marker', 'policy_marker_text']);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    /**
     * Polic Marker element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_policy_marker_element_complete(): void
    {
        $sector_typeData = json_decode(
            '[{"policy_marker_vocabulary":"1","significance":"1","policy_marker":"1","narrative":[{"narrative":"policy-marker-1-narrative1","language":"aa"}]},{"policy_marker_vocabulary":"99","vocabulary_uri":"https:\/\/google.com","significance":"2","policy_marker_text":"vocab-99","narrative":[{"narrative":"policy-marker-99-narrative1","language":"ak"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_complete($this->element, $sector_typeData);
    }
}
