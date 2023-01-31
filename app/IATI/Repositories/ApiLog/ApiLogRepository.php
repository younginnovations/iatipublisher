<?php

declare(strict_types=1);

namespace App\IATI\Repositories\ApiLog;

use App\IATI\Models\ApiLog\ApiLog;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ApiLogRepository.
 */
class ApiLogRepository extends Repository
{
    /**
     * Get model name with namespace.
     *
     * @return string
     */
    public function getModel(): string
    {
        return ApiLog::class;
    }

    /**
     * Returns all logs.
     *
     * @return Collection
     */
    public function getLogs(): Collection
    {
        return $this->model->get();
    }
}
