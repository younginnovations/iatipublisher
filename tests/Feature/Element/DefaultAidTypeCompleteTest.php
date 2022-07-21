<?php

namespace Tests\Feature\Element;

class DefaultAidTypeCompleteTest extends ElementCompleteTest
{
    private string $element = 'default_aid_type';

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->activityObj->element = $this->element;
    }

    public function test_default_aid_type_mandatory_attributes()
    {
        $this->test_mandatory_attributes($this->element, ['default_aid_type', 'earmarking_category', 'earmarking_modality', 'cash_and_voucher_modalities']);
    }

    public function test_default_aid_type_mandatory_sub_elements()
    {
        $this->test_mandatory_sub_elements($this->element, []);
    }

    public function test_default_aid_type_all_element_empty()
    {
        $default_aid_typeData = json_decode('[{"default_aid_type_vocabulary":"1","default_aid_type":""},{"default_aid_type_vocabulary":"2","earmarking_category":""},{"default_aid_type_vocabulary":"3","earmarking_modality":""},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":""}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    public function test_default_aid_type_attribute_empty_default_aid_type_for_default_aid_type_vocabulary_1()
    {
        $default_aid_typeData = json_decode('[{"default_aid_type_vocabulary":"1","default_aid_type":""},{"default_aid_type_vocabulary":"2","earmarking_category":"1"},{"default_aid_type_vocabulary":"3","earmarking_modality":"A"},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":"1"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    public function test_default_aid_type_attribute_no_default_aid_type_key_for_default_aid_type_vocabulary_1()
    {
        $default_aid_typeData = json_decode('[{"default_aid_type_vocabulary":"1"},{"default_aid_type_vocabulary":"2","earmarking_category":"1"},{"default_aid_type_vocabulary":"3","earmarking_modality":"A"},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":"1"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    public function test_default_aid_type_attribute_empty_earmarking_category_for_default_aid_type_vocabulary_2()
    {
        $default_aid_typeData = json_decode('[{"default_aid_type_vocabulary":"1","default_aid_type":"1"},{"default_aid_type_vocabulary":"2","earmarking_category":""},{"default_aid_type_vocabulary":"3","earmarking_modality":"A"},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":"1"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    public function test_default_aid_type_attribute_no_earmarking_category_key_for_default_aid_type_vocabulary_2()
    {
        $default_aid_typeData = json_decode('[{"default_aid_type_vocabulary":"1"},{"default_aid_type_vocabulary":"2"},{"default_aid_type_vocabulary":"3","earmarking_modality":"A"},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":"1"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    public function test_default_aid_type_attribute_empty_earmarking_modality_for_default_aid_type_vocabulary_3()
    {
        $default_aid_typeData = json_decode('[{"default_aid_type_vocabulary":"1","default_aid_type":"1"},{"default_aid_type_vocabulary":"2","earmarking_category":""},{"default_aid_type_vocabulary":"3","earmarking_modality":""},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":"1"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    public function test_default_aid_type_attribute_no_earmarking_modality_key_for_default_aid_type_vocabulary_3()
    {
        $default_aid_typeData = json_decode('[{"default_aid_type_vocabulary":"1"},{"default_aid_type_vocabulary":"2"},{"default_aid_type_vocabulary":"3"},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":"1"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    public function test_default_aid_type_attribute_empty_cash_and_voucher_modalities_for_default_aid_type_vocabulary_4()
    {
        $default_aid_typeData = json_decode('[{"default_aid_type_vocabulary":"1","default_aid_type":"1"},{"default_aid_type_vocabulary":"2","earmarking_category":""},{"default_aid_type_vocabulary":"3","earmarking_modality":""},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":""}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    public function test_default_aid_type_attribute_no_cash_and_voucher_modalities_key_for_default_aid_type_vocabulary_4()
    {
        $default_aid_typeData = json_decode('[{"default_aid_type_vocabulary":"1"},{"default_aid_type_vocabulary":"2"},{"default_aid_type_vocabulary":"3"},{"default_aid_type_vocabulary":"4"}]', true);

        $this->test_level_one_multi_dimensional_element_incomplete($this->element, $default_aid_typeData);
    }

    public function test_default_aid_type_element_complete()
    {
        $default_aid_typeData = json_decode('[{"default_aid_type_vocabulary":"1","default_aid_type":"A01"},{"default_aid_type_vocabulary":"2","earmarking_category":"1"},{"default_aid_type_vocabulary":"3","earmarking_modality":"A"},{"default_aid_type_vocabulary":"4","cash_and_voucher_modalities":"1"}]', true);

        $this->test_level_one_multi_dimensional_element_complete($this->element, $default_aid_typeData);
    }
}
