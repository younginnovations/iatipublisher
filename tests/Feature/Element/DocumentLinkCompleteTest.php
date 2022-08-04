<?php

namespace Tests\Feature\Element;

/**
 * Class DescriptionCompleteTest.
 */
class DocumentLinkCompleteTest extends ElementCompleteTest
{
    private string $element = 'document_link';

    /**
     * Document Link element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_document_link_element_complete(): void
    {
        $actualData = json_decode(
            '[{"url":"https://wwww.google.com","format":"image\/png","title":[{"narrative":[{"narrative":"document-link-narrative1","language":"en"}]}],"description":[{"narrative":[{"narrative":"document-link-descp1","language":"ae"}]}],"category":[{"code":"A01"}],"language":[{"code":"ae"}],"document_date":[{"date":"2022-07-27"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_complete($this->element, $actualData);
    }
}
