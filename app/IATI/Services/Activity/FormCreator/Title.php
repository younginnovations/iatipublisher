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
    protected $formBuilder;

    /**
     * @var IatiActivity
     */
    protected $iatiActivity;

    /**
     * @var string
     */
    protected $formPath;

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
     * @param array $data
     * @param $activityId
     * @return $this
     */
    public function editForm($data, $activityId)
    {
        $model['narrative'] = $data;

        return $this->formBuilder->create(
            $this->formPath,
            [
            'method'    => 'PUT',
            'model'     => $model,
            'url'       => route('admin.activities.title.update', [$activityId, 0]),
            ]
        )->add('Save', 'submit', ['attr' => ['class' => ''], 'label' => 'Save'])
         ->add('Cancel', 'static', [
             'label' => false,
             'value' => 'Cancel',
             'attr'    => [
                 'class' => '',
                 'href'  => '',
             ],
         ]);
    }
}
