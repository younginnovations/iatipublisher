<?php

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
}
