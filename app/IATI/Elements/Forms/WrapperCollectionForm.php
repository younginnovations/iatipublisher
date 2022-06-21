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

        foreach ($data['sub_elements'] as $field) {
            // dd(str_replace('[__NAME__]','',$this->getName()));
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
                            'class' => 'form-field-group form-child-body flex flex-wrap rounded-br-lg border-y border-r border-spring-50 p-6',
                        ],
                    ],
                ]
            )->add('add_to_collection', 'button', [
                'label' => sprintf('add more %s', Arr::get($field, 'name', '')),
                'attr' => [
                    'class' => 'add_to_collection add_more button relative -translate-y-1/2 pl-3.5 text-xs font-bold uppercase leading-normal text-spring-50 text-bluecoral',
                    'form_type' => $field['name'],
                    'icon' => true,
                ],
            ]);
        }
    }
}
