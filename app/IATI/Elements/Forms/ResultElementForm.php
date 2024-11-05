<?php

declare(strict_types=1);

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
                    'content' => '',
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
                            'class'            => 'App\IATI\Elements\Forms\BaseForm',
                            'data'             => $this->getData(sprintf('sub_elements.%s', $name)),
                            'label'            => false,
                            'element_criteria' => $this->getData(sprintf('sub_elements.%s.element_criteria', $name)) ?? '',
                            'hover_text'       => $this->getData(sprintf('sub_elements.%s.hover_text', $name)) ?? '',
                            'help_text'        => $this->getData(sprintf('sub_elements.%s.help_text', $name)) ?? '',
                            'helper_text'      => $this->getData(sprintf('sub_elements.%s.helper_text', $name)) ?? '',
                            'is_collapsable'   => Arr::get($sub_element, 'is_collapsable', ''),
                            'label_indicator'  => Arr::get($sub_element, 'label_indicator', ),
                            'wrapper'          => ['class' => $this->getBaseFormWrapperClasses()],
                            'dynamic_wrapper'  => ['class' => $this->getBaseFormDynamicWrapperClasses($sub_element)],
                        ],
                    ]
                );

                if (Arr::get($sub_element, 'add_more', false) || Arr::get($sub_element, 'add_more_attributes', false)) {
                    $addMoreButtonClass = 'add_to_parent add_more button two relative pl-6 text-xs font-bold uppercase leading-normal text-spring-50 text-bluecoral ';

                    if (Arr::get($sub_element, 'add_more_has_borders')) {
                        $addMoreButtonClass = $addMoreButtonClass . getAddAdditionalButtonBorders();
                    }

                    $this->add('add_to_collection_' . $sub_element['name'], 'button', [
                        'label' => generateAddAdditionalLabel($sub_element['name'], $this->getData(sprintf('sub_elements.%s.name', $name))),
                        'attr'  => [
                            'class'     => $addMoreButtonClass,
                            'form_type' => $sub_element['name'],
                            'icon'      => true,
                        ],
                    ]);
                }
            }
        }
    }

    private function getBaseFormWrapperClasses()
    {
        return 'multi-form relative three pb-3';
    }

    private function getBaseFormDynamicWrapperClasses($sub_element)
    {
        $hasAddMore = isset($sub_element['add_more']) && $sub_element['add_more'];
        $isNarrative = strtolower($sub_element['name']) === 'narrative';
        $hasAttributes = Arr::get($sub_element, 'attributes', null) !== null;
        $hasSubElements = !empty($sub_element['sub_elements']);
        $hasNarrativeSubElement = $hasSubElements && isset($sub_element['sub_elements']['narrative']);
        $formBorderClass = $this->shouldRenderBorderOnForm($sub_element) ? 'border-spring-50 border' : '';
        $labelBorderClass = $this->shouldRenderBorderOnLabel($sub_element) ? 'label-with-border' : '';

        if ($hasAddMore) {
            if (!$hasAttributes && $isNarrative) {
                return "border-spring-50 one $formBorderClass $labelBorderClass";
            }

            return "subelement rounded-t-sm two border-spring-50 $formBorderClass $labelBorderClass";
        }

        if ($hasNarrativeSubElement && !$hasAttributes) {
            return "subelement rounded-t-sm three $formBorderClass $labelBorderClass";
        }

        return "subelement rounded-t-sm four border-spring-50 mb-6 $formBorderClass $labelBorderClass";
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
