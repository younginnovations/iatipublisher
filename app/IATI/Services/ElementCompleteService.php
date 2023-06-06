<?php

declare(strict_types=1);

namespace App\IATI\Services;

use App\IATI\Services\Activity\RecipientRegionService;
use App\IATI\Traits\ElementCompleteServiceTrait;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use JsonException;

/**
 * Class ElementCompleteService.
 */
class ElementCompleteService
{
    use ElementCompleteServiceTrait;

    /**
     * Public variable element.
     *
     * @var string
     */
    public string $element = '';

    /**
     * @var string
     */
    public $tempNarrative = '';

    /**
     * @var string
     */
    public $tempAmount = '';

    /**
     * Checks if attribute is complete.
     *
     * @param $mandatoryAttributes
     * @param $data
     *
     * @return bool
     *
     * @throws JsonException
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

        return $this->checkAttributeDataStatus($mandatoryAttributes, $data, $elementSchema);
    }

    /**
     * Checks if single dimension attribute is complete.
     *
     * @param $data
     *
     * @return bool
     *
     * @throws JsonException
     */
    public function singleDimensionAttributeCheck($data): bool
    {
        return $this->isSingleDimensionAttributeCompleted(getElementSchema($this->element), $data);
    }

    /**
     * Checks if all element is complete.
     *
     * @param $data
     *
     * @return bool
     *
     * @throws JsonException
     */
    public function isLevelOneMultiDimensionElementCompleted($data): bool
    {
        if (is_variable_null($data)) {
            return false;
        }

        return $this->isLevelOneMultiDimensionDataCompleted(getElementSchema($this->element), $data);
    }

    /**
     * Checks if two level sub element is complete.
     *
     * @param $data
     *
     * @return bool
     *
     * @throws JsonException
     */
    public function isLevelTwoSingleDimensionElementCompleted($data): bool
    {
        if (is_variable_null($data) || !$this->singleDimensionAttributeCheck($data)) {
            return false;
        }

        $elementSchema = getElementSchema($this->element);

        return $this->isSubElementCompleted($elementSchema['sub_elements'], $data);
    }

    /**
     * Checks if two level sub element is complete.
     *
     * @param $data
     *
     * @return bool
     *
     * @throws JsonException
     */
    public function isLevelTwoMultiDimensionElementCompleted($data): bool
    {
        if (is_variable_null($data)) {
            return false;
        }

        return $this->isLevelTwoMultiDimensionDataCompleted(getElementSchema($this->element), $data);
    }

