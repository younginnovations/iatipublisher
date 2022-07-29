<?php

namespace Tests\Feature\Element;

/**
 * Class RelatedActivityCompleteTest.
 */
class ResultCompleteTest extends ElementCompleteTest
{
    private string $element = 'result';

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
     * Mandatory period attribute test.
     *
     * @return void
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
     */
    public function test_period_element_complete(): void
    {
        $actualData = json_decode(
            '[{"period_start":[{"date":"asd"}],"period_end":[{"date":"asd"}],"target":[{"value":"12","comment":[{"narrative":[{"narrative":"asdasd","language":"ak"}]}], "dimension":[{"name":"asdsad","value":null}],"document_link":[{"url":"www.google.com","format":"asdasd","title":[{"narrative":[{"narrative":"test","language":"fr"}]}],"description":[{"narrative":[{"narrative":"asdasd","language":"en"}]}],"category":[{"code":"AG"}],"language":[{"language":null}],"document_date":[{"date":"2022-08-06"}]}],"location":[{"reference":null}]}],"actual":[{"value":"10","comment":[{"narrative":[{"narrative":"comment actual","language":"bs"}]}],"dimension":[{"name":"asdsad","value":null}],"document_link":[{"url":"www.google.com","format":"asdasd","title":[{"narrative":[{"narrative":"asdasd","language":"en"}]}],"description":[{"narrative":[{"narrative":"asdasda","language":"fr"}]}],"category":[{"code":"AE"}],"language":[{"language":null}],"document_date":[{"date":"2022-08-06"}]}],"location":[{"reference":null}]}]},{"period_start":[{"date":"2022-06-28"}],"period_end":[{"date":"2022-08-06"}],"target":[{"value":"12","comment":[{"narrative":[{"narrative":"comment","language":"ak"}]}],"dimension":[{"name":"asdsad","value":null}],"document_link":[{"url":"www.google.com","format":"asdasd","title":[{"narrative":[{"narrative":"asdasda","language":"ar"}]}],"description":[{"narrative":[{"narrative":"asdasda","language":"gr"}]}],"category":[{"code":"BB"}],"language":[{"language":null}],"document_date":[{"date":"2022-08-06"}]}],"location":[{"reference":null}]}],"actual":[{"value":"10","comment":[{"narrative":[{"narrative":"comment actual","language":"bs"}]}],"dimension":[{"name":"asdasd","value":null}],"document_link":[{"url":"www.google.com","format":"asdasd","title":[{"narrative":[{"narrative":"asdasda","language":"sp"}]}],"description":[{"narrative":[{"narrative":"asdasda","language":"an"}]}],"category":[{"code":"EE"}],"language":[{"language":null}],"document_date":[{"date":"2020"}]}],"location":[{"reference":null}]}]}]',
            true
        );
        $this->element = 'period';
        $this->test_result_data_complete($this->element, $actualData);
    }

    /**
     * Mandatory indicator attribute test.
     *
     * @return void
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
     */
    public function test_indicator_mandatory_sub_elements(): void
    {
        $this->element = 'indicator';
        $this->test_mandatory_sub_elements($this->element, [
            'document_link' => ['url', 'format'],
            'reference'     => ['vocabulary', 'code'],
            'baseline'      => ['year'],
        ]);
    }

