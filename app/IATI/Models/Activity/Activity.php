<?php

namespace App\IATI\Models\Activity;

use App\IATI\Models\Organization\Organization;
use Database\Factories\IATI\Models\Activity\ActivityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'identifier',
        'other_identifier',
        'title',
        'description',
        'activity_status',
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
     * Factory for creating activity.
     *
     * @return ActivityFactory
     */
    public static function newFactory(): ActivityFactory
    {
        return new ActivityFactory();
    }

    /**
     * Activity hasmany results.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function results(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Result::class, 'activity_id', 'id');
    }

    /**
     * Factory for creating activity.
     *
     * Activity belongs to an organisation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }

    /**
     * Return mandatory attributes fields.
     *
     * @param $attributes
     *
     * @return array
     */
    public function mandatoryAttributes($attributes): array
    {
        $mandatoryAttributes = [];

        foreach ($attributes as $attribute) {
            if ($attribute['criteria'] == 'mandatory') {
                $mandatoryAttributes[] = $attribute['name'];
            }
        }

        return $mandatoryAttributes;
    }

    /**
     * Return mandatory sub element fields.
     *
     * @param $fields
     *
     * @return array
     */
    public function mandatorySubElements($fields): array
    {
        $mandatoryElements = [];

        foreach ($fields as $field) {
            $mandatoryFields = [];

            if ($field['criteria'] == 'mandatory') {
                $mandatoryFields[] = $field['name'];
            }

            if (isset($field['attributes'])) {
                $attributes = $field['attributes'];

                foreach ($attributes as $attribute) {
                    if ($attribute['criteria'] == 'mandatory') {
                        $mandatoryFields[] = $attribute['name'];
                    }
                }
            }

            if (!empty($mandatoryFields)) {
                $mandatoryElements[$field['name']] = $mandatoryFields;
            }
        }

        return $mandatoryElements;
    }

    /**
     * Checks if sub element is complete.
     *
     * @param $mandatoryFields
     * @param $data
     *
     * @return bool
     */
    public function isDataCompleted($mandatoryFields, $data): bool
    {
        if (empty($data)) {
            return false;
        }

        foreach ($data as $datum) {
            foreach ($mandatoryFields as $mandatoryField) {
                if (empty($datum[$mandatoryField])) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Checks if attribute is complete.
     *
     * @param $mandatoryAttributes
     * @param $data
     *
     * @return bool
     */
    public function isAttributeDataCompleted($mandatoryAttributes, $data): bool
    {
        if (empty($mandatoryAttributes)) {
            return true;
        }

        foreach ($mandatoryAttributes as $mandatoryAttribute) {
            foreach ($data as $datum) {
                if (array_key_exists($mandatoryAttribute, $datum) && empty($datum[$mandatoryAttribute])) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Checks if sub element is complete.
     *
     * @param $mandatorySubElements
     * @param $data
     *
     * @return bool
     */
    public function isSubElementDataCompleted($mandatorySubElements, $data): bool
    {
        if (empty($mandatorySubElements)) {
            return true;
        }

        foreach ($mandatorySubElements as $key => $mandatorySubElement) {
            foreach ($data as $datum) {
                if (array_key_exists($key, $datum)) {
                    if (!$this->isDataCompleted($mandatorySubElement, $datum[$key])) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * Checks if single dimension attribute is complete.
     *
     * @param $element
     * @param $data
     *
     * @return bool
     */
    public function singleDimensionAttributeCheck($element, $data): bool
    {
        if (empty($data)) {
            return false;
        }

        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $attributes = $elementSchema[$element]['attributes'];
        $mandatoryAttributes = $this->mandatoryAttributes($attributes);

        foreach ($mandatoryAttributes as $mandatoryAttribute) {
            if (array_key_exists($mandatoryAttribute, $data) && empty($data[$mandatoryAttribute])) {
                //dd('attribute-check:', $mandatoryAttributes, $data);
                return false;
            }
        }

        return true;
    }

    /**
     * Checks if all element is complete.
     *
     * @param $element
     * @param $data
     *
     * @return bool
     */
    public function isLevelOneElementCompleted($element, $data): bool
    {
        if (empty($data)) {
            return false;
        }

        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);

        if (array_key_exists('attributes', $elementSchema[$element])) {
            if (!$this->isAttributeDataCompleted($this->mandatoryAttributes($elementSchema[$element]['attributes']), $data)) {
                return false;
            }
        }

        if (array_key_exists('sub_elements', $elementSchema[$element])) {
            return $this->isSubElementDataCompleted($this->mandatorySubElements($elementSchema[$element]['sub_elements']), $data);
        }

        return true;
    }

    /**
     * Checks if two level sub element is complete.
     *
     * @param $element
     * @param $data
     *
     * @return bool
     */
    public function isLevelTwoElementCompleted($element, $data): bool
    {
        if (!$this->singleDimensionAttributeCheck($element, $data)) {
            return false;
        }
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $subElements = $elementSchema[$element]['sub_elements'];

        foreach ($subElements as $key => $subElement) {
            $subElementAttributes = $subElement['attributes'];
            $mandatorySubElementAttributes = $this->mandatoryAttributes($subElementAttributes);
            $tempData = $data[$key];

            if (!$this->isAttributeDataCompleted($mandatorySubElementAttributes, $tempData)) {
                //dd('sub-element-attribute-check:', $mandatorySubElementAttributes, $tempData);
                return false;
            }

            $childSubElements = $subElement['sub_elements'];
            $mandatoryChildSubElements = $this->mandatorySubElements($childSubElements);

            if (!$this->isSubElementDataCompleted($mandatoryChildSubElements, $tempData)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks three level sub element is complete.
     *
     * @param $element
     * @param $data
     *
     * @return bool
     */
    public function isLevelThreeElementCompleted($element, $data): bool
    {
        if (!$this->singleDimensionAttributeCheck($element, $data)) {
            return false;
        }

        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $subElements = $elementSchema[$element]['sub_elements'];

        foreach ($subElements as $key => $subElement) {
            $subElementAttributes = $subElement['attributes'];
            $mandatorySubElementAttributes = $this->mandatoryAttributes($subElementAttributes);
            $tempData = $data[$key];

            if (!$this->isAttributeDataCompleted($mandatorySubElementAttributes, $tempData)) {
                //dd('sub-element-attribute-check:', $mandatorySubElementAttributes, $tempData);
                return false;
            }

            $childSubElements = $subElement['sub_elements'];

            foreach ($childSubElements as $innerKey => $childSubElement) {
                $mandatoryChildSubElements = $this->mandatorySubElements($childSubElement['sub_elements']);

                foreach ($tempData as $tempDatum) {
                    if (!$this->isSubElementDataCompleted($mandatoryChildSubElements, $tempDatum[$innerKey])) {
                        //dd('third-level-sub-element-check:', $mandatoryChildSubElements, $tempDatum[$innerKey]);
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * Returns identifier element complete status.
     *
     * @return bool
     */
    public function getActivityIdentifierElementCompletedAttribute(): bool
    {
        $identifier = $this->identifier;

        if (!array_key_exists('activity_identifier', $identifier) || empty($identifier['activity_identifier'])) {
            return false;
        }

        return true;
    }

    /**
     * Returns title element complete status.
     *
     * @return bool
     */
    public function getTitleElementCompletedAttribute(): bool
    {
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $mandatorySubElements = $this->mandatorySubElements($elementSchema['title']['sub_elements']);
        $this->attributes['title_element_completed'] = $this->isDataCompleted($mandatorySubElements['narrative'], $this->title);

        return $this->isDataCompleted($mandatorySubElements['narrative'], $this->title);
    }

    /**
     * Returns description element complete status.
     *
     * @return bool
     */
    public function getDescriptionElementCompletedAttribute(): bool
    {
        return $this->isLevelOneElementCompleted('description', $this->description);
    }

    /**
     * Returns activity_date element complete status.
     *
     * @return bool
     */
    public function getActivityDateElementCompletedAttribute(): bool
    {
        return $this->isLevelOneElementCompleted('activity_date', $this->activity_date);
    }

    /**
     * Returns recipient_country element complete status.
     *
     * @return bool
     */
    public function getRecipientCountryElementCompletedAttribute(): bool
    {
        return $this->isLevelOneElementCompleted('recipient_country', $this->recipient_country);
    }

    /**
     * Returns budget element complete status.
     *
     * @return bool
     */
    public function getBudgetElementCompletedAttribute(): bool
    {
        return $this->isLevelOneElementCompleted('budget', $this->budget);
    }

    /**
     * Returns recipient_region element complete status.
     *
     * @return bool
     */
    public function getRecipientRegionElementCompletedAttribute(): bool
    {
        return $this->isLevelOneElementCompleted('recipient_region', $this->recipient_region);
    }

    /**
     * Returns default_aid_type element complete status.
     *
     * @return bool
     */
    public function getDefaultAidTypeElementCompletedAttribute(): bool
    {
        return $this->isLevelOneElementCompleted('default_aid_type', $this->default_aid_type);
    }

    /**
     * Returns other_identifier element complete status.
     *
     * @return bool
     */
    public function getOtherIdentifierElementCompletedAttribute(): bool
    {
        return $this->isLevelTwoElementCompleted('other_identifier', $this->other_identifier);
    }

    /**
     * Returns related_activity element complete status.
     *
     * @return bool
     */
    public function getRelatedActivityElementCompletedAttribute(): bool
    {
        return $this->isLevelOneElementCompleted('related_activity', $this->related_activity);
    }

    /**
     * Returns description element complete status.
     *
     * @return bool
     */
    public function getSectorElementCompletedAttribute(): bool
    {
        return $this->isLevelOneElementCompleted('sector', $this->sector);
    }

    /**
     * Returns humanitarian_scope element complete status.
     *
     * @return bool
     */
    public function getHumanitarianScopeElementCompletedAttribute(): bool
    {
        return $this->isLevelOneElementCompleted('humanitarian_scope', $this->humanitarian_scope);
    }

    /**
     * Returns legacy_data element complete status.
     *
     * @return bool
     */
    public function getLegacyDataElementCompletedAttribute(): bool
    {
        return $this->isLevelOneElementCompleted('legacy_data', $this->legacy_data);
    }

    /**
     * Returns tag element complete status.
     *
     * @return bool
     */
    public function getTagElementCompletedAttribute(): bool
    {
        return $this->isLevelOneElementCompleted('tag', $this->tag);
    }

    /**
     * Returns policy_marker element complete status.
     *
     * @return bool
     */
    public function getPolicyMarkerElementCompletedAttribute(): bool
    {
        return $this->isLevelOneElementCompleted('policy_marker', $this->policy_marker);
    }

    /**
     * Returns activity_status element complete status.
     *
     * @return bool
     */
    public function getActivityStatusElementCompletedAttribute(): bool
    {
        return !empty($this->activity_status);
    }

    /**
     * Returns activity_scope element complete status.
     *
     * @return bool
     */
    public function getActivityScopeElementCompletedAttribute(): bool
    {
        return !empty($this->activity_scope);
    }

    /**
     * Returns collaboration_type element complete status.
     *
     * @return bool
     */
    public function getCollaborationTypeElementCompletedAttribute(): bool
    {
        return !empty($this->collaboration_type);
    }

    /**
     * Returns default_flow_type element complete status.
     *
     * @return bool
     */
    public function getDefaultFlowTypeElementCompletedAttribute(): bool
    {
        return !empty($this->default_flow_type);
    }

    /**
     * Returns default_finance_type element complete status.
     *
     * @return bool
     */
    public function getDefaultFinanceTypeElementCompletedAttribute(): bool
    {
        return !empty($this->default_finance_type);
    }

    /**
     * Returns default_tied_status element complete status.
     *
     * @return bool
     */
    public function getDefaultTiedStatusElementCompletedAttribute(): bool
    {
        return !empty($this->default_tied_status);
    }

    /**
     * Returns capital_spend element complete status.
     *
     * @return bool
     */
    public function getCapitalSpendElementCompletedAttribute(): bool
    {
        return !empty($this->capital_spend);
    }

    /**
     * Returns conditions element complete status.
     *
     * @return bool
     */
    public function getConditionsElementCompletedAttribute(): bool
    {
        return $this->isLevelTwoElementCompleted('conditions', $this->conditions);
    }

    /**
     * Returns country_budget_items element complete status.
     *
     * @return bool
     */
    public function getCountryBudgetItemsElementCompletedAttribute(): bool
    {
        return $this->isLevelThreeElementCompleted('country_budget_items', $this->country_budget_items);
    }
}
