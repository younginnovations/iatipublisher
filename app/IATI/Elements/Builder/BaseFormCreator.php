<?php

declare(strict_types=1);

namespace App\IATI\Elements\Builder;

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
     * @param       $formData
     * @param $method
     * @param $parent_url
     *
     * @return Form
     */
    public function editForm(array $model, $formData, $method, string $parent_url): Form
    {
        return $this->formBuilder->create(
            'App\IATI\Elements\Forms\BaseForm',
            [
                'method' => $method,
                'model'  => $model,
                'url'    => $this->url,
                'data'   => $formData,
            ]
        )

        ->add('buttons', 'buttongroup', [
            'wrapper' => [
                'class' => 'fixed left-0 bottom-0 w-full bg-eggshell py-5 pr-20 xl:pr-40 shadow-dropdown',
            ],
            'buttons' => [
                'clear'    => [
                    'label'     => translateButton('cancel'),
                    'attr'      => [
                        'type'      => 'anchor',
                        'class'     => 'ghost-btn mr-8',
                        'href' => $parent_url,
                    ],
                ],

                'submit'    => [
                    'label'     => translateButton('save_and_exit'),
                    'attr'      => [
                        'type'      => 'submit',
                        'class'     => 'primary-btn save-btn',
                    ],
                ],
            ],
            ]);
    }
}
