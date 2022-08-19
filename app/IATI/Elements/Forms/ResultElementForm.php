<?php

namespace App\IATI\Elements\Forms;

use Illuminate\Support\Arr;

/**
 * Class ResultElementForm.
 */
class ResultElementForm extends BaseForm
{
    /**
     * Builds multilevel subelement form.
     *
     * @return mixed|void
     */
    public function buildForm(): void
    {
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
                $this->add(sprintf('sub_elements.%s.name_heading', $name), 'static', [
                    'title'   => true,
                    'content' => '<div class="bg-white" id=' . $name . '>
                    <div class="title flex items-center mb-4">
                        <div class="text-sm shrink-0 uppercase text-n-40 font-bold">' . $name . '</div>
                        <div class="line grow h-px border-b border-n-40 ml-4"></div>
                    </div>
                    </div>',
                ]);

                $this->add(
                    $this->getData(sprintf('sub_elements.%s.name', $name)),
                    'collection',
                    [
                        'type'           => 'form',
                        'property'       => 'name',
                        'prototype'      => true,
                        'prototype_name' => '__PARENT_NAME__',
                        'options'        => [
                            'class'           => 'App\IATI\Elements\Forms\BaseForm',
                            'data'            => $this->getData(sprintf('sub_elements.%s', $name)),
                            'label'           => false,
                            'element_criteria' => $this->getData(sprintf('sub_elements.%s.element_criteria', $name)) ?? '',
                            'wrapper'         => [
                                'class' => 'multi-form relative',
                            ],
                            'dynamic_wrapper' => [
                                'class' => (isset($sub_element['add_more']) && $sub_element['add_more']) ?
                                    ((!Arr::get($sub_element, 'attributes', null) && strtolower(
                                        $sub_element['name']
                                    ) === 'narrative') ? 'border-l border-spring-50 pb-11' : 'subelement rounded-tl-lg border-l border-spring-50 pb-11')
                                    : ((empty($sub_element['attributes']) && $sub_element['sub_elements'] && isset($sub_element['sub_elements']['narrative'])) ? 'subelement rounded-tl-lg mb-6' : 'subelement rounded-tl-lg border-l border-spring-50 mb-6'),
                            ],
                        ],
                    ]
                );

                if (Arr::get($sub_element, 'add_more', false) || Arr::get($sub_element, 'add_more_attributes', false)) {
                    $this->add('add_to_collection_' . $sub_element['name'], 'button', [
                        'label' => sprintf(
                            'add more %s',
                            str_replace('_', ' ', $this->getData(sprintf('sub_elements.%s.name', $name)))
                        ),
                        'attr'  => [
                            'class'     => 'add_to_parent add_more button relative -translate-y-1/2 pl-3.5 text-xs font-bold uppercase leading-normal text-spring-50 text-bluecoral',
                            'form_type' => $sub_element['name'],
                            'icon'      => true,
                        ],
                    ]);
                }
            }
        }
    }
}
