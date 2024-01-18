<?php

declare(strict_types=1);

namespace App;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ValidationStatus.
 */
class ValidationStatus extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'validation_status';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'activity_id',
        'status',
        'response',
    ];

    /**
     * Relation to the user who tried to published  ( Validate ) the activity.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relation to the activity that is being published ( Validated ).
     *
     * @return BelongsTo
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }
}
