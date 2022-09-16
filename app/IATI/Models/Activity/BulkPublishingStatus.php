<?php

declare(strict_types=1);

namespace App\IATI\Models\Activity;

use App\IATI\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BulkPublishingStatus.
 */
class BulkPublishingStatus extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'bulk_publishing_status';

    /**
     * @var array
     */
    protected $fillable
        = [
            'organization_id',
            'activity_id',
            'activity_title',
            'status',
            'job_batch_uuid',
        ];

    /**
     * Bulk publishing status belong to an organization.
     *
     * @return BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    /**
     * Bulk publishing status belong to an activity.
     *
     * @return BelongsTo
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }
}
