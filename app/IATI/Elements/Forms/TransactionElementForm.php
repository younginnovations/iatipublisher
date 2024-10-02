<?php

declare(strict_types=1);

namespace App\IATI\Elements\Forms;

use Illuminate\Support\Arr;

/**
 * Class TransactionElementForm.
 */
class TransactionElementForm extends BaseForm
{
    /**
     * Builds multilevel subelement form.
     *
     * @throws \JsonException
     *
     * @return void
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
                $addProperty = $this->addProperty($name, $sub_element);

                if ($name === 'value') {
                    ['name' => $fieldName, 'choices' => $fieldChoice, 'placeholder' => $fieldPlaceHolder] = $addProperty['options']['data']['attributes']['currency'];
                    $addProperty['options']['data']['attributes']['currency']['placeholder'] = getDefaultValue($this->getData()['overRideDefaultFieldValue'], $fieldName, $fieldChoice ?? []) ?? $fieldPlaceHolder;
                }

                $this->add(
                    $this->getData(sprintf('sub_elements.%s.name', $name)),
                    'collection',
                    $addProperty
                );

                if (Arr::get($sub_element, 'add_more', false) || Arr::get($sub_element, 'add_more_attributes', false)) {
                    $addMoreButtonClass = 'add_to_parent add_more button three relative pl-6 text-xs font-bold uppercase leading-normal text-spring-50 text-bluecoral ';

                    if ($this->shouldRenderBorderOnAddMoreButton($sub_element)) {
                        $addMoreButtonClass = $addMoreButtonClass . getAddAdditionalButtonBorders() . 'border-y';
                    }

                    $this->add('add_to_collection_' . $sub_element['name'], 'button', [
                        'label' => generateAddAdditionalLabel($sub_element['name'], $sub_element['name']),
                        'attr' => [
                            'class' => $addMoreButtonClass,
                            'form_type' => $sub_element['name'],
                            'icon' => true,
                        ],
                    ]);
                }
            }
        }
    }

    /**
     * Adds property for form.
     *
     * @param $name
     * @param $dynamicWrapperClass
     *
     * @return array
     */
    public function addProperty($name, $sub_element): array
    {
        return  [
            'type'           => 'form',
            'property'       => 'name',
            'prototype'      => true,
            'prototype_name' => '__PARENT_NAME__',
            'options'        => [
                'class'             => 'App\IATI\Elements\Forms\BaseForm',
                'data'              => $this->getData(sprintf('sub_elements.%s', $name)),
                'element_criteria'  => $this->getData(sprintf('sub_elements.%s.element_criteria', $name)),
                'hover_text'        => $this->getData(sprintf('sub_elements.%s.hover_text', $name)) ?? '',
                'help_text'         => $this->getData(sprintf('sub_elements.%s.help_text', $name)) ?? '',
                'helper_text'       => $this->getData(sprintf('sub_elements.%s.helper_text', $name)) ?? '',
                'info_text'         => $this->getData(sprintf('sub_elements.%s.info_text', $name)) ?? '',
                'warning_info_text' => $this->getData(sprintf('sub_elements.%s.warning_info_text', $name)) ?? '',
                'label'             => false,
                'is_collapsable'   => Arr::get($sub_element, 'is_collapsable', ''),
                'label_indicator'  => Arr::get($sub_element, 'label_indicator', ),
                'wrapper'           => ['class' => $this->getBaseFormWrapperClasses()],
                'dynamic_wrapper'   => ['class' => $this->getBaseFormDynamicWrapperClasses($sub_element)],
            ],
        ];
    }

    private function getBaseFormDynamicWrapperClasses($sub_element): string
    {
        $hasAddMore = isset($sub_element['add_more']) && $sub_element['add_more'];
        $hasAddMoreAttributes = Arr::get($sub_element, 'add_more_attributes', false);
        $isNarrative = strtolower($sub_element['name']) === 'narrative';
        $hasAttributes = !Arr::get($sub_element, 'attributes', null);
        $hasSubElements = !empty($sub_element['sub_elements']);
        $hasNarrativeSubElement = isset($sub_element['sub_elements']['narrative']);

        if ($hasAddMore || $hasAddMoreAttributes) {
            $dynamicWrapperClass = ($hasAttributes && $isNarrative)
                ? 'border-spring-50 one '
                : 'subelement rounded-t-sm two border-spring-50 mt-6';
        } else {
            $dynamicWrapperClass = ($hasAttributes && $hasSubElements && $hasNarrativeSubElement)
                ? 'subelement rounded-t-sm three mt-6'
                : 'subelement rounded-t-sm four border-spring-50 mt-6 ';
        }
        $formBorderClass = $this->shouldRenderBorderOnForm($sub_element) ? 'border-spring-50 border' : '';
        $labelBorderClass = $this->shouldRenderBorderOnLabel($sub_element) ? 'label-with-border' : '';

        if (Arr::get($sub_element, 'freeze')) {
            $dynamicWrapperClass .= ' freeze';
        }

        return "$dynamicWrapperClass $formBorderClass $labelBorderClass";
    }

    private function getBaseFormWrapperClasses(): string
    {
        return 'multi-form relative four ';
    }

    private function shouldRenderBorderOnAddMoreButton($element): bool
    {
        return Arr::get($element, 'add_more_has_borders', false);
    }

    private function shouldRenderBorderOnForm($element): bool
    {
        return Arr::get($element, 'form_has_borders', false);
    }

    private function shouldRenderBorderOnLabel($element): bool
    {
        return Arr::get($element, 'label_has_borders', false);
    }
}
