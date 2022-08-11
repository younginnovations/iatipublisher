<?php

declare(strict_types=1);

namespace App\IATI\Services;

/**
 * Class ElementCompleteService.
 */
class ElementCompleteService
{
    /**
     * Public variable element.
     *
     * @var string
     */
    public string $element = '';

    /**
     * Returns mandatory fields.
     *
     * @param $field
     *
     * @return bool
     */
    public function isFieldMandatory($field): bool
    {
        return array_key_exists('criteria', $field) && $field['criteria'] === 'mandatory';
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
     * Returns mandatory attributes.
     *
     * @param $subElement
     *
     * @return array
     */
    public function getMandatoryAttributes($subElement): array
    {
        return array_key_exists('attributes', $subElement) ? $this->mandatoryAttributes($subElement['attributes']) : [];
    }

    /**
     * Returns mandatory sub elements.
     *
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
     * @throws \JsonException
     */
    public function isAttributeDataCompleted($mandatoryAttributes, $data): bool
    {
        if (empty($mandatoryAttributes)) {
            return true;
        }

        if (empty($data)) {
            return false;
        }

        $elementSchema = getElementSchema($this->element);

        foreach ($mandatoryAttributes as $mandatoryAttribute) {
            if (array_key_exists('dependent_attributes', $elementSchema) && array_key_exists($mandatoryAttribute, $elementSchema['dependent_attributes'])) {
                $parentLevel = $elementSchema['attributes'];

                if (array_key_exists('sub_element', $elementSchema['dependent_attributes'][$mandatoryAttribute])
                    && !empty($elementSchema['dependent_attributes'][$mandatoryAttribute]['sub_element'])) {
                    $parentLevel = $elementSchema['sub_elements'][$elementSchema['dependent_attributes'][$mandatoryAttribute]['sub_element']]['attributes'];
                }

                $parent = $parentLevel[$mandatoryAttribute]['parent'];

                /*checks if parent attribute have specific value for child attribute to be relevant*/
                if (!in_array($data[$parent['name']], $parent['value'], true)) {
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
     * @throws \JsonException
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
     * @throws \JsonException
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
     * @throws \JsonException
     */
    public function isElementCompleted($mandatoryAttributes, $mandatorySubElements, $data): bool
    {
        if (!empty($mandatoryAttributes) || !empty($mandatorySubElements)) {
            if (empty($data)) {
                return false;
            }

            foreach ($data as $datum) {
                if (!$this->isAttributeDataCompleted($mandatoryAttributes, $datum)) {
                    //dd('isElementCompleted fx is called1', 'Attribute is empty', 'mandatory-attributes:', $mandatoryAttributes, $data, $datum);

                    return false;
                }

                if (!$this->isSubElementDataCompleted($mandatorySubElements, $datum)) {
                    //dd('isElementCompleted fx is called2', 'Sub element is empty', 'mandatory-sub-element:', $mandatorySubElements, $data, $datum);

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
     * @throws \JsonException
     */
    public function isSubElementCompleted($subElements, $data): bool
    {
        foreach ($subElements as $key => $subElement) {
            $mandatorySubElementAttributes = $this->getMandatoryAttributes($subElement);
            $mandatoryChildSubElements = $this->getMandatorySubElements($subElement);

            if (!empty($mandatorySubElementAttributes) || !empty($mandatoryChildSubElements)) {
                if (!array_key_exists($key, $data)) {
                    //dd('isSubElementCompleted fx is called1', 'Sub element key not present', 'mandatory-sub-element_attributes:', $mandatorySubElementAttributes, 'mandatory-child-sub-elements: ',
                    //  $mandatoryChildSubElements, $key, $data);

                    return false;
                }

                if (empty($data[$key])) {
                    //dd('isSubElementCompleted fx is called2', 'Sub element empty', 'mandatory-sub-element_attributes:', $mandatorySubElementAttributes, 'mandatory-child-sub-elements: ',
                    //$mandatoryChildSubElements, $key, $data);

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
     * @param $data
     *
     * @return bool
     * @throws \JsonException
     */
    public function singleDimensionAttributeCheck($data): bool
    {
        return $this->isSingleDimensionAttributeCompleted(getElementSchema($this->element), $data);
    }

    /**
     * Checks if level one attribute and sub element is complete.
     *
     * @param $elementSchema
     * @param $data
     *
     * @return bool
     * @throws \JsonException
     */
    public function isLevelOneMultiDimensionDataCompleted($elementSchema, $data): bool
    {
        return $this->isElementCompleted($this->getMandatoryAttributes($elementSchema), $this->getMandatorySubElements($elementSchema), $data);
    }

    /**
     * Checks if all element is complete.
     *
     * @param $data
     *
     * @return bool
     * @throws \JsonException
     */
    public function isLevelOneMultiDimensionElementCompleted($data): bool
    {
        return $this->isLevelOneMultiDimensionDataCompleted(getElementSchema($this->element), $data);
    }

    /**
     * Checks if two level sub element is complete.
     *
     * @param $data
     *
     * @return bool
     * @throws \JsonException
     */
    public function isLevelTwoSingleDimensionElementCompleted($data): bool
    {
        if (!$this->singleDimensionAttributeCheck($data)) {
            return false;
        }

        $elementSchema = getElementSchema($this->element);

        return $this->isSubElementCompleted($elementSchema['sub_elements'], $data);
    }

    /**
     * Checks if level two attribute and sub element is complete.
     *
     * @param $elementSchema
     * @param $data
     *
     * @return bool
     * @throws \JsonException
     */
    public function isLevelTwoMultiDimensionDataCompleted($elementSchema, $data): bool
    {
        if (!$this->isMultiDimensionAttributeCompleted($elementSchema, $data)) {
            return false;
        }

        $subElements = getArr($elementSchema, 'sub_elements');
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
     * @param $data
     *
     * @return bool
     * @throws \JsonException
     */
    public function isLevelTwoMultiDimensionElementCompleted($data): bool
    {
        return $this->isLevelTwoMultiDimensionDataCompleted(getElementSchema($this->element), $data);
    }

    /**
     * Checks three level sub element is complete.
     *
     * @param $data
     *
     * @return bool
     * @throws \JsonException
     */
    public function isLevelThreeSingleDimensionElementCompleted($data): bool
    {
        if (!$this->singleDimensionAttributeCheck($data)) {
            return false;
        }

        $elementSchema = getElementSchema($this->element);
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
     * Returns identifier element complete status.
     *
     * @param $activity
     *
     * @return bool
     */
    public function isIatiIdentifierElementCompleted($activity): bool
    {
        $identifier = $activity->iati_identifier;

        return !(!array_key_exists('activity_identifier', $identifier) || empty($identifier['activity_identifier']));
    }

    /**
     * Returns title element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isTitleElementCompleted($activity): bool
    {
        $this->element = 'title';
        $elementSchema = getElementSchema($this->element);

        return $this->isSubElementDataCompleted($this->mandatorySubElements($elementSchema['sub_elements']), ['narrative' => $activity->title]);
    }

    /**
     * Returns description element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isDescriptionElementCompleted($activity): bool
    {
        $this->element = 'description';

        return $this->isLevelOneMultiDimensionElementCompleted($activity->description);
    }

    /**
     * Returns activity_date element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isActivityDateElementCompleted($activity): bool
    {
        $this->element = 'activity_date';

        return $this->isLevelOneMultiDimensionElementCompleted($activity->activity_date);
    }

    /**
     * Returns recipient_country element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isRecipientCountryElementCompleted($activity): bool
    {
        $this->element = 'recipient_country';

        return $this->isLevelOneMultiDimensionElementCompleted($activity->recipient_country);
    }

    /**
     * Returns budget element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isBudgetElementCompleted($activity): bool
    {
        $this->element = 'budget';

        return $this->isLevelOneMultiDimensionElementCompleted($activity->budget);
    }

    /**
     * Returns recipient_region element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isRecipientRegionElementCompleted($activity): bool
    {
        $this->element = 'recipient_region';

        return $this->isLevelOneMultiDimensionElementCompleted($activity->recipient_region);
    }

    /**
     * Returns default_aid_type element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isDefaultAidTypeElementCompleted($activity): bool
    {
        $this->element = 'default_aid_type';

        return $this->isLevelOneMultiDimensionElementCompleted($activity->default_aid_type);
    }

    /**
     * Returns related_activity element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isRelatedActivityElementCompleted($activity): bool
    {
        $this->element = 'related_activity';

        return $this->isLevelOneMultiDimensionElementCompleted($activity->related_activity);
    }

    /**
     * Returns description element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isSectorElementCompleted($activity): bool
    {
        $this->element = 'sector';

        return $this->isLevelOneMultiDimensionElementCompleted($activity->sector);
    }

    /**
     * Returns humanitarian_scope element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isHumanitarianScopeElementCompleted($activity): bool
    {
        $this->element = 'humanitarian_scope';

        return $this->isLevelOneMultiDimensionElementCompleted($activity->humanitarian_scope);
    }

    /**
     * Returns legacy_data element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isLegacyDataElementCompleted($activity): bool
    {
        $this->element = 'legacy_data';

        return $this->isLevelOneMultiDimensionElementCompleted($activity->legacy_data);
    }

    /**
     * Returns tag element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isTagElementCompleted($activity): bool
    {
        $this->element = 'tag';

        return $this->isLevelOneMultiDimensionElementCompleted($activity->tag);
    }

    /**
     * Returns policy_marker element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isPolicyMarkerElementCompleted($activity): bool
    {
        $this->element = 'policy_marker';

        return $this->isLevelOneMultiDimensionElementCompleted($activity->policy_marker);
    }

    /**
     * Returns participating_org_element_completed element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isParticipatingOrgElementCompleted($activity): bool
    {
        $this->element = 'participating_org';

        return $this->isLevelOneMultiDimensionElementCompleted($activity->participating_org);
    }

    /**
     * Returns activity_status element complete status.
     *
     * @param $activity
     *
     * @return bool
     */
    public function isActivityStatusElementCompleted($activity): bool
    {
        $this->element = 'activity_status';

        return !empty($activity->activity_status);
    }

    /**
     * Returns activity_scope element complete status.
     *
     * @param $activity
     *
     * @return bool
     */
    public function isActivityScopeElementCompleted($activity): bool
    {
        $this->element = 'activity_scope';

        return !empty($activity->activity_scope);
    }

    /**
     * Returns collaboration_type element complete status.
     *
     * @param $activity
     *
     * @return bool
     */
    public function isCollaborationTypeElementCompleted($activity): bool
    {
        $this->element = 'collaboration_type';

        return !empty($activity->collaboration_type);
    }

    /**
     * Returns default_flow_type element complete status.
     *
     * @param $activity
     *
     * @return bool
     */
    public function isDefaultFlowTypeElementCompleted($activity): bool
    {
        $this->element = 'default_flow_type';

        return !empty($activity->default_flow_type);
    }

    /**
     * Returns default_finance_type element complete status.
     *
     * @param $activity
     *
     * @return bool
     */
    public function isDefaultFinanceTypeElementCompleted($activity): bool
    {
        $this->element = 'default_finance_type';

        return !empty($activity->default_finance_type);
    }

    /**
     * Returns default_tied_status element complete status.
     *
     * @param $activity
     *
     * @return bool
     */
    public function isDefaultTiedStatusElementCompleted($activity): bool
    {
        $this->element = 'default_tied_status';

        return !empty($activity->default_tied_status);
    }

    /**
     * Returns capital_spend element complete status.
     *
     * @param $activity
     *
     * @return bool
     */
    public function isCapitalSpendElementCompleted($activity): bool
    {
        $this->element = 'capital_spend';

        return !empty($activity->capital_spend);
    }

    /**
     * Returns other_identifier element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isOtherIdentifierElementCompleted($activity): bool
    {
        $this->element = 'other_identifier';

        return $this->isLevelTwoSingleDimensionElementCompleted($activity->other_identifier);
    }

    /**
     * Returns conditions element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isConditionsElementCompleted($activity): bool
    {
        $this->element = 'conditions';

        return $this->isLevelTwoSingleDimensionElementCompleted($activity->conditions);
    }

    /**
     * Returns conditions element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isDocumentLinkElementCompleted($activity): bool
    {
        $this->element = 'document_link';

        return $this->isLevelTwoMultiDimensionElementCompleted($activity->document_link);
    }

    /**
     * Returns contact_info element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isContactInfoElementCompleted($activity): bool
    {
        $this->element = 'contact_info';

        return $this->isLevelTwoMultiDimensionElementCompleted($activity->contact_info);
    }

    /**
     * Returns location element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isLocationElementCompleted($activity): bool
    {
        $this->element = 'location';

        return $this->isLevelTwoMultiDimensionElementCompleted($activity->location);
    }

    /**
     * Returns planned_disbursement element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isPlannedDisbursementElementCompleted($activity): bool
    {
        $this->element = 'planned_disbursement';

        return $this->isLevelTwoMultiDimensionElementCompleted($activity->planned_disbursement);
    }

    /**
     * Returns country_budget_items element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isCountryBudgetItemsElementCompleted($activity): bool
    {
        $this->element = 'country_budget_items';

        return $this->isLevelThreeSingleDimensionElementCompleted($activity->country_budget_items);
    }

    /**
     * Checks if target or actual or baseline elements are completed.
     *
     * @param $elementSchema
     * @param $data
     *
     * @return bool
     * @throws \JsonException
     */
    public function isTargetAndActualAndBaselineDataCompleted($elementSchema, $data): bool
    {
        foreach (['comment', 'dimension', 'location'] as $item) {
            if (!$this->isLevelOneMultiDimensionDataCompleted($elementSchema['sub_elements'][$item], getArr($data, $item))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks if period element is completed.
     *
     * @param $data
     *
     * @return bool
     * @throws \JsonException
     */
    public function isPeriodElementCompleted($data): bool
    {
        $this->element = 'period';
        $elementSchema = getElementSchema($this->element);

        foreach ($data as $datum) {
            foreach (['period_start', 'period_end'] as $item) {
                if (!$this->isLevelOneMultiDimensionDataCompleted($elementSchema['sub_elements'][$item], getArr($datum, $item))) {
                    return false;
                }
            }

            foreach (['target', 'actual'] as $item) {
                $itemData = $datum[$item];
                $doc_element = $elementSchema['sub_elements'][$item]['sub_elements']['document_link'];

                foreach ($itemData as $itemDatum) {
                    $docs = getArr($itemDatum, 'document_link');

                    if (!$this->isLevelTwoMultiDimensionDataCompleted($doc_element, $docs)) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * @param $data
     * @param $subElement
     *
     * @return bool
     * @throws \JsonException
     */
    public function isBaselineCompleted($data, $subElement): bool
    {
        foreach ($data as $baselineDatum) {
            if (!$this->isLevelOneMultiDimensionDataCompleted($subElement['sub_elements']['comment'], getArr($baselineDatum, 'comment'))) {
                return false;
            }

            if (!$this->isLevelTwoMultiDimensionDataCompleted($subElement['sub_elements']['document_link'], getArr($baselineDatum, 'document_link'))) {
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
     * @throws \JsonException
     */
    public function isResultAndIndicatorElementCompleted($elementSchema, $data): bool
    {
        if (!$this->isSingleDimensionAttributeCompleted($elementSchema, $data)) {
            return false;
        }

        foreach (['title', 'description', 'reference'] as $item) {
            if (!$this->isLevelOneMultiDimensionDataCompleted($elementSchema['sub_elements'][$item], getArr($data, $item))) {
                return false;
            }
        }

        if (!$this->isLevelTwoMultiDimensionDataCompleted($elementSchema['sub_elements']['document_link'], getArr($data, 'document_link'))) {
            return false;
        }

        return true;
    }

    /**
     * Checks if indicator element is completed.
     *
     * @param $data
     *
     * @return bool
     * @throws \JsonException
     */
    public function isIndicatorElementCompleted($data): bool
    {
        $this->element = 'indicator';
        $elementSchema = getElementSchema($this->element);

        foreach ($data as $datum) {
            if (!$this->isResultAndIndicatorElementCompleted($elementSchema, $datum)) {
                return false;
            }

            if (!$this->isBaselineCompleted($datum['baseline'], $elementSchema['sub_elements']['baseline'])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks if result element is completed.
     *
     * @param $data
     *
     * @return bool
     * @throws \JsonException
     */
    public function isResultElementDataCompleted($data): bool
    {
        $this->element = 'result';
        $elementSchema = getElementSchema($this->element);

        foreach ($data as $datum) {
            if (!$this->isResultAndIndicatorElementCompleted($elementSchema, $datum)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns period, indicator and result data.
     *
     * @param $activity
     *
     * @return array
     */
    public function getFormattedResults($activity): array
    {
        $results = $activity->results()->with('indicators.periods')->get()->toArray();
        $resultData = [];
        $indicatorData = [];
        $periodData = [];

        if (!empty($results)) {
            foreach ($results as $result) {
                $resultData[] = $result['result'];
                $indicators = $result['indicators'];

                if (!empty($indicators)) {
                    foreach ($indicators as $indicator) {
                        $indicatorData[] = $indicator['indicator'];
                        $periods = $indicator['periods'];

                        if (!empty($periods)) {
                            foreach ($periods as $period) {
                                $periodData[] = $period['period'];
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
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isResultElementCompleted($activity): bool
    {
        [$resultData, $indicatorData, $periodData] = $this->getFormattedResults($activity);

        if (!$this->isPeriodElementCompleted($periodData)) {
            return false;
        }

        if (!$this->isIndicatorElementCompleted($indicatorData)) {
            return false;
        }

        if (!$this->isResultElementDataCompleted($resultData)) {
            return false;
        }

        return true;
    }

    /**
     * @param $subElements
     * @param $data
     *
     * @return bool
     * @throws \JsonException
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
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isTransactionsElementCompleted($activity): bool
    {
        $transactionData = $activity->transactions()->get()->toArray();

        if (!empty($transactionData)) {
            $this->element = 'transactions';
            $elementSchema = getElementSchema($this->element);

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
