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

    public function test_location_element_complete()
    {
        $actualData = json_decode('[{"ref":"ref 1","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"vocab code"},{"vocabulary":"G1","code":"vocab code 2"}],"name":[{"narrative":[{"narrative":"name 1","language":"aa"},{"narrative":"name 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"aa"},{"narrative":"description 2","language":"ae"}]}],"activity_description":[{"narrative":[{"narrative":"activity description 1","language":"ab"},{"narrative":"activity description 2","language":"af"}]}],"administrative":[{"vocabulary":"A2","code":"DZ","level":"1236"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"56","longitude":"27"}]}],"exactness":[{"code":"1"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"CMPQ"}]},{"ref":"ref 2","location_reach":[{"code":"1"}],"location_id":[{"vocabulary":"A2","code":"768546"},{"vocabulary":"A4","code":"code 3"}],"name":[{"narrative":[{"narrative":"name 21","language":"ae"},{"narrative":"name 22","language":"ak"}]}],"description":[{"narrative":[{"narrative":"description 21","language":"af"}]}],"activity_description":[{"narrative":[{"narrative":"description activiy 1","language":"ae"},{"narrative":"description activity 2","language":"am"}]}],"administrative":[{"vocabulary":"G1","code":"AX","level":"123"}],"point":[{"srs_name":"http:\/\/www.opengis.net\/def\/crs\/EPSG\/0\/4326","pos":[{"latitude":"27","longitude":"29"}]}],"exactness":[{"code":"2"}],"location_class":[{"code":"2"}],"feature_designation":[{"code":"MFGQ"}]}]', true);

        $this->test_level_two_multi_dimensional_element_complete($this->element, $actualData);
    }
}
