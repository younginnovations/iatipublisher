<?php

namespace App\IATI\Elements\Forms;

/**
 * Class ParentCollectionForm.
 */
class ParentCollectionForm extends BaseForm
{
    /**
     * Builds parent collection form.
     *
     * @return mixed|void
     */
    public function buildForm():void
    {
        $this->add(
            $this->getData('name'),
            'collection',
            [
                'type' => 'form',
                'property' => 'name',
                'prototype' => true,
                'prototype_name' => '__PARENT_NAME__',
                'options' => [
                    'class' => 'App\IATI\Elements\Forms\BaseForm',
                    'data' => $this->data,
                    'label' => false,
                    'wrapper' => [
                        'class' => 'multi-form relative',
                    ],
                ],
            ]
        )->add('add_to_collection', 'button', [
            'label' => sprintf('add more %s', str_replace('_', ' ', $this->getData('name'))),
            'attr' => [
                'icon' => true,
                'class' => 'add_to_parent add_more button relative text-xs font-bold text-spring-50 text-bluecoral uppercase leading-normal -translate-y-1/2 pl-3.5',
            ],
        ]);
    }
}
