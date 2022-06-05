<?php

namespace App\IATI\Elements\Forms;

/**
 * Class ParentCollectionForm.
 */
class ParentCollectionForm extends BaseForm
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add(
            $this->getData('name'),
            'collection',
            [
                'type'    => 'form',
                'property' => 'name',
                'prototype' => true,
                'prototype_name' => '__PARENT_NAME__',
                'options' => [
                    'class' => 'App\IATI\Elements\Forms\BaseForm',
                    'data'  => $this->data,
                    'label' => false,
                    'wrapper' => [
                        'class' => 'multi-form form-field-group flex flex-wrap',
                    ],
                ],
            ]
        )->add('add_to_collection', 'button', [
            'label' => 'add more',
            'attr' => [
                'class' => 'add_to_parent button relative font-bold text-n-40 text-bluecoral text-xs uppercase leading-normal mt-2 space-x-2',
            ],
        ]);
    }
}
