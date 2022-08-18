<?php

declare(strict_types=1);

namespace App\IATI\Services;

/**
 * Class ElementCompleteService.
 */
class OrganizationElementCompleteService
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

                if (
                    array_key_exists('sub_element', $elementSchema['dependent_attributes'][$mandatoryAttribute])
                    && !empty($elementSchema['dependent_attributes'][$mandatoryAttribute]['sub_element'])
                ) {
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
     * Returns identifier element complete status.
     *
     * @param $activity
     *
     * @return bool
     */
    public function isOrganizationIdentifierElementCompleted($organization): bool
    {
        $identifier = $organization->identifier;

        return !(!array_key_exists('identifier', $identifier) || empty($identifier));
    }

    /**
     * Returns title element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isNameElementCompleted($organization): bool
    {
        $this->element = 'name';
        $elementSchema = getOrganizationElementSchema($this->element);

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
    public function isReportingOrgElementCompleted($organization): bool
    {
        $this->element = 'reporting_org';

        return $this->isLevelOneMultiDimensionElementCompleted($organization->reporting_org);
    }

    /**
     * Returns conditions element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isTotalBudgetElementCompleted($organization): bool
    {
        $this->element = 'total_budget';

        return $this->isLevelTwoMultiDimensionElementCompleted($organization->total_budget);
    }

    /**
     * Returns conditions element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isTotalExpenseElementCompleted($organization): bool
    {
        $this->element = 'total_expense';

        return $this->isLevelTwoMultiDimensionElementCompleted($organization->total_expense);
    }

    /**
     * Returns conditions element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isDocumentLinkElementCompleted($organization): bool
    {
        $this->element = 'document_link';

        return $this->isLevelTwoMultiDimensionElementCompleted($organization->document_link);
    }

    /**
     * Returns conditions element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isRecipientOrgBudgeElementCompleted($organization): bool
    {
        $this->element = 'recipient_org_budget';

        return $this->isLevelTwoMultiDimensionElementCompleted($organization->recipient_org_budget);
    }

    /**
     * Returns conditions element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isRecipientCountryBudgetElementCompleted($organization): bool
    {
        $this->element = 'recipient_country_budget';

        return $this->isLevelTwoMultiDimensionElementCompleted($organization->recipient_country_budget);
    }

    /**
     * Returns conditions element complete status.
     *
     * @param $activity
     *
     * @return bool
     * @throws \JsonException
     */
    public function isRecipientRegionBudgetElementCompleted($organization): bool
    {
        $this->element = 'recipient_region_budget';

        return $this->isLevelTwoMultiDimensionElementCompleted($organization->recipient_region_budget);
    }
}
