<?php

namespace App\IATI\Elements\Forms;

use Kris\LaravelFormBuilder\Form;

class WrapperCollectionForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $data = $this->getData();

        foreach ($data['sub_elements'] as $field) {
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
                            'class' => 'form-child-body form-field-group flex flex-wrap',
                        ],
                    ],
                ]
            )->add('add_to_collection', 'button', [
                'label' => 'Add More',
                'attr' => [
                    'class' => 'add_to_collection button relative font-bold text-n-40 text-bluecoral text-xs uppercase leading-normal mt-2 space-x-2',
                ],
            ]);
        }
    }
}
