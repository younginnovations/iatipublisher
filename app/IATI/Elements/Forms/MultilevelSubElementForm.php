<?php

namespace App\IATI\Elements\Forms;

use Illuminate\Support\Arr;

/**
 * Class ParentCollectionForm.
 */
class MultilevelSubElementForm extends BaseForm
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $attributes = Arr::get($this->getData(), 'attributes', null);
        $sub_elements = Arr::get($this->getData(), 'sub_elements', null);

        if ($attributes) {
            if (Arr::get($this->getData(), 'add_more', false) && !$sub_elements) {
                $this->buildCollection($attributes);
            } else {
                foreach ($attributes as $attribute) {
                    if (is_array($attribute)) {
                        $this->buildField($attribute);
                    }
                }
            }
        }

        if ($sub_elements) {
            foreach ($sub_elements as $name => $sub_element) {
                $this->add(
                    $this->getData(sprintf('sub_elements.%s.name', $name)),
                    'collection',
                    [
                        'type'    => 'form',
                        'property' => 'name',
                        'prototype' => true,
                        'prototype_name' => '__PARENT_NAME__',
                        'options' => [
                            'class' => 'App\IATI\Elements\Forms\BaseForm',
                            'data'  => $this->getData(sprintf('sub_elements.%s', $name)),
                            'label' => false,
                            'wrapper' => [
                                'class' => 'multi-form relative',
                            ],
                        ],
                    ]
                )->add('add_to_collection', 'button', [
                    'label' => 'add more',
                    'attr' => [
                        'class' => 'add_to_parent add_more button relative -translate-y-1/2 pl-3.5 text-xs font-bold uppercase leading-normal text-spring-50 text-bluecoral',
                        'icon' => true,                    ],
                ]);
            }
        }
    }
}
