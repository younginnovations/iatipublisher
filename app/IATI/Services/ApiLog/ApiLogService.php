<?php

declare(strict_types=1);

namespace App\IATI\Services\ApiLog;

use App\IATI\Repositories\ApiLog\ApiLogRepository;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ApiLogService.
 */
class ApiLogService
{
    /**
     * @var ApiLogRepository
     */
    private $apiLogRepo;

    /**
     * @var DatabaseManager
     */
    private $db;

    /**
     * ApiLogService constructor.
     *
     * @param ApiLogRepository $apiLogRepo
     * @param DatabaseManager  $db
     */
    public function __construct(ApiLogRepository $apiLogRepo, DatabaseManager $db)
    {
        $this->apiLogRepo = $apiLogRepo;
        $this->db = $db;
    }

    /**
     * Returns all logs.
     *
     * @return Collection
     */
    public function getAllApiLogs(): Collection
    {
        return $this->apiLogRepo->all();
    }

    /**
     * @param array $postData
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function save(array $postData): Model
    {
        return $this->apiLogRepo->store($postData);
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
        return $this->apiLogRepo->store($data);
    }
}
