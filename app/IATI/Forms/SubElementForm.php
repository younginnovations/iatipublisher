<?php

namespace App\IATI\Forms;

use Kris\LaravelFormBuilder\Form;

class SubElementForm extends Form
{
    /**
     * @param $field
     *
     * @return void
     */
    public function buildFields($field): void
    {
        $options = [
            'label'         => $field['label'] ?? 'Label',
            'required'      => $field['required'] ?? false,
            'multiple'      => $field['multiple'] ?? false,
        ];

        if ($field['type'] == 'select') {
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
    }
}
