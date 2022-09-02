<?php

declare(strict_types=1);

namespace App\IATI\Models\Organization;

use App\IATI\Models\Activity\ActivityPublished;
use App\IATI\Models\Setting\Setting;
use App\IATI\Models\User\User;
use App\IATI\Services\ElementCompleteService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Organization.
 */
class Organization extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'publisher_id',
        'publisher_name',
        'publisher_type',
        'identifier',
        'name',
        'address',
        'telephone',
        'reporting_org',
        'country',
        'logo_url',
        'organization_url',
        'status',
        'is_published',
        'registration_agency',
        'registration_number',
        'reporting_org',
        'total_budget',
        'recipient_org_budget',
        'recipient_region_budget',
        'recipient_country_budget',
        'document_link',
        'total_expenditure',
        'organisation_identifier',
        'name',
        'element_status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'reporting_org' => 'json',
        'total_budget' => 'json',
        'recipient_org_budget' => 'json',
        'recipient_region_budget' => 'json',
        'recipient_country_budget' => 'json',
        'document_link' => 'json',
        'total_expenditure' => 'json',
        'organisation_identifier' => 'json',
        'name' => 'json',
        'element_status' => 'json',
    ];

    /**
     * @var ElementCompleteService
     */
    protected ElementCompleteService $elementCompleteService;

    /**
     * Construct function.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->elementCompleteService = new ElementCompleteService();
    }

    /**
     * Organisation has many activities.
     *
     * @return HasMany
     */
    public function activities(): HasMany
    {
        return $this->hasMany(ActivityPublished::class, 'organization_id', 'id');
    }

    /**
     * Organization has one user.
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'organization_id', 'id');
    }

    /**
     * Organization has settings.
     *
     * @return HasOne
     */
    public function settings(): HasOne
    {
        return $this->hasOne(Setting::class, 'organization_id', 'id');
    }

    /**
     * Returns complete status of reporting_org.
     *
     * @return bool
     * @throws \JsonException
     */
    public function getReportingOrgElementCompletedAttribute(): bool
    {
        $this->elementCompleteService->element = 'reporting_org';

        return $this->elementCompleteService->isLevelOneMultiDimensionElementCompleted($this->reporting_org);
    }

    /**
     * An Organization can have many Activities published.
     *
     * @return HasMany
     */
    public function publishedFiles(): HasMany
    {
        return $this->hasMany(ActivityPublished::class, 'organization_id', 'id');
    }
}
