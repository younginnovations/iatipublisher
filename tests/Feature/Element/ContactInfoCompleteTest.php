<?php

declare(strict_types=1);

namespace Tests\Feature\Element;

/**
 * Class ContactInfoCompleteTest.
 */
class ContactInfoCompleteTest extends ElementCompleteTest
{
    /**
     * Element contact_info.
     *
     * @var string
     */
    private string $element = 'contact_info';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, []);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_condition_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    /**
     * Empty contact_info data test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_empty_data(): void
    {
        $actualData = '';

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Empty contact_info array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_empty_array(): void
    {
        $actualData = json_decode('[]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Empty contact_info json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_empty_json_array(): void
    {
        $actualData = json_decode('[{}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element person_name empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_empty_person_name(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":"","job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element person_name empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_empty_person_name_array(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element person_name empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_empty_person_name_json_array(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element person_name empty narrative test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_person_name_empty_narrative(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":""}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element person_name empty narrative array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_person_name_empty_narrative_array(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element person_name empty narrative json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_person_name_empty_narrative_json_array(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element person_name sub element narrative empty narrative test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_person_name_sub_element_narrative_empty_narrative(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element person_name sub element narrative no narrative key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_person_name_sub_element_narrative_no_narrative_key(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"language":"en"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element person_name sub element narrative empty language test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_person_name_sub_element_narrative_empty_attribute_language(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":""}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element person_name sub element narrative no language key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_person_name_sub_element_narrative_no_attribute_language_key(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asdsad"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element job_title empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_empty_job_title(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":"","telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element job_title empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_empty_job_title_array(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element job_title empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_empty_job_title_json_array(): void
    {
        $actualData = json_decode('[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]', true, 512, JSON_THROW_ON_ERROR);

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element job_title empty narrative test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_job_title_empty_narrative(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":""}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element job_title empty narrative array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_job_title_empty_narrative_array(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element job_title empty narrative json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_job_title_empty_narrative_json_array(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element job_title sub element narrative empty narrative test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_job_title_sub_element_narrative_empty_narrative(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element job_title sub element narrative no narrative key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_job_title_sub_element_narrative_no_narrative_key(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[{"language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element job_title sub element narrative empty language test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_job_title_sub_element_narrative_empty_attribute_language(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":""}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element job_title sub element narrative no language key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_job_title_sub_element_narrative_no_attribute_language_key(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element mailing_address empty test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_empty_mailing_address(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"contact-info1-person-name-narrative1","language":"ae"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":""}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element mailing_address empty array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_empty_mailing_address_array(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element mailing_address empty json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_empty_mailing_address_json_array(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element mailing_address empty narrative test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_mailing_address_empty_narrative(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":""}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":""}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * ub element mailing_address empty narrative array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_mailing_address_empty_narrative_array(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element mailing_address empty narrative json array test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_mailing_address_empty_narrative_json_array(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element mailing_address sub element narrative empty narrative test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_mailing_address_sub_element_narrative_empty_narrative(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element mailing_address sub element narrative no narrative key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_mailing_address_sub_element_narrative_no_narrative_key(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[{"language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element mailing_address sub element narrative empty language test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_mailing_address_sub_element_narrative_empty_attribute_language(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":""}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":""}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Sub element mailing_address sub element narrative no language key test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_sub_element_mailing_address_sub_element_narrative_no_attribute_language_key(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"asd","language":"en"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_incomplete($this->element, $actualData);
    }

    /**
     * Contact Info element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_contact_info_element_complete(): void
    {
        $actualData = json_decode(
            '[{"type":"1","organisation":[{"narrative":[{"narrative":"contact-info1-org-narrative1","language":"aa"}]}],"department":[{"narrative":[{"narrative":"contact-info1-dept-narrative1","language":"ab"}]}],"person_name":[{"narrative":[{"narrative":"contact-info1-person-name-narrative1","language":"ae"}]}],"job_title":[{"narrative":[{"narrative":"contact-info1-job-title-narrative1","language":"af"}]}],"telephone":[{"telephone":"+977-0044111222333444"}],"email":[{"email":"manish.pradhan@yipl.com.np"}],"website":[{"website":"https:\/\/www.google.com"}],"mailing_address":[{"narrative":[{"narrative":"contact-info1-mailing-address-narrative1","language":"am"}]}]}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_two_multi_dimensional_element_complete($this->element, $actualData);
    }
}
