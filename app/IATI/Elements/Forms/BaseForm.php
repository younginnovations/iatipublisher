<?php

namespace App\IATI\Elements\Forms;

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
                'property' => 'name',
                'prototype' => true,
                'prototype_name' => '__NAME__',
                'options' => [
                    'class' => 'App\IATI\Elements\Forms\SubElementForm',
                    'data'  => $field,
                    'label' => false,
                    'wrapper' => [
                        'class' => 'form-child-body',
                    ],
                ],
            ]
        )->add('add_to_collection', 'button', [
            'label' => 'add to collection',
            'attr' => [
                'class' => 'add_to_collection',
            ],
        ]);
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
