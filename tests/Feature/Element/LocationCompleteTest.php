<?php

namespace Tests\Feature\Element;

class LocationCompleteTest extends ElementCompleteTest
{
    private string $element = 'location';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_location_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, []);
    }

    public function test_location_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, ['location_id'=>['vocabulary', 'code'], 'point'=>['srs_name'], 'location_class'=>['code'], 'feature_designation'=>['code']]);
    }

    public function test_location_empty_data()
    {
        $actualData = '';

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_empty_array()
    {
        $actualData = json_decode('[]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_empty_json_array()
    {
        $actualData = json_decode('[{}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_empty_location_id()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":"","name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_empty_location_id_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_empty_location_id_json_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_location_id_empty_attribute_vocabulary()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_location_id_no_attribute_vocabulary_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_location_id_empty_attribute_code()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"","code":""}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_location_id_no_attribute_code_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":""}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_no_name_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_name_empty()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":"","description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_name_empty_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_name_empty_json_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_name_empty_narrative()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_name_empty_narrative_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_name_empty_narrative_json_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_name_sub_element_narrative_empty_narrative()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"","language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_name_sub_element_narrative_no_narrative_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"language":"aa"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_name_sub_element_narrative_empty_attribute_language()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":""}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_name_sub_element_narrative_no_attribute_language_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_no_description_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_description_empty()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":"","description":"","activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_description_empty_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[],"description":[],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_description_empty_json_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{}],"description":[{}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_description_empty_narrative()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":""}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_description_empty_narrative_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_description_empty_narrative_json_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_description_sub_element_narrative_empty_narrative()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"narrative":"","language":"en"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_description_sub_element_narrative_no_narrative_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"language":"en"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_description_sub_element_narrative_empty_attribute_language()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"narrative":"asd","language":""}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_description_sub_element_narrative_no_attribute_language_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_no_activity_description_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_activity_description_empty()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":"","administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_activity_description_empty_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_sub_element_activity_description_empty_json_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_activity_description_empty_narrative()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{"narrative":""}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_activity_description_empty_narrative_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{"narrative":[]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_activity_description_empty_narrative_json_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{"narrative":[{}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_activity_description_sub_element_narrative_empty_narrative()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{"narrative":[{"narrative":"","language":"en"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_activity_description_sub_element_narrative_no_narrative_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{"narrative":[{"language":"en"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_activity_description_sub_element_narrative_empty_attribute_language()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{"narrative":[{"narrative":"asd","language":""}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_activity_description_sub_element_narrative_no_attribute_language_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":""}],"description":[{"narrative":[{"narrative":"asd","language":"en"}]}],"activity_description":[{"narrative":[{"narrative":"asd"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_no_point_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_point_empty()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":"","exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_point_empty_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_point_empty_json_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_point_no_attribute_srs_name_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_point_empty_attribute_srs_name()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_point_sub_element_no_pos_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_point_sub_element_pos_empty()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":"","exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_point_sub_element_pos_empty_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_point_sub_element_pos_empty_json_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_point_sub_element_pos_attribute_no_latitude_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"longitude":"27"}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_point_sub_element_pos_attribute_empty_latitude()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"","longitude":"27"}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_location_class_empty()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":"","feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_no_location_class_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_location_class_empty_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_location_class_empty_json_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_location_class_attribute_code_empty()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":""}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_feature_designation_empty()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http://www.opengis.net/def/crs/EPSG/0/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":""}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_no_feature_designation_key()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http://www.opengis.net/def/crs/EPSG/0/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_feature_designation_empty_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http://www.opengis.net/def/crs/EPSG/0/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_feature_designation_empty_json_array()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http://www.opengis.net/def/crs/EPSG/0/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_feature_designation_attribute_code_empty()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http://www.opengis.net/def/crs/EPSG/0/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":""}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_location_element_complete()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http://www.opengis.net/def/crs/EPSG/0/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_complete($this->element, $actualData);
    }
}
