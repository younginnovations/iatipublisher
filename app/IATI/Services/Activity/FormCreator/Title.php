<?php

namespace App\IATI\Services\Activity\FormCreator;

use App\IATI\IatiActivity;
use Kris\LaravelFormBuilder\FormBuilder;

/**
 * Class Title
 * Contains function that return activity title edit form.
 */
class Title
{
    /**
     * @var FormBuilder
     */
    protected FormBuilder $formBuilder;

    /**
     * @var IatiActivity
     */
    protected IatiActivity $iatiActivity;

    /**
     * @var string
     */
    protected string $formPath;

    /**
     * @param FormBuilder $formBuilder
     */
    public function __construct(FormBuilder $formBuilder, IatiActivity $iatiActivity)
    {
        $this->formBuilder = $formBuilder;
        $this->iatiActivity = $iatiActivity;
        $this->formPath = $this->iatiActivity->getTitle()->getForm();
    }

    /**
     * Returns activity title edit form.
     *
     * @param array $data
     * @param       $activityId
     * @param       $formData
     *
     * @return \Kris\LaravelFormBuilder\Form
     */
    public function editForm(array $data, $activityId, $formData): \Kris\LaravelFormBuilder\Form
    {
        $model['narrative'] = $data;

        return $this->formBuilder->create(
            'App\IATI\Forms\BaseForm',
            [
                'method' => 'PUT',
                'model'  => $model,
                'url'    => route('admin.activities.title.update', [$activityId, 0]),
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
