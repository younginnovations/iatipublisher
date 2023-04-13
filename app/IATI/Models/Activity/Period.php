<?php

declare(strict_types=1);

namespace App\IATI\Models\Activity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Period.
 */
class Period extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /**
     * @var string
     */
    protected $table = 'result_indicator_periods';

    /**
     * @var array
     */
    protected $fillable = [
        'indicator_id',
        'period',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'period' => 'json',
    ];

    protected $touches = ['indicator'];

    /**
     * Before inbuilt function.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::saving(
            function ($model) {
                $model->period_code = sprintf('%d%s', $model->id, time());
            }
        );
    }

    /**
     * Period belongs to indicator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function indicator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Indicator::class, 'indicator_id', 'id');
    }
}
