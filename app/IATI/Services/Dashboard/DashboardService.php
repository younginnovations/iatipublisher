<?php

declare(strict_types=1);

namespace App\IATI\Services\Dashboard;

use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Repositories\Organization\OrganizationRepository;
use App\IATI\Repositories\User\UserRepository;
use App\IATI\Traits\DateRangeResolverTrait;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Class OrganizationService.
 */
class DashboardService
{
    use DateRangeResolverTrait;

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
     * @return array
     */
    public function getPublisherStats(): array
    {
        $publisherStat = $this->organizationRepo->getPublisherStats();
        $publisherStat['lastRegisteredPublisher']['user_id'] = $this->userRepo->findBy('organization_id', $publisherStat['lastRegisteredPublisher']['id'])->first()->id;

        return $publisherStat;
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
            'lastUpdatedPublisher' => ($this->activityRepo->getLastUpdatedActivity())->organization->toArray(),
            'publisherWithoutActivity' => $this->organizationRepo->publisherWithoutActivity(),
        ];
    }

    /**
     * Gets user count for user dashboard.
     *
     * @return array
     */
    public function getUserCounts(): array
    {
        $results = $this->userRepo->getUserCounts();

        $userCounts = [
            'general_user' => ['active' => 0, 'disabled' => 0],
            'admin' => ['active' => 0, 'disabled' => 0],
            'iati_admin' => ['active' => 0, 'disabled' => 0],
        ];

        foreach ($results as $result) {
            $status = $result->status ? 'active' : 'disabled';
            $count = $result->count;

            if ($result->role_id === 4) {
                $userCounts['general_user'][$status] = $count;
            } elseif ($result->role_id === 3) {
                $userCounts['admin'][$status] = $count;
            } elseif ($result->role_id === 2) {
                $userCounts['iati_admin'][$status] = $count;
            }
        }

        return $userCounts;
    }

    /**
     * Returns data in range, grouped by (if param).
     *
     * @param $startDate
     * @param $endDate
     * @param string|false $groupBy
     * @param string $activeColumn
     *
     * @return Collection|array
     */
    public function getDataCountInRange($startDate, $endDate, bool|string $groupBy = false, string $activeColumn = 'created_at'): Collection|array
    {
        if ($groupBy) {
            if ($groupBy === 'days') {
                return $this->userRepo->getDataCountInRangeGroupedByDay($startDate, $endDate, $activeColumn);
            }

            return $this->userRepo->getDataCountInRangeGroupedByMonth($startDate, $endDate, $activeColumn);
        }

        return $this->userRepo->getBasicUserDataInRange($startDate, $endDate, $activeColumn);
    }

    /**
     * Returns user data for report download.
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     *
     * @return array|Collection
     */
    public function getUserDataForReportDownload(Carbon $startDate, Carbon $endDate): array|Collection
    {
        return $this->getDataCountInRange($startDate, $endDate);
    }

    public function getActivityCount($queryParams)
    {
        return $this->activityRepo->getActivityCount($queryParams);
    }

    public function getActivityStatus($queryParams)
    {
        $activityStatus = $this->activityRepo->getActivityStatus($queryParams);
        $processedStatus = [
            'Published' => 0,
            'Draft (Not Published)' => 0,
            'Draft (Need to republish)' => 0,
        ];

        foreach ($activityStatus as $status) {
            if ($status['status'] === 'published') {
                $processedStatus['Published'] = $status['count'];
            } elseif ($status['linked_to_iati'] === true) {
                $processedStatus['Draft (Not Published)'] = $status['count'];
            } else {
                $processedStatus['Draft (Need to republish)'] = $status['count'];
            }
        }

        return $processedStatus;
    }

    /**
     * Returns array containing publisher type.
     *
     * @param $queryParams
     * @param $type
     *
     * @return array
     */
    public function getActivityBy($queryParams, $type): array
    {
        $activityStatus = $this->activityRepo->getActivityBy($queryParams, $type);
        $processedStatus = [
            'By importing via CSV' => 0,
            'By importing via XML' => 0,
            'By importing via XLS' => 0,
            'Manually' => 0,
        ];

        foreach ($activityStatus as $type => $count) {
            switch ($type) {
                case 'manual':
                    $processedStatus['Manually'] = $count;
                    break;
                case 'xls':
                    $processedStatus['By importing via XLS'] = $count;
                    break;
                case 'xml':
                    $processedStatus['By importing via xml'] = $count;
                    break;
                case 'csv':
                    $processedStatus['By importing via CSV'] = $count;
                    break;
            }
        }

        return $processedStatus;
    }

    public function getAllActivitiesToDownload(): array
    {
        return $this->activityRepo->getActivitiesDashboardDownload();
    }

    public function getActivityCompleteness($queryParams): array
    {
        $activityCompleteness = $this->activityRepo->getCompleteStatus($queryParams);
        $processedCompleteness = [];

        foreach ($activityCompleteness as $status => $data) {
            $type = sprintf('Activities with %s core element data', $status);

            if (!empty($data)) {
                foreach ($data as $countArray) {
                    $processedCompleteness[$type][$countArray['status']] = $countArray['count'];
                }
            } else {
                $processedCompleteness[$type]['published'] = 0;
                $processedCompleteness[$type]['draft'] = 0;
            }
        }

        return $processedCompleteness;
    }

    public function getOrganizationToDownload(): array
    {
        return $this->organizationRepo->getOrganizationDashboardDownload();
    }

    /**
     * Returns data for user dashboard table component.
     *
     * @param int   $page
     * @param array $queryParams
     *
     * @return LengthAwarePaginator
     */
    public function getUserCountByOrganization(int $page, array $queryParams): LengthAwarePaginator
    {
        return $this->userRepo->getUserCountByOrganization($page, $queryParams);
    }
}
