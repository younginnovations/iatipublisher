<?php

namespace App\IATI\Elements\Forms;

use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class SubElementForm.
 */
class SubElementForm extends Form
{
    /**
     * Builds subelement form.
     *
     * @return mixed|void
     */
    public function buildForm():void
    {
        $data = $this->getData();
        if (Arr::get($data, 'type', null)) {
            $this->buildFields($this->getData());
        }

        if (isset($data['attributes'])) {
            $attributes = $data['attributes'];

            foreach ($attributes as $attribute) {
                if (is_array($attribute)) {
                    $this->buildFields($attribute);
                }
            }
        }

        $this->add('delete', 'button', [
            'attr' => [
                'class' => 'delete delete-item absolute right-0 top-2/4 -translate-y-1/2 translate-x-1/2',
            ],
        ]);
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
            'label' => $field['label'] ?? '',
            'help_block' => [
                'text' => $field['help_text']['text'] ?? '',
            ],
            'hover_block' => [
                'title' => $field['label'],
                'text' => $field['hover_text'] ?? '',
            ],
            'required' => $field['required'],
            'multiple' => $field['multiple'] ?? false,
            'attr' => [
                'class' => 'form__input border-0',
            ],
            'wrapper' => [
                'class' => 'form-field basis-6/12 max-w-half',
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
}
