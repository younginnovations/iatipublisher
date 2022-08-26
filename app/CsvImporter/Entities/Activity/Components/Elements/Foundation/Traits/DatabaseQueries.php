<?php

namespace App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Traits;

use App\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

/**
 * Class DatabaseQueries.
 */
trait DatabaseQueries
{
    /**
     * Get all Activity Identifiers present until now.
     * @return array
     */
    protected function activityIdentifiers()
    {
        $identifiers = [];

        foreach ($this->activities() as $activity) {
            $identifiers[] = Arr::get($activity->identifier, 'activity_identifier');
        }

        return $identifiers;
    }

    /**
     * Get all the Activities.
     * @return Collection
     */
    protected function activities()
    {
        return app()->make(Activity::class)->query()->where('organization_id', '=', $this->organizationId)->get(['identifier']);
    }
}
