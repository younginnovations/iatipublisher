<?php

namespace Tests\Feature;

use Tests\Feature\Element\ElementCompleteTest;

class CoreElementTest extends ElementCompleteTest
{
    /**
     * Tests core element.
     *
     * @return void
     */
    public function test_core_elements(): void
    {
        $actualCoreElements = [
            'title'                => true,
            'description'          => true,
            'budget'               => true,
            'transactions'         => true,
            'sector'               => true,
            'participating_org'    => true,
            'activity_status'      => true,
            'activity_date'        => true,
            'recipient_country'    => true,
            'recipient_region'     => true,
            'collaboration_type'   => true,
            'default_flow_type'    => true,
            'default_finance_type' => true,
            'default_aid_type'     => true,
        ];

        $this->assertTrue($this->arrayStructure($actualCoreElements, getCoreElements()));
    }

    /**
     * Test core element is not completed.
     *
     * @return void
     */
    public function test_core_element_not_completed(): void
    {
        $actualElements = [
            'title'                => true,
            'description'          => true,
            'budget'               => true,
            'transactions'         => true,
            'sector'               => true,
            'participating_org'    => true,
            'activity_status'      => true,
            'activity_date'        => true,
            'recipient_country'    => true,
            'recipient_region'     => true,
            'collaboration_type'   => true,
            'default_flow_type'    => true,
            'default_finance_type' => true,
            'default_aid_type'     => false,
        ];

        $this->assertFalse(coreElementCompleted($actualElements));
    }

    /**
     * Test core element is completed.
     *
     * @return void
     */
    public function test_core_element_completed(): void
    {
        $actualElements = [
            'title'                => true,
            'description'          => true,
            'budget'               => true,
            'transactions'         => true,
            'sector'               => true,
            'participating_org'    => true,
            'activity_status'      => true,
            'activity_date'        => true,
            'recipient_country'    => true,
            'recipient_region'     => true,
            'collaboration_type'   => true,
            'default_flow_type'    => true,
            'default_finance_type' => true,
            'default_aid_type'     => true,
        ];

        $this->assertTrue(coreElementCompleted($actualElements));
    }
}
