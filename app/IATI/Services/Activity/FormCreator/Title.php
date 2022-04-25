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
     * @param array $data
     * @param $activityId
     * @return $this
     * return activity title edit form.
     */
    public function editForm()
    {
        return $this->formBuilder->create(
            $this->formPath,
            [
            'method' => 'POST',
            'url' => '',
        ]
        );
    }
}
