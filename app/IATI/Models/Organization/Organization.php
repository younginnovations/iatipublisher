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
    ];

    /**
     * @var array
     */
    protected $casts = ['reporting_org' => 'json'];

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
     * Organization hasone user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'organization_id', 'id');
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
     * Organization has one setting.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function settings(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Setting::class, 'organization_id', 'id');
    }

    /**
     * An Organization can have many Activities published.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publishedFiles(): HasMany
    {
        return $this->hasMany(ActivityPublished::class, 'organization_id', 'id');
    }
}
