<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Traits;

use App\Models\CustomVocab;
use Illuminate\Contracts\Container\BindingResolutionException;

trait SectorQueries
{
    /**
     * Returns custom vocabs.
     *
     * @param $orgId
     *
     * @return mixed
     * @throws BindingResolutionException
     */
    protected function customVocabs($orgId): mixed
    {
        return app()->make(CustomVocab::class)
                    ->query()
                    ->where('org_id', '=', $orgId)
                    ->where('vocabulary_type', '=', 'sector')
                    ->first(['vocab_data'])['vocab_data'];
    }
}
