<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Constants\CoreElements;
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
     * @throws \JsonException
     */
    public function test_core_elements(): void
    {
        $actualCoreElements = CoreElements::all();
        $currentCoreElements = [
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
            'default_tied_status',
            'default_flow_type',
            'default_finance_type',
            'default_aid_type',
            'budget',
            'transactions',
        ];

        $this->assertTrue($this->arrayStructure($currentCoreElements, $actualCoreElements));
    }

    /**
     * @throws \JsonException
     */
    public function testCompleteStatusForAllCoreElementInIteration(): void
    {
        $allElements = CoreElements::getCoreElementsWithTrueValue();

        foreach ($allElements as $element => $completenessStatus) {
            $allElements[$element] = false;
            $this->testCoreCompletionIsIncomplete($allElements, $element);
            $allElements[$element] = true;
        }

        $allElements = CoreElements::getCoreElementsWithTrueValue();

        foreach ($allElements as $element => $completenessStatus) {
            $this->testCoreCompletionIsComplete($allElements, $element);
        }
    }

    public function testCoreCompletionIsIncomplete($elementStatusArray = [], $element = ''): void
    {
        if (count($elementStatusArray) > 0 && $element) {
            $this->assertFalse(isCoreElementCompleted($elementStatusArray), "Failed assertion for $element when marked as incomplete.");
        } else {
            /* True assertion when this method is called by the test class, and not testCompleteStatusForAllCoreElementInIteration() **/
            $this->assertTrue(true);
        }
    }

    public function testCoreCompletionIsComplete($elementStatusArray = [], $element = ''): void
    {
        if (count($elementStatusArray) > 0 && $element) {
            $this->assertTrue(isCoreElementCompleted($elementStatusArray), "Failed assertion for $element when marked as complete.");
        } else {
            /* True assertion when this method is called by the test class, and not testCompleteStatusForAllCoreElementInIteration() **/
            $this->assertTrue(true);
        }
    }
}
