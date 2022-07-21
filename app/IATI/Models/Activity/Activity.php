<?php

namespace App\IATI\Models\Activity;

use App\IATI\Models\Document\Document;
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

    public $element = '';

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentLinks()
    {
        return $this->hasMany(Document::class);
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
        $elementJsonSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $elementSchema     = $elementJsonSchema[$this->element];

        foreach ($mandatoryAttributes as $mandatoryAttribute) {
            if (array_key_exists('dependent_attributes', $elementSchema) && array_key_exists($mandatoryAttribute, $elementSchema['dependent_attributes'])) {
                $parentLevel = $elementSchema['attributes'];

                if (array_key_exists(
                        'sub_element',
                        $elementSchema['dependent_attributes'][$mandatoryAttribute]
                    ) && !empty($elementSchema['dependent_attributes'][$mandatoryAttribute]['sub_element'])) {
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
        $mandatoryAttributes = array_key_exists('attributes', $elementSchema) ? $this->mandatoryAttributes($elementSchema['attributes']) : [];

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
        $mandatoryAttributes = array_key_exists('attributes', $elementSchema) ? $this->mandatoryAttributes($elementSchema['attributes']) : [];

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
            $mandatorySubElementAttributes = array_key_exists('attributes', $subElement) ? $this->mandatoryAttributes($subElement['attributes']) : [];
            $mandatoryChildSubElements     = array_key_exists('sub_elements', $subElement) ? $this->mandatorySubElements($subElement['sub_elements']) : [];

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
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);

        return $this->isSingleDimensionAttributeCompleted($elementSchema[$element], $data);
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
        $mandatoryAttributes  = array_key_exists('attributes', $elementSchema) ? $this->mandatoryAttributes($elementSchema['attributes']) : [];
        $mandatorySubElements = array_key_exists('sub_elements', $elementSchema) ? $this->mandatorySubElements($elementSchema['sub_elements']) : [];

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
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);

        return $this->isLevelOneMultiDimensionDataCompleted($elementSchema[$element], $data);
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

        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $subElements   = $elementSchema[$element]['sub_elements'];

        return $this->isSubElementCompleted($subElements, $data);
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

        $subElements              = array_key_exists('sub_elements', $elementSchema) ? $elementSchema['sub_elements'] : [];
        $mandatorySubElementsFlag = false;

        foreach ($subElements as $key => $subElement) {
            $mandatorySubElementAttributes = array_key_exists('attributes', $subElement) ? $this->mandatoryAttributes($subElement['attributes']) : [];

            if (!empty($mandatorySubElementAttributes)) {
                $mandatorySubElementsFlag = true;
                break;
            }

            $mandatoryChildSubElements = array_key_exists('sub_elements', $subElement) ? $this->mandatorySubElements($subElement['sub_elements']) : [];

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
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);

        return $this->isLevelTwoMultiDimensionDataCompleted($elementSchema[$element], $data);
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

        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $subElements   = $elementSchema[$element]['sub_elements'];

        foreach ($subElements as $key => $subElement) {
            $mandatorySubElementAttributes = array_key_exists('attributes', $subElement) ? $this->mandatoryAttributes($subElement['attributes']) : [];

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
    public function isTargetAndActualAndBaselineCompleted($elementSchema, $data): bool
    {
        if (!$this->isSingleDimensionAttributeCompleted($elementSchema, $data)) {
            return false;
        }

        $commentData = array_key_exists('comment', $data) ? $data['comment'] : [];

        if (!$this->isLevelOneMultiDimensionDataCompleted($elementSchema['sub_elements']['comment'], $commentData)) {
            return false;
        }

        $dimensionData = array_key_exists('dimension', $data) ? $data['dimension'] : [];

        if (!$this->isLevelOneMultiDimensionDataCompleted($elementSchema['sub_elements']['dimension'], $dimensionData)) {
            return false;
        }

        $locationData = array_key_exists('location', $data) ? $data['location'] : [];

        if (!$this->isLevelOneMultiDimensionDataCompleted($elementSchema['sub_elements']['location'], $locationData)) {
            return false;
        }

        $documentLinkData = array_key_exists('document_link', $data) ? $data['document_link'] : [];

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
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $subElements   = array_key_exists('sub_elements', $elementSchema[$element]) ? $elementSchema[$element]['sub_elements'] : [];

        foreach ($data as $datum) {
            $periodStartData = array_key_exists('period_start', $datum) ? $datum['period_start'] : [];

            if (!$this->isLevelOneMultiDimensionDataCompleted($subElements['period_start'], $periodStartData)) {
                return false;
            }

            $periodEndData = array_key_exists('period_end', $datum) ? $datum['period_end'] : [];

            if (!$this->isLevelOneMultiDimensionDataCompleted($subElements['period_end'], $periodEndData)) {
                return false;
            }

            $targetData = array_key_exists('target', $datum) ? $datum['target'] : [];

            foreach ($targetData as $targetDatum) {
                if (!$this->isTargetAndActualAndBaselineCompleted($elementSchema[$element]['sub_elements']['target'], $targetDatum)) {
                    return false;
                }
            }

            $actualData = array_key_exists('actual', $datum) ? $datum['actual'] : [];

            foreach ($actualData as $actualDatum) {
                if (!$this->isTargetAndActualAndBaselineCompleted($elementSchema[$element]['sub_elements']['actual'], $actualDatum)) {
                    return false;
                }
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

        $titleData = array_key_exists('title', $data) ? $data['title'] : [];

        if (!$this->isLevelOneMultiDimensionDataCompleted($elementSchema['sub_elements']['title'], $titleData)) {
            return false;
        }

        $descriptionData = array_key_exists('description', $data) ? $data['description'] : [];

        if (!$this->isLevelOneMultiDimensionDataCompleted($elementSchema['sub_elements']['description'], $descriptionData)) {
            return false;
        }

        $referenceData = array_key_exists('reference', $data) ? $data['reference'] : [];

        if (!$this->isLevelOneMultiDimensionDataCompleted($elementSchema['sub_elements']['reference'], $referenceData)) {
            return false;
        }

        $documentLinkData = array_key_exists('document_link', $data) ? $data['document_link'] : [];

        if (!$this->isLevelTwoMultiDimensionDataCompleted($elementSchema['sub_elements']['document_link'], $documentLinkData)) {
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
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);

        foreach ($data as $datum) {
            if (!$this->isResultAndIndicatorElementCompleted($elementSchema[$element], $datum)) {
                return false;
            }

            $baselineData = $datum['baseline'];

            foreach ($baselineData as $baselineDatum) {
                $this->isTargetAndActualAndBaselineCompleted($elementSchema[$element]['sub_elements']['baseline'], $baselineDatum);
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
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);

        foreach ($data as $datum) {
            if (!$this->isResultAndIndicatorElementCompleted($elementSchema[$element], $datum)) {
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
        $identifier = json_decode($this->iati_identifier, true);

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
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);

        return $this->isSubElementDataCompleted($this->mandatorySubElements($elementSchema['title']['sub_elements']), ['narrative' => $this->title]);
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

        $tempData = json_decode(
            '[{"url":"asdsad","format":"image\/png","title":[{"narrative":[{"narrative":"document-link-narrative1","language":"en"}]}],"description":[{"narrative":[{"narrative":null,"language":null}]}],"category":[{"code":"A01"}],"language":[{"language":null}],"document_date":[{"date":null}]}]',
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
     * Returns result element complete status.
     *
     * @return bool
     */
    public function getResultElementCompletedAttribute(): bool
    {
        $this->element = 'period';

        $periodData = json_decode(
            '[{"period_start":[{"date":"asd"}],"period_end":[{"date":"asd"}],"target":[{"value":"12","comment":[{"narrative":[{"narrative":"asdasd","language":"ak"}]}], "dimension":[{"name":"asdsad","value":null}],"document_link":[{"url":"www.google.com","format":"asdasd","title":[{"narrative":[{"narrative":"test","language":"fr"}]}],"description":[{"narrative":[{"narrative":"asdasd","language":"en"}]}],"category":[{"code":"AG"}],"language":[{"language":null}],"document_date":[{"date":"2022-08-06"}]}],"location":[{"reference":null}]}],"actual":[{"value":"10","comment":[{"narrative":[{"narrative":"comment actual","language":"bs"}]}],"dimension":[{"name":"asdsad","value":null}],"document_link":[{"url":"www.google.com","format":"asdasd","title":[{"narrative":[{"narrative":"asdasd","language":"en"}]}],"description":[{"narrative":[{"narrative":"asdasda","language":"fr"}]}],"category":[{"code":"AE"}],"language":[{"language":null}],"document_date":[{"date":"2022-08-06"}]}],"location":[{"reference":null}]}]},{"period_start":[{"date":"2022-06-28"}],"period_end":[{"date":"2022-08-06"}],"target":[{"value":"12","comment":[{"narrative":[{"narrative":"comment","language":"ak"}]}],"dimension":[{"name":"asdsad","value":null}],"document_link":[{"url":"www.google.com","format":"asdasd","title":[{"narrative":[{"narrative":"asdasda","language":"ar"}]}],"description":[{"narrative":[{"narrative":"asdasda","language":"gr"}]}],"category":[{"code":"BB"}],"language":[{"language":null}],"document_date":[{"date":"2022-08-06"}]}],"location":[{"reference":null}]}],"actual":[{"value":"10","comment":[{"narrative":[{"narrative":"comment actual","language":"bs"}]}],"dimension":[{"name":"asdasd","value":null}],"document_link":[{"url":"www.google.com","format":"asdasd","title":[{"narrative":[{"narrative":"asdasda","language":"sp"}]}],"description":[{"narrative":[{"narrative":"asdasda","language":"an"}]}],"category":[{"code":"EE"}],"language":[{"language":null}],"document_date":[{"date":"2020"}]}],"location":[{"reference":null}]}]}]',
            true
        );

        if (!$this->isPeriodElementCompleted('period', $periodData)) {
            return false;
        }

        $this->element = 'indicator';

        $indicatorData = json_decode(
            '[{"measure":"1","ascending":"1","aggregation_status":"1","title":[{"narrative":[{"narrative":"asdasd","language":"ab"},{"narrative":"test title 2","language":"af"}]}],"description":[{"narrative":[{"narrative":"test description 1","language":"ab"},{"narrative":"test description 2","language":"af"}]}],"document_link":[{"url":"/https://minio-stage.yipl.com.np:9000/document_link/1/uahep_prod422.backup","format":"application/3gpp-ims+xml","title":[{"narrative":[{"narrative":"test title 1","language":"ak"},{"narrative":"test title 2","language":"ak"}]}],"description":[{"narrative":[{"narrative":"test description","language":"ab"},{"narrative":"test 2 description","language":"ak"}]}],"category":[{"code":"A03"},{"code":"A04"}],"language":[{"language":"ab"},{"language":"ak"}],"document_date":[{"date":"2022-07-11"}]}],"reference":[{"vocabulary":"2","code":"123","indicator_uri":"http://localhost:8000/activities/1/result/1/indicator/create"},{"vocabulary":"4","code":"456","indicator_uri":"http://localhost:8000/activities/1/result/1/indicator/create"}],"baseline":[{"year":"2020","date":"2020-02-13","value":"12","comment":[{"narrative":[{"narrative":"comment","language":"ae"},{"narrative":"comment 2","language":"am"}]}],"dimension":[{"name":"dimension 1","value":"12"},{"name":"dimension 2","value":"23"}],"document_link":[{"url":"/http://localhost:8000/activities/1/result/1/indicator/create","format":"application/3gpdash-qoe-report+xml","title":[{"narrative":[{"narrative":"test","language":"ab"},{"narrative":"title document link","language":"am"}]}],"description":[{"narrative":[{"narrative":"description 1","language":"ae"},{"narrative":"description 2","language":"am"}]}],"category":[{"code":"A04"},{"code":"A02"}],"language":[{"language":"ab"},{"language":"am"}],"document_date":[{"date":"2022-07-07"}]}],"location":[{"reference":"location 1"}]},{"year":"2022","date":"2022-07-07","value":"123","comment":[{"narrative":[{"narrative":"comment","language":"ae"},{"narrative":"comment 2","language":"am"}]}],"dimension":[{"name":"dimension baseline 2","value":"456"}],"document_link":[{"url":"/http://localhost:8000/activities/1/result/1/indicator/create","format":"application/3gpp-ims+xml","title":[{"narrative":[{"narrative":"narrative 1","language":"af"},{"narrative":"narrative 2","language":"ae"}]}],"description":[{"narrative":[{"narrative":"des","language":"ab"}]}],"category":[{"code":"A05"},{"code":"A06"}],"language":[{"language":"ae"},{"language":"am"}],"document_date":[{"date":"2022-07-07"}]},{"url":"/document_link 2","format":"application/3gpp-ims+xml","title":[{"narrative":[{"narrative":"asdf","language":"ab"}]}],"description":[{"narrative":[{"narrative":"narrative","language":"ab"},{"narrative":"narrative","language":"ak"}]}],"category":{"0":{"code":"A05"},"7":{"code":"A04"}},"language":{"0":{"language":"aa"},"6":{"language":"ak"}},"document_date":[{"date":"2022-07-07"}]},{"url":"/document_link 2","format":"application/3gpp-ims+xml","title":[{"narrative":[{"narrative":"asdf","language":"ab"}]}],"description":[{"narrative":[{"narrative":"narrative","language":"ab"},{"narrative":"narrative","language":"ak"}]}],"category":[{"code":"A05"},{"code":"A04"}],"language":[{"language":"aa"},{"language":"ak"}],"document_date":[{"date":"2022-07-07"}]}],"location":[{"reference":"test location"}]}]}]',
            true
        );

        if (!$this->isIndicatorElementCompleted('indicator', $indicatorData)) {
            return false;
        }

        $this->element = 'result';

        $resultData = json_decode(
            '[{"type":"1","aggregation_status":"1","title":[{"narrative":[{"narrative":"title narrative 1","language":"aa"},{"narrative":"title narrative 2","language":"am"}]}],"description":[{"narrative":[{"narrative":"description narrative 1","language":"aa"},{"narrative":"description narrative 2","language":"am"}]}],"document_link":[{"url":"https:\/\/minio-stage.yipl.com.np:9000\/document_link\/1\/uahep_prod422.backup","format":"application\/1d-interleaved-parityfec","title":[{"narrative":[{"narrative":"title 11","language":"ab"},{"narrative":"title 12","language":"am"}]}],"description":[{"narrative":[{"narrative":"description 11","language":"aa"},{"narrative":"description 12","language":"am"}]}],"category":[{"code":"A01"},{"code":"A06"}],"language":[{"language":"aa"},{"language":"am"}],"document_date":[{"date":"2022-07-07"}]},{"url":"http:\/\/192.168.254.240:9000\/document_link\/2\/Uahep.postman_collection.json","format":"application\/1d-interleaved-parityfec","title":[{"narrative":[{"narrative":"title 21","language":"aa"},{"narrative":"title 22","language":"am"}]}],"description":[{"narrative":[{"narrative":"description 21","language":"aa"},{"narrative":"description 22","language":"am"}]}],"category":[{"code":"A01"},{"code":"A05"}],"language":[{"language":"aa"},{"language":"am"}],"document_date":[{"date":"asdsad"}]}],"reference":[{"vocabulary":"99","code":"123","vocabulary_uri":"http:\/\/json-parser.com\/8e6e1d55\/1"},{"vocabulary":"99","code":"456","vocabulary_uri":"http:\/\/json-parser.com\/8e6e1d55\/2"}]}]',
            true
        );

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
        $this->element   = 'transactions';
        $transactionData = json_decode(
            '[{"reference":"ref test","humanitarian":"1","transaction_type":[{"transaction_type_code":"1"}],"transaction_date":[{"date":"2022-07-08"}],"value":[{"amount":"5000","date":"2022-07-08","currency":"AED"}],"description":[{"narrative":[{"narrative":"test description","language":"ab"},{"narrative":"description 2","language":"af"}]}],"provider_organization":[{"organization_identifier_code":"provider ref","provider_activity_id":"15","type":"15","narrative":[{"narrative":"narative 1","language":"ae"},{"narrative":"narrative 2","language":"am"}]}],"receiver_organization":[{"organization_identifier_code":"receiver org","receiver_activity_id":"16","type":"15","narrative":[{"narrative":"receiver narrative 1","language":"ab"},{"narrative":"receiver narrative 2","language":"ak"}]}],"disbursement_channel":[{"disbursement_channel_code":"123"}],"sector":[{"sector_vocabulary":"2","vocabulary_uri":null,"code":null,"text":null,"category_code":"112","sdg_goal":null,"sdg_target":null,"narrative":[{"narrative":"test narrative","language":"ab"},{"narrative":"test narrative 2","language":"am"}]},{"sector_vocabulary":"4","vocabulary_uri":null,"code":null,"text":"5638","category_code":null,"sdg_goal":null,"sdg_target":null,"narrative":[{"narrative":"narrative 22","language":"af"},{"narrative":"narrative 23","language":"am"}]}],"recipient_country":[{"country_code":"AL","narrative":[{"narrative":"test narrative","language":"ab"},{"narrative":"test narrative recipient","language":"am"}]}],"recipient_region":[{"region_vocabulary":"99","region_code":"123","custom_code":"test code","vocabulary_uri":"https:\/\/github.com\/younginnovations\/iatipublisher\/runs\/6980821807?check_suite_focus=true","narrative":[{"narrative":"narrative region 1","language":"aa"},{"narrative":"narrative region 2","language":"am"}]}],"flow_type":[{"flow_type":"10"}],"finance_type":[{"finance_type":"210"}],"aid_type":[{"aid_type_vocabulary":"1","aid_type_code":"A02","earmarking_category":"asdasd","earmarking_modality":"asd","cash_and_voucher_modalities":"asdasd"},{"aid_type_vocabulary":"4","aid_type_code":"asdsad","earmarking_category":"asdasd","earmarking_modality":"asdsad","cash_and_voucher_modalities":"1"}],"tied_status":[{"tied_status_code":"3"}]}]',
            true
        );
        $elementSchema = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $subElements = $elementSchema['transactions']['sub_elements'];

        foreach ($transactionData as $transactionDatum) {
            if (!$this->checkTransactionData($subElements, $transactionDatum)) {
                return false;
            }
        }

        return true;
    }
}
