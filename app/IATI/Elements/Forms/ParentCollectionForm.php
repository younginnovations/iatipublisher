<?php

namespace App\IATI\Elements\Forms;

use Illuminate\Support\Arr;

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
        $field = $this->getData();

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
                    'dynamic_wrapper' => [
                        'class' => (isset($field['add_more']) && $field['add_more']) ?
                        (strtolower($field['name']) === 'narrative' && Arr::get($field, 'attributes', null) ? 'border-l border-spring-50 pb-11' : 'subelement rounded-tl-lg border-l border-spring-50 pb-11')
                        : 'subelement rounded-tl-lg border-l border-spring-50 mb-6',
                    ],
                ],
            ]
        );

        if (Arr::get($field, 'add_more', true) || Arr::get($field, 'add_more_attributes', false)) {
            $this->add('add_to_collection', 'button', [
                'label' => sprintf('add more %s', str_replace('_', ' ', $this->getData('name'))),
                'attr' => [
                    'icon' => true,
                    'class' => 'add_to_parent add_more button relative text-xs font-bold text-spring-50 text-bluecoral uppercase leading-normal -translate-y-1/2 pl-3.5',
                ],
            ]);
        }
    }
}
