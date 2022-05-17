<?php

namespace App\IATI\Forms\Activity;

use App\IATI\Forms\BaseForm;
use Illuminate\Support\Arr;

class Title extends BaseForm
{
    public function buildForm()
    {
        $data = $this->getTitleContentsFromJson();

        $this
            ->addNarrative('narrative', Arr::get($data, 'sub-elements.narrative.label'), ['narrative_required' => Arr::get($data, 'sub-elements.narrative.required')]);
//            ->addAddMoreButton('add_title', $class);
    }

    public function getTitleContentsFromJson()
    {
        $data = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);

        return $data['title'];
    }
}