    /**
     * Indicator element complete test.
     *
     * @return void
     */
    public function test_indicator_element_complete(): void
    {
        $this->element = 'indicator';
        $actualData = json_decode(
            '[{"measure":"1","ascending":"1","aggregation_status":"1","title":[{"narrative":[{"narrative":"asdasd","language":"ab"},{"narrative":"test title 2","language":"af"}]}],"description":[{"narrative":[{"narrative":"test description 1","language":"ab"},{"narrative":"test description 2","language":"af"}]}],"document_link":[{"url":"/https://minio-stage.yipl.com.np:9000/document_link/1/uahep_prod422.backup","format":"application/3gpp-ims+xml","title":[{"narrative":[{"narrative":"test title 1","language":"ak"},{"narrative":"test title 2","language":"ak"}]}],"description":[{"narrative":[{"narrative":"test description","language":"ab"},{"narrative":"test 2 description","language":"ak"}]}],"category":[{"code":"A03"},{"code":"A04"}],"language":[{"language":"ab"},{"language":"ak"}],"document_date":[{"date":"2022-07-11"}]}],"reference":[{"vocabulary":"2","code":"123","indicator_uri":"http://localhost:8000/activities/1/result/1/indicator/create"},{"vocabulary":"4","code":"456","indicator_uri":"http://localhost:8000/activities/1/result/1/indicator/create"}],"baseline":[{"year":"2020","date":"2020-02-13","value":"12","comment":[{"narrative":[{"narrative":"comment","language":"ae"},{"narrative":"comment 2","language":"am"}]}],"dimension":[{"name":"dimension 1","value":"12"},{"name":"dimension 2","value":"23"}],"document_link":[{"url":"/http://localhost:8000/activities/1/result/1/indicator/create","format":"application/3gpdash-qoe-report+xml","title":[{"narrative":[{"narrative":"test","language":"ab"},{"narrative":"title document link","language":"am"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"ae"},{"narrative":"description 2","language":"am"}]}],"category":[{"code":"A04"},{"code":"A02"}],"language":[{"language":"ab"},{"language":"am"}],"document_date":[{"date":"2022-07-07"}]}],"location":[{"reference":"location 1"}]},{"year":"2022","date":"2022-07-07","value":"123","comment":[{"narrative":[{"narrative":"comment","language":"ae"},{"narrative":"comment 2","language":"am"}]}],"dimension":[{"name":"dimension baseline 2","value":"456"}],"document_link":[{"url":"/http://localhost:8000/activities/1/result/1/indicator/create","format":"application/3gpp-ims+xml","title":[{"narrative":[{"narrative":"narrative 1","language":"af"},{"narrative":"narrative 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"des","language":"ab"}]}],"category":[{"code":"A05"},{"code":"A06"}],"language":[{"language":"ae"},{"language":"am"}],"document_date":[{"date":"2022-07-07"}]},{"url":"/document_link 2","format":"application/3gpp-ims+xml","title":[{"narrative":[{"narrative":"asdf","language":"ab"}]}],"description":[{"narrative":[{"narrative":"narrative","language":"ab"},{"narrative":"narrative","language":"ak"}]}],"category":{"0":{"code":"A05"},"7":{"code":"A04"}},"language":{"0":{"language":"aa"},"6":{"language":"ak"}},"document_date":[{"date":"2022-07-07"}]},{"url":"/document_link 2","format":"application/3gpp-ims+xml","title":[{"narrative":[{"narrative":"asdf","language":"ab"}]}],"description":[{"narrative":[{"narrative":"narrative","language":"ab"},{"narrative":"narrative","language":"ak"}]}],"category":[{"code":"A05"},{"code":"A04"}],"language":[{"language":"aa"},{"language":"ak"}],"document_date":[{"date":"2022-07-07"}]}],"location":[{"reference":"test location"}]}]}]',
            true
        );
        $this->test_result_data_complete($this->element, $actualData);
    }

    /**
     * Mandatory result attribute test.
     *
     * @return void
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
     */
    public function test_result_element_complete(): void
    {
        $this->element = 'result';
        $actualData = json_decode(
            '[{"type":"1","aggregation_status":"1","title":[{"narrative":[{"narrative":"title narrative 1","language":"aa"},{"narrative":"title narrative 2","language":"am"}]}],"description":[{"narrative":[{"narrative":"description narrative 1","language":"aa"},{"narrative":"description narrative 2","language":"am"}]}],"document_link":[{"url":"https:\/\/minio-stage.yipl.com.np:9000\/document_link\/1\/uahep_prod422.backup","format":"application\/1d-interleaved-parityfec","title":[{"narrative":[{"narrative":"title 11","language":"ab"},{"narrative":"title 12","language":"am"}]}],"description":[{"narrative":[{"narrative":"description 11","language":"aa"},{"narrative":"description 12","language":"am"}]}],"category":[{"code":"A01"},{"code":"A06"}],"language":[{"language":"aa"},{"language":"am"}],"document_date":[{"date":"2022-07-07"}]},{"url":"http:\/\/192.168.254.240:9000\/document_link\/2\/Uahep.postman_collection.json","format":"application\/1d-interleaved-parityfec","title":[{"narrative":[{"narrative":"title 21","language":"aa"},{"narrative":"title 22","language":"am"}]}],"description":[{"narrative":[{"narrative":"description 21","language":"aa"},{"narrative":"description 22","language":"am"}]}],"category":[{"code":"A01"},{"code":"A05"}],"language":[{"language":"aa"},{"language":"am"}],"document_date":[{"date":"asdsad"}]}],"reference":[{"vocabulary":"99","code":"123","vocabulary_uri":"http:\/\/json-parser.com\/8e6e1d55\/1"},{"vocabulary":"99","code":"456","vocabulary_uri":"http:\/\/json-parser.com\/8e6e1d55\/2"}]}]',
            true
        );

        $this->test_result_data_complete($this->element, $actualData);
    }
}
