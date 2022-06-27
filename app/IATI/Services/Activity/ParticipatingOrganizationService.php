<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\ParticipatingOrganizationRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class participatingOrganization
 *Service.
 */
class ParticipatingOrganizationService
{
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
}
