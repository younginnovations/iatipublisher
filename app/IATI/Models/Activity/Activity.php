<?php

namespace App\IATI\Models\Activity;

use App\IATI\Models\Document\Document;
use App\IATI\Models\Organization\Organization;
use Database\Factories\IATI\Models\Activity\ActivityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Activity.
 */
class Activity extends Model
{
    use HasFactory;

    protected $appends = ['title_element_completed'];
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
     * Activity hasmany results.
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
     * Returns element complete status.
     *
     * @param $element
     *
     * @return bool
     */
    public function getElementStatus($element): bool
    {
        $elementStatus = $this->element_status;

        return $elementStatus[$element];
    }

    /**
     * Returns identifier element complete status.
     *
     * @return bool
     */
    public function getActivityIdentifierElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('iati_identifier');
    }

    /**
     * Returns title element complete status.
     *
     * @return bool
     */
    public function getTitleElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('title');
    }

    /**
     * Returns description element complete status.
     *
     * @return bool
     */
    public function getDescriptionElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('description');
    }

    /**
     * Returns activity_date element complete status.
     *
     * @return bool
     */
    public function getActivityDateElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('activity_date');
    }

    /**
     * Returns recipient_country element complete status.
     *
     * @return bool
     */
    public function getRecipientCountryElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('recipient_country');
    }

    /**
     * Returns budget element complete status.
     *
     * @return bool
     */
    public function getBudgetElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('budget');
    }

    /**
     * Returns recipient_region element complete status.
     *
     * @return bool
     */
    public function getRecipientRegionElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('recipient_region');
    }

    /**
     * Returns default_aid_type element complete status.
     *
     * @return bool
     */
    public function getDefaultAidTypeElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('default_aid_type');
    }

    /**
     * Returns other_identifier element complete status.
     *
     * @return bool
     */
    public function getOtherIdentifierElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('other_identifier');
    }

    /**
     * Returns related_activity element complete status.
     *
     * @return bool
     */
    public function getRelatedActivityElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('related_activity');
    }

    /**
     * Returns description element complete status.
     *
     * @return bool
     */
    public function getSectorElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('sector');
    }

    /**
     * Returns humanitarian_scope element complete status.
     *
     * @return bool
     */
    public function getHumanitarianScopeElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('humanitarian_scope');
    }

    /**
     * Returns legacy_data element complete status.
     *
     * @return bool
     * @throws \JsonException
     */
    public function getLegacyDataElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('legacy_data');
    }

    /**
     * Returns tag element complete status.
     *
     * @return bool
     */
    public function getTagElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('tag');
    }

    /**
     * Returns policy_marker element complete status.
     *
     * @return bool
     */
    public function getPolicyMarkerElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('policy_marker');
    }

    /**
     * Returns activity_status element complete status.
     *
     * @return bool
     */
    public function getActivityStatusElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('activity_status');
    }

    /**
     * Returns activity_scope element complete status.
     *
     * @return bool
     */
    public function getActivityScopeElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('activity_scope');
    }

    /**
     * Returns collaboration_type element complete status.
     *
     * @return bool
     */
    public function getCollaborationTypeElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('collaboration_type');
    }

    /**
     * Returns default_flow_type element complete status.
     *
     * @return bool
    public function getDefaultFlowTypeElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('default_flow_type');
    }

    /**
     * Returns default_finance_type element complete status.
     *
     * @return bool
     */
    public function getDefaultFinanceTypeElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('default_finance_type');
    }

    /**
     * Returns default_tied_status element complete status.
     *
     * @return bool
     */
    public function getDefaultTiedStatusElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('default_tied_status');
    }

    /**
     * Returns capital_spend element complete status.
     *
     * @return bool
     */
    public function getCapitalSpendElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('capital_spend');
    }

    /**
     * Returns conditions element complete status.
     *
     * @return bool
     */
    public function getConditionsElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('conditions');
    }

    /**
     * Returns country_budget_items element complete status.
     *
     * @return bool
     */
    public function getCountryBudgetItemsElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('country_budget_items');
    }

    /**
     * Returns result element complete status.
     *
     * @return bool
     */
    public function getResultElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('result');
    }

    /**
     * Returns transaction element complete status.
     *
     * @return bool
     */
    public function getTransactionElementCompletedAttribute(): bool
    {
        return $this->getElementStatus('transaction');
    }
}
