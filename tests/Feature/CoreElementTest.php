<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\Feature\Element\ElementCompleteTest;

/**
 * Class TransactionObserver.
 */
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
            'reporting_org',
            'iati_identifier',
            'title',
            'description',
            'participating_org',
            'activity_status',
            'activity_date',
            'recipient_country',
            'recipient_region',
            'sector',
            'collaboration_type',
            'default_flow_type',
            'default_finance_type',
            'default_aid_type',
            'budget',
            'transactions',
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
            'reporting_org'        => true,
            'iati_identifier'      => true,
            'title'                => true,
            'description'          => true,
            'participating_org'    => true,
            'activity_status'      => true,
            'activity_date'        => true,
            'recipient_country'    => true,
            'recipient_region'     => true,
            'sector'               => true,
            'collaboration_type'   => true,
            'default_flow_type'    => true,
            'default_finance_type' => true,
            'default_aid_type'     => true,
            'budget'               => true,
            'transactions'         => false,
        ];

        $this->assertFalse(isCoreElementCompleted($actualElements));
    }

    /**
     * Test core element is completed.
     *
     * @return void
     */
    public function test_core_element_completed(): void
    {
        $actualElements = [
            'reporting_org'        => true,
            'iati_identifier'      => true,
            'title'                => true,
            'description'          => true,
            'participating_org'    => true,
            'activity_status'      => true,
            'activity_date'        => true,
            'recipient_country'    => true,
            'recipient_region'     => true,
            'sector'               => true,
            'collaboration_type'   => true,
            'default_flow_type'    => true,
            'default_finance_type' => true,
            'default_aid_type'     => true,
            'budget'               => true,
            'transactions'         => true,
        ];

        $this->assertTrue(isCoreElementCompleted($actualElements));
    }
}
