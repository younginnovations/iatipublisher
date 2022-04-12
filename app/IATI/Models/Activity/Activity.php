<?php

namespace App\IATI\Models\Activity;

use App\IATI\Models\Organisation\Organisation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Activity.
 */
class Activity extends Model
{
    use HasFactory;

    /**
     * Fillable property for mass assignment.
     * @var array
     */
    protected $fillable = [
        'identifier',
        'other_identifier',
        'title',
        'description',
        'status',
        'activity_date',
        'contact_info',
        'activity_scope',
        'participating_organization',
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
    ];

    /**
     * @var array
     */
    protected $casts = [
        'identifier'                 => 'json',
        'other_identifier'           => 'json',
        'title'                      => 'json',
        'description'                => 'json',
        'activity_date'              => 'json',
        'contact_info'               => 'json',
        'activity_scope'             => 'json',
        'participating_organization' => 'json',
        'recipient_country'          => 'json',
        'recipient_region'           => 'json',
        'location'                   => 'json',
        'sector'                     => 'json',
        'country_budget_items'       => 'json',
        'humanitarian_scope'         => 'json',
        'policy_marker'              => 'json',
        'collaboration_type'         => 'json',
        'default_flow_type'          => 'json',
        'default_finance_type'       => 'json',
        'default_aid_type'           => 'json',
        'default_tied_status'        => 'json',
        'budget'                     => 'json',
        'planned_disbursement'       => 'json',
        'capital_spend'              => 'json',
        'document_link'              => 'json',
        'related_activity'           => 'json',
        'legacy_data'                => 'json',
        'conditions'                 => 'json',
        'default_field_values'       => 'json',
        'tag'                        => 'json',
    ];

    /**
     * Activity belongs to an organisation.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organisation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Organisation::class, 'org_id');
    }
}
