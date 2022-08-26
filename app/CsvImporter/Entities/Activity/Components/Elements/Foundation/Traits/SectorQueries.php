<?php

namespace App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Traits;

use App\Models\CustomVocab;

trait SectorQueries
{
    protected function customVocabs($orgId)
    {
        return app()->make(CustomVocab::class)
                    ->query()
                    ->where('org_id', '=', $orgId)
                    ->where('vocabulary_type', '=', 'sector')
                    ->first(['vocab_data'])['vocab_data'];
    }
}
