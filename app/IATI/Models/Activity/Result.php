<?php

declare(strict_types=1);

namespace App\IATI\Models\Activity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Result.
 */
class Result extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'activity_results';

    /**
     * Fillable property for mass assignment.
     *
     * @var array
     */
    protected $fillable
        = [
            'activity_id',
            'result',
        ];

    /**
     * @var array
     */
    protected $casts
        = [
            'result' => 'json',
        ];

    /**
     * Result belongs to activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activity(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

    /**
     * Result hasmany indicators.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function indicators(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Indicator::class, 'result_id', 'id');
    }
}
