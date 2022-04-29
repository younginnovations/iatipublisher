<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ActivityRepository.
 */
class ActivityRepository
{
    /**
     * @var Activity
     */
    protected $activity;

    /**
     * ActivityRepository Constructor.
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns all activities present in database.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllActivities(): Collection
    {
        return $this->activity->all();
    }

    /**
     * Creates activity.
     * @param $input
     * @param $organizationId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($input, $organizationId) : \Illuminate\Database\Eloquent\Model
    {
        $activity_identifier = [
            'activity_identifier' => $input['activity_identifier'],
            'iati_identifier_text' => $input['iati_identifier_text'],
        ];

        $activity_title = [
            [
                'narrative' => $input['narrative'],
                'language'  => $input['language'],
            ],
        ];

        return $this->activity->create([
            'identifier'    => $activity_identifier,
            'title'         => $activity_title,
            'org_id'        => $organizationId,
        ]);
    }

    /**
     * Returns activity identifiers used by an organization.
     * @param $organizationId
     * @return Collection
     */
    public function getActivityIdentifiersForOrganization($organizationId): Collection
    {
        return $this->activity->where('org_id', $organizationId)->get(['identifier']);
    }
}
