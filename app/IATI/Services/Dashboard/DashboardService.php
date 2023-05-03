<?php

declare(strict_types=1);

namespace App\IATI\Services\Dashboard;

use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Repositories\Organization\OrganizationRepository;
use App\IATI\Repositories\User\UserRepository;

/**
 * Class OrganizationService.
 */
class DashboardService
{
    /**
     * @var OrganizationRepository
     */
    private OrganizationRepository $organizationRepo;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepo;

    /**
     * @var ActivityRepository
     */
    private ActivityRepository $activityRepo;

    /**
     * UserService constructor.
     *
     * @param OrganizationRepository $organizationRepo
     * @param ActivityRepository $activityRepo
     * @param UserRepository $userRepo
     */
    public function __construct(OrganizationRepository $organizationRepo, ActivityRepository $activityRepo, UserRepository $userRepo)
    {
        $this->organizationRepo = $organizationRepo;
        $this->activityRepo = $activityRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * Returns array containing publisher stats.
     *
     * @param $queryParams
     *
     * @return array
     */
    public function getPublisherStats($queryParams): array
    {
        return $this->organizationRepo->getPublisherStats($queryParams);
    }

    /**
     * Returns array containing publisher type.
     *
     * @param $queryParams
     * @param $type
     *
     * @return array
     */
    public function getPublisherBy($queryParams, $type): array
    {
        return $this->organizationRepo->getPublisherBy($queryParams, $type);
    }

    public function getPublisherBySetup($queryParams): array
    {
        return $this->organizationRepo->getPublisherBySetup($queryParams);
    }

    public function getPublisherGroupedByDate($queryParams, $type)
    {
        return $this->organizationRepo->getPublisherGroupedByDate($queryParams, $type);
    }

    public function getActivityStats($queryParams)
    {
        return [
            'totalCount' => $this->activityRepo->all()->count(),
            'lastUpdatedPublisher' => $this->organizationRepo->getLastUpdatedPublisher(),
            'publisherWithoutActivity' => $this->organizationRepo->publisherWithoutActivity(),
        ];
    }
}
