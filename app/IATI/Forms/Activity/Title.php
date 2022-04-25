<?php

namespace App\IATI\Forms\Activity;

use App\IATI\Forms\BaseForm;
use Kris\LaravelFormBuilder\Field;

class Title extends BaseForm
{
    public function buildForm()
    {
        $this
            ->add('name', Field::TEXT, [
                'rules' => 'required|min:5',
            ])
            ->add('lyrics', Field::TEXTAREA, [
                'rules' => 'max:5000',
            ])
            ->add('publish', Field::CHECKBOX);
    }
}
