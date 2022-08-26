<?php

declare(strict_types=1);

namespace App\IATI\Elements\Forms;

use Illuminate\Support\Arr;

/**
 * Class MultilevelSubElementForm.
 */
class MultilevelSubElementForm extends BaseForm
{
    /**
     * Builds multilevel subelement form.
     *
     * @return mixed|void
     */
    public function buildForm():void
    {
        $element = $this->getData();
        $attributes = Arr::get($this->getData(), 'attributes', null);
        $sub_elements = Arr::get($this->getData(), 'sub_elements', null);
        $this->setClientValidationEnabled(false);

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
                            'element_criteria' => $this->getData(sprintf('sub_elements.%s.element_criteria', $name)),
                            'wrapper' => [
                                'class' => 'multi-form relative',
                            ],
                            'dynamic_wrapper' => [
                                'class' => (isset($sub_element['add_more']) && $sub_element['add_more'] || Arr::get($element, 'add_more_attributes', false)) ?
                                (strtolower($sub_element['name']) === 'narrative' && !isset($sub_element['attributes']) && !count($sub_element['attributes']) > 0 ? 'border-l border-spring-50 pb-11' : 'subelement rounded-tl-lg border-l border-spring-50 pb-11')
                                : 'subelement rounded-tl-lg border-l border-spring-50 mb-6',
                            ],                        ],
                    ]
                )->add('add_to_collection', 'button', [
                    'label' => sprintf('add more %s', str_replace('_', ' ', $this->getData(sprintf('sub_elements.%s.name', $name)))),
                    'attr' => [
                        'class' => 'add_to_parent add_more button relative -translate-y-1/2 pl-3.5 text-xs font-bold uppercase leading-normal text-spring-50 text-bluecoral',
                        'icon' => true,                    ],
                ]);
            }
        }
    }
}
