<?php

declare(strict_types=1);

namespace App\IATI\Models\Activity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ActivitySnapshot.
 */
class ActivitySnapshot extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'activity_snapshots';

    /**
     * @var array
     */
    protected $fillable
        = [
            'org_id',
            'activity_id',
            'published_data',
            'filename',
        ];

    /**
     * @var array
     */
    protected $casts
        = [
            'published_data' => 'json',
        ];

    /**
     * ActivitySnapshot belongs to an activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activity(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }
}
