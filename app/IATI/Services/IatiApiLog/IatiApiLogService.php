<?php

declare(strict_types=1);

namespace App\IATI\Services\IatiApiLog;

use App\IATI\Repositories\IatiApiLog\IatiApiLogRepository;
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
