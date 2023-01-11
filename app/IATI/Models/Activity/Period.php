<?php

declare(strict_types=1);

namespace App\IATI\Models\Activity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Period.
 */
class Period extends Model
{
    use HasFactory;

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

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::created(function ($period) {
            $period->indicator->result->activity->touch();
        });

        static::updated(function ($period) {
            $period->indicator->result->activity->touch();
        });
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
