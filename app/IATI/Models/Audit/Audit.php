<?php

declare(strict_types=1);

namespace App\IATI\Models\Audit;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Audit as AuditTrait;
use OwenIt\Auditing\Contracts\Audit as AuditContract;

/**
 * Class Audit.
 */
class Audit extends Model implements AuditContract
{
    use AuditTrait;

    /**
     * @inheritdoc
     */
    protected $guarded = [];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
    ];

    /**
     * Before inbuilt function.
     * Decode array values to avoid json values with escaped characters in audit table on save.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::saving(
            function ($model) {
                if ($model->auditable_type != 'App\\IATI\\Models\\User\\User' && $model->auditable_type != 'App\\IATI\\Models\\Organization\\Organization') {
                    if ($model->old_values) {
                        $tempOldValues = [];

                        foreach ($model->old_values as $key => $item) {
                            $tempOldValues[$key] = is_string($item) ? json_decode($item) : $item;
                        }

                        $model->old_values = $tempOldValues;
                    }

                    if ($model->new_values) {
                        $tempNewValues = [];

                        foreach ($model->new_values as $key => $item) {
                            $tempNewValues[$key] = is_string($item) ? json_decode($item) : $item;
                        }

                        $model->new_values = $tempNewValues;
                    }
                }

                $authUser = auth()->user();

                $model->full_name = $authUser->full_name ?? null;
                $model->email = $authUser->email ?? null;
            }
        );
    }
}
