<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Indicator;
use App\IATI\Repositories\Repository;
use App\IATI\Traits\FillDefaultValuesTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class IndicatorRepository.
 */
class IndicatorRepository extends Repository
{
    use FillDefaultValuesTrait;

    /**
     * @return string
     */
    public function getModel(): string
    {
        return Indicator::class;
    }

    /**
     * Returns all indicator belonging to resultId.
     *
     * @param int $resultId
     * @param int $page
     *
     * @return LengthAwarePaginator
     */
    public function getPaginatedIndicator(int $resultId, int $page = 1): LengthAwarePaginator
    {
        return $this->model->where('result_id', $resultId)->orderBy('created_at', 'DESC')->paginate(10, ['*'], 'indicator', $page);
    }

    /**
     * Return Activity Result Indicators.
     *
     * @param $resultId
     *
     * @return Collection
     */
    public function getResultIndicators($resultId): Collection
    {
        return $this->model->where('result_id', $resultId)->get()->sortByDesc('updated_at');
    }

    /**
     * Returns specific indicator for specific result.
     *
     * @param int $resultId
     * @param int $id
     *
     * @return mixed
     */
    public function getResultIndicator(int $resultId, int $id): mixed
    {
        return $this->model->where(['result_id'=>$resultId, 'id'=>$id])->first();
    }
}
