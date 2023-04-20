<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use Illuminate\Support\Arr;

/**
 * Class ElementCompleteServiceTrait.
 */
trait ElementCompleteServiceTrait
{
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
     * Checks if Element's dependent_attributes contain specified mandatory attribute.
     *
     * @param $schema
     * @param $mandatoryAttribute
     * @return bool
     */
    public function checkIfDependentAttributesExistAndContainsSpecifiedMandatoryAttribute($schema, $mandatoryAttribute): bool
    {
        return array_key_exists('dependent_attributes', $schema) && array_key_exists($mandatoryAttribute, $schema['dependent_attributes']);
    }

    /**
     * Checks if Element's dependent_attributes's attribute has a sub-element.
     *
     * @param $schema
     * @param $mandatoryAttribute
     * @return bool
     */
    public function checkIfDependentMandatoryAttributeContainsSubelement($schema, $mandatoryAttribute): bool
    {
        return array_key_exists('sub_element', $schema['dependent_attributes'][$mandatoryAttribute])
            && !empty($schema['dependent_attributes'][$mandatoryAttribute]['sub_element']);
    }

    /**
     * Returns Dependent Mandatory Attribute's sub-elements's attribute schema.
     *
     * @param $schema
     * @param $mandatoryAttribute
     * @return mixed
     */
    protected function getAttributeSchemaOfDependentMandatoryAttributeSubelement($schema, $mandatoryAttribute): mixed
    {
        return $schema['sub_elements'][$schema['dependent_attributes'][$mandatoryAttribute]['sub_element']]['attributes'];
    }

    /**
     * Checks if child field is set + not empty + non zero when parent is set.
     *
     * @param $data
     * @param $mandatoryAttribute
     * @return bool
     */
    protected function isIncompleteWhenParentFieldIsSet($data, $mandatoryAttribute): bool
    {
        if (is_string($data)) {
            return false;
        }

        $keyExists = array_key_exists($mandatoryAttribute, $data);

        return $keyExists && empty($data[$mandatoryAttribute]) && !$this->isZero($data[$mandatoryAttribute]);
    }

    /**
     * Checks if child field is set when parent is not set.
     *
     * @param $data
     * @param $schema
     * @return bool
     */
    protected function isIncompleteWhenParentFieldIsNotSet($data, $schema): bool
    {
        if (is_string($data)) {
            if (empty($data)) {
                return true;
            }

            return false;
        }

        $defaultAttribute = Arr::get($schema, 'default_attribute', false);
        $doesChildHaveDefaultField = $defaultAttribute && array_key_exists($defaultAttribute, $data);
        $isChildDefaultFieldEmpty = $defaultAttribute && empty($data[$schema['default_attribute']]);

        return $doesChildHaveDefaultField && $isChildDefaultFieldEmpty;
    }

