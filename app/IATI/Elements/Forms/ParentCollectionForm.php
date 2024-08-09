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

        $this->add(
            $this->getData('name'),
            'collection',
            [
                'type'           => 'form',
                'property'       => 'name',
                'prototype'      => true,
                'prototype_name' => '__PARENT_NAME__',
                'options'        => [
                    'class'            => 'App\IATI\Elements\Forms\BaseForm',
                    'data'             => $this->data,
                    'label'            => false,
                    'element_criteria' => $field['element_criteria'] ?? '',
                    'hover_text'       => Arr::get($field, 'hover_text', ''),
                    'help_text'        => Arr::get($field, 'help_text', ''),
                    'helper_text'      => Arr::get($field, 'helper_text', ''),
                    'info_text'        => Arr::get($field, 'info_text', ''),
                    'wrapper'          => ['class' => $this->getBaseFormWrapperClasses()],
                    'dynamic_wrapper'  => ['class' => $this->getBaseFormDynamicWrapperClasses($field)],
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

    private function getBaseFormWrapperClasses(): string
    {
        return 'multi-form relative';
    }

    private function getBaseFormDynamicWrapperClasses($field): string
    {
        $hasAddMoreButton = isset($field['add_more']) && $field['add_more'];
        $isSubElementNarrative = isset($field['name']) && strtolower($field['name']) === 'narrative';
        $elementHasAttributes = Arr::get($field, 'attributes', null);

        if ($hasAddMoreButton) {
            if ($isSubElementNarrative && $elementHasAttributes) {
                $dynamicWrapperClass = 'border-l border-spring-50 pb-11';
            } else {
                $dynamicWrapperClass = 'subelement rounded-tl-lg border-l border-spring-50 pb-11';
            }
        } else {
            $dynamicWrapperClass = 'subelement rounded-tl-lg border-l border-spring-50 mb-6';
        }

        if (Arr::get($field, 'freeze')) {
            $dynamicWrapperClass .= ' freeze';
        }

        $collapsableClass = getCollapsableClass($field, 'parent-form');

        return $dynamicWrapperClass . ' ' . $collapsableClass;
    }
}
