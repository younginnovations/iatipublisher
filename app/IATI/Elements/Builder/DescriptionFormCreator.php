<?php

declare(strict_types=1);

namespace App\IATI\Elements\Builder;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

class DescriptionFormCreator
{
    /**
     * @var string
     */
    public string $url;

    /**
     * @var FormBuilder
     */
    protected FormBuilder $formBuilder;

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
            'App\IATI\Elements\Forms\DescriptionCollectionForm',
            [
                'method' => 'PUT',
                'model'  => $model,
                'url'    => $this->url,
                'data'   => $formData,
            ]
        )->add('Save', 'submit', ['attr' => ['class' => ''], 'label' => 'Save'])
                                 ->add('Cancel', 'static', [
                                     'label' => false,
                                     'value' => 'Cancel',
                                     'attr'  => [
                                         'class' => '',
                                         'href'  => '',
                                     ],
                                 ]);
    }
}
