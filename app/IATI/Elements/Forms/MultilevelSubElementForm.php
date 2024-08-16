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
     * @return void
     * @throws \JsonException
     */
    public function buildForm(): void
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
                        'type'           => 'form',
                        'property'       => 'name',
                        'prototype'      => true,
                        'prototype_name' => '__PARENT_NAME__',
                        'options'        => [
                            'class'            => 'App\IATI\Elements\Forms\BaseForm',
                            'data'             => $this->getData(sprintf('sub_elements.%s', $name)),
                            'label'            => false,
                            'element_criteria' => $this->getData(sprintf('sub_elements.%s.element_criteria', $name)),
                            'hover_text'       => $this->getData(sprintf('sub_elements.%s.hover_text', $name)) ?? '',
                            'help_text'        => $this->getData(sprintf('sub_elements.%s.help_text', $name)) ?? '',
                            'helper_text'      => $this->getData(sprintf('sub_elements.%s.helper_text', $name)) ?? '',
                            'wrapper'          => ['class' => $this->getBaseFormWrapperClasses()],
                            'dynamic_wrapper'  => ['class' => $this->getBaseFormDynamicWrapperClasses($sub_element, $element)]],
                    ]
                )->add('add_to_collection', 'button', [
                    'label' => generateAddAdditionalLabel($element['name'], $this->getData(sprintf('sub_elements.%s.name', $name))),
                    'attr' => [
                        'class' => 'add_to_parent add_more button relative -translate-y-1/2 pl-3.5 text-xs font-bold uppercase leading-normal text-spring-50 text-bluecoral',
                        'icon' => true,                    ],
                ]);
            }
        }
    }

    private function getBaseFormWrapperClasses(): string
    {
        return 'multi-form relative';
    }

    private function getBaseFormDynamicWrapperClasses($sub_element, $element): string
    {
        $hasAddMoreButton = isset($sub_element['add_more']) && $sub_element['add_more'];
        $canAddMoreAttributes = Arr::get($element, 'add_more_attributes', false);
        $elementHasAttributes = isset($sub_element['attributes']) && !count($sub_element['attributes']) > 0;
        $isSubElementNarrative = isset($sub_element['name']) && strtolower($sub_element['name']) === 'narrative';
        $collapsableClass = getCollapsableClass($element, 'multi-level-form');

        if ($hasAddMoreButton || $canAddMoreAttributes) {
            if ($isSubElementNarrative && !$elementHasAttributes) {
                return "border-l border-spring-50 pb-11 border-reed $collapsableClass";
            }

            return "subelement rounded-tl-lg border-l border-spring-50 pb-11 $collapsableClass";
        }

        return "subelement rounded-tl-lg border-l border-spring-50 mb-6 $collapsableClass";
    }
}
