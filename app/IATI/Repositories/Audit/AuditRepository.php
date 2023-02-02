<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Audit;

use App\IATI\Repositories\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use OwenIt\Auditing\Models\Audit;

/**
 * Class AuditRepository.
 */
class AuditRepository extends Repository
{
    protected $activeModal;

    /**
     * Returns audit model.
     *
     * @return string
     */
    public function getModel(): string
    {
        return Audit::class;
    }

    /**
     * Stores row in audit table.
     *
     * @param $rows
     *
     * @return void
     */
    public function insertRows($rows): void
    {
        $this->activeModal = $this->model->insertGetId($rows);
    }

    /**
     * Returns paginated audits.
     *
     * @param int $page
     * @param array $queryParams
     *
     * @return LengthAwarePaginator
     */
    public function getAuditLog(int $page, array $queryParams): LengthAwarePaginator
    {
        return $this->model
            ->orderBy(
                $queryParams['orderBy'] ?? 'id',
                $queryParams['direction'] ?? 'asc'
            )
            ->paginate(10, ['*'], 'audit', $page);
    }

    /**
     * Returns active audit instance id.
     *
     * @return int
     */
    public function getModelId():int
    {
        return $this->activeModal;
    }
}
