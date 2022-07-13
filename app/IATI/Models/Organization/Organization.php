<?php

declare(strict_types=1);

namespace App\IATI\Models\Organization;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    /**
     * Organisation has many activities.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Activity::class, 'org_id', 'id');
    }
}