    /**
     * Checks three level sub element is complete.
     *
     * @param $data
     *
     * @return bool
     *
     * @throws JsonException
     */
    public function isLevelThreeSingleDimensionElementCompleted($data): bool
    {
        if (is_variable_null($data) || !$this->singleDimensionAttributeCheck($data)) {
            return false;
        }

        $elementSchema = getElementSchema($this->element);
        $subElements = $elementSchema['sub_elements'];

        foreach ($subElements as $key => $subElement) {
            $mandatorySubElementAttributes = $this->getMandatoryAttributes($subElement);

            if (empty($mandatorySubElementAttributes)) {
                continue;
            }

            if (
                !array_key_exists($key, $data)
                || empty($data[$key])
            ) {
                return false;
            }

            $tempData = $data[$key];

            foreach ($tempData as $datum) {
                if (!$this->isAttributeDataCompleted($mandatorySubElementAttributes, $datum)) {
                    return false;
                }
            }

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
     *
     * @throws JsonException
     */
    public function isTitleElementCompleted($activity): bool
    {
        $this->element = 'title';
        $elementSchema = getElementSchema($this->element);

        return $this->isSubElementDataCompleted($this->mandatorySubElements($elementSchema['sub_elements']), ['narrative' => $activity->title]);
    }

    /**
     * Returns reporting org element complete status.
     *
     * @param $activity
     *
     * @return bool
     *
     * @throws JsonException
     */
    public function isReportingOrgElementCompleted($activity): bool
    {
        $this->element = 'reporting_org';

        return $this->isLevelOneMultiDimensionElementCompleted($activity->reporting_org);
    }

    /**
     * Returns description element complete status.
     *
     * @param $activity
     *
     * @return bool
     *
     * @throws JsonException
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
     *
     * @throws JsonException
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
     *
     * @throws BindingResolutionException
     * @throws JsonException
     */
    public function isRecipientCountryElementCompleted($activity): bool
    {
        $this->element = 'recipient_country';

        return $this->checkIfRecipientCountryElementCompleted($activity);
    }

    /**
     * Returns budget element complete status.
     *
     * @param $activity
     *
     * @return bool
     *
     * @throws JsonException
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
     *
     * @throws BindingResolutionException
     * @throws JsonException
     */
    public function isRecipientRegionElementCompleted($activity): bool
    {
        $this->element = 'recipient_region';

        return $this->checkIfRecipientRegionElementCompleted($activity);
    }

    /**
     * Returns default_aid_type element complete status.
     *
     * @param $activity
     *
     * @return bool
     *
     * @throws JsonException
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
     *
     * @throws JsonException
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
     *
     * @throws JsonException
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
     *
     * @throws JsonException
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
     *
     * @throws JsonException
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
     *
     * @throws JsonException
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
     *
     * @throws JsonException
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
     *
     * @throws JsonException
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

        return $activity->capital_spend !== null;
    }

    /**
     * Returns other_identifier element complete status.
     *
     * @param $activity
     *
     * @return bool
     *
     * @throws JsonException
     */
    public function isOtherIdentifierElementCompleted($activity): bool
    {
        $this->element = 'other_identifier';

        return $this->isLevelTwoMultiDimensionElementCompleted($activity->other_identifier);
    }

    /**
     * Returns conditions element complete status.
     *
     * @param $activity
     *
     * @return bool
     *
     * @throws JsonException
     */
    public function isConditionsElementCompleted($activity): bool
    {
        $this->element = 'conditions';

        if (isset($activity->conditions) && Arr::get($activity->conditions, 'condition_attached') === '0') {
            return true;
        }

        return $this->isLevelTwoSingleDimensionElementCompleted($activity->conditions);
    }

    /**
     * Returns conditions element complete status.
     *
     * @param $activity
     *
     * @return bool
     *
     * @throws JsonException
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
     *
     * @throws JsonException
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
     *
     * @throws JsonException
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
     *
     * @throws JsonException
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
     *
     * @throws JsonException
     */
    public function isCountryBudgetItemsElementCompleted($activity): bool
    {
        $this->element = 'country_budget_items';

        return $this->isLevelThreeSingleDimensionElementCompleted($activity->country_budget_items);
    }

    /**
     * Checks if period element is completed.
     *
     * @param $data
     *
     * @return bool
     *
     * @throws JsonException
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
     *
     * @throws JsonException
     */
    public function isBaselineCompleted($data, $subElement): bool
    {
        foreach ($data as $baselineDatum) {
            if (
                !$this->isLevelOneMultiDimensionDataCompleted($subElement['sub_elements']['comment'], getArr($baselineDatum, 'comment'))
                || !$this->isLevelTwoMultiDimensionDataCompleted($subElement['sub_elements']['document_link'], getArr($baselineDatum, 'document_link'))
            ) {
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
     *
     * @throws JsonException
     */
    public function isResultAndIndicatorElementCompleted($elementSchema, $data): bool
    {
        if (
            !$this->isSingleDimensionAttributeCompleted($elementSchema, $data)
            || !$this->isLevelTwoMultiDimensionDataCompleted($elementSchema['sub_elements']['document_link'], getArr($data, 'document_link'))
        ) {
            return false;
        }

        foreach (['title', 'description', 'reference'] as $item) {
            if (!$this->isLevelOneMultiDimensionDataCompleted($elementSchema['sub_elements'][$item], getArr($data, $item))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks if indicator element is completed.
     *
     * @param $data
     *
     * @return bool
     *
     * @throws JsonException
     */
    public function isIndicatorElementCompleted($data): bool
    {
        $this->element = 'indicator';
        $elementSchema = getElementSchema($this->element);

        foreach ($data as $datum) {
            if (
                !$this->isResultAndIndicatorElementCompleted($elementSchema, $datum)
                || !$this->isBaselineCompleted($datum['baseline'], $elementSchema['sub_elements']['baseline'])
            ) {
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
     *
     * @throws JsonException
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
     *
     * @throws JsonException
     */
    public function isResultElementCompleted($activity): bool
    {
        [$resultData, $indicatorData, $periodData] = $this->getFormattedResults($activity);

        if (
            (is_variable_null($periodData) || !$this->isPeriodElementCompleted($periodData))
            || (is_variable_null($indicatorData) || !$this->isIndicatorElementCompleted($indicatorData))
            || (is_variable_null($resultData) || !$this->isResultElementDataCompleted($resultData))
        ) {
            return false;
        }

        return true;
    }

    /**
     * @param $subElements
     * @param $data
     *
     * @return bool
     *
     * @throws JsonException
     */
    public function checkTransactionData($subElements, $data): bool
    {
        if (is_variable_null($data) || !$this->singleDimensionAttributeCheck($data)) {
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
     *
     * @throws JsonException
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

    /**
     * Checks if recipient Region is completed.
     *
     * @param $activity
     *
     * @return bool
     *
     * @throws BindingResolutionException
     * @throws JsonException
     */
    public function checkIfRecipientRegionElementCompleted($activity): bool
    {
        $regionStatus = $this->isLevelOneMultiDimensionElementCompleted($activity->recipient_region);

        if (empty($activity->recipient_region) && !empty($activity->recipient_country)) {
            $countryTotalPercentage = (float) array_sum(array_column($activity->recipient_country, 'percentage'));

            if ($countryTotalPercentage === 100.0) {
                return true;
            }

            return false;
        }

        if (!empty($activity->recipient_region)) {
            $recipientRegionService = app()->make(RecipientRegionService::class);
            $groupPercentage = $recipientRegionService->groupRegion($activity->recipient_region);
            $firstGroupTotalPercentage = Arr::first($groupPercentage, static function ($value) {
                return $value;
            })['total'];

            /*
             * We are only comparing first groups percentage because all groups are expected to be same.
             * This is because recipient region request validation prevents unique vocab from having different percentages.
             * Comparing with ( 100 - % of RecipientCountry ) is the same as comparing with 100.0 if Recipient Country is empty.
             */
            if (empty($activity->recipient_country) && $firstGroupTotalPercentage !== 100.0) {
                return  false;
            }

            if (!empty($activity->recipient_country)) {
                $countryTotalPercentage = (float) array_sum(array_column($activity->recipient_country, 'percentage'));
                $totalPercentage = $firstGroupTotalPercentage + $countryTotalPercentage;

                return $totalPercentage === 100.0 ? $regionStatus : false;
            }
        }

        return $regionStatus;
    }

    /**
     * Checks if recipient country is completed.
     *
     * @param $activity
     *
     * @return bool
     *
     * @throws BindingResolutionException
     * @throws JsonException
     */
    public function checkIfRecipientCountryElementCompleted($activity): bool
    {
        $countryStatus = $this->isLevelOneMultiDimensionElementCompleted($activity->recipient_country);

        if (empty($activity->recipient_country) && !empty($activity->recipient_region)) {
            $recipientRegionService = app()->make(RecipientRegionService::class);
            $groupPercentage = $recipientRegionService->groupRegion($activity->recipient_region);
            $firstGroupTotalPercentage = Arr::first($groupPercentage, static function ($value) {
                return $value;
            })['total'];

            if ($firstGroupTotalPercentage === 100.0) {
                return $countryStatus;
            }

            return false;
        }

        if (!empty($activity->recipient_country)) {
            $countryTotalPercentage = (float) array_sum(array_column($activity->recipient_country, 'percentage'));

            if (empty($activity->recipient_region) && $countryTotalPercentage != 100.0) {
                return false;
            }

            if ($countryTotalPercentage !== (100.0 - getAllocatedPercentageOfRecipientRegion($activity))) {
                return false;
            }
        }

        return $countryStatus;
    }

    /**
     * Refresh element_status of activity.
     *
     * @param $activity
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    public function refreshElementStatus($activity): void
    {
        $skippables = [
            'id',
            'org_id',
            'status',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'upload_medium',
            'linked_to_iati',
            'element_status',
            'default_field_values',
            'migrated_from_aidstream',
            'complete_percentage',
        ];

        $elementStatus = [];
        $attributes = $activity->getAttributes();

        foreach ($attributes as $attribute => $value) {
            $attributeMethod = dashesToCamelCase('is_' . $attribute . '_element_completed');

            if (!in_array($attribute, $skippables) && is_callable([$this, $attributeMethod])) {
                $elementStatus[$attribute] = call_user_func([$this, $attributeMethod], $activity);
            }
        }

        $activity->element_status = $elementStatus;
        $activity->complete_percentage = $this->calculateCompletePercentage($activity->element_status);
        $activity->timestamps = false;
        $activity->updateQuietly(['touch' => false]);
    }

    /**
     * Calculate element complete percentage for an activity.
     *
     * @param $element_status
     *
     * @return float
     */
    public function calculateCompletePercentage($element_status): float
    {
        $core_elements = getCoreElements();
        $completed_core_element_count = 0;

        foreach ($core_elements as $core_element) {
            if (
                array_key_exists(
                    $core_element,
                    $element_status
                ) && $element_status[$core_element]
            ) {
                $completed_core_element_count++;
            }
        }

        return ($completed_core_element_count / count($core_elements)) * 100;
    }
}
