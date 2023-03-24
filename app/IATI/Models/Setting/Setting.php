<?php

declare(strict_types=1);

namespace App\IATI\Models\Setting;

use App\IATI\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Setting.
 */
class Setting extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'organization_id',
        'publishing_info',
        'default_values',
        'activity_default_values',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'publishing_info'         => 'json',
        'default_values'          => 'json',
        'activity_default_values' => 'json',
    ];

    /**
     * Setting belongs to organization.
     *
     * @return BelongsTo
     */
    protected function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
