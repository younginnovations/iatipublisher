<?php

declare(strict_types=1);

namespace App\IATI\Services\IatiApiLog;

use App\IATI\Repositories\IatiApiLog\IatiApiLogRepository;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ApiLogService.
 */
class IatiApiLogService
{
    /**
     * @var iatiApiLogRepository
     */
    private $iatiApiLogRepo;

    /**
     * @var DatabaseManager
     */
    private $db;

    /**
     * ApiLogService constructor.
     *
     * @param iatiApiLogRepository $iatiApiLogRepo
     * @param DatabaseManager  $db
     */
    public function __construct(IatiApiLogRepository $iatiApiLogRepo, DatabaseManager $db)
    {
        $this->iatiApiLogRepo = $iatiApiLogRepo;
        $this->db = $db;
    }

    /**
     * Returns all logs.
     *
     * @return Collection
     */
    public function getAllApiLogs(): Collection
    {
        return $this->iatiApiLogRepo->all();
    }

    /**
     * @param array $postData
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function save(array $postData): Model
    {
        return $this->iatiApiLogRepo->store($postData);
    }

    /**
     * Returns array of paginated filtered log, filtered log total count and total log counts.
     *
     * @param $params
     *
     * @return array
     */
    public function getFilteredlog($params): array
    {
        $query_params = [];
        // $query_params['page']   = $params['start'];
        // $query_params['length'] = $params['length'];
        // $query_params['params'] = $params['params'];

        $count = $this->iatiApiLogRepo->countLogs();
        $logs = $this->iatiApiLogRepo->getLogs($query_params);
        $filteredCount = $this->iatiApiLogRepo->filteredLogCounts($query_params);
        $apiLogData = [];
        $method = trans('api.method_types');

        foreach ($logs as $key => $value) {
            $nestedData = [];
            $nestedData['method'] = isset($method[$value['method']]) ? $method[$value['method']] : '';
            $nestedData['api'] = trans('api.api_alias.' . parse_url($value['url'])['path']);
            $nestedData['url'] = $value['url'];
            $nestedData['request'] = $value['request'];
            $nestedData['response'] = $value['response'];
            $nestedData['called_at'] = Carbon::parse($value['created_at'])->format('Y-m-d');
            $apiLogData[] = $nestedData;
        }

        return [
            'data'          => $apiLogData,
            'count'         => $count,
            'filteredCount' => $filteredCount,
        ];
    }

    /**
     * Stores iati api logs.
     *
     * @param $data
     *
     * @return Model
     */
    public function store(array $data): Model
    {
        return $this->iatiApiLogRepo->store($data);
    }
}
