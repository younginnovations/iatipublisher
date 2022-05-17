<?php

namespace App\IATI\Forms\Activity;

use App\IATI\Forms\BaseForm;

class Narrative extends BaseForm
{
    protected $showFieldErrors = true;

    /**
     * builds the narrative form.
     *
     * default help-text for narrative and languages can be changed by
     * adding 'addData' before adding Narrative
     * with keys 'help-text-narrative' and 'help-text-language' respectively
     */
    public function buildForm()
    {
        $this
            ->add(
                'narrative',
                'textarea',
                [
                    'label'      => $this->getData('label'),
                    'help_block' => $this->addHelpText('help block'),
                    'attr'       => ['rows' => 4],
                    'required'   => $this->getData('narrative_required'),
                ]
            )
            ->addLanguage();
    }
}
