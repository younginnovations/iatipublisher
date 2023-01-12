<?php

declare(strict_types=1);

namespace App\IATI\Repositories\IatiApiLog;

use App\IATI\Models\IatiApiLog\IatiApiLog;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ApiLogRepository.
 */
class IatiApiLogRepository extends Repository
{
    /**
     * Get model name with namespace.
     *
     * @return string
     */
    public function getModel(): string
    {
        return IatiApiLog::class;
    }

    /**
     * Returns all filtered logs.
     *
     * @param $params
     *
     * @return Collection
     */
    public function getLogs($params) : Collection
    {
        // $page = $params['page']/$params['length'] + 1;
        // $take = $params['length'];
        // $skip = (intval($page) - 1) * $take;

        // $collection = $this->setFilterParameters($params);

        // return $collection->skip($skip)->take($take)->latest()->get();
        return $this->model->get();
    }

    /**
     * Returns total count of filtered logs.
     *
     * @param $params
     *
     * @return int
     */
    public function filteredLogCounts($params) : int
    {
        $collection = $this->setFilterParameters($params);

        return $collection->count();
    }

    /**
     * Returns total count of logs.
     *
     * @return int
     */
    public function countLogs() : int
    {
        return $this->model->count();
    }

    /**
     * Sets the filter criteria for logs.
     *
     * @param $params
     *
     * @return Builder
     */
    public function setFilterParameters($params)
    {
        $collection = $this->model;

        // if(isset($params['params']['method']) && $params['params']['method']){
        //     $collection = $collection->where('method',$params['params']['method']);
        // }

        // if(isset($params['params']['url']) && $params['params']['url']){
        //     $collection = $collection->where('url','like','%'.$params['params']['url'].'%');
        // }

        // if(isset($params['params']['called_at']) && $params['params']['called_at']){
        //     $collection = $collection->whereDate('updated_at',$params['params']['called_at']);
        // }

        return $collection;
    }
}
