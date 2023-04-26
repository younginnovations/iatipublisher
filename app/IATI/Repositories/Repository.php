<?php

declare(strict_types=1);

namespace App\IATI\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;

/**
 * Class Repository.
 */
abstract class Repository implements RepositoryInterface
{
    /**
     * @var Builder
     */
    protected mixed $model;

    /**
     * Repository constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->model = $this->makeModel($app);
    }

    /**
     * Get model name with namespace.
     *
     * @return string
     */
    abstract public function getModel(): string;

    /**
     * Get model.
     *
     * @param $app
     *
     * @return mixed
     */
    protected function makeModel($app): mixed
    {
        return $app->make($this->getModel());
    }

    /**
     * Get all resources.
     *
     * @param array $columns
     *
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    /**
     * Store newly created resource.
     *
     * @param array $data
     *
     * @return Model
     */
    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Store multiple data.
     *
     * @param array $data
     * @param $uniqueBy
     *
     * @return int
     */
    public function upsert(array $data, $uniqueBy): int
    {
        return $this->model->upsert($data, $uniqueBy);
    }

    /**
     * Update specific resource.
     *
     * @param array $data
     * @param       $id
     *
     * @return bool
     */
    public function update($id, array $data): bool
    {
        return $this->model->find($id)->update($data);
    }

    /**
     * Delete specific resource.
     *
     * @param $id
     *
     * @return bool
     */
    public function delete($id): bool
    {
        return (bool) $this->model->destroy($id);
    }

    /**
     * Delete multiple resource.
     *
     * @param $items
     *
     * @return int
     */
    public function deleteMany($items): int
    {
        return $this->model->destroy($items);
    }

    /**
     * Find specific resource.
     *
     * @param       $id
     * @param array $columns
     *
     * @return object|null
     */
    public function find($id, array $columns = ['*']): ?object
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * Find specific resource by given attribute.
     *
     * @param       $attribute
     * @param       $value
     * @param array $columns
     *
     * @return object
     */
    public function findBy($attribute, $value, array $columns = ['*']): object
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * Find specific all resource by given attribute.
     *
     * @param       $attribute
     * @param       $value
     * @param array $columns
     *
     * @return object
     */
    public function findAllBy($attribute, $value, array $columns = ['*']): object
    {
        return $this->model->where($attribute, '=', $value)->get($columns);
    }

    /**
     * Checks if specific resource exists.
     *
     * @param       $attribute
     * @param $value
     *
     * @return bool
     */
    public function exists($attribute, $value): bool
    {
        return $this->model->where($attribute, '=', $value)->exists();
    }

    /**
     * Insert one or multiple data and returns their id.
     *
     * @param       $data
     *
     * @return array
     */
    public function insertGetId($data): array
    {
        return $this->model->insertGetId($data, 'id');
    }

    /**
     * Returns count of data grouped by day/date.
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     *
     * @return array
     */
    public function getDataInRangeGroupedByDay(Carbon $startDate, Carbon $endDate): array
    {
        return $this->model->select(DB::raw('DATE(created_at) as date_string, COUNT(*) as count_value'))
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('count_value', 'date_string')
            ->toArray();
    }

    /**
     * Returns count of data grouped by month.
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     *
     * @return array
     */
    public function getDataInRangeGroupedByMonth(Carbon $startDate, Carbon $endDate): array
    {
        return $this->model
            ->select(DB::raw('DATE_TRUNC(\'month\', created_at) AS month_string, COUNT(*) AS count_value'))
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->groupBy('month_string')
            ->pluck('count_value', 'month_string')->toArray();
    }
}
