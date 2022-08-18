<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Period;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PeriodRepository.
 */
class PeriodRepository extends Repository
{
    /**
     * @return string
     */
    public function getModel(): string
    {
        return Period::class;
    }

    /**
     * Return specific indicator period.
     *
     * @param $indicatorId
     * @param $periodId
     *
     * @return Model
     */
    public function getIndicatorPeriod($indicatorId, $periodId): Model
    {
        return $this->model->where('id', $periodId)->where('indicator_id', $indicatorId)->first();
    }

    /**
     * Returns all period belonging to indicator id.
     *
     * @param int $indicatorId
     * @param int $page
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPaginatedPeriod($indicatorId, $page = 1): Collection | \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->model->where('indicator_id', $indicatorId)->orderBy('created_at', 'DESC')->paginate(10, ['*'], 'indicator', $page);
    }
}
