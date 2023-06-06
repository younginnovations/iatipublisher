<?php

namespace App\IATI\Models\Import;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ImportActivityError.
 */
class ImportActivityError extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'import_activity_errors';

    /**
     * @var array
     */
    protected $fillable = ['activity_id', 'error', 'created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $casts = [
        'error'  => 'json',
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
