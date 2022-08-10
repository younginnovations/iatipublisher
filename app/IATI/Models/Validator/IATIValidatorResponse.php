<?php

namespace App\IATI\Models\Validator;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class IATIValidatorResponse.
 */
class IATIValidatorResponse extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'iati_validator_responses';

    /**
     * @var array
     */
    protected $fillable = ['activity_id', 'response'];

    /**
     * @var array
     */
    protected $casts = [
        'response'  => 'json',
    ];

    /**
     * Validator response belongs to an activity.
     *
     * @return BelongsTo
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }
}
