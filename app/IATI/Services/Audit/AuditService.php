<?php

declare(strict_types=1);

namespace App\IATI\Services\Audit;

use App\IATI\Repositories\Audit\AuditRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

/**
 * Class ActivityService.
 */
class AuditService
{
    /**
     * @var AuditRepository
     */
    protected AuditRepository $auditRepository;

    /**
     * AuditService constructor.
     *
     * @param AuditRepository $auditRepository
     */
    public function __construct(AuditRepository $auditRepository)
    {
        $this->auditRepository = $auditRepository;
    }

    /**
     * Stores custom event not caught by laravel-audit package in the audit table.
     *
     * @param mixed $auditables
     * @param string $event
     * @param string $eventFormat
     *
     * @return void
     */
    public function auditEvent(object|array|string|null $auditables, string $event, string $eventFormat = ''): void
    {
        $event = $this->buildEvent($event, $eventFormat);
        $this->auditRepository->insertRows($this->populateColumn($auditables, $event));
    }

    /**
     * Populate a columns in a row.
     *
     * @param mixed $auditables
     * @param string $event
     *
     * @return array
     */
    public function populateColumn(object|array|string|null $auditables, string $event): array
    {
        $row = [];
        $row['user_type'] = $this->getUserType();
        $row['user_id'] = $this->getUserId();
        $row['auditable_type'] = $event === 'signin' ? get_class(auth()->user()) : $this->getAuditableType($auditables);
        $row['auditable_id'] = $event === 'signin' ? auth()->user()->id : null;
        $row['event'] = $event;
        $row['url'] = request()->getUri();
        $row['ip_address'] = request()->getClientIp();
        $row['user_agent'] = request()->userAgent();
        $row['created_at'] = now();
        $row['updated_at'] = now();
        $row['new_values'] = $this->getNewValues($auditables, $row['auditable_type'], $event);

        return $row;
    }

    /**
     * Builds the complete event.
     * example: download-csv, download-xml...
     *
     * @param string $event
     * @param string $eventFormat
     *
     * @return string
     */
    public function buildEvent(string $event, string $eventFormat): string
    {
        if ($event === 'download') {
            $event = empty($eventFormat) ? $event : $event . '-' . $eventFormat;
        }

        return $event;
    }

    /**
     * Returns user_type.
     * example: App\IATI\Models\User\User.
     *
     * @return string
     */
    public function getUserType(): string
    {
        return get_class(Auth::user());
    }

    /**
     * Return user_id.
     * example: 2, 3, 4...
     *
     * @return int|string
     */
    public function getUserId(): int | string
    {
        return Auth::id();
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
        return $this->auditRepository->getAuditLog($page, $queryParams);
    }

    /**
     * Updates audit data row.
     *
     * @param $id
     * @param $data
     *
     * @return void
     */
    public function update($id, $data): void
    {
        $this->auditRepository->update($id, $data);
    }

    /**
     * Return auditable_type.
     * example: App\IATI\Models\User\User, App\IATI\Models\Activity\Activity...
     *
     * @param mixed $auditables
     *
     * @return string|null
     */
    public function getAuditableType(object|array|string|null $auditables): string|null
    {
        if (is_string($auditables)) {
            return $auditables;
        } elseif (is_array($auditables) || is_object($auditables)) {
            return get_class($auditables[0]);
        } else {
            return null;
        }
    }

    /**
     * Returns encrypted values if user models custom event is audited.
     *
     * @param $auditables
     * @param $auditableType
     * @param $event
     *
     *
     * @return bool|string
     */
    public function getNewValues($auditables, $auditableType, $event): bool | string
    {
        $auditables = $auditables->toArray();

        if ($auditableType === get_class(auth()->user()) && $event !== 'signin') {
            foreach ($auditables as $index => $item) {
                foreach ($item as $key => $value) {
                    $item[$key] = Crypt::encryptString($value);
                }
                $auditables[$index] = $item;
            }
        }

        if ($auditableType === get_class(auth()->user()) && $event === 'signin') {
            foreach ($auditables as $index => $item) {
                if ($index === 'id' || $index === 'username') {
                    $auditables[$index] = Crypt::encryptString($item);
                } else {
                    unset($auditables[$index]);
                }
            }
        }

        return json_encode($auditables);
    }
}
