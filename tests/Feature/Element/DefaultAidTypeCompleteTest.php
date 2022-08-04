<?php

namespace Tests\Feature\Element;

/**
 * Class DefaultAidTypeCompleteTest.
 */
class DefaultAidTypeCompleteTest extends ElementCompleteTest
{
    private string $element = 'default_aid_type';

    /**
     * Mandatory attribute test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_default_aid_type_mandatory_attributes(): void
    {
        $this->test_mandatory_attributes($this->element, ['default_aid_type', 'earmarking_category', 'earmarking_modality', 'cash_and_voucher_modalities']);
    }

    /**
     * Mandatory sub element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_default_aid_type_mandatory_sub_elements(): void
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    /**
     * Empty all element test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_default_aid_type_all_element_empty(): void
    {
        $default_aid_typeData = json_decode(
            '[{"default_aid_type_vocabulary":"1","default_aid_type":""},{"default_aid_type_vocabulary":"2","earmarking_category":""},{"default_aid_type_vocabulary":"3","earmarking_modality":""},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":""}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    /**
     * Attribute default_aid_type empty for default_aid_type_vocabulary 1 test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_default_aid_type_attribute_empty_default_aid_type_for_default_aid_type_vocabulary_1(): void
    {
        $default_aid_typeData = json_decode(
            '[{"default_aid_type_vocabulary":"1","default_aid_type":""},{"default_aid_type_vocabulary":"2","earmarking_category":"1"},{"default_aid_type_vocabulary":"3","earmarking_modality":"A"},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":"1"}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    /**
     * Attribute default_aid_type no key for default_aid_type_vocabulary 1 test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_default_aid_type_attribute_no_default_aid_type_key_for_default_aid_type_vocabulary_1(): void
    {
        $default_aid_typeData = json_decode(
            '[{"default_aid_type_vocabulary":"1"},{"default_aid_type_vocabulary":"2","earmarking_category":"1"},{"default_aid_type_vocabulary":"3","earmarking_modality":"A"},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":"1"}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    /**
     * Attribute earmarking_category empty for default_aid_type_vocabulary 2 test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_default_aid_type_attribute_empty_earmarking_category_for_default_aid_type_vocabulary_2(): void
    {
        $default_aid_typeData = json_decode(
            '[{"default_aid_type_vocabulary":"1","default_aid_type":"1"},{"default_aid_type_vocabulary":"2","earmarking_category":""},{"default_aid_type_vocabulary":"3","earmarking_modality":"A"},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":"1"}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    /**
     * Attribute earmarking_category no key for default_aid_type_vocabulary 2 test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_default_aid_type_attribute_no_earmarking_category_key_for_default_aid_type_vocabulary_2(): void
    {
        $default_aid_typeData = json_decode(
            '[{"default_aid_type_vocabulary":"1"},{"default_aid_type_vocabulary":"2"},{"default_aid_type_vocabulary":"3","earmarking_modality":"A"},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":"1"}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    /**
     * Attribute earmarking_modality empty for default_aid_type_vocabulary 3 test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_default_aid_type_attribute_empty_earmarking_modality_for_default_aid_type_vocabulary_3(): void
    {
        $default_aid_typeData = json_decode(
            '[{"default_aid_type_vocabulary":"1","default_aid_type":"1"},{"default_aid_type_vocabulary":"2","earmarking_category":""},{"default_aid_type_vocabulary":"3","earmarking_modality":""},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":"1"}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    /**
     * Attribute earmarking_modality no key for default_aid_type_vocabulary 3 test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_default_aid_type_attribute_no_earmarking_modality_key_for_default_aid_type_vocabulary_3(): void
    {
        $default_aid_typeData = json_decode(
            '[{"default_aid_type_vocabulary":"1"},{"default_aid_type_vocabulary":"2"},{"default_aid_type_vocabulary":"3"},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":"1"}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    /**
     * Attribute cash_and_voucher_modalities empty for default_aid_type_vocabulary 4 test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_default_aid_type_attribute_empty_cash_and_voucher_modalities_for_default_aid_type_vocabulary_4(): void
    {
        $default_aid_typeData = json_decode(
            '[{"default_aid_type_vocabulary":"1","default_aid_type":"1"},{"default_aid_type_vocabulary":"2","earmarking_category":""},{"default_aid_type_vocabulary":"3","earmarking_modality":""},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":""}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    /**
     * Attribute cash_and_voucher_modalities no key for default_aid_type_vocabulary 4 test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_default_aid_type_attribute_no_cash_and_voucher_modalities_key_for_default_aid_type_vocabulary_4(): void
    {
        $default_aid_typeData = json_decode(
            '[{"default_aid_type_vocabulary":"1"},{"default_aid_type_vocabulary":"2"},{"default_aid_type_vocabulary":"3"},{"default_aid_type_vocabulary":"4"}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    /**
     * Default Aid Type element complete test.
     *
     * @return void
     * @throws \JsonException
     */
    public function test_default_aid_type_element_complete(): void
    {
        $default_aid_typeData = json_decode(
            '[{"default_aid_type_vocabulary":"1","default_aid_type":"A01"},{"default_aid_type_vocabulary":"2","earmarking_category":"1"},{"default_aid_type_vocabulary":"3","earmarking_modality":"A"},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":"1"}]',
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->test_level_one_multi_dimensional_element_complete($this->element, $default_aid_typeData);
    }
}
