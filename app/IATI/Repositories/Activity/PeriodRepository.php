<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Period;
use App\IATI\Repositories\Repository;
use App\IATI\Traits\FillDefaultValuesTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class PeriodRepository.
 */
class PeriodRepository extends Repository
{
    use FillDefaultValuesTrait;

    /**
     * @return string
     */
    public function getModel(): string
    {
        return Period::class;
    }

    /**
     * Returns all period belonging to indicator id.
     *
     * @param int $indicatorId
     * @param int $page
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getPaginatedPeriod(int $indicatorId, int $page = 1): Collection |LengthAwarePaginator
    {
        return $this->model->where('indicator_id', $indicatorId)->orderBy('created_at', 'DESC')->paginate(10, ['*'], 'indicator', $page);
    }

    /**
     * Returns specific period for specific indicator.
     *
     * @param int $indicatorId
     * @param int $id
     *
     * @return mixed
     */
    public function getIndicatorPeriod(int $indicatorId, int $id): mixed
    {
        return $this->model->where(['indicator_id'=>$indicatorId, 'id'=>$id])->first();
    }
}
