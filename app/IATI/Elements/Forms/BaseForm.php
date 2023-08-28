<?php

declare(strict_types=1);

namespace App\IATI\Elements\Forms;

use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class BaseForm.
 */
class BaseForm extends Form
{
    /**
     * @param $field
     *
     * @return void
     */
    public function buildCollection($field): void
    {
        $element = $this->getData();
        if (!Arr::get($field, 'type', null) && array_key_exists('sub_elements', $field) && Arr::get(
            $field,
            'wrapper_collection',
            true
        )) {
            $field['parent'] = $element['name'];

            $this->add(
                $field['name'],
                'collection',
                [
                    'type'           => 'form',
                    'property'       => 'name',
                    'prototype'      => true,
                    'prototype_name' => '__NAME__',
                    'options'        => [
                        'class'           => 'App\IATI\Elements\Forms\WrapperCollectionForm',
                        'data'            => $field,
                        'label'           => false,
                        'element_criteria' => Arr::get($field, 'element_criteria', ''),
                        'hover_text' => Arr::get($field, 'hover_text', ''),
                        'help_text' => Arr::get($field, 'help_text', ''),
                        'helper_text' => Arr::get($field, 'helper_text', ''),
                        'wrapper'         => [
                            'class' => 'wrapped-child-body',
                        ],
                        'dynamic_wrapper' => [
                            'class' => (isset($field['add_more']) && $field['add_more']) ?
                                ((!Arr::get($element, 'attributes', null) && strtolower(
                                    $field['name']
                                ) === 'narrative') && !strtolower($element['name']) == 'mailing_address' ? 'border-l border-spring-50 pb-11' : 'subelement rounded-tl-lg border-l border-spring-50 pb-11')
                                : ((!Arr::get(
                                    $field,
                                    'attributes',
                                    null
                                ) && $field['sub_elements'] && isset($field['sub_elements']['narrative'])) ? 'subelement rounded-tl-lg mb-6' : 'subelement rounded-tl-lg border-l border-spring-50 mb-6'),
                        ],
                    ],
                ]
            );

            if ((isset($field['add_more']) && $field['add_more']) || (isset($element['add_more_attributes']) && $element['add_more_attributes'])) {
                $this->add('add_to_collection_' . $field['name'], 'button', [
                    'label' => sprintf('Add additional %s', str_replace('_', ' ', $field['name'])),
                    'attr'  => [
                        'class'     => 'add_to_collection add_more button relative -translate-y-1/2 pl-3.5 text-xs font-bold uppercase leading-normal text-spring-50 text-bluecoral ',
                        'form_type' => $field['parent'] . '_' . $field['name'],
                        'has_child_collection' => 1,
                        'icon' => true,
                    ],
                ]);
            }
        } else {
            $this->add(
                $field['name'] ?? $element['name'],
                'collection',
                [
                    'type'           => 'form',
                    'property'       => 'name',
                    'prototype'      => true,
                    'prototype_name' => '__NAME__',
                    'options'        => [
                        'class'           => 'App\IATI\Elements\Forms\SubElementForm',
                        'data'            => $field,
                        'label'           => false,
                        'element_criteria' => $field['element_criteria'] ?? '',
                        'hover_text'    => isset($field['name']) ? Arr::get($field, 'hover_text', '') : Arr::get($element, 'hover_text', ''),
                        'help_text' => isset($field['name']) ? Arr::get($field, 'help_text', '') : Arr::get($element, 'help_text', ''),
                        'wrapper'         => [
                            'class' => ((Arr::get($element, 'attributes', null) && isset($field['name']) && strtolower(
                                $field['name']
                            ) === 'narrative') ? 'form-field-group form-child-body xl:flex flex-wrap rounded-tl-lg rounded-br-lg border-y border-r border-spring-50 p-6' : 'form-field-group form-child-body xl:flex flex-wrap rounded-br-lg border-y border-r border-spring-50 p-6'),
                        ],
                        'dynamic_wrapper' => [
                            'class' => (((isset($field['add_more']) && $field['add_more']) || Arr::get(
                                $element,
                                'add_more_attributes',
                                false
                            )) ?
                                (!Arr::get($element, 'attributes', null) && strtolower(
                                    $field['name']
                                ) === 'narrative' ? 'border-l border-spring-50 pb-11' : 'subelement rounded-tl-lg border-l border-spring-50 pb-11')
                                : 'subelement rounded-tl-lg border-l border-spring-50 mb-6') . (Arr::get($field, 'read_only', false) ? ' freeze' : ''),
                        ],
                    ],
                ]
            );

            $name = $field['name'] ?? $element['name'];

            if ((isset($field['add_more']) && $field['add_more']) || Arr::get($element, 'add_more_attributes', false)) {
                $this->add('add_to_collection_' . $name, 'button', [
                    'label' => sprintf('add additional %s', str_replace('_', ' ', Arr::get($element, 'attributes', null) ? ($field['name'] ?? $name) : $element['name'])),
                    'attr'  => [
                        'class'     => 'add_to_collection add_more button relative -translate-y-1/2 pl-3.5 text-xs font-bold uppercase leading-normal text-spring-50 text-bluecoral ' . (Arr::get($field, 'read_only', false) ? ' freeze' : ''),
                        'form_type' => !empty(Arr::get($this->getData(), 'name', null)) ? sprintf(
                            '%s_%s',
                            Arr::get($this->getData(), 'name', ''),
                            $name
                        ) : $name,
                        'icon'      => true,
                    ],
                ]);
            }
        }
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function buildForm(): void
    {
        $this->setClientValidationEnabled(false);
        $element = $this->getData();
        $attributes = Arr::get($element, 'attributes', null);
        $sub_elements = Arr::get($element, 'sub_elements', null);

        if ($attributes) {
            if (Arr::get($element, 'add_more', false) && !$sub_elements && Arr::get(
                $element,
                'make_collection',
                true
            )) {
                $this->buildCollection($attributes);
            } else {
                foreach ($attributes as $attribute) {
                    if (is_array($attribute)) {
                        $this->buildField($attribute);
                    }
                }

                if (Arr::get($element, 'add_more', false) || Arr::get($element, 'add_more_attributes', false)) {
                    $this->add('delete_' . $element['name'], 'button', [
                        'attr' => [
                            'class' => 'delete-parent delete-item absolute right-0 top-16 -translate-y-1/2 translate-x-1/2',
                        ],
                    ]);
                }
            }
        }

        if ($sub_elements) {
            foreach ($sub_elements as $sub_element) {
                $this->buildCollection($sub_element);

                if (Arr::get($element, 'add_more', false) && Arr::get($sub_element, 'add_more', false)) {
                    $this->add('delete_' . $sub_element['name'], 'button', [
                        'attr' => [
                            'class' => 'delete-parent delete-item absolute right-0 top-16 -translate-y-1/2 translate-x-1/2',
                        ],
                    ]);
                }
            }
        }
    }

    /**
     * Return codeList array from json codeList.
     *
     * @param string $filePath
     * @param bool   $code
     *
     * @return array
     * @throws \JsonException
     */
    public function getCodeList(string $filePath, bool $code = true): array
    {
        $filePath = app_path("Data/$filePath");
        $codeListFromFile = file_get_contents($filePath);
        $codeLists = json_decode($codeListFromFile, true, 512, JSON_THROW_ON_ERROR);
        $codeList = last($codeLists);
        $data = [];

        foreach ($codeList as $list) {
            $data[$list['code']] = ($code) ? $list['code'] . (array_key_exists(
                'name',
                $list
            ) ? ' - ' . $list['name'] : '') : $list['name'];
        }

        return $data;
    }

    /**
     * @param $field
     *
     * @return void
     * @throws \JsonException
     */
    public function buildField($field): void
    {
        $options = [
            'help_block'  => [
                'text' => $field['help_text'] ?? '',
                'title' => $field['label'],
            ],
            'hover_block' => [
                'title' => $field['label'],
                'text'  => $field['hover_text'] ?? '',
            ],
            'label'       => $field['label'] ?? '',
            'required'    => $field['required'] ?? false,
            'multiple'    => $field['multiple'] ?? false,
            'attr'        => [
                'class'    => 'form__input code border-0',
                'readonly' => (array_key_exists(
                    'read_only',
                    $field
                ) && $field['read_only'] == true) ? 'readonly' : false,
                'placeholder' => Arr::get($field, 'placeholder', ''),

            ],
            'wrapper'     => [
                'class' => 'form-field basis-auto w-full xl:basis-6/12 attribute' . (Arr::get($field, 'read_only', false) ? ' freeze' : ''),
            ],
        ];

        if ($field['type'] === 'text') {
            $options['attr']['class'] = $this->getAttributeClasses($field, $options);
        }

        if ($field['type'] === 'select') {
            $options['attr']['class'] = 'select2';
            $options['attr']['data-placeholder'] = Arr::get($field, 'placeholder', '');
            $options['empty_value'] = $field['empty_value'] ?? 'Select a value';
            $options['choices'] = $field['choices'] ? (is_string($field['choices']) ? ($this->getCodeList($field['choices'])) : $field['choices']) : false;
            $options['default_value'] = $field['default'] ?? '';
            $options['attr']['disabled'] = (array_key_exists(
                'read_only',
                $field
            ) && $field['read_only'] == true) ? 'disabled' : false;

            $options['attr']['class'] = $this->getAttributeClasses($field, $options);
        }

        $this
            ->add(
                $field['name'],
                $field['type'],
                $options
            );
    }

    /**
     * Returns attribute class$options
     * Returns attribute class + 'cursor-not-allowed' (if read_only : true in json-schema).
     *
     * @param $field
     * @param $options
     *
     * @return string
     */
    public function getAttributeClasses($field, $options): string
    {
        $classWithCursorNotAllowed = $options['attr']['class'] . ' cursor-not-allowed';

        return (
            array_key_exists('read_only', $field) && $field['read_only'] == true
        ) ? $classWithCursorNotAllowed : $options['attr']['class'];
    }
}
