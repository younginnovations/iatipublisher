<?php

declare(strict_types=1);

namespace App\IATI\Elements\Builder;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

/**
 * Class MultilevelSubElementFormCreator.
 */
class MultilevelSubElementFormCreator
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
     * MultilevelSubElementFormCreator constructor.
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
     *
     * @return Form
     */
    public function editForm(array $model, $formData): Form
    {
        return $this->formBuilder->create(
            'App\IATI\Elements\Forms\MultilevelSubElementForm',
            [
                'method' => 'PUT',
                'model'  => $model,
                'url'    => $this->url,
                'data'   => $formData,
            ]
        )->add('buttons', 'buttongroup', [
            'wrapper' => [
                'class' => 'fixed left-0 bottom-0 w-full bg-eggshell py-5 pr-40 shadow-dropdown z-50',
            ],
            'buttons' => [
                'clear'    => [
                    'label'     => 'Cancel',
                    'attr'      => [
                        'type'      => 'clear',
                        'class'     => 'ghost-btn mr-8',
                    ],
                ],

                'submit'    => [
                    'label'     => 'Save Publishing Setting',
                    'attr'      => [
                        'type'      => 'submit',
                        'class'     => 'primary-btn save-btn',
                    ],
                ],
            ],
        ]);
    }
}
