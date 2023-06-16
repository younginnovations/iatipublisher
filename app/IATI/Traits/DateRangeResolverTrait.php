<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/*
 * Class DateRangeResolverTrait.
 */
trait DateRangeResolverTrait
{
    /**
     * Returns date range related params from request.
     *
     * @param $request
     *
     * @return array
     */
    public function resolveDateRangeFromRequest($request): array
    {
        $fixed = $request->get('fixed') ?? false;
        $startDateString = $request->get('start_date') ?? false;
        $endDateString = $request->get('end_date') ?? false;
        $column = $request->get('date_type') ?? 'created_at';
        $count = $request->get('count_only') ?? false;

        return [$fixed, $startDateString, $endDateString, $column, $count];
    }

    /**
     * Returns [(object)startDate, (object)endDate and (string)groupBy].
     *
     * @param string $fixedTimeRange
     *
     * @return array
     */
    public function resolveFixedRangeParams(string $fixedTimeRange): array
    {
        $carbon = new Carbon();
        $groupBy = 'days';

        switch ($fixedTimeRange) {
            case 'this_week':
                $startDate = $carbon->now()->startOfWeek(0);
                $endDate = $carbon->now()->endOfWeek(6);
                break;
            case 'this_month':
                $startDate = $carbon->now()->startOfMonth();
                $endDate = $carbon->now()->endOfMonth();
                $groupBy = 'month';
                break;
            case 'this_year':
                $startDate = $carbon->now()->startOfYear();
                $endDate = $carbon->now()->endOfYear();
                $groupBy = 'month';
                break;
            case Str::contains($fixedTimeRange, 'last'):
                $exploded = explode('_', $fixedTimeRange);
                $time = Arr::get($exploded, 1, 7);
                $unit = Arr::get($exploded, 2, 'days');
                $startDate = $carbon->now()->sub($unit, $time)->startOf($unit);
                $endDate = $carbon->now()->endOf($unit);
                $groupBy = ($unit === 'days' || $unit === 'day') ? 'days' : 'month';
                break;
            default:
                $startDate = $carbon->now()->today()->startOfDay();
                $endDate = $carbon->now()->today()->endOfDay();
                break;
        }

        return [$startDate, $endDate, $groupBy];
    }

    /**
     * Returns [(object)startDate, (object)endDate and (string)groupBy].
     *
     * @param string $startDateString
     * @param string $endDateString
     *
     * @return array
     */
    public function resolveCustomRangeParams(string $startDateString, string $endDateString): array
    {
        $carbon = new Carbon();
        $startDate = $carbon->parse($startDateString);
        $endDateString = $carbon->parse($endDateString);

        return [$startDate, $endDateString, 'days'];
    }

    /**
     * Returns formatted data in a way that there is no missing days/month between date-range.
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param $unformattedResults
     *
     * @return array
     */
    public function fillDataToMissingDates(Carbon $startDate, Carbon $endDate, $unformattedResults): array
    {
        $interval = $startDate->diff($endDate);
        $intervalYear = $interval->y;
        $intervalMonth = $interval->m;

        if ($intervalYear || $intervalMonth > 1) {
            $results = $this->fillMissingMonthToData($startDate->startOfMonth(), $endDate->startOfMonth(), $unformattedResults);
        } else {
            $results = $this->fillMissingDaysToData($startDate, $endDate, $unformattedResults);
        }

        return $results;
    }

    /**
     * Sets count to 0 for months that are missing.
     *
     * @param $startDate
     * @param $endDate
     * @param $results
     *
     * @return array
     */
    public function fillMissingMonthToData($startDate, $endDate, $results): array
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

    /**
     * Sets count to 0 for days that are missing.
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param array $results
     * @return array
     */
    public function fillMissingDaysToData(Carbon $startDate, Carbon $endDate, array $results): array
    {
        $formattedResults = [];
        $currentDate = $startDate;

        while ($currentDate <= $endDate) {
            $dateString = $currentDate->format('Y-m-d');
            $formattedResults[$dateString] = Arr::get($results, $dateString, 0);
            $currentDate->addDay();
        }

        return $formattedResults;
    }
}
