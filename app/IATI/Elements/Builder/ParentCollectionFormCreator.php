<?php

declare(strict_types=1);

namespace App\IATI\Elements\Builder;

use App\IATI\Services\Setting\SettingService;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

/**
 * Class ParentCollectionFormCreator.
 */
class ParentCollectionFormCreator
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
     * @var SettingService
     */
    protected SettingService $settingService;

    /**
     * ParentCollectionFormCreator constructor.
     *
     * @param FormBuilder $formBuilder
     */
    public function __construct(FormBuilder $formBuilder, SettingService $settingService)
    {
        $this->formBuilder = $formBuilder;
        $this->settingService = $settingService;
    }

    /**
     * Returns activity title edit form.
     *
     * @param array $model
     * @param       $formData
     * @param       $method
     * @param       $parent_url
     *
     * @return Form
     */
    public function editForm(array $model, $formData, $method, string $parent_url, $overRideDefaultFieldValue = []): Form
    {
        $formData['overRideDefaultFieldValue'] = $overRideDefaultFieldValue;

        if (!empty($overRideDefaultFieldValue) && count($overRideDefaultFieldValue)) {
            $settingsDefaultValue = $this->settingService->getSetting()->default_values;
            $formData['overRideDefaultFieldValue'] = array_replace($settingsDefaultValue, $overRideDefaultFieldValue);
        }

        return $this->formBuilder->create(
            'App\IATI\Elements\Forms\ParentCollectionForm',
            [
                'method'                    => $method,
                'model'                     => $model,
                'url'                       => $this->url,
                'data'                      => $formData,
            ]
        )->add('buttons', 'buttongroup', [
            'wrapper' => [
                'class' => 'fixed left-0 bottom-0 w-full bg-eggshell py-5 pr-20 xl:pr-40 shadow-dropdown',
            ],
            'buttons' => [
                'clear'    => [
                    'label'     => 'Cancel',
                    'attr'      => [
                        'type'      => 'anchor',
                        'class'     => 'ghost-btn mr-8',
                        'href'      => $parent_url,
                    ],
                ],
                'submit'    => [
                    'label'     => 'Save and Exit',
                    'attr'      => [
                        'type'      => 'submit',
                        'class'     => 'primary-btn save-btn',
                    ],
                ],
            ],
        ]);
    }
}