    /**
     * Checks if PARENT field is broken when dealing with parents that have dependent child
     * Example for broken case:
     * User selects xyz_vocabulary >> selects proper code,
     * THEN clears xyz_vocabulary from UI, still retaining code in the form,
     * Proceeds to save. This is a broken case.
     * (happens in some cases only).
     *
     * @param $data
     * @param $schema
     * @param $mandatoryAttribute
     * @param $parentName
     * @param $mandatoryAttributes
     * @return bool
     */
    protected function brokenParentChildRelationShip($data, $schema, $mandatoryAttribute, $parentName, $mandatoryAttributes): bool
    {
        $defaultAttribute = Arr::get($schema, 'default_attribute', false);

        if ($defaultAttribute && $mandatoryAttribute !== $defaultAttribute) {
            foreach ($data as $key => $datum) {
                if ($key === $mandatoryAttribute) {
                    if (isset($data[$parentName]) && $data[$parentName] && isset($data[$mandatoryAttribute]) && $data[$mandatoryAttribute]) {
                        return false;
                    }

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Checks if Attribute data is completed.
     *
     * @param $mandatoryAttributes
     * @param $data
     * @param $schema
     * @return bool
     */
    public function checkAttributeDataStatus($mandatoryAttributes, $data, $schema): bool
    {
        foreach ($mandatoryAttributes as $mandatoryAttribute) {
            if ($this->checkIfDependentAttributesExistAndContainsSpecifiedMandatoryAttribute($schema, $mandatoryAttribute)) {
                $parentLevelAttributes = $schema['attributes'];

                if ($this->checkIfDependentMandatoryAttributeContainsSubelement($schema, $mandatoryAttribute)) {
                    $parentLevelAttributes = $this->getAttributeSchemaOfDependentMandatoryAttributeSubelement($schema, $mandatoryAttribute);
                }

                $parentArray = $parentLevelAttributes[$mandatoryAttribute]['parent'];
                $parentName = $parentArray['name'];
                $possibleValuesAllowedInParent = $parentArray['value'];
                $parentDataFromForm = false;

                if (is_array($data)) {
                    $parentDataFromForm = $data[$parentName] ?? false;
                }

                /*checks if parent attribute have specific value for child attribute to be relevant*/
                if ($parentDataFromForm && !in_array($parentDataFromForm, $possibleValuesAllowedInParent, true)) {
                    if ($this->brokenParentChildRelationShip($data, $schema, $mandatoryAttribute, $parentName, $mandatoryAttributes)) {
                        return false;
                    }

                    continue;
                }
            }

            if ($this->isIncompleteWhenParentFieldIsSet($data, $mandatoryAttribute)) {
                return false;
            }
        }

        if ($this->isIncompleteWhenParentFieldIsNotSet($data, $schema)) {
            return false;
        }

        return true;
    }

    /**
     * Returns mandatory fields.
     *
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
     * Checks if sub element is complete.
     *
     * @param $mandatorySubElements
     * @param $data
     *
     * @return bool
     */
    public function isSubElementDataCompleted($mandatorySubElements, $data): bool
    {
        if (is_variable_null($data)) {
            return false;
        }

        if (empty($mandatorySubElements)) {
            return true;
        }

        if (empty($data)) {
            return false;
        }

        return $this->checkSubElementDataStatus($mandatorySubElements, $data);
    }

    /**
     * Checks if sub element data is completed.
     *
     * @param $mandatorySubElements
     * @param $data
     * @return bool
     */
    public function checkSubElementDataStatus($mandatorySubElements, $data): bool
    {
        foreach ($mandatorySubElements as $key => $mandatorySubElement) {
            if (!array_key_exists($key, $data)) {
                return false;
            }
            $items = $data[$key];

            if (empty($items)) {
                return false;
            }

            foreach ($mandatorySubElement as $mandatoryField) {
                foreach ($items as $item) {
                    if (!array_key_exists($mandatoryField, $item) || (empty($item[$mandatoryField]))) {
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
     * @param $elementSchema
     * @param $data
     *
     * @return bool
     * @throws \JsonException
     */
    public function isSingleDimensionAttributeCompleted($elementSchema, $data): bool
    {
        $mandatoryAttributes = $this->getMandatoryAttributes($elementSchema);

        if (!empty($mandatoryAttributes) && (empty($data) || !$this->isAttributeDataCompleted($mandatoryAttributes, $data))) {
            return false;
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
                    return false;
                }

                if (!$this->isSubElementDataCompleted($mandatorySubElements, $datum)) {
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
                if (
                    !array_key_exists($key, $data)
                    || empty($data[$key])
                    || !$this->isElementCompleted($mandatorySubElementAttributes, $mandatoryChildSubElements, $data[$key])
                ) {
                    return false;
                }
            }
        }

        return true;
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
        $mandatorySubElementsFlag = $this->hasMandatorySubElements($subElements);

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
     * Checks if sub elements has mandatory fields.
     *
     * @param $subElements
     * @return bool
     */
    public function hasMandatorySubElements($subElements): bool
    {
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

        return $mandatorySubElementsFlag;
    }

    /**
     * Sets Narrative.
     *
     * @param string $key
     * @param $datum
     * @return void
     */
    public function setTempNarrative(string $key, $datum): void
    {
        if ($key === 'narrative') {
            $this->tempNarrative = $datum;
        }
    }

    /**
     * Sets Amount.
     *
     * @param string $key
     * @param $datum
     * @return void
     */
    public function setTempAmount(string $key, $datum): void
    {
        if ($key === 'amount') {
            $this->tempAmount = $datum;
        }
    }

    /**
     * Checks if variable is zero.
     *
     * @param $variable
     * @return bool
     */
    public function isZero($variable): bool
    {
        return $variable === 0 || $variable === '0';
    }
}
