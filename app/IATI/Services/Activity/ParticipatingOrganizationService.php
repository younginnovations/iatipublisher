<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ParticipatingOrganizationRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class participatingOrganization
 *Service.
 */
class ParticipatingOrganizationService
{
    use XmlBaseElement;

    /**
     * @var ParticipatingOrganizationRepository
     */
    protected ParticipatingOrganizationRepository $participatingOrganizationRepository;

    /**
     * ParticipatingOrganizationService constructor.
     *
     * @param ParticipatingOrganizationRepository $participatingOrganizationRepository
     */
    public function __construct(ParticipatingOrganizationRepository $participatingOrganizationRepository)
    {
        $this->participatingOrganizationRepo = $participatingOrganizationRepository;
    }

    /**
     * Returns participating organization data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getParticipatingOrganizationData(int $activity_id): ?array
    {
        return $this->participatingOrganizationRepo->getParticipatingOrganizationData($activity_id);
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
        return $this->participatingOrganizationRepo->getActivityData($id);
    }

    /**
     * Updates activity participating organization.
     *
     * @param $participatingOrganization
     * @param $activity
     *
     * @return bool
     */
    public function update($participatingOrganization, $activity): bool
    {
        return $this->participatingOrganizationRepo->update($participatingOrganization, $activity);
    }

    /**
     * Returns data in required xml array format.
     *
     * @param Activity $activity
     *
     * @return array
     */
    public function getXmlData(Activity $activity): array
    {
        $activityData = [];
        $participatingOrganizations = (array) $activity->participating_organization;

        if (count($participatingOrganizations)) {
            foreach ($participatingOrganizations as $participatingOrganization) {
                $activityData[] = [
                    '@attributes' => [
                        'ref'         => Arr::get($participatingOrganization, 'ref', null),
                        'type'        => Arr::get($participatingOrganization, 'type', null),
                        'role'        => Arr::get($participatingOrganization, 'organization_role', null),
                        'activity-id' => Arr::get($participatingOrganization, 'identifier', null),
                        'crs-channel-code' => Arr::get($participatingOrganization, 'crs_channel_code', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($participatingOrganization, 'narrative', [])),
                ];
            }
        }

        return $activityData;
    }
}
