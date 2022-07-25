<?php

declare(strict_types=1);

namespace App\IATI\Models\Activity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction.
 */
class Transaction extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'activity_transactions';

    /**
     * Fillable property for mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'activity_id',
        'transaction',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'transaction' => 'json',
    ];

    /**
     * Transaction belongs to an activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activity(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }
}
