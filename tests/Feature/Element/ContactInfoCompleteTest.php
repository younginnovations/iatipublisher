<?php

namespace Tests\Feature\Element;

class ContactInfoCompleteTest extends ElementCompleteTest
{
    private string $element = 'contact_info';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_contact_info_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, []);
    }

    public function test_contact_info_empty_data()
    {
        $actualData = '';

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_empty_array()
    {
        $actualData = json_decode('[]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_empty_json_array()
    {
        $actualData = json_decode('[{}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_empty_person_name()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":"","job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_empty_person_name_array()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_empty_person_name_json_array()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_person_name_empty_narrative()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":""}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_person_name_empty_narrative_array()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_person_name_empty_narrative_json_array()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_person_name_sub_element_narrative_empty_narrative()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_person_name_sub_element_narrative_no_narrative_key()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"language":"en"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_person_name_sub_element_narrative_empty_attribute_language()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":""}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_person_name_sub_element_narrative_no_attribute_language_key()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asdsad"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_empty_job_title()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":"","telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_empty_job_title_array()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_empty_job_title_json_array()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_job_title_empty_narrative()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":""}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_job_title_empty_narrative_array()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_job_title_empty_narrative_json_array()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_job_title_sub_element_narrative_empty_narrative()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_job_title_sub_element_narrative_no_narrative_key()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[{"language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_job_title_sub_element_narrative_empty_attribute_language()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":""}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_job_title_sub_element_narrative_no_attribute_language_key()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_empty_mailing_address()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"contact-info1-person-name-narrative1","language":"ae"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":""}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_empty_mailing_address_array()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_empty_mailing_address_json_array()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_mailing_address_empty_narrative()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":""}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":""}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_mailing_address_empty_narrative_array()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_mailing_address_empty_narrative_json_array()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_mailing_address_sub_element_narrative_empty_narrative()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_mailing_address_sub_element_narrative_no_narrative_key()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[{"language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_mailing_address_sub_element_narrative_empty_attribute_language()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":""}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":""}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_sub_element_mailing_address_sub_element_narrative_no_attribute_language_key()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    public function test_contact_info_element_complete()
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"contact-info1-person-name-narrative1","language":"ae"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true);

        $this->test_level_two_multi_dimensional_element_complete($this->element, $actualData);
    }
}
