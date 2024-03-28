<?php

declare(strict_types=1);

namespace App\IATI\Elements\Builder;

use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

/**
 * Class BaseFormCreator.
 */
class BaseFormCreator
{
    /**
     * @var string
     */
    public string $url;

    /**
     * @var FormBuilder
     */
    protected FormBuilder $formBuilder;

    /**
     * BaseFormCreator constructor.
     *
     * @param FormBuilder $formBuilder
     */
    public function __construct(FormBuilder $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    /**
     * Returns activity title edit form.
     *
     * @param array $model
     * @param $formData
     * @param $method
     * @param string $parent_url
     * @param bool $showCancelOrSaveButton
     * @param array $additonalInfo
     *
     * @return Form
     */
    public function editForm(array $model, $formData, $method, string $parent_url, bool $showCancelOrSaveButton = true, array $additonalInfo = []): Form
    {
        $form = $this->formBuilder->create(
            'App\IATI\Elements\Forms\BaseForm',
            [
                'method' => $method,
                'model'  => $model,
                'url'    => $this->url,
                'data'   => $formData,
                'id'     => empty($additonalInfo) ? '' : Arr::get($additonalInfo, 'formId'),
            ]
        );

        if ($showCancelOrSaveButton) {
            $form->add('buttons', 'buttongroup', [
                'wrapper' => [
                    'class' => 'fixed left-0 bottom-0 w-full bg-eggshell py-5 pr-20 xl:pr-40 shadow-dropdown',
                ],
                'buttons' => [
                    'clear'    => [
                        'label'     => 'Cancel',
                        'attr'      => [
                            'type'  => 'anchor',
                            'class' => 'ghost-btn mr-8',
                            'href'  => $parent_url,
                        ],
                    ],

                    'submit'    => [
                        'label'     => 'Save and Exit',
                        'attr'      => [
                            'type'  => empty($additonalInfo) ? 'submit' : 'button',
                            'class' => 'primary-btn save-btn',
                            'id'    => empty($additonalInfo) ? '' : Arr::get($additonalInfo, 'submitId'),
                        ],
                    ],
                ],
            ]);
        }

        return $form;
    }
}
