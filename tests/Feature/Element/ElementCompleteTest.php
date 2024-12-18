<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

use App\IATI\Services\ElementCompleteService;
use Illuminate\Support\Arr;
use Tests\TestCase;

/**
 * Class ElementCompleteTest.
 */
class ElementCompleteTest extends TestCase
{
    /**
     * @var ElementCompleteService
     */
    protected ElementCompleteService $elementCompleteService;

    /**
     * @param string|null $name
     * @param array       $data
     * @param string      $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->elementCompleteService = new ElementCompleteService();
    }

    /**
     * Compares arrays.
     *
     * @param $actual
     * @param $expected
     *
     * @return bool
     */
    protected function arrayStructure($actual, $expected): bool
    {
        if (!is_array($expected) || !is_array($actual)) {
            return $actual === $expected;
        }

        foreach ($expected as $key => $value) {
            if (!$this->arrayStructure(Arr::get($actual, $key, []), $value)) {
                return false;
            }
        }
        foreach ($actual as $key => $value) {
            if (!$this->arrayStructure($value, Arr::get($expected, $key, []))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Mandatory attribute test.
     *
     * @param $element
     * @param $actualAttributes
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_mandatory_attributes($element, $actualAttributes): void
    {
        $this->elementCompleteService->element = $element;
        $elementSchema = getElementSchema($element);

        $this->assertTrue($this->arrayStructure($actualAttributes, $this->elementCompleteService->mandatoryAttributes($elementSchema['attributes'])));
    }

    /**
     * Mandatory sub element test.
     *
     * @param $element
     * @param $actualSubElement
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_mandatory_sub_elements($element, $actualSubElement): void
    {
        $this->elementCompleteService->element = $element;
        $elementSchema = getElementSchema($element);

        $this->assertTrue($this->arrayStructure($actualSubElement, $this->elementCompleteService->mandatorySubElements($elementSchema['sub_elements'])));
    }

    /**
     * Empty sub element test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_sub_element_empty($element, $actualData): void
    {
        $this->elementCompleteService->element = $element;
        $elementSchema = getElementSchema($element);

        $this->assertFalse($this->elementCompleteService->isSubElementDataCompleted($this->elementCompleteService->mandatorySubElements($elementSchema['sub_elements']), $actualData));
    }

    /**
     * Sub element complete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_sub_element_complete($element, $actualData): void
    {
        $this->elementCompleteService->element = $element;
        $elementSchema = getElementSchema($element);

        $this->assertTrue($this->elementCompleteService->isSubElementDataCompleted($this->elementCompleteService->mandatorySubElements($elementSchema['sub_elements']), $actualData));
    }

    /**
     * Level one multi dimensional element incomplete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_level_one_multi_dimensional_element_incomplete($element, $actualData): void
    {
        $this->elementCompleteService->element = $element;

        $this->assertFalse($this->elementCompleteService->isLevelOneMultiDimensionElementCompleted($actualData));
    }

    /**
     * Level one multi dimensional element complete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_level_one_multi_dimensional_element_complete($element, $actualData): void
    {
        $this->elementCompleteService->element = $element;

        $this->assertTrue($this->elementCompleteService->isLevelOneMultiDimensionElementCompleted($actualData));
    }

    /**
     * Level two single dimensional element incomplete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_level_two_single_dimensional_element_incomplete($element, $actualData): void
    {
        $this->elementCompleteService->element = $element;

        $this->assertFalse($this->elementCompleteService->isLevelTwoSingleDimensionElementCompleted($actualData));
    }

    /**
     * Level two single dimensional element complete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_level_two_single_dimensional_element_complete($element, $actualData): void
    {
        $this->elementCompleteService->element = $element;

        $this->assertTrue($this->elementCompleteService->isLevelTwoSingleDimensionElementCompleted($actualData));
    }

    /**
     * Level two multi dimensional element incomplete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_level_two_multi_dimensional_element_incomplete($element, $actualData): void
    {
        $this->elementCompleteService->element = $element;

        $this->assertFalse($this->elementCompleteService->isLevelTwoMultiDimensionElementCompleted($actualData));
    }

    /**
     * Level two multi dimensional element complete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_level_two_multi_dimensional_element_complete($element, $actualData): void
    {
        $this->elementCompleteService->element = $element;

        $this->assertTrue($this->elementCompleteService->isLevelTwoMultiDimensionElementCompleted($actualData));
    }

    /**
     * Level three single dimensional element incomplete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_level_three_single_dimensional_element_incomplete($element, $actualData): void
    {
        $this->elementCompleteService->element = $element;

        $this->assertFalse($this->elementCompleteService->isLevelThreeSingleDimensionElementCompleted($actualData));
    }

    /**
     * Level three single dimensional element complete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_level_three_single_dimensional_element_complete($element, $actualData): void
    {
        $this->elementCompleteService->element = $element;

        $this->assertTrue($this->elementCompleteService->isLevelThreeSingleDimensionElementCompleted($actualData));
    }

    /**
     * Transaction element complete test.
     *
     * @param $subElements
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_transaction_data_complete($subElements, $actualData): void
    {
        $this->elementCompleteService->element = 'transactions';

        $this->assertTrue($this->elementCompleteService->checkTransactionData($subElements, $actualData));
    }

    /**
     * Result element complete test.
     *
     * @param $element
     * @param $actualData
     *
     * @return void
     * @throws \JsonException
     */
    protected function test_result_data_complete($element, $actualData): void
    {
        $this->elementCompleteService->element = $element;

        if ($element === 'result') {
            $this->assertTrue($this->elementCompleteService->isResultElementDataCompleted($actualData));
        } elseif ($element === 'indicator') {
            $this->assertTrue($this->elementCompleteService->isIndicatorElementCompleted($actualData));
        } elseif ($element === 'period') {
            $this->assertTrue($this->elementCompleteService->isPeriodElementCompleted($actualData));
        }
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->elementCompleteService);
    }
}
