<?php

namespace App\IATI\Forms;

use Kris\LaravelFormBuilder\Form;

/**
 * Class BaseForm.
 */
class BaseForm extends Form
{
    /**
     * @param $field
     *
     * @return void
     */
    public function buildCollection($field): void
    {
        $this->add(
            $field['name'],
            'collection',
            [
                'type'    => 'form',
                'options' => [
                    'class' => 'App\IATI\Forms\SubElementForm',
                    'data'  => $field,
                    'label' => false,
                ],
            ]
        );
    }

    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $element = $this->getData();
        $sub_elements = $element['sub_elements'];

        foreach ($sub_elements as $sub_element) {
            $this->buildCollection($sub_element);
        }
    }
}
