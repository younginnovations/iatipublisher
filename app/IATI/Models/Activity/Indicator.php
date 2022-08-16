<?php

declare(strict_types=1);

namespace App\IATI\Models\Activity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Indicator.
 */
class Indicator extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'activity_result_indicators';

    /**
     * @var array
     */
    protected $fillable
    = [
        'result_id',
        'indicator',
    ];

    /**
     * @var array
     */
    protected $casts
    = [
        'indicator' => 'json',
    ];

    /**
     * Indicator hasmany periods.
     *
     * @return HasMany
     */
    public function periods(): HasMany
    {
        return $this->hasMany(Period::class, 'indicator_id', 'id');
    }

    /**
     * Result belongs to activity.
     *
     * @return BelongsTo
     */
    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class, 'result_id', 'id');
    }
}
