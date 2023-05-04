<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\XlsValidator\Traits;

use App\Http\Requests\Activity\Budget\BudgetRequest;
use App\Http\Requests\Activity\CapitalSpend\CapitalSpendRequest;
use App\Http\Requests\Activity\CollaborationType\CollaborationTypeRequest;
use App\Http\Requests\Activity\Condition\ConditionRequest;
use App\Http\Requests\Activity\ContactInfo\ContactInfoRequest;
use App\Http\Requests\Activity\CountryBudgetItem\CountryBudgetItemRequest;
use App\Http\Requests\Activity\Date\DateRequest;
use App\Http\Requests\Activity\DefaultAidType\DefaultAidTypeRequest;
use App\Http\Requests\Activity\DefaultFinanceType\DefaultFinanceTypeRequest;
use App\Http\Requests\Activity\DefaultFlowType\DefaultFlowTypeRequest;
use App\Http\Requests\Activity\DefaultTiedStatus\DefaultTiedStatusRequest;
use App\Http\Requests\Activity\Description\DescriptionRequest;
use App\Http\Requests\Activity\DocumentLink\DocumentLinkRequest;
use App\Http\Requests\Activity\HumanitarianScope\HumanitarianScopeRequest;
use App\Http\Requests\Activity\Indicator\IndicatorRequest;
use App\Http\Requests\Activity\LegacyData\LegacyDataRequest;
use App\Http\Requests\Activity\Location\LocationRequest;
use App\Http\Requests\Activity\OtherIdentifier\OtherIdentifierRequest;
use App\Http\Requests\Activity\ParticipatingOrganization\ParticipatingOrganizationRequest;
use App\Http\Requests\Activity\Period\PeriodRequest;
use App\Http\Requests\Activity\PlannedDisbursement\PlannedDisbursementRequest;
use App\Http\Requests\Activity\PolicyMarker\PolicyMarkerRequest;
use App\Http\Requests\Activity\RecipientCountry\RecipientCountryRequest;
use App\Http\Requests\Activity\RecipientRegion\RecipientRegionRequest;
use App\Http\Requests\Activity\RelatedActivity\RelatedActivityRequest;
use App\Http\Requests\Activity\Result\ResultRequest;
use App\Http\Requests\Activity\Scope\ScopeRequest;
use App\Http\Requests\Activity\Sector\SectorRequest;
use App\Http\Requests\Activity\Status\StatusRequest;
use App\Http\Requests\Activity\Tag\TagRequest;
use App\Http\Requests\Activity\Transaction\TransactionRequest;
use Illuminate\Support\Arr;

/**
 * Class ErrorValidationRules.
 */
