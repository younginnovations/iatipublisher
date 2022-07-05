<?php

declare(strict_types=1);

namespace App\IATI\Elements\Forms;

use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class WrapperCollectionForm.
 */
class WrapperCollectionForm extends Form
{
    /**
     * Builds wrapper collection form.
     *
     * @return mixed|void
     */
    public function buildForm(): void
    {
        $data = $this->getData();
        $this->setClientValidationEnabled(false);

        if (isset($data['attributes']) && $data['attributes']) {
            $attributes = $data['attributes'];

            foreach ($attributes as $attribute) {
                if (is_array($attribute)) {
                    $this->buildFields($attribute);
                }
            }
        }

        foreach ($data['sub_elements'] as $field) {
            if (count(Arr::get($field, 'sub_elements', []))) {
                $this->buildCollection($field);
            } else {
                $this->add(
                    $field['name'],
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
                            'wrapper'         => [
                                'class' => 'form-field-group form-child-body flex flex-wrap rounded-br-lg border-y border-r border-spring-50 p-6',
                            ],
                            'dynamic_wrapper' => [
                                'class' => (isset($field['add_more']) && $field['add_more']) ?
                                    (strtolower($field['name']) === 'narrative' && !Arr::get(
                                        $data,
                                        'attributes',
                                        null
                                    ) ? 'border-l border-spring-50 pb-11' : 'subelement rounded-tl-lg border-l border-spring-50 pb-11')
                                    : 'subelement rounded-tl-lg border-l border-spring-50 mb-6',
                            ],
                        ],
                    ]
                );

                $name = isset($field['name']) ? $field['name'] : $data['name'];

                if (isset($field['add_more']) && $field['add_more']) {
                    $this->add('add_to_collection_' . $name, 'button', [
                        'label' => 'Add More',
                        'attr'  => [
                            'class'     => 'add_to_collection add_more button relative -translate-y-1/2 pl-3.5 text-xs font-bold uppercase leading-normal text-spring-50 text-bluecoral',
                            'form_type' => $data['name'] . '_' . $field['name'],
                            'icon'      => true,
                        ],
                    ]);
                }
            }
        }
    }

    /**
     * Builds form field.
     *
     * @param $field
     *
     * @return void
     */
    public function buildFields($field): void
    {
        $options = [
            'label'       => $field['label'] ?? '',
            'help_block'  => [
                'text' => $field['help_text']['text'] ?? '',
            ],
            'hover_block' => [
                'title' => $field['label'],
                'text'  => $field['hover_text'] ?? '',
            ],
            'required'    => $field['required'],
            'multiple'    => $field['multiple'] ?? false,
            'attr'        => [
                'class' => 'form__input border-0',
            ],
            'wrapper'     => [
                'class' => 'form-field basis-6/12 max-w-half sub-attribute',
            ],
        ];

        if (array_key_exists('type', $field) && $field['type'] == 'select') {
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
    public function buildCollection($field): void
    {
        $element = $this->getData();

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
                    'wrapper'         => [
                        'class' => 'wrapped-child-body',
                    ],
                    'dynamic_wrapper' => [
                        'class' => (isset($field['add_more']) && $field['add_more']) ?
                            ((!Arr::get(
                                $element,
                                'attributes',
                                null
                            ) && strtolower($field['name']) === 'narrative') ? 'border-l border-spring-50 pb-11' : 'subelement rounded-tl-lg border-l border-spring-50 pb-11')
                            : ((!Arr::get(
                                $field,
                                'attributes',
                                null
                            ) && $field['sub_elements'] && isset($field['sub_elements']['narrative'])) ? 'subelement rounded-tl-lg mb-6' : 'subelement rounded-tl-lg border-l border-spring-50 mb-6'),
                    ],
                ],
            ]
        );

        if (isset($field['add_more']) && $field['add_more']) {
            $this->add('add_to_collection_' . $field['name'], 'button', [
                'label' => 'Add More',
                'attr'  => [
                    'class'     => 'add_to_collection add_more button relative -translate-y-1/2 pl-3.5 text-xs font-bold uppercase leading-normal text-spring-50 text-bluecoral ',
                    'form_type' =>  $field['name'],
                    'icon'      => true,
                ],
            ]);
        }
    }
}
