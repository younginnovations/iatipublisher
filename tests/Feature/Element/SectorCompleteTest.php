<?php

namespace Tests\Feature\Element;

/**
 * Class SectorCompleteTest.
 */
class SectorCompleteTest extends ElementCompleteTest
{
    private string $element = 'sector';

    /**
     * Construct function.
     *
     * @param string|null $name
     * @param array       $data
     * @param string      $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    /**
     * Mandatory attribute test.
     *
     * @return void
     */
    public function test_sector_type_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, ['code', 'text', 'category_code', 'sdg_goal', 'sdg_target']);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     */
    public function test_sector_type_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, ['narrative' => ['language']]);
    }

    /**
     * Sector element complete test.
     *
     * @return void
     */
    public function test_sector_type_element_complete(): void
    {
        $sector_typeData = json_decode(
            '[{"sector_vocabulary":"1","code":"11110","percentage":"100","narrative":[{"narrative":"sector-1-narrative1","language":"aa"}]},{"sector_vocabulary":"2","category_code":"111","percentage":"100","narrative":[{"narrative":"sector-2-narrative1","language":"ab"}]},{"sector_vocabulary":"3","text":"vocab-3","percentage":"100","narrative":[{"narrative":"sector-3-narrative1","language":"am"}]},{"sector_vocabulary":"4","text":"vocab-4","percentage":"100","narrative":[{"narrative":"sector-4-narrative1","language":"ba"}]},{"sector_vocabulary":"5","text":"vocab-5","percentage":"100","narrative":[{"narrative":"sector-5-narrative1","language":"bn"}]},{"sector_vocabulary":"6","text":"vocab-6","percentage":"100","narrative":[{"narrative":null,"language":"en"}]},{"sector_vocabulary":"7","sdg_goal":"1","percentage":"100","narrative":[{"narrative":null,"language":"fr"}]},{"sector_vocabulary":"8","sdg_target":"1.1","percentage":"100","narrative":[{"narrative":null,"language":"gr"}]},{"sector_vocabulary":"9","text":"vocab-9","percentage":"100","narrative":[{"narrative":null,"language":"sp"}]},{"sector_vocabulary":"10","text":"vocab-10","percentage":"100","narrative":[{"narrative":null,"language":"hr"}]},{"sector_vocabulary":"99","vocabulary_uri":"https:\/\/www.google.com","text":"vocab-99","percentage":"100","narrative":[{"narrative":null,"language":"aa"}]}]',
            true
        );

        $this->test_level_one_multi_dimensional_element_complete($this->element, $sector_typeData);
    }
}
