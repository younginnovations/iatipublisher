<?php

declare(strict_types=1);

namespace App\IATI\Models\Activity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function periods(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Period::class, 'indicator_id', 'id');
    }

    /**
     * Result belongs to activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function result(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Result::class, 'result_id', 'id');
    }
}
