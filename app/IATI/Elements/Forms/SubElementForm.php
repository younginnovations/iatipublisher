<?php

namespace App\IATI\Elements\Forms;

use Kris\LaravelFormBuilder\Form;

class SubElementForm extends Form
{
    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $data = $this->getData();
        $this->buildFields($this->getData());

        if (isset($data['attributes'])) {
            $attributes = $data['attributes'];
            foreach ($attributes as $attribute) {
                $this->buildFields($attribute);
            }
        }

        $this->add('delete', 'button', [
            'attr' => [
                'class' => 'delete delete-item',
            ],
        ]);
    }

    /**
     * @param $field
     *
     * @return void
     */
    public function buildFields($field): void
    {
        $options = [
            'label' => $field['label'] ?? 'Label',
            'help_block' => [
                'text' => $field['help_text']['text'] ?? '',
            ],
            'hover_block' => [
                'title' => $field['label'],
                'text' => $field['hover_text'] ?? '',
            ],
            'label' => $field['label'] ?? '',
            'required' => false,
            'multiple' => $field['multiple'] ?? false,
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
            $options['choices'] = $field['choices'] ?? false;
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
