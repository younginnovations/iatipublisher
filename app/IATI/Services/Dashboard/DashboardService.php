<?php

declare(strict_types=1);

namespace App\IATI\Services\Dashboard;

use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Repositories\Organization\OrganizationRepository;
use App\IATI\Repositories\User\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Arr;

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

    /**
     * Gets user count for user dashboard.
     *
     * @return array
     */
    public function getUserCounts(): array
    {
        $results = $this->userRepo->getUserCounts();

        $userCounts = [
            'general_users_count' => ['active' => 0, 'disabled' => 0],
            'admin_users_count'   => ['active' => 0, 'disabled' => 0],
            'iati_admins_count'   => ['active' => 0, 'disabled' => 0],
        ];

        foreach ($results as $result) {
            $status = $result->status ? 'active' : 'disabled';
            $count = $result->count;

            if ($result->role_id === 4) {
                $userCounts['general_users_count'][$status] = $count;
            } elseif ($result->role_id === 3) {
                $userCounts['admin_users_count'][$status] = $count;
            } elseif ($result->role_id === 2) {
                $userCounts['iati_admins_count'][$status] = $count;
            }
        }

        return $userCounts;
    }

    /**
     * Returns count of users registered today.
     * @param $countOnly
     *
     * @return array|mixed
     */
    public function getUsersRegisteredToday($countOnly): mixed
    {
        $data = $this->userRepo->getUsersCreatedToday($countOnly);

        if ($countOnly) {
            return ['user_count'=>$data];
        }

        return  $data;
    }

    /**
     * Returns count of users registered this week, grouped by day, formatted to named days [sunday, monday...].
     *
     * @return array
     */
    public function getUsersRegisteredThisWeek(): array
    {
        $carbon = new Carbon();
        $startDate = $carbon->now()->startOfWeek(0);
        $endDate = $carbon->now()->endOfWeek(6);
        $results = $this->userRepo->getDataInRangeGroupedByDay($startDate, $endDate);

        if ($results) {
            $formattedResults = [];
            $currentDate = $startDate;

            while ($currentDate <= $endDate) {
                $dateString = $currentDate->format('Y-m-d');
                $formattedDate = strtolower($carbon->parse($dateString)->format('l'));
                $formattedResults[$formattedDate] = Arr::get($results, $dateString, 0);
                $currentDate->addDay();
            }

            return $formattedResults;
        }

        return [];
    }

    /**
     * Returns count of users registered this week, grouped by days.
     *
     * @return array
     */
    public function getUsersRegisteredThisMonth(): array
    {
        $carbon = new Carbon();
        $startDate = $carbon->now()->startOfMonth();
        $endDate = $carbon->now()->endOfMonth();
        $results = $this->userRepo->getDataInRangeGroupedByDay($startDate, $endDate);

        if ($results) {
            $formattedResults = [];
            $currentDate = $startDate;

            while ($currentDate <= $endDate) {
                $dateString = $currentDate->format('Y-m-d');
                $formattedResults[$dateString] = Arr::get($results, $dateString, 0);
                $currentDate->addDay();
            }

            return $formattedResults;
        }

        return [];
    }

    /**
     * Returns count of users registered in [{today - 7 days} to today], grouped by day.
     *
     * @return array
     */
    public function getUsersRegisteredLast7Days(): array
    {
        $carbon = new Carbon();
        $startDate = $carbon->now()->subDays(6);
        $endDate = $carbon->now()->today()->endOfDay();
        $results = $this->userRepo->getDataInRangeGroupedByDay($startDate, $endDate);

        if ($results) {
            $formattedResults = [];
            $currentDate = $startDate;

            while ($currentDate <= $endDate) {
                $dateString = $currentDate->format('Y-m-d');
                $formattedResults[$dateString] = Arr::get($results, $dateString, 0);
                $currentDate->addDay();
            }

            return $formattedResults;
        }

        return [];
    }

    /**
     * Returns count of users registered this year, [Jan - today] grouped by month.
     *
     * @return array
     */
    public function getUsersRegisteredThisYear(): array
    {
        $carbon = new Carbon();
        $startDate = $carbon->now()->startOfYear();
        $endDate = $carbon->now()->endOfYear();
        $results = $this->getDataRegisteredInAYear($startDate, $endDate);

        if ($results) {
            return $this->formatMonthlyData($startDate, $endDate, $results);
        }

        return [];
    }

    /**
     * Returns count of users registered in [{current month - 6 months} to current month], grouped by month.
     *
     * @return array
     */
    public function getUsersRegisteredLast6Months(): array
    {
        $carbon = new Carbon();
        $startDate = $carbon->now()->startOfMonth()->subMonth(6);
        $endDate = $carbon->now()->endOfMonth()->today();
        $results = $this->userRepo->getDataInRangeGroupedByMonth($startDate, $endDate);

        if ($results) {
            return $this->formatMonthlyData($startDate, $endDate, $results);
        }

        return [];
    }

    /**
     * Returns count of users registered in [{current month - 12 months} to current month], grouped by month.
     *
     * @return array
     */
    public function getUsersRegisteredLast12Months(): array
    {
        $carbon = new Carbon();
        $startDate = $carbon->now()->startOfMonth()->subMonth(12);
        $endDate = $carbon->now()->endOfMonth()->today();
        $results = $this->userRepo->getDataInRangeGroupedByMonth($startDate, $endDate);

        if ($results) {
            return $this->formatMonthlyData($startDate, $endDate, $results);
        }

        return [];
    }

    /**
     * Utility function,
     * Use encase u want monthly grouped data between $startDate and $endDate
     * Example, for monthly data from 2019 to 2023, u could iterate over date and get monthly counts for each year.
     *
     * @param $startDate
     * @param $endDate
     *
     * @return array
     */
    public function getDataRegisteredInAYear($startDate, $endDate): array
    {
        return $this->userRepo->getDataInRangeGroupedByMonth($startDate, $endDate);
    }

    /**
     * Returns formatted data in such a way that there is no missing month from data.
     * Sets count to 0 for months that are not pulled from db.
     *
     * @param $startDate
     * @param $endDate
     * @param $results
     *
     * @return array
     */
    public function formatMonthlyData($startDate, $endDate, $results): array
    {
        $formattedResults = [];
        $currentDate = $startDate;

        while ($currentDate <= $endDate) {
            $monthStringComplete = $currentDate->format('Y-m-d H:i:s');
            $monthString = $currentDate->format('Y-m-d');
            $formattedResults[$monthString] = Arr::get($results, $monthStringComplete, 0);
            $currentDate->addMonth();
        }

        return $formattedResults;
    }

    public function getDataInFreeRange()
    {
    }
}
