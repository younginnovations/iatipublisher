<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ParticipatingOrganizationRepository
 * .
 */
class ParticipatingOrganizationRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * ParticipatingOrganizationRepository
     *  Constructor.
     *
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns participating organization data of an activity.
     *
     * @param $activityId
     *
     * @return array|null
     */
    public function getParticipatingOrganizationData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->participating_organization;
    }

    /**
     * Returns activity object.
     *
     * @param $id
     *
     * @return Model
     */
    public function getActivityData($id): Model
    {
        return $this->activity->findOrFail($id);
    }

    /**
     * Updates participating organization info.
     *
     * @param $participatingOrganization
     * @param $activity
     *
     * @return bool
     */
    public function update($participatingOrganization, $activity): bool
    {
        foreach ($participatingOrganization['participating_organization'] as $key => $participating_org) {
            $participatingOrganization['participating_organization'][$key]['narrative'] = array_values($participating_org['narrative']);
        }

        $activity->participating_organization = $participatingOrganization['participating_organization'];

        return $activity->save();
    }
}
