<?php

namespace App\IATI\Forms;

use Kris\LaravelFormBuilder\Form;

/**
 * Class BaseForm.
 */
class BaseForm extends Form
{
    protected $narrativeClass = ['narrative', 'title'];

    /**
     * Set model to form object.
     *
     * @param mixed $model
     * @return BaseForm
     */
    public function setupModel($model)
    {
        parent::setupModel($model);
        $oldData = old();
        $this->model = $oldData ? $oldData : $model;
    }

    /**
     * @param        $className
     * @param string $label
     * @param array  $data
     * @return BaseForm
     */
    protected function addNarrative($className, $label = 'Text', $data = [])
    {
        $label = ($label == 'Text') ? 'Text' : $label;

        $data['label'] = $label;
        $oldData = old();
        $data['model'] = $oldData ? $oldData : null;

        return $this->addCollection('narrative', 'Activity\Narrative', $className, $data, 'Narrative');
    }

    /**
     * @param       $name
     * @param array $choices
     * @param null  $label
     * @param null  $helpText
     * @param null  $defaultValue
     * @param bool  $required
     * @param array $customOptions
     * @return $this
     */
    protected function addSelect(
        $name,
        array $choices,
        $label = null,
        $helpText = [],
        $defaultValue = null,
        $required = false,
        $customOptions = []
    ) {
        $options = [
            'choices'       => $choices,
            'label'         => $label,
            'empty_value'   => 'Select a value',
            'default_value' => $defaultValue,
            'help_block'    => $helpText,
            'required'      => $required,
        ];

        $options = array_merge($options, $customOptions);

        return $this->add(
            $name,
            'select',
            $options
        );
    }

    /**
     * @param        $name
     * @param        $file
     * @param string $class
     * @param array  $data
     * @param bool   $label
     * @return $this
     */
    public function addCollection($name, $file, $class = '', array $data = [], $label = null)
    {
        $class .= ($class ? ' has_add_more' : '');
        $filePath = sprintf('App\IATI\Forms\%s', $file);
        $FormClass = !class_exists($filePath) ? sprintf(
            'App\IATI\Forms\%s',
            $file
        ) : $filePath;

        return $this->add(
            $name,
            'collection',
            [
                'type'    => 'form',
                'options' => [
                    'class' => $FormClass,
                    'data'  => $data,
                    'label' => false,
                ],
                'label'   => $label,
                'wrapper' => [
                    'class' => sprintf('collection_form custom-collection %s', $class),
                ],
            ]
        );
    }

    /**
     * add help text in the form fields.
     * @param      $helpText
     * @return array
     */
    protected function addHelpText($helpText, $tooltip = true)
    {
//        $help = trans(session()->get('version') . "/help");
//        is_array($help) ?: $help = trans(config('app.default_version_name') . '/help');
//        if (!isset($help[$helpText])) {
//            return null;
//        }
//
        $attr = [
            'class' => 'text-gray-50 text-xs font-normal block mt-3',
        ];
//
//        if ($tooltip) {
//            $attr = array_merge(
//                $attr,
//                [
//                    'class'          => 'help-text',
//                    'title'          => htmlspecialchars($help[$helpText]),
//                    'data-toggle'    => 'tooltip',
//                    'data-html'      => 'true',
//                    'data-placement' => 'top',
//                ]
//            );
//        }

        return ['text' => $helpText, 'tag' => 'span', 'attr' => $attr];
    }

    protected function addLanguage()
    {
        $this->addSelect(
            'language',
            [
                'aa'    => 'aa - Afar',
                'en'    => 'en - English',
            ],
            'Language',
            $this->addHelpText('Select a language'),
            null,
            null,
        );
//        $this->addRemoveThisButton('remove_from_collection');
    }
}
