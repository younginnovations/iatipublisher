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
                    $this->add('add_to_collection_' . $sub_element['name'], 'button', [
                        'label' => generateAddAdditionalLabel($sub_element['name'], $sub_element['name']),
                        'attr' => [
                            'class' => 'add_to_parent add_more button relative -translate-y-1/2 pl-3.5 text-xs font-bold uppercase leading-normal text-spring-50 text-bluecoral',
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
                'wrapper'           => ['class' => $this->getBaseFormWrapperClasses()],
                'dynamic_wrapper'   => ['class' => $this->getBaseFormDynamicWrapperClasses($sub_element)],
            ],
        ];
    }

    private function getBaseFormDynamicWrapperClasses($sub_element): string
    {
        $dynamicWrapperClass = ((isset($sub_element['add_more']) && $sub_element['add_more']) || Arr::get($sub_element, 'add_more_attributes', false)) ?
            ((!Arr::get($sub_element, 'attributes', null) && strtolower($sub_element['name']) === 'narrative') ? 'border-l border-spring-50 pb-11' : 'subelement rounded-tl-lg border-l border-spring-50 pb-11')
            : ((empty($sub_element['attributes']) && $sub_element['sub_elements'] && isset($sub_element['sub_elements']['narrative'])) ? 'subelement rounded-tl-lg mb-6' : 'subelement rounded-tl-lg border-l border-spring-50 mb-6');

        if (Arr::get($sub_element, 'freeze')) {
            $dynamicWrapperClass .= ' freeze';
        }

        return $dynamicWrapperClass;
    }

    private function getBaseFormWrapperClasses(): string
    {
        return 'multi-form relative';
    }
}
