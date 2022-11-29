<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Traits;

use App\IATI\Models\Activity\Activity;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

/**
 * Class DatabaseQueries.
 */
trait DatabaseQueries
{
    /**
     * Get all Activity Identifiers present until now.
     *
     * @return array
     * @throws BindingResolutionException
     */
    protected function activityIdentifiers(): array
    {
        $identifiers = [];

        foreach ($this->activities() as $activity) {
            $identifiers[] = Arr::get($activity->identifier, 'activity_identifier');
        }

        return $identifiers;
    }

    /**
     * Get all the Activities.
     *
     * @return Collection
     * @throws BindingResolutionException
     */
    protected function activities(): Collection
    {
        return app()->make(Activity::class)->query()->where('org_id', '=', $this->organizationId)->get(['iati_identifier']);
    }
}
