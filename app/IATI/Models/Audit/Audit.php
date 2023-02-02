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
                    $tempOldValues = [];
                    foreach ($model->old_values as $key => $item) {
                        $tempOldValues[$key] = json_decode($item);
                    }
                    $model->old_values = $tempOldValues;

                    $tempNewValues = [];
                    foreach ($model->new_values as $key => $item) {
                        $tempNewValues[$key] = json_decode($item);
                    }
                    $model->new_values = $tempNewValues;
                }
            }
        );
    }
}
