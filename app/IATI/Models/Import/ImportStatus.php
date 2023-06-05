<?php

namespace App\IATI\Models\Import;

use App\IATI\Models\Organization\Organization;
use App\IATI\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ImportStatus.
 */
class ImportStatus extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'import_status';

    /**
     * @var array
     */
    protected $fillable = [
        'organization_id',
        'status',
        'type',
        'template',
        'data_count',
        'user_id',
    ];

    /**
     * Validator response belongs to an activity.
     *
     * @return BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    /**
     * Validator response belongs to an activity.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
