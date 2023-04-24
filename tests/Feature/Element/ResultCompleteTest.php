<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

/**
 * Class RelatedActivityCompleteTest.
 */
class ResultCompleteTest extends ElementCompleteTest
{
    /**
     * Element result.
     *
     * @var string
     */
    private string $element = 'result';

    /**
     * Mandatory period attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_period_mandatory_attributes(): void
    {
        $this->element = 'period';
        $this->test_mandatory_attributes($this->element, []);
    }

    /**
     * Mandatory period sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_period_mandatory_sub_elements(): void
    {
        $this->element = 'period';
        $this->test_mandatory_sub_elements($this->element, [
            'period_start' => ['date'],
            'period_end'   => ['date'],
        ]);
    }

    /**
     * Period element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_period_element_complete(): void
    {
        $actualData = json_decode(
            '[{"period_start":[{"date":"2022-08-02"}],"period_end":[{"date":"2022-08-20"}],"target":[{"value":"123456756","comment":[{"narrative":[{"narrative":"dgfthygju","language":"ab"}]}],"dimension":[{"name":null,"value":null}],"document_link":[{"url":"https://www.coo.com","format":"asd","title":[{"narrative":[{"narrative":"fghm","language":"ae"}]}],"description":[{"narrative":[{"narrative":"asd","language":"ab"}]}],"category":[{"code":123}],"language":[{"language":"aa"}],"document_date":[{"date":"2022-02-22"}]}],"location":[{"reference":null}]}],"actual":[{"value":"123456","comment":[{"narrative":[{"narrative":"bj","language":"aa"}]}],"dimension":[{"name":"cfgvhnb","value":"23456"}],"document_link":[{"url":"https:\/\/stage.iatipublisher.yipl.com.np\/activities\/10\/result\/2\/indicator\/create","format":"application\/1d-interleaved-parityfec","title":[{"narrative":[{"narrative":"jj","language":"ab"}]}],"description":[{"narrative":[{"narrative":"bbh","language":"aa"}]}],"category":[{"code":"A02"}],"language":[{"language":"ab"}],"document_date":[{"date":"2022-08-03"}]}],"location":[{"reference":null}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $this->element = 'period';
        $this->test_result_data_complete($this->element, $actualData);
    }

    /**
     * Mandatory indicator attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_indicator_mandatory_attributes(): void
    {
        $this->element = 'indicator';
        $this->test_mandatory_attributes($this->element, ['measure']);
    }

    /**
     * Mandatory indicator sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_indicator_mandatory_sub_elements(): void
    {
        $this->element = 'indicator';
        $this->test_mandatory_sub_elements($this->element, [
            'document_link' => ['url', 'format'],
            'reference'     => ['vocabulary'],
            'baseline'      => ['year'],
        ]);
    }

    /**
     * Indicator element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_indicator_element_complete(): void
    {
        $this->element = 'indicator';
        $actualData = json_decode(
            '[{"measure":"2","ascending":null,"aggregation_status":null,"title":[{"narrative":[{"narrative":"12345","language":"af"}]}],"description":[{"narrative":[{"narrative":"q23456","language":"ab"}]}],"document_link":[{"url":"https:\/\/minio-stage.yipl.com.np:9000\/iati\/document_link\/11\/chapter_1adbms.pdf","format":"application\/3gpp-ims+xml","title":[{"narrative":[{"narrative":"sdgfhyj","language":"ae"}]}],"description":[{"narrative":[{"narrative":"fghjk","language":"aa"}]}],"category":[{"code":"A07"}],"language":[{"language":"ab"}],"document_date":[{"date":"2022-08-11"}]}],"reference":[{"vocabulary":"3","code":"dgfhyjk"}],"baseline":[{"year":"1233","date":"2022-08-04","value":null,"comment":[{"narrative":[{"narrative":"dfghj","language":"ab"}]}],"dimension":[{"name":"dfgh","value":null}],"document_link":[{"url":"https:\/\/stage.iatipublisher.yipl.com.np\/activities\/10\/result\/2\/indicator\/create","format":"application\/1d-interleaved-parityfec","title":[{"narrative":[{"narrative":"vnv","language":"ae"}]}],"description":[{"narrative":[{"narrative":"xfcg","language":"af"}]}],"category":[{"code":"A02"}],"language":[{"language":"ae"}],"document_date":[{"date":"2022-08-04"}]},{"url":"https://wwww.google.com","format":"application\/1d-interleaved-parityfec","title":[{"narrative":[{"narrative":"asd","language":"ae"}]}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"category":[{"code":123}],"language":[{"language":"123"}],"document_date":[{"date":"2022-02-22"}]}],"location":[{"reference":null}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $this->test_result_data_complete($this->element, $actualData);
    }

    /**
     * Mandatory result attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_result_mandatory_attributes(): void
    {
        $this->element = 'result';
        $this->test_mandatory_attributes($this->element, ['type']);
    }

    /**
     * Mandatory result sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_result_mandatory_sub_elements(): void
    {
        $this->element = 'result';
        $this->test_mandatory_sub_elements($this->element, [
            'document_link' => ['url', 'format'],
            'reference'     => ['vocabulary', 'code'],
        ]);
    }

    /**
     * Result element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_result_element_complete(): void
    {
        $this->element = 'result';
        $actualData = json_decode(
            '[{"type":"2","aggregation_status":"1","title":[{"narrative":[{"narrative":"wesdrtfyh","language":"aa"}]}],"description":[{"narrative":[{"narrative":"rdfthgyj","language":"aa"}]}],"document_link":[{"url":"https:\/\/minio-stage.yipl.com.np:9000\/iati\/document_link\/11\/chapter_1adbms.pdf","format":"application\/3gpp-ims+xml","title":[{"narrative":[{"narrative":"dgfhj","language":"ab"}]}],"description":[{"narrative":[{"narrative":"fghj","language":"ab"}]}],"category":[{"code":"A03"}],"language":[{"language":"ae"}],"document_date":[{"date":"2022-08-05"}]}],"reference":[{"vocabulary":"99","code":"gffg","vocabulary_uri":null}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_result_data_complete($this->element, $actualData);
    }
}
