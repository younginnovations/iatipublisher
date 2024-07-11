<?php

declare(strict_types=1);

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
    public function buildForm(): void
    {
        $field = $this->getData();
        $dynamicWrapperClass = (isset($field['add_more']) && $field['add_more']) ?
            (strtolower($field['name']) === 'narrative' && Arr::get($field, 'attributes', null) ? 'border-l border-spring-50 pb-11' : 'subelement rounded-tl-lg border-l border-spring-50 pb-11')
            : 'subelement rounded-tl-lg border-l border-spring-50 mb-6';

        if (Arr::get($field, 'freeze')) {
            $dynamicWrapperClass .= ' freeze';
        }

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
                    'element_criteria' => $field['element_criteria'] ?? '',
                    'hover_text' => Arr::get($field, 'hover_text', ''),
                    'help_text' => Arr::get($field, 'help_text', ''),
                    'helper_text' => Arr::get($field, 'helper_text', ''),
                    'info_text' => Arr::get($field, 'info_text', ''),
                    'wrapper' => [
                        'class' => 'multi-form relative',
                    ],
                    'dynamic_wrapper' => [
                        'class' => $dynamicWrapperClass,
                    ],
                ],
            ]
        );

        if (Arr::get($field, 'add_more', false) || Arr::get($field, 'add_more_attributes', false)) {
            $this->add('add_to_collection', 'button', [
                'label' => generateAddAdditionalLabel($field['name'], $field['name']),
                'attr' => [
                    'icon' => true,
                    'class' => 'add_to_parent add_more button relative text-xs font-bold text-spring-50 text-bluecoral uppercase leading-normal -translate-y-1/2 pl-3.5',
                ],
            ]);
        }
    }
}
