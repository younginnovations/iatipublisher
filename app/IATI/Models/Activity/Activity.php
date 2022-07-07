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
            if (array_key_exists('criteria', $attribute) && $attribute['criteria'] == 'mandatory') {
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

            if (array_key_exists('criteria', $field) && $field['criteria'] == 'mandatory') {
                $mandatoryFields[] = $field['name'];
            }

            if (isset($field['attributes'])) {
                $attributes = $field['attributes'];

                foreach ($attributes as $attribute) {
                    if (array_key_exists('criteria', $attribute) && $attribute['criteria'] == 'mandatory') {
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

        if (empty($data)) {
            return false;
        }

        foreach ($mandatoryAttributes as $mandatoryAttribute) {
            if (!array_key_exists($mandatoryAttribute, $data) || (empty($data[$mandatoryAttribute]))) {
                dd('isAttributeDataCompleted fx called', ' Attribute is empty', 'attribute-check:', $mandatoryAttributes, $data);

                return false;
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

        if (empty($data)) {
            return false;
        }

        foreach ($mandatorySubElements as $key => $mandatorySubElement) {
            if (!array_key_exists($key, $data)) {
                dd('isSubElementDataCompleted fx called', 'Whole Sub element has not filled yet', 'sub-element-check:', $mandatorySubElement, $data);

                return false;
            }
            $items = $data[$key];

            if (empty($items)) {
                dd('isSubElementDataCompleted fx called', 'Sub element has not filled yet', 'sub-element-check:', $mandatorySubElement, $data, $items);

                return false;
            }

            foreach ($mandatorySubElement as $mandatoryField) {
                foreach ($items as $item) {
                    if (!array_key_exists($mandatoryField, $item) || (empty($item[$mandatoryField]))) {
                        dd('isSubElementDataCompleted fx called', ' Sub element is empty', 'sub-element-check:', $mandatoryField, $item);

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
        $mandatoryAttributes = $this->mandatoryAttributes($elementSchema[$element]['attributes']);

        if (!empty($mandatoryAttributes)) {
            if (!$this->isAttributeDataCompleted($mandatoryAttributes, $data)) {
                //dd('singleDimensionAttributeCheck fx called', 'Level2 single dimension attribute is empty', 'attribute-check:', $mandatoryAttributes, $data);

                return false;
            }
        }

        return true;
    }

    public function isSubElementCompleted($subElements, $data): bool
    {
        foreach ($subElements as $key => $subElement) {
            $mandatorySubElementAttributes = array_key_exists('attributes', $subElement) ? $this->mandatoryAttributes($subElement['attributes']) : [];
            $mandatoryChildSubElements = array_key_exists('sub_elements', $subElement) ? $this->mandatorySubElements($subElement['sub_elements']) : [];

            if (!empty($mandatorySubElementAttributes) || !empty($mandatoryChildSubElements)) {
                foreach ($data as $datum) {
                    if (!$this->isElementCompleted($mandatorySubElementAttributes, $mandatoryChildSubElements, $datum[$key])) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    public function isElementCompleted($mandatoryAttributes, $mandatorySubElements, $data): bool
    {
        if (!empty($mandatoryAttributes) || !empty($mandatorySubElements)) {
            if (empty($data)) {
                return false;
            }

            foreach ($data as $datum) {
                if (!$this->isAttributeDataCompleted($mandatoryAttributes, $datum)) {
                    dd('isElementCompleted fx is called', 'Attribute is empty', 'attribute-check:', $mandatoryAttributes, $data, $datum);

                    return false;
                }

                if (!$this->isSubElementDataCompleted($mandatorySubElements, $datum)) {
                    dd('isElementCompleted fx is called', 'Sub element is empty', 'sub-element-check:', $mandatorySubElements, $data, $datum);

                    return false;
                }
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
    public function isLevelOneMultiDimensionElementCompleted($element, $data): bool
    {
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $mandatoryAttributes = array_key_exists('attributes', $elementSchema[$element]) ? $this->mandatoryAttributes($elementSchema[$element]['attributes']) : [];
        $mandatorySubElements = array_key_exists('sub_elements', $elementSchema[$element]) ? $this->mandatorySubElements($elementSchema[$element]['sub_elements']) : [];

        return $this->isElementCompleted($this->mandatoryAttributes($mandatoryAttributes), $this->mandatorySubElements($mandatorySubElements), $data);
    }

    /**
     * Checks if two level sub element is complete.
     *
     * @param $element
     * @param $data
     *
     * @return bool
     */
    public function isLevelTwoSingleDimensionElementCompleted($element, $data): bool
    {
        if (empty($data)) {
            return false;
        }

        if (!$this->singleDimensionAttributeCheck($element, $data)) {
            return false;
        }

        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $subElements = $elementSchema[$element]['sub_elements'];

        foreach ($subElements as $key => $subElement) {
            $mandatoryAttributes = array_key_exists('attributes', $subElement) ? $this->mandatoryAttributes($subElement['attributes']) : [];
            $mandatorySubElements = array_key_exists('sub_elements', $subElement) ? $this->mandatorySubElements($subElement['sub_elements']) : [];

            if (!$this->isElementCompleted($mandatoryAttributes, $mandatorySubElements, $data[$key])) {
                return false;
            }
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
    public function isLevelTwoMultiDimensionElementCompleted($element, $data): bool
    {
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $mandatoryAttributes = array_key_exists('attributes', $elementSchema[$element]) ? $this->mandatoryAttributes($elementSchema[$element]['attributes']) : [];

        if (!empty($mandatoryAttributes)) {
            foreach ($data as $datum) {
                if (!$this->isAttributeDataCompleted($mandatoryAttributes, $datum)) {
                    return false;
                }
            }
        }

        return $this->isSubElementCompleted($elementSchema[$element]['sub_elements'], $data);
    }

    /**
     * Checks three level sub element is complete.
     *
     * @param $element
     * @param $data
     *
     * @return bool
     */
    public function isLevelThreeSingleDimensionElementCompleted($element, $data): bool
    {
        if (empty($data)) {
            return false;
        }

        if (!$this->singleDimensionAttributeCheck($element, $data)) {
            return false;
        }

        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $subElements = $elementSchema[$element]['sub_elements'];

        foreach ($subElements as $key => $subElement) {
            $mandatorySubElementAttributes = array_key_exists('attributes', $subElement) ? $this->mandatoryAttributes($subElement['attributes']) : [];
            $tempData = $data[$key];

            if (!empty($mandatorySubElementAttributes)) {
                if (empty($tempData)) {
                    return false;
                }
                foreach ($tempData as $datum) {
                    dd($mandatorySubElementAttributes, $datum);
                    if (!$this->isAttributeDataCompleted($mandatorySubElementAttributes, $datum)) {
                        return false;
                    }
                }
            }

            return $this->isSubElementCompleted($subElement['sub_elements'], $tempData);
        }

        return true;
    }

    /**
     * Returns identifier element complete status.
     *
     * @return bool
     */
    public function getIdentifierElementCompletedAttribute(): bool
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
        return $this->isLevelOneMultiDimensionElementCompleted('description', $this->description);
    }

    /**
     * Returns activity_date element complete status.
     *
     * @return bool
     */
    public function getActivityDateElementCompletedAttribute(): bool
    {
        return $this->isLevelOneMultiDimensionElementCompleted('activity_date', $this->activity_date);
    }

    /**
     * Returns recipient_country element complete status.
     *
     * @return bool
     */
    public function getRecipientCountryElementCompletedAttribute(): bool
    {
        return $this->isLevelOneMultiDimensionElementCompleted('recipient_country', $this->recipient_country);
    }

    /**
     * Returns budget element complete status.
     *
     * @return bool
     */
    public function getBudgetElementCompletedAttribute(): bool
    {
        return $this->isLevelOneMultiDimensionElementCompleted('budget', $this->budget);
    }

    /**
     * Returns recipient_region element complete status.
     *
     * @return bool
     */
    public function getRecipientRegionElementCompletedAttribute(): bool
    {
        return $this->isLevelOneMultiDimensionElementCompleted('recipient_region', $this->recipient_region);
    }

    /**
     * Returns default_aid_type element complete status.
     *
     * @return bool
     */
    public function getDefaultAidTypeElementCompletedAttribute(): bool
    {
        return $this->isLevelOneMultiDimensionElementCompleted('default_aid_type', $this->default_aid_type);
    }

    /**
     * Returns related_activity element complete status.
     *
     * @return bool
     */
    public function getRelatedActivityElementCompletedAttribute(): bool
    {
        return $this->isLevelOneMultiDimensionElementCompleted('related_activity', $this->related_activity);
    }

    /**
     * Returns description element complete status.
     *
     * @return bool
     */
    public function getSectorElementCompletedAttribute(): bool
    {
        return $this->isLevelOneMultiDimensionElementCompleted('sector', $this->sector);
    }

    /**
     * Returns humanitarian_scope element complete status.
     *
     * @return bool
     */
    public function getHumanitarianScopeElementCompletedAttribute(): bool
    {
        return $this->isLevelOneMultiDimensionElementCompleted('humanitarian_scope', $this->humanitarian_scope);
    }

    /**
     * Returns legacy_data element complete status.
     *
     * @return bool
     */
    public function getLegacyDataElementCompletedAttribute(): bool
    {
        return $this->isLevelOneMultiDimensionElementCompleted('legacy_data', $this->legacy_data);
    }

    /**
     * Returns tag element complete status.
     *
     * @return bool
     */
    public function getTagElementCompletedAttribute(): bool
    {
        return $this->isLevelOneMultiDimensionElementCompleted('tag', $this->tag);
    }

    /**
     * Returns policy_marker element complete status.
     *
     * @return bool
     */
    public function getPolicyMarkerElementCompletedAttribute(): bool
    {
        return $this->isLevelOneMultiDimensionElementCompleted('policy_marker', $this->policy_marker);
    }

    /**
     * Returns participating_org_element_completed element complete status.
     *
     * @return bool
     */
    public function getParticipatingOrgElementCompletedAttribute(): bool
    {
        return $this->isLevelOneMultiDimensionElementCompleted('participating_org', $this->participating_organization);
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
     * Returns other_identifier element complete status.
     *
     * @return bool
     */
    public function getOtherIdentifierElementCompletedAttribute(): bool
    {
        return $this->isLevelTwoSingleDimensionElementCompleted('other_identifier', $this->other_identifier);
    }

    /**
     * Returns conditions element complete status.
     *
     * @return bool
     */
    public function getConditionsElementCompletedAttribute(): bool
    {
        return $this->isLevelTwoSingleDimensionElementCompleted('conditions', $this->conditions);
    }

    /**
     * Returns conditions element complete status.
     *
     * @return bool
     */
    public function getDocumentLinkElementCompletedAttribute(): bool
    {
        $tempData = json_decode(
            '[{"url":"","format":"image\/png","title":[{"narrative":[{"narrative":"document-link-narrative1","language":"en"}]}],"description":[{"narrative":[{"narrative":null,"language":null}]}],"category":[{"code":"A01"}],"language":[{"language":null}],"document_date":[{"date":null}]}]',
            true
        );

        return $this->isLevelTwoMultiDimensionElementCompleted('document_link', $tempData);
    }

    /**
     * Returns contact_info element complete status.
     *
     * @return bool
     */
    public function getContactInfoElementCompletedAttribute(): bool
    {
        return $this->isLevelTwoMultiDimensionElementCompleted('contact_info', $this->contact_info);
    }

    /**
     * Returns location element complete status.
     *
     * @return bool
     */
    public function getLocationElementCompletedAttribute(): bool
    {
        return $this->isLevelTwoMultiDimensionElementCompleted('location', $this->location);
    }

    /**
     * Returns planned_disbursement element complete status.
     *
     * @return bool
     */
    public function getPlannedDisbursementElementCompletedAttribute(): bool
    {
        return $this->isLevelTwoMultiDimensionElementCompleted('planned_disbursement', $this->planned_disbursement);
    }

    /**
     * Returns country_budget_items element complete status.
     *
     * @return bool
     */
    public function getCountryBudgetItemsElementCompletedAttribute(): bool
    {
        return $this->isLevelThreeSingleDimensionElementCompleted('country_budget_items', $this->country_budget_items);
    }
}
