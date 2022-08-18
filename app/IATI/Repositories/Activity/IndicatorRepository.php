<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Indicator;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IndicatorRepository.
 */
class IndicatorRepository extends Repository
{
    /**
     * @return string
     */
    public function getModel(): string
    {
        return Indicator::class;
    }

    /**
     * Return Activity Result Indicators.
     *
     * @param $resultId
     * @return Collection
     */
    public function getResultIndicators($resultId): Collection
    {
        return $this->model->where('result_id', $resultId)->get()->sortByDesc('updated_at');
    }

    /**
     * Return specific result indicator.
     *
     * @param $resultId
     * @param $resultIndicatorId
     *
     * @return Model|null
     */
    public function getResultIndicator($resultId, $resultIndicatorId): ?Model
    {
        return $this->model->where('id', $resultIndicatorId)->where('result_id', $resultId)->first();
    }

    /**
     * Returns all indicator belonging to resultId.
     *
     * @param int $resultId
     * @param int $page
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPaginatedIndicator($resultId, $page = 1): Collection | \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->model->where('result_id', $resultId)->orderBy('created_at', 'DESC')->paginate(10, ['*'], 'indicator', $page);
    }
}
