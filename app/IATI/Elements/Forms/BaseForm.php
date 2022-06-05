<?php

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
//        if (!Arr::get($field, 'type', null) && array_key_exists('sub_elements', $field)) {
//            foreach (Arr::get($field, 'sub_elements') as $subElement) {
//                $this->buildCollection($subElement);
//            }
//        } else {
//            $this->add(
//                $field['name'],
//                'collection',
//                [
//                    'type'    => 'form',
//                    'property' => 'name',
//                    'prototype' => true,
//                    'prototype_name' => '__NAME__',
//                    'options' => [
//                        'class' => 'App\IATI\Elements\Forms\SubElementForm',
//                        'data'  => $field,
//                        'label' => false,
//                        'wrapper' => [
//                            'class' => 'form-child-body form-field-group flex flex-wrap',
//                        ],
//                    ],
//                ]
//            )->add('add_to_collection', 'button', [
//                'label' => 'Add More',
//                'attr' => [
//                    'class' => 'add_to_collection button relative font-bold text-n-40 text-bluecoral text-xs uppercase leading-normal mt-2 space-x-2',
//                ],
//            ]);
//        }

        if (!Arr::get($field, 'type', null) && array_key_exists('sub_elements', $field)) {
            $this->add(
                $field['name'],
                'collection',
                [
                    'type'    => 'form',
                    'property' => 'name',
                    'prototype' => true,
                    'prototype_name' => '__NAME__',
                    'options' => [
                        'class' => 'App\IATI\Elements\Forms\WrapperCollectionForm',
                        'data'  => $field,
                        'label' => false,
                        'wrapper' => [
                            'class' => 'form-child-body form-field-group flex flex-wrap',
                        ],
                    ],
                ]
            );
        } else {
            $this->add(
                $field['name'],
                'collection',
                [
                    'type'    => 'form',
                    'property' => 'name',
                    'prototype' => true,
                    'prototype_name' => '__NAME__',
                    'options' => [
                        'class' => 'App\IATI\Elements\Forms\SubElementForm',
                        'data'  => $field,
                        'label' => false,
                        'wrapper' => [
                            'class' => 'form-child-body form-field-group flex flex-wrap',
                        ],
                    ],
                ]
            )->add('add_to_collection', 'button', [
                'label' => 'Add More',
                'attr' => [
                    'class' => 'add_to_collection button relative font-bold text-n-40 text-bluecoral text-xs uppercase leading-normal mt-2 space-x-2',
                ],
            ]);
        }
    }

    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $element = $this->getData();
        $attributes = Arr::get($element, 'attributes', null);
        $sub_elements = Arr::get($element, 'sub_elements', null);

        if ($attributes) {
            if (Arr::get($element, 'add_more', false) && !$sub_elements) {
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
            foreach ($sub_elements as $sub_element) {
                $this->buildCollection($sub_element);

                if (Arr::get($element, 'add_more', false)) {
                    $this->add('delete', 'button', [
                        'attr' => [
                            'class' => 'delete-parent delete-item',
                        ],
                    ]);
                }
            }
        }
    }

    /**
     * Return codeList array from json codeList.
     * @param string $filePath
     * @param bool $code
     * @return array
     */
    public function getCodeList(string $filePath, bool $code = true): array
    {
        $filePath = app_path("Data/$filePath");
        $codeListFromFile = file_get_contents($filePath);
        $codeLists = json_decode($codeListFromFile, true);
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
     */
    public function buildField($field): void
    {
        $options = [
            'help_block' => [
                'text' => $field['help_text']['text'] ?? '',
            ],
            'hover_block' => [
                'title' => $field['label'],
                'text' => $field['hover_text'] ?? '',
            ],
            'label'         => $field['label'] ?? '',
            'required'      => $field['required'] ?? false,
            'multiple'      => $field['multiple'] ?? false,
            'attr' => [
                'class' => 'form__input border-0',
            ],
            'wrapper' => [
                'class' => 'form-field basis-6/12 max-w-half',
            ],
        ];

        if ($field['type'] == 'select') {
            $options['attr']['class'] = 'select2';
            $options['empty_value'] = $field['empty_value'] ?? 'Select a value';
            $options['choices'] = $field['choices'] ? (is_string($field['choices']) ? ($this->getCodeList($field['choices'])) : $field['choices']) : false;
            $options['default_value'] = $field['default'] ?? false;
        }

        $this
            ->add(
                $field['name'],
                $field['type'],
                $options
            );
    }
}
