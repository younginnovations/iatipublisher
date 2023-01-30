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
     * Returns all logs.
     *
     * @return Collection
     */
    public function getLogs(): Collection
    {
        return $this->model->get();
    }
}
