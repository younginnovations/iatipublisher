<?php

namespace Tests\Feature\Element;

/**
 * Class LocationCompleteTest.
 */
class LocationCompleteTest extends ElementCompleteTest
{
    private string $element = 'location';

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
     * @throws \JsonException
     */
    public function test_location_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, []);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, ['location_id' => ['vocabulary', 'code'], 'point' => ['srs_name'], 'location_class' => ['code'], 'feature_designation' => ['code']]);
    }

    /**
     * Empty data test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_empty_data(): void
    {
        $actualData = '';

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_empty_array(): void
    {
        $actualData = json_decode('[]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_empty_json_array(): void
    {
        $actualData = json_decode('[{}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element location_id empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_empty_location_id(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":"","name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element location_id empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_empty_location_id_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element location_id empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_empty_location_id_json_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element location_id attribute vocabulary empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_location_id_empty_attribute_vocabulary(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element location_id attribute vocabulary no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_location_id_no_attribute_vocabulary_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element location_id attribute code empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_location_id_empty_attribute_code(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":""}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element location_id attribute code no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_location_id_no_attribute_code_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element name no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_no_name_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element name empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_name_empty(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":"","description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element name empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_name_empty_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element name empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_name_empty_json_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element name empty narrative test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_name_empty_narrative(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element name empty narrative array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_name_empty_narrative_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element name empty narrative json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_name_empty_narrative_json_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element name sub element narrative empty narrative test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_name_sub_element_narrative_empty_narrative(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element name sub element narrative no narrative key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_name_sub_element_narrative_no_narrative_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element name sub element narrative empty language test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_name_sub_element_narrative_empty_attribute_language(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":""}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element name sub element narrative no language key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_name_sub_element_narrative_no_attribute_language_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element description no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_no_description_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element description empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_description_empty(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":"","activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element description empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_description_empty_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element description empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_description_empty_json_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element description sub element narrative empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_description_empty_narrative(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":""}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element description sub element narrative empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_description_empty_narrative_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element description sub element narrative empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_description_empty_narrative_json_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[{}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element description sub element narrative empty narrative test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_description_sub_element_narrative_empty_narrative(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[{"narrative":"","language":"en"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element description sub element narrative no narrative key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_description_sub_element_narrative_no_narrative_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[{"language":"en"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element description sub element narrative empty language test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_description_sub_element_narrative_empty_attribute_language(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[{"narrative":"asd","language":""}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element description sub element narrative no language key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_description_sub_element_narrative_no_attribute_language_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element description no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_no_activity_description_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element activity_description empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_activity_description_empty(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":"","administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element activity_description empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_activity_description_empty_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element activity_description empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_activity_description_empty_json_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element activity_description sub element narrative empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_activity_description_empty_narrative(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{"narrative":""}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element activity_description sub element narrative empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_activity_description_empty_narrative_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{"narrative":[]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element activity_description sub element narrative empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_activity_description_empty_narrative_json_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{"narrative":[{}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element activity_description sub element narrative empty narrative test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_activity_description_sub_element_narrative_empty_narrative(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{"narrative":[{"narrative":"","language":"en"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element activity_description sub element narrative no narrative key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_activity_description_sub_element_narrative_no_narrative_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{"narrative":[{"language":"en"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element activity_description sub element narrative empty language test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_activity_description_sub_element_narrative_empty_attribute_language(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{"narrative":[{"narrative":"asd","language":""}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element activity_description sub element narrative no language key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_activity_description_sub_element_narrative_no_attribute_language_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{"narrative":[{"narrative":"asd"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element point no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_no_point_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element point empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_point_empty(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":"","exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element point empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_point_empty_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element point empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_point_empty_json_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element point attribute srs_name no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_point_no_attribute_srs_name_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element point attribute srs_name empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_point_empty_attribute_srs_name(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element point sub_element pos no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_point_sub_element_no_pos_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element point sub_element pos empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_point_sub_element_pos_empty(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":"","exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element point sub_element pos empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_point_sub_element_pos_empty_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element point sub_element pos empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_point_sub_element_pos_empty_json_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element point sub_element pos no latitude test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_point_sub_element_pos_attribute_no_latitude_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"longitude":"27"}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element point sub_element pos empty latitude test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_point_sub_element_pos_attribute_empty_latitude(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"","longitude":"27"}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element location_class empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_location_class_empty(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":"","feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element location_class no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_no_location_class_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element location_class empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_location_class_empty_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element location_class empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_location_class_empty_json_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element location_class attribute code empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_location_class_attribute_code_empty(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":""}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element location_class attribute code empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_feature_designation_empty(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http://www.opengis.net/def/crs/EPSG/0/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":""}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element feature_designation no key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_no_feature_designation_key(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http://www.opengis.net/def/crs/EPSG/0/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element feature_designation empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_feature_designation_empty_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http://www.opengis.net/def/crs/EPSG/0/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element feature_designation empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_feature_designation_empty_json_array(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http://www.opengis.net/def/crs/EPSG/0/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element feature_designation attirbute code empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_sub_element_feature_designation_attribute_code_empty(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http://www.opengis.net/def/crs/EPSG/0/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":""}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Location element compelete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_location_element_complete(): void
    {
        $actualData = json_decode(
            '[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http://www.opengis.net/def/crs/EPSG/0/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_complete($this->element, $actualData);
    }
}
