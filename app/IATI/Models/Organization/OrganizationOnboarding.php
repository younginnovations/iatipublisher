<?php

namespace App\IATI\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class OrganizationOnboarding.
 */
class OrganizationOnboarding extends Model
{
    use HasFactory;

    /**
     * @const PUBLISHING_SETTINGS
     */
    public const PUBLISHING_SETTINGS = 'Publishing Settings';

    /**
     * @const DEFAULT_VALUES
     */
    public const DEFAULT_VALUES = 'Default Values';

    /**
     * @const ORGANIZATION_DATA
     */
    public const ORGANIZATION_DATA = 'Organisation Data';

    /**
     * @const ACTIVITY
     */
    public const ACTIVITY = 'Activity Data';

    /**
     * @var array
     */
    protected $fillable
        = [
            'org_id',
            'completed_onboarding',
            'steps_status',
            'dont_show_again',
        ];

    /**
     * @var array
     */
    protected $casts
        = [
            'steps_status' => 'json',
        ];

    /**
     * Onboarding belongs to an organization.
     *
     * @return BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }
}
