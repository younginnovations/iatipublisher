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

    public string $element = '';
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
     * Checks if array key exists.
     *
     * @param $data
     * @param $key
     *
     * @return array
     */
    public function extracted($data, $key): array
    {
        return array_key_exists($key, $data) ? $data[$key] : [];
    }

    /**
     * Returns element schema.
     *
     * @param $element
     *
     * @return mixed
     */
    public function getJsonSchema($element): mixed
    {
        $elementJsonSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);

        return $this->extracted($elementJsonSchema, $element);
    }

    /**
     * Returns mandatory fields.
     *
     * @param $field
     *
     * @return bool
     */
    public function isFieldMandatory($field): bool
    {
        return array_key_exists('criteria', $field) && $field['criteria'] == 'mandatory';
    }

    /**
     * @param       $fields
     * @param array $mandatoryFields
     *
     * @return array
     */
    public function getMandatoryFields($fields, array $mandatoryFields): array
    {
        foreach ($fields as $attribute) {
            if ($this->isFieldMandatory($attribute)) {
                $mandatoryFields[] = $attribute['name'];
            }
        }

        return $mandatoryFields;
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
        return $this->getMandatoryFields($attributes, []);
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

            if ($this->isFieldMandatory($field)) {
                $mandatoryFields[] = $field['name'];
            }

            if (isset($field['attributes'])) {
                $attributes = $field['attributes'];

                $mandatoryFields = $this->getMandatoryFields($attributes, $mandatoryFields);
            }

            if (!empty($mandatoryFields)) {
                $mandatoryElements[$field['name']] = $mandatoryFields;
            }
        }

        return $mandatoryElements;
    }

    /**
     * @param $subElement
     *
     * @return array
     */
    public function getMandatoryAttributes($subElement): array
    {
        return array_key_exists('attributes', $subElement) ? $this->mandatoryAttributes($subElement['attributes']) : [];
    }

    /**
     * @param $subElement
     *
     * @return array
     */
    public function getMandatorySubElements($subElement): array
    {
        return array_key_exists('sub_elements', $subElement) ? $this->mandatorySubElements($subElement['sub_elements']) : [];
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
        $elementSchema = $this->getJsonSchema($this->element);

        foreach ($mandatoryAttributes as $mandatoryAttribute) {
            if (array_key_exists('dependent_attributes', $elementSchema) && array_key_exists($mandatoryAttribute, $elementSchema['dependent_attributes'])) {
                $parentLevel = $elementSchema['attributes'];

                if (array_key_exists('sub_element', $elementSchema['dependent_attributes'][$mandatoryAttribute])
                    && !empty($elementSchema['dependent_attributes'][$mandatoryAttribute]['sub_element'])) {
                    $parentLevel = $elementSchema['sub_elements'][$elementSchema['dependent_attributes'][$mandatoryAttribute]['sub_element']]['attributes'];
                }

                $parent = $parentLevel[$mandatoryAttribute]['parent'];

                /*checks if parent attribute have specific value for child attribute to be relevant*/
                if (!in_array($data[$parent['name']], $parent['value'])) {
                    continue;
                }
            }

            if (!array_key_exists($mandatoryAttribute, $data) || (empty($data[$mandatoryAttribute]))) {
                //dd('isAttributeDataCompleted fx called1', ' Attribute is empty', 'attribute-check:', $mandatoryAttributes, $mandatoryAttribute, $data);

                return false;
            }
        }

        return true;
    }

    /**
     * Checks if single dimension attribute is complete.
     *
     * @param $elementSchema
     * @param $data
     *
     * @return bool
     */
    public function isSingleDimensionAttributeCompleted($elementSchema, $data): bool
    {
        $mandatoryAttributes = $this->getMandatoryAttributes($elementSchema);

        if (!empty($mandatoryAttributes)) {
            if (empty($data)) {
                return false;
            }

            if (!$this->isAttributeDataCompleted($mandatoryAttributes, $data)) {
                //dd('singleDimensionAttributeCheck fx called1', 'Level2 single dimension attribute is empty', 'attribute-check:', $mandatoryAttributes, $data);

                return false;
            }
        }

        return true;
    }

    /**
     * Checks if multi dimension attribute is complete.
     *
     * @param $elementSchema
     * @param $data
     *
     * @return bool
     */
    public function isMultiDimensionAttributeCompleted($elementSchema, $data): bool
    {
        $mandatoryAttributes = $this->getMandatoryAttributes($elementSchema);

        if (!empty($mandatoryAttributes)) {
            if (empty($data)) {
                return false;
            }
            foreach ($data as $datum) {
                if (!$this->isAttributeDataCompleted($mandatoryAttributes, $datum)) {
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

        if (empty($data)) {
            return false;
        }

        foreach ($mandatorySubElements as $key => $mandatorySubElement) {
            if (!array_key_exists($key, $data)) {
                //dd('isSubElementDataCompleted fx called1', 'Whole Sub element has not filled yet', 'sub-element-check:', $mandatorySubElement, $data);

                return false;
            }
            $items = $data[$key];

            if (empty($items)) {
                //dd('isSubElementDataCompleted fx called2', 'Sub element array is empty', 'sub-element-check:', $mandatorySubElement, $data, $items);

                return false;
            }

            foreach ($mandatorySubElement as $mandatoryField) {
                foreach ($items as $item) {
                    if (!array_key_exists($mandatoryField, $item) || (empty($item[$mandatoryField]))) {
                        //dd('isSubElementDataCompleted fx called3', 'Sub element is empty', 'sub-element-check:', $mandatoryField, $item);

                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * Checks if element's attribute and sub elements both are complete.
     *
     * @param $mandatoryAttributes
     * @param $mandatorySubElements
     * @param $data
     *
     * @return bool
     */
    public function isElementCompleted($mandatoryAttributes, $mandatorySubElements, $data): bool
    {
        if (!empty($mandatoryAttributes) || !empty($mandatorySubElements)) {
            if (empty($data)) {
                return false;
            }

            foreach ($data as $datum) {
                if (!$this->isAttributeDataCompleted($mandatoryAttributes, $datum)) {
                    //dd('isElementCompleted fx is called1', 'Attribute is empty', 'attribute-check:', $mandatoryAttributes, $data, $datum);

                    return false;
                }

                if (!$this->isSubElementDataCompleted($mandatorySubElements, $datum)) {
                    //dd('isElementCompleted fx is called2', 'Sub element is empty', 'sub-element-check:', $mandatorySubElements, $data, $datum);

                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Checks if sub element with attributes is complete.
     *
     * @param $subElements
     * @param $data
     *
     * @return bool
     */
    public function isSubElementCompleted($subElements, $data): bool
    {
        foreach ($subElements as $key => $subElement) {
            $mandatorySubElementAttributes = $this->getMandatoryAttributes($subElement);
            $mandatoryChildSubElements = $this->getMandatorySubElements($subElement);

            if (!empty($mandatorySubElementAttributes) || !empty($mandatoryChildSubElements)) {
                if (!array_key_exists($key, $data)) {
                    //dd('isSubElementCompleted fx is called1', 'Sub element key not present', $mandatorySubElementAttributes, $mandatoryChildSubElements, $key, $data);

                    return false;
                }

                if (empty($data[$key])) {
                    //dd('isSubElementCompleted fx is called2', 'Sub element empty', $mandatorySubElementAttributes, $mandatoryChildSubElements, $key, $data);

                    return false;
                }
                if (!$this->isElementCompleted($mandatorySubElementAttributes, $mandatoryChildSubElements, $data[$key])) {
                    return false;
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
        return $this->isSingleDimensionAttributeCompleted($this->getJsonSchema($element), $data);
    }

    /**
     * Checks if level one attribute and sub element is complete.
     *
     * @param $elementSchema
     * @param $data
     *
     * @return bool
     */
    public function isLevelOneMultiDimensionDataCompleted($elementSchema, $data): bool
    {
        $mandatoryAttributes = $this->getMandatoryAttributes($elementSchema);
        $mandatorySubElements = $this->getMandatorySubElements($elementSchema);

        return $this->isElementCompleted($mandatoryAttributes, $mandatorySubElements, $data);
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
        return $this->isLevelOneMultiDimensionDataCompleted($this->getJsonSchema($element), $data);
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
        if (!$this->singleDimensionAttributeCheck($element, $data)) {
            return false;
        }

        $elementSchema = $this->getJsonSchema($element);

        return $this->isSubElementCompleted($elementSchema['sub_elements'], $data);
    }

    /**
     * Checks if level two attribute and sub element is complete.
     *
     * @param $elementSchema
     * @param $data
     *
     * @return bool
     */
    public function isLevelTwoMultiDimensionDataCompleted($elementSchema, $data): bool
    {
        if (!$this->isMultiDimensionAttributeCompleted($elementSchema, $data)) {
            return false;
        }

        $subElements = $this->extracted($elementSchema, 'sub_elements');
        $mandatorySubElementsFlag = false;

        foreach ($subElements as $subElement) {
            $mandatorySubElementAttributes = $this->getMandatoryAttributes($subElement);

            if (!empty($mandatorySubElementAttributes)) {
                $mandatorySubElementsFlag = true;
                break;
            }

            $mandatoryChildSubElements = $this->getMandatorySubElements($subElement);

            if (!empty($mandatoryChildSubElements)) {
                $mandatorySubElementsFlag = true;
                break;
            }
        }

        if ($mandatorySubElementsFlag) {
            if (empty($data)) {
                return false;
            }
            foreach ($data as $datum) {
                if (!$this->isSubElementCompleted($subElements, $datum)) {
                    return false;
                }
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
        return $this->isLevelTwoMultiDimensionDataCompleted($this->getJsonSchema($element), $data);
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
        if (!$this->singleDimensionAttributeCheck($element, $data)) {
            return false;
        }

        $elementSchema = $this->getJsonSchema($element);
        $subElements = $elementSchema['sub_elements'];

        foreach ($subElements as $key => $subElement) {
            $mandatorySubElementAttributes = $this->getMandatoryAttributes($subElement);

            if (empty($mandatorySubElementAttributes)) {
                continue;
            }

            if (!array_key_exists($key, $data)) {
                //dd('isLevelThreeSingleDimensionElementCompleted fx called1', 'sub-element-empty', 'sub-element-check:', $mandatorySubElementAttributes, $key, $data);

                return false;
            }

            if (empty($data[$key])) {
                //dd('isLevelThreeSingleDimensionElementCompleted fx called2', 'sub-element-empty', 'sub-element-check:', $mandatorySubElementAttributes, $key, $data);

                return false;
            }

            $tempData = $data[$key];

            foreach ($tempData as $datum) {
                if (!$this->isAttributeDataCompleted($mandatorySubElementAttributes, $datum)) {
                    return false;
                }
            }

            $tempData = $data[$key];

            foreach ($tempData as $tempDatum) {
                if (!$this->isSubElementCompleted($subElement['sub_elements'], $tempDatum)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Checks if target or actual or baseline elements are completed.
     *
     * @param $elementSchema
     * @param $data
     *
     * @return bool
     */
    public function isTargetAndActualAndBaselineDataCompleted($elementSchema, $data): bool
    {
        if (!$this->isSingleDimensionAttributeCompleted($elementSchema, $data)) {
            return false;
        }

        $commentData = $this->extracted($data, 'comment');

        if (!$this->isLevelOneMultiDimensionDataCompleted($elementSchema['sub_elements']['comment'], $commentData)) {
            return false;
        }

        $dimensionData = $this->extracted($data, 'dimension');

        if (!$this->isLevelOneMultiDimensionDataCompleted($elementSchema['sub_elements']['dimension'], $dimensionData)) {
            return false;
        }

        $locationData = $this->extracted($data, 'location');

        if (!$this->isLevelOneMultiDimensionDataCompleted($elementSchema['sub_elements']['location'], $locationData)) {
            return false;
        }

        $documentLinkData = $this->extracted($data, 'document_link');

        if (!$this->isLevelTwoMultiDimensionDataCompleted($elementSchema['sub_elements']['document_link'], $documentLinkData)) {
            return false;
        }

        return true;
    }

    /**
     * Checks if period element is completed.
     *
     * @param $element
     * @param $data
     *
     * @return bool
     */
    public function isPeriodElementCompleted($element, $data): bool
    {
        $elementSchema = $this->getJsonSchema($element);
        $subElements = $this->getMandatorySubElements($elementSchema);

        foreach ($data as $datum) {
            if (!$this->isLevelOneMultiDimensionDataCompleted($subElements['period_start'], $this->extracted($datum, 'period_start'))) {
                return false;
            }

            if (!$this->isLevelOneMultiDimensionDataCompleted($subElements['period_end'], $this->extracted($datum, 'period_end'))) {
                return false;
            }

            if (!$this->isTargetAndActualAndBaselineCompleted($datum, $elementSchema['sub_elements'], 'target')) {
                return false;
            }

            if (!$this->isTargetAndActualAndBaselineCompleted($datum, $elementSchema['sub_elements'], 'actual')) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $data
     * @param $subElements
     * @param $key
     *
     * @return bool
     */
    public function isTargetAndActualAndBaselineCompleted($data, $subElements, $key): bool
    {
        $attributeData = $this->extracted($data, $key);

        foreach ($attributeData as $attributeDatum) {
            if (!$this->isTargetAndActualAndBaselineDataCompleted($subElements[$key], $attributeDatum)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks if result or indicator element is completed.
     *
     * @param $elementSchema
     * @param $data
     *
     * @return bool
     */
    public function isResultAndIndicatorElementCompleted($elementSchema, $data): bool
    {
        if (!$this->isSingleDimensionAttributeCompleted($elementSchema, $data)) {
            return false;
        }

        if (!$this->isLevelOneMultiDimensionDataCompleted($elementSchema['sub_elements']['title'], $this->extracted($data, 'title'))) {
            return false;
        }

        if (!$this->isLevelOneMultiDimensionDataCompleted($elementSchema['sub_elements']['description'], $this->extracted($data, 'description'))) {
            return false;
        }

        if (!$this->isLevelOneMultiDimensionDataCompleted($elementSchema['sub_elements']['reference'], $this->extracted($data, 'reference'))) {
            return false;
        }

        if (!$this->isLevelTwoMultiDimensionDataCompleted($elementSchema['sub_elements']['document_link'], $this->extracted($data, 'document_link'))) {
            return false;
        }

        return true;
    }

    /**
     * Checks if indicator element is completed.
     *
     * @param $element
     * @param $data
     *
     * @return bool
     */
    public function isIndicatorElementCompleted($element, $data): bool
    {
        $elementSchema = $this->getJsonSchema($element);

        foreach ($data as $datum) {
            if (!$this->isResultAndIndicatorElementCompleted($elementSchema, $datum)) {
                return false;
            }

            if (!$this->isTargetAndActualAndBaselineCompleted($datum, $elementSchema['sub_elements'], 'baseline')) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks if result element is completed.
     *
     * @param $element
     * @param $data
     *
     * @return bool
     */
    public function isResultElementCompleted($element, $data): bool
    {
        $elementSchema = $this->getJsonSchema($element);

        foreach ($data as $datum) {
            if (!$this->isResultAndIndicatorElementCompleted($elementSchema, $datum)) {
                return false;
            }
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
        $identifier = $this->iati_identifier;

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
        $this->element = 'title';
        $elementSchema = $this->getJsonSchema($this->element);

        return $this->isSubElementDataCompleted($this->mandatorySubElements($elementSchema['sub_elements']), ['narrative' => $this->title]);
    }

    /**
     * Returns description element complete status.
     *
     * @return bool
     */
    public function getDescriptionElementCompletedAttribute(): bool
    {
        $this->element = 'description';

        return $this->isLevelOneMultiDimensionElementCompleted('description', $this->description);
    }

    /**
     * Returns activity_date element complete status.
     *
     * @return bool
     */
    public function getActivityDateElementCompletedAttribute(): bool
    {
        $this->element = 'activity_date';

        return $this->isLevelOneMultiDimensionElementCompleted('activity_date', $this->activity_date);
    }

    /**
     * Returns recipient_country element complete status.
     *
     * @return bool
     */
    public function getRecipientCountryElementCompletedAttribute(): bool
    {
        $this->element = 'recipient_country';

        return $this->isLevelOneMultiDimensionElementCompleted('recipient_country', $this->recipient_country);
    }

    /**
     * Returns budget element complete status.
     *
     * @return bool
     */
    public function getBudgetElementCompletedAttribute(): bool
    {
        $this->element = 'budget';

        return $this->isLevelOneMultiDimensionElementCompleted('budget', $this->budget);
    }

    /**
     * Returns recipient_region element complete status.
     *
     * @return bool
     */
    public function getRecipientRegionElementCompletedAttribute(): bool
    {
        $this->element = 'recipient_region';

        return $this->isLevelOneMultiDimensionElementCompleted('recipient_region', $this->recipient_region);
    }

    /**
     * Returns default_aid_type element complete status.
     *
     * @return bool
     */
    public function getDefaultAidTypeElementCompletedAttribute(): bool
    {
        $this->element = 'default_aid_type';

        return $this->isLevelOneMultiDimensionElementCompleted('default_aid_type', $this->default_aid_type);
    }

    /**
     * Returns related_activity element complete status.
     *
     * @return bool
     */
    public function getRelatedActivityElementCompletedAttribute(): bool
    {
        $this->element = 'related_activity';

        return $this->isLevelOneMultiDimensionElementCompleted('related_activity', $this->related_activity);
    }

    /**
     * Returns description element complete status.
     *
     * @return bool
     */
    public function getSectorElementCompletedAttribute(): bool
    {
        $this->element = 'sector';

        return $this->isLevelOneMultiDimensionElementCompleted('sector', $this->sector);
    }

    /**
     * Returns humanitarian_scope element complete status.
     *
     * @return bool
     */
    public function getHumanitarianScopeElementCompletedAttribute(): bool
    {
        $this->element = 'humanitarian_scope';

        return $this->isLevelOneMultiDimensionElementCompleted('humanitarian_scope', $this->humanitarian_scope);
    }

    /**
     * Returns legacy_data element complete status.
     *
     * @return bool
     */
    public function getLegacyDataElementCompletedAttribute(): bool
    {
        $this->element = 'legacy_data';

        return $this->isLevelOneMultiDimensionElementCompleted('legacy_data', $this->legacy_data);
    }

    /**
     * Returns tag element complete status.
     *
     * @return bool
     */
    public function getTagElementCompletedAttribute(): bool
    {
        $this->element = 'tag';

        return $this->isLevelOneMultiDimensionElementCompleted('tag', $this->tag);
    }

    /**
     * Returns policy_marker element complete status.
     *
     * @return bool
     */
    public function getPolicyMarkerElementCompletedAttribute(): bool
    {
        $this->element = 'policy_marker';

        return $this->isLevelOneMultiDimensionElementCompleted('policy_marker', $this->policy_marker);
    }

    /**
     * Returns participating_org_element_completed element complete status.
     *
     * @return bool
     */
    public function getParticipatingOrgElementCompletedAttribute(): bool
    {
        $this->element = 'participating_org';

        return $this->isLevelOneMultiDimensionElementCompleted('participating_org', $this->participating_org);
    }

    /**
     * Returns activity_status element complete status.
     *
     * @return bool
     */
    public function getActivityStatusElementCompletedAttribute(): bool
    {
        $this->element = 'activity_status';

        return !empty($this->activity_status);
    }

    /**
     * Returns activity_scope element complete status.
     *
     * @return bool
     */
    public function getActivityScopeElementCompletedAttribute(): bool
    {
        $this->element = 'activity_scope';

        return !empty($this->activity_scope);
    }

    /**
     * Returns collaboration_type element complete status.
     *
     * @return bool
     */
    public function getCollaborationTypeElementCompletedAttribute(): bool
    {
        $this->element = 'collaboration_type';

        return !empty($this->collaboration_type);
    }

    /**
     * Returns default_flow_type element complete status.
     *
     * @return bool
     */
    public function getDefaultFlowTypeElementCompletedAttribute(): bool
    {
        $this->element = 'default_flow_type';

        return !empty($this->default_flow_type);
    }

    /**
     * Returns default_finance_type element complete status.
     *
     * @return bool
     */
    public function getDefaultFinanceTypeElementCompletedAttribute(): bool
    {
        $this->element = 'default_finance_type';

        return !empty($this->default_finance_type);
    }

    /**
     * Returns default_tied_status element complete status.
     *
     * @return bool
     */
    public function getDefaultTiedStatusElementCompletedAttribute(): bool
    {
        $this->element = 'default_tied_status';

        return !empty($this->default_tied_status);
    }

    /**
     * Returns capital_spend element complete status.
     *
     * @return bool
     */
    public function getCapitalSpendElementCompletedAttribute(): bool
    {
        $this->element = 'capital_spend';

        return !empty($this->capital_spend);
    }

    /**
     * Returns other_identifier element complete status.
     *
     * @return bool
     */
    public function getOtherIdentifierElementCompletedAttribute(): bool
    {
        $this->element = 'other_identifier';

        return $this->isLevelTwoSingleDimensionElementCompleted('other_identifier', $this->other_identifier);
    }

    /**
     * Returns conditions element complete status.
     *
     * @return bool
     */
    public function getConditionsElementCompletedAttribute(): bool
    {
        $this->element = 'conditions';

        return $this->isLevelTwoSingleDimensionElementCompleted('conditions', $this->conditions);
    }

    /**
     * Returns conditions element complete status.
     *
     * @return bool
     */
    public function getDocumentLinkElementCompletedAttribute(): bool
    {
        $this->element = 'document_link';

        return $this->isLevelTwoMultiDimensionElementCompleted('document_link', $this->document_link);
    }

    /**
     * Returns contact_info element complete status.
     *
     * @return bool
     */
    public function getContactInfoElementCompletedAttribute(): bool
    {
        $this->element = 'contact_info';

        return $this->isLevelTwoMultiDimensionElementCompleted('contact_info', $this->contact_info);
    }

    /**
     * Returns location element complete status.
     *
     * @return bool
     */
    public function getLocationElementCompletedAttribute(): bool
    {
        $this->element = 'location';

        return $this->isLevelTwoMultiDimensionElementCompleted('location', $this->location);
    }

    /**
     * Returns planned_disbursement element complete status.
     *
     * @return bool
     */
    public function getPlannedDisbursementElementCompletedAttribute(): bool
    {
        $this->element = 'planned_disbursement';

        return $this->isLevelTwoMultiDimensionElementCompleted('planned_disbursement', $this->planned_disbursement);
    }

    /**
     * Returns country_budget_items element complete status.
     *
     * @return bool
     */
    public function getCountryBudgetItemsElementCompletedAttribute(): bool
    {
        $this->element = 'country_budget_items';

        return $this->isLevelThreeSingleDimensionElementCompleted('country_budget_items', $this->country_budget_items);
    }

    /**
     * Returns period, indicator and result data.
     *
     * @return array
     */
    public function getFormattedResults(): array
    {
        $results = $this->results()->with('indicators.periods')->get()->toArray();
        $resultData = [];
        $indicatorData = [];
        $periodData = [];

        if (!empty($results)) {
            foreach ($results as $result) {
                $resultData[] = $result['result'];
                $indicators = $result['indicators'];

                if (!empty($indicators)) {
                    foreach ($indicators as $indicator) {
                        $indicatorData[] = $indicator;
                        $periods = $indicator['periods'];

                        if (!empty($periods)) {
                            foreach ($periods as $period) {
                                $periodData[] = $period;
                            }
                        }
                    }
                }
            }
        }

        return [$resultData, $indicatorData, $periodData];
    }

    /**
     * Returns result element complete status.
     *
     * @return bool
     */
    public function getResultElementCompletedAttribute(): bool
    {
        [$resultData, $periodData, $indicatorData] = $this->getFormattedResults();

        $this->element = 'period';

        if (!$this->isPeriodElementCompleted('period', $periodData)) {
            return false;
        }

        $this->element = 'indicator';

        if (!$this->isIndicatorElementCompleted('indicator', $indicatorData)) {
            return false;
        }

        $this->element = 'result';

        if (!$this->isResultElementCompleted('result', $resultData)) {
            return false;
        }

        return true;
    }

    /**
     * @param $subElements
     * @param $data
     *
     * @return bool
     */
    public function checkTransactionData($subElements, $data): bool
    {
        if (!$this->singleDimensionAttributeCheck('transactions', $data)) {
            return false;
        }

        foreach ($subElements as $subElement) {
            if (!$this->isLevelOneMultiDimensionDataCompleted($subElement, $data[$subElement['name']])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    public function getTransactionsElementCompletedAttribute(): bool
    {
        $transactionData = $this->transactions()->get()->toArray();

        if (!empty($transactionData)) {
            $this->element = 'transactions';
            $elementSchema = $this->getJsonSchema($this->element);

            foreach ($transactionData as $transactionDatum) {
                if (!$this->checkTransactionData($elementSchema['sub_elements'], $transactionDatum['transaction'])) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }
}
