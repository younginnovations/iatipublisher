<?php

namespace App\IATI\Elements\Forms;

/**
 * Class DateCollectionForm.
 */
class DateCollectionForm extends BaseForm
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add(
            'activity_date',
            'collection',
            [
                'type'    => 'form',
                'property' => 'name',
                'prototype' => true,
                'prototype_name' => '__NAME__',
                'options' => [
                    'class' => 'App\IATI\Elements\Forms\BaseForm',
                    'data'  => $this->data,
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
}
