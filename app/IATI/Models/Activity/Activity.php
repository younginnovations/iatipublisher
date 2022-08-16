<?php

declare(strict_types=1);

namespace App\IATI\Models\Activity;

use App\IATI\Models\Document\Document;
use App\IATI\Models\Organization\Organization;
use Database\Factories\IATI\Models\Activity\ActivityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * Class Activity.
 */
class Activity extends Model
{
    use HasFactory;

    /**
     * Fillable property for mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'iati_identifier',
        'other_identifier',
        'title',
        'description',
        'activity_status',
        'status',
        'activity_date',
        'contact_info',
        'activity_scope',
        'participating_org',
        'recipient_country',
        'recipient_region',
        'location',
        'sector',
        'country_budget_items',
        'humanitarian_scope',
        'policy_marker',
        'collaboration_type',
        'default_flow_type',
        'default_finance_type',
        'default_aid_type',
        'default_tied_status',
        'budget',
        'planned_disbursement',
        'capital_spend',
        'document_link',
        'related_activity',
        'legacy_data',
        'conditions',
        'org_id',
        'default_field_values',
        'is_published',
        'tag',
        'element_status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'iati_identifier'      => 'json',
        'identifier'           => 'json',
        'other_identifier'     => 'json',
        'title'                => 'json',
        'description'          => 'json',
        'activity_date'        => 'json',
        'contact_info'         => 'json',
        'activity_scope'       => 'json',
        'participating_org'    => 'json',
        'recipient_country'    => 'json',
        'recipient_region'     => 'json',
        'location'             => 'json',
        'sector'               => 'json',
        'country_budget_items' => 'json',
        'humanitarian_scope'   => 'json',
        'policy_marker'        => 'json',
        'collaboration_type'   => 'json',
        'default_flow_type'    => 'json',
        'default_finance_type' => 'json',
        'default_aid_type'     => 'json',
        'default_tied_status'  => 'json',
        'budget'               => 'json',
        'planned_disbursement' => 'json',
        'capital_spend'        => 'json',
        'document_link'        => 'json',
        'related_activity'     => 'json',
        'legacy_data'          => 'json',
        'conditions'           => 'json',
        'default_field_values' => 'json',
        'tag'                  => 'json',
        'element_status'       => 'json',
    ];

    /**
     * Factory for creating activity.
     *
     * @return ActivityFactory
     */
    public static function newFactory(): ActivityFactory
    {
        return new ActivityFactory();
    }

    /**
     * An Activity has many ActivityDocumentLink.
     *
     * @return HasMany
     */
    public function documentLinks(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Activity hasmany transactions.
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'activity_id', 'id');
    }

    /**
     * Activity hasmany results.
     *
     * @return HasMany
     */
    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'activity_id', 'id');
    }

    /**
     * Factory for creating activity.
     *
     * Activity belongs to an organisation.
     *
     * @return BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }

    /**
     * Checks if activity belongs to organization.
     *
     * @return bool
     */
    public function isActivityOfOrg(): bool
    {
        return $this->org_id === Auth::user()->organization_id;
    }
}
