<?php

namespace App\IATI\Elements\Forms;

use Illuminate\Support\Arr;
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
     * @return mixed|void
     */
    public function buildForm()
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