trait ErrorValidationRules
{
    /**
     * @param array $activity
     *
     * @return array
     */
    protected function errorForActivityStatus(array $activity): array
    {
        return (new StatusRequest())->getErrorsForActivityStatus(Arr::get($activity, 'activity_status'));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function errorForActivityScope(array $activity): array
    {
        return (new ScopeRequest())->getErrorsForActivityScope(Arr::get($activity, 'activity_scope'));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function errorForCollaborationType(array $activity): array
    {
        return (new CollaborationTypeRequest())->getErrorsForCollaborationType(Arr::get($activity, 'collaboration_type'));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function errorForDefaultFlowType(array $activity): array
    {
        return (new DefaultFlowTypeRequest())->getErrorsForDefaultFlowType(Arr::get($activity, 'default_flow_type'));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function errorForDefaultFinanceType(array $activity): array
    {
        return (new DefaultFinanceTypeRequest())->getErrorsForDefaultFinanceType(Arr::get($activity, 'default_finance_type'));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function errorForDefaultTiedStatus(array $activity): array
    {
        return (new DefaultTiedStatusRequest())->getErrorsForDefaultTiedStatus(Arr::get($activity, 'default_tied_status'));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function errorForCapitalSpend(array $activity): array
    {
        return (new CapitalSpendRequest())->getErrorsForCapitalSpend(Arr::get($activity, 'capital_spend'));
    }

    /**
     * Rules for Description.
     *
     * @param array $activity
     *
     * @return array
     */
    protected function errorForDescription(array $activity): array
    {
        return (new DescriptionRequest())->getErrorsForDescription(Arr::get($activity, 'description', []));
    }

    /**
     * Rules for Other Identifier.
     *
     * @param array $activity
     *
     * @return array
     */
    public function errorForOtherIdentifier(array $activity): array
    {
        return (new OtherIdentifierRequest())->getErrorsForOtherIdentifier(Arr::get($activity, 'other_identifier', []));
    }

    /**
     * Rules for Activity Date.
     *
     * @param array $activity
     * @return array
     */
    protected function errorForActivityDate(array $activity): array
    {
        return (new DateRequest())->getErrorsForActivityDate(Arr::get($activity, 'activity_date', []));
    }

    /**
     * Rules for Contact Info.
     *
     * @param array $activity
     * @return array
     */
    protected function errorForContactInfo(array $activity): array
    {
        return (new ContactInfoRequest())->getErrorsForContactInfo(Arr::get($activity, 'contact_info', []));
    }

    /**
     * returns rules for participating organization.
     * @param array $activity
     * @return array
     */
    public function errorForParticipatingOrg(array $activity): array
    {
        return (new ParticipatingOrganizationRequest())->getErrorsForParticipatingOrg(Arr::get($activity, 'participating_org', []));
    }

    /**
     * returns rules for recipient country form.
     * @param array $activity
     * @return array
     */
    public function errorForRecipientCountry(array $activity): array
    {
        return (new RecipientCountryRequest())->getErrorsForRecipientCountry(Arr::get($activity, 'recipient_country', []), true, );
    }

    /**
     * returns rules for recipient region.
     * @param array $activity
     * @return array
     */
    public function errorForRecipientRegion(array $activity): array
    {
        return (new RecipientRegionRequest())->getErrorsForRecipientRegion(Arr::get($activity, 'recipient_region', []), true, Arr::get($activity, 'recipient_country', []));
    }

    /**
     * returns rules for sector form.
     * @param array $activity
     * @return array
     */
    protected function errorForSector(array $activity): array
    {
        return (new SectorRequest())->getErrorsForSector(Arr::get($activity, 'sector', []), true);
    }

    /**
     * returns rules for location form.
     * @param array $activity
     * @return array
     */
    protected function errorForLocation(array $activity): array
    {
        return (new LocationRequest())->getErrorsForLocation(Arr::get($activity, 'location', []));
    }

    /**
     * returns rules for country budget item form.
     * @param array $activity
     * @return array
     */
    public function errorForCountryBudgetItem(array $activity): array
    {
        $countryBudgetItems = Arr::get($activity, 'country_budget_items', []);

        return (new CountryBudgetItemRequest())->getErrorsForCountryBudgetItem($countryBudgetItems);
    }

    /**
     * returns rules for HumanitarianScope.
     *
     * @param array $activity
     *
     * @return array
     */
    public function errorForHumanitarianScope(array $activity): array
    {
        return (new HumanitarianScopeRequest())->getErrorsForHumanitarianScope(Arr::get($activity, 'humanitarian_scope', []));
    }

    /**
     * Get rules for Policy Marker.
     *
     * @param array $activity
     * @return array
     */
    public function errorForPolicyMarker(array $activity): array
    {
        return (new PolicyMarkerRequest())->getErrorsForPolicyMarker(Arr::get($activity, 'policy_marker', []));
    }

    /**
     * Get rules for Budget.
     *
     * @param array $activity
     * @return array
     */
    protected function errorForBudget(array $activity): array
    {
        return (new BudgetRequest())->getErrorsForBudget(Arr::get($activity, 'budget', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function errorForPlannedDisbursement(array $activity): array
    {
        return (new PlannedDisbursementRequest())->getErrorsForPlannedDisbursement(Arr::get($activity, 'planned_disbursement', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function errorForDocumentLink(array $activity): array
    {
        return (new DocumentLinkRequest())->getErrors(Arr::get($activity, 'document_link', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function errorForRelatedActivity(array $activity): array
    {
        return (new RelatedActivityRequest())->getErrorsForRelatedActivity(Arr::get($activity, 'related_activity', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function errorForLegacyData(array $activity): array
    {
        return (new LegacyDataRequest())->getErrorsForLegacyData();
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function errorForCondition(array $activity): array
    {
        return $this->getBaseRules((new ConditionRequest())->getErrorsForCondition(Arr::get($activity, 'conditions.condition', [])), 'conditions', Arr::get($activity, 'conditions.condition', ''), false);
    }

    /**
     * returns rules for transaction.
     * @param $activity
     * @return array
     */
    protected function errorForTransaction($activity): array
    {
        $rules = [];
        $transactions = Arr::get($activity, 'transactions', []);

        foreach ($transactions as $idx => $transaction) {
            $tempRules = $this->getBaseRules((new TransactionRequest())->getErrorsForTransaction($transaction, true, $activity), 'transactions.' . $idx, $transaction, false);

            foreach ($tempRules as $index => $rule) {
                $rules[$index] = $rule;
            }
        }

        return $rules;
    }

    /**
     * returns rules for result.
     * @param array $activity
     * @return array
     */
    protected function errorForResult(array $activity): array
    {
        $results = Arr::get($activity, 'result', []) ?? [];
        $indicators = Arr::get($activity, 'indicator', []) ?? [];
        $rules = [];

        foreach ($results as $resultIndex => $result) {
            $resultBase = sprintf('result.%s', $resultIndex);
            $rules[sprintf('%s.type', $resultBase)] = sprintf(
                'nullable|in:%s',
                $this->validCodeList('ResultType')
            );

            $tempRules = [
                $this->getErrorsForIndicator(Arr::get($result, 'indicator', []), $resultBase, $result),
                (new ResultRequest())->getErrorsForResult($result, true, $indicators),
            ];

            foreach ($tempRules as $tempRule) {
                foreach ($tempRule as $idx => $rule) {
                    $rules[$resultBase . '.' . $idx] = $rule;
                }
            }
        }

        return $rules;
    }

    /**
     * returns rules for indicator.
     * @param $indicators
     * @param $resultBase
     * @param $result
     * @return array
     */
    protected function getErrorsForIndicator($indicators, $resultBase, $result): array
    {
        $rules = [];

        foreach ($indicators as $indicatorIndex => $indicator) {
            $indicatorBase = sprintf('indicator.%s', $indicatorIndex);
            $rules[sprintf('%s.ascending', $indicatorBase)] = 'nullable|in:1,0';

            $tempRules = [
                (new IndicatorRequest())->getErrorsForIndicator($indicator, true, $result),
                $this->getErrorsForPeriod(Arr::get($indicator, 'period', []) ?? [], $resultBase . '.' . $indicatorBase, $indicator),
            ];

            foreach ($tempRules as $index => $tempRule) {
                foreach ($tempRule as $idx => $rule) {
                    $rules[$indicatorBase . '.' . $idx] = $rule;
                }
            }
        }

        return $rules;
    }

    /**
     * returns rules for period.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getErrorsForPeriod($formFields, $formBase, $indicator): array
    {
        $rules = [];

        foreach ($formFields as $periodIndex => $period) {
            $periodBase = sprintf('period.%s', $periodIndex);
            $tempRules = (new PeriodRequest())->getErrorsForPeriod($period, true, $indicator, $formBase . '.' . $periodBase);

            foreach ($tempRules as $idx => $rule) {
                $rules[$periodBase . '.' . $idx] = $rule;
            }
        }

        return $rules;
    }

    /**
     * return rules for tag.
     *
     * @param array $activity
     * @return array
     */
    public function errorForTag(array $activity): array
    {
        return (new TagRequest())->getErrorsForTag(Arr::get($activity, 'tag', []));
    }

    /**
     * returns rules for default aid type.
     *
     * @param array $activity
     * @return array
     */
    protected function errorForDefaultAidType(array $activity): array
    {
        return (new DefaultAidTypeRequest())->getErrorsForDefaultAidType(Arr::get($activity, 'default_aid_type', []));
    }
}
