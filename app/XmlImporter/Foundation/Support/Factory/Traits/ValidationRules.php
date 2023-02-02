<?php

declare(strict_types=1);

namespace App\XmlImporter\Foundation\Support\Factory\Traits;

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
use App\Http\Requests\Activity\ReportingOrg\ReportingOrgRequest;
use App\Http\Requests\Activity\Result\ResultRequest;
use App\Http\Requests\Activity\Scope\ScopeRequest;
use App\Http\Requests\Activity\Sector\SectorRequest;
use App\Http\Requests\Activity\Status\StatusRequest;
use App\Http\Requests\Activity\Tag\TagRequest;
use App\Http\Requests\Activity\Title\TitleRequest;
use App\Http\Requests\Activity\Transaction\TransactionRequest;
use Illuminate\Support\Arr;

/**
 * Class ValidationRules.
 */
trait ValidationRules
{
    /**
     * @param array $activity
     *
     * @return array
     */
    protected function rulesForActivityStatus(array $activity): array
    {
        return (new StatusRequest())->getRulesForActivityStatus(Arr::get($activity, 'activity_status'));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function rulesForActivityScope(array $activity): array
    {
        return (new ScopeRequest())->getRulesForActivityScope(Arr::get($activity, 'activity_scope'));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function rulesForCollaborationType(array $activity): array
    {
        return (new CollaborationTypeRequest())->getRulesForCollaborationType(Arr::get($activity, 'collaboration_type'));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function rulesForDefaultFlowType(array $activity): array
    {
        return (new DefaultFlowTypeRequest())->getRulesForDefaultFlowType(Arr::get($activity, 'default_flow_type'));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function rulesForDefaultFinanceType(array $activity): array
    {
        return (new DefaultFinanceTypeRequest())->getRulesForDefaultFinanceType(Arr::get($activity, 'default_finance_type'));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function rulesForDefaultTiedStatus(array $activity): array
    {
        return (new DefaultTiedStatusRequest())->getRulesForDefaultTiedStatus(Arr::get($activity, 'default_tied_status'));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function rulesForCapitalSpend(array $activity): array
    {
        return (new CapitalSpendRequest())->getRulesForCapitalSpend(Arr::get($activity, 'capital_spend'));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function rulesForTitle(array $activity): array
    {
        return (new TitleRequest())->getRulesForTitle('title', Arr::get($activity, 'title', []));
    }

    /**
     * Rules for Description.
     *
     * @param array $activity
     *
     * @return array
     */
    protected function rulesForDescription(array $activity): array
    {
        return (new DescriptionRequest())->getRulesForDescription(Arr::get($activity, 'description', []));
    }

    /**
     * Rules for Other Identifier.
     *
     * @param array $activity
     *
     * @return array
     */
    public function rulesForOtherIdentifier(array $activity): array
    {
        return (new OtherIdentifierRequest())->getRulesForOtherIdentifier(Arr::get($activity, 'other_identifier', []));
    }

    /**
     * Rules for Activity Date.
     *
     * @param array $activity
     * @return array
     */
    protected function rulesForActivityDate(array $activity): array
    {
        return (new DateRequest())->getRulesForActivityDate(Arr::get($activity, 'activity_date', []));
    }

    /**
     * Rules for Contact Info.
     *
     * @param array $activity
     * @return array
     */
    protected function rulesForContactInfo(array $activity): array
    {
        return (new ContactInfoRequest())->getRulesforContactInfo(Arr::get($activity, 'contact_info', []));
    }

    /**
     * returns rules for participating organization.
     * @param array $activity
     * @return array
     */
    public function rulesForParticipatingOrg(array $activity): array
    {
        return (new ParticipatingOrganizationRequest())->getRulesForParticipatingOrg(Arr::get($activity, 'participating_org', []));
    }

    /**
     * returns rules for recipient country form.
     * @param array $activity
     * @return array
     */
    public function rulesForRecipientCountry(array $activity): array
    {
        return (new RecipientCountryRequest())->getRulesForRecipientCountry(Arr::get($activity, 'recipient_country', []), true, );
    }

    /**
     * returns rules for recipient region.
     * @param array $activity
     * @return array
     */
    public function rulesForRecipientRegion(array $activity): array
    {
        return (new RecipientRegionRequest())->getRulesForRecipientRegion(Arr::get($activity, 'recipient_region', []), true, Arr::get($activity, 'recipient_country', []));
    }

    /**
     * returns rules for sector form.
     * @param array $activity
     * @return array
     */
    protected function rulesForSector(array $activity): array
    {
        return (new SectorRequest())->getSectorsRules(Arr::get($activity, 'sector', []), true);
    }

    /**
     * returns rules for location form.
     * @param array $activity
     * @return array
     */
    protected function rulesForLocation(array $activity): array
    {
        return (new LocationRequest())->getRulesForLocation(Arr::get($activity, 'location', []));
    }

    /**
     * returns rules for country budget item form.
     * @param array $activity
     * @return array
     */
    public function rulesForCountryBudgetItems(array $activity): array
    {
        $countryBudgetItems = Arr::get($activity, 'country_budget_items', []);
        $rules = [];
        $tempRules = (new CountryBudgetItemRequest())->getRulesForCountryBudgetItem(Arr::get($countryBudgetItems, key($countryBudgetItems), []));

        foreach ($tempRules as $idx => $rule) {
            $rules['country_budget_items.0.' . $idx] = $rule;
        }

        return $rules;
    }

    /**
     * returns rules for HumanitarianScope.
     *
     * @param array $activity
     *
     * @return array
     */
    public function rulesForHumanitarianScope(array $activity): array
    {
        return (new HumanitarianScopeRequest())->getRulesForHumanitarianScope(Arr::get($activity, 'humanitarian_scope', []));
    }

    /**
     * Get rules for Policy Marker.
     *
     * @param array $activity
     * @return array
     */
    public function rulesForPolicyMarker(array $activity): array
    {
        return (new PolicyMarkerRequest())->getRulesForPolicyMarker(Arr::get($activity, 'policy_marker', []));
    }

    /**
     * Get rules for Budget.
     *
     * @param array $activity
     * @return array
     */
    protected function rulesForBudget(array $activity): array
    {
        return (new BudgetRequest())->getRulesForBudget(Arr::get($activity, 'budget', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function rulesForPlannedDisbursement(array $activity): array
    {
        return (new PlannedDisbursementRequest())->getRulesForPlannedDisbursement(Arr::get($activity, 'planned_disbursement', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function rulesForDocumentLink(array $activity): array
    {
        return (new DocumentLinkRequest())->getRulesForDocumentLink(Arr::get($activity, 'document_link', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function rulesForRelatedActivity(array $activity): array
    {
        return (new RelatedActivityRequest())->getRulesForRelatedActivity(Arr::get($activity, 'related_activity', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function rulesForLegacyData(array $activity): array
    {
        return (new LegacyDataRequest())->getRulesForActivityLegacyData(Arr::get($activity, 'legacy_data', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function rulesForCondition(array $activity): array
    {
        return $this->getBaseRules((new ConditionRequest())->getRulesForCondition(Arr::get($activity, 'conditions.condition', [])), 'conditions', Arr::get($activity, 'conditions.condition', ''), false);
    }

    /**
     * returns rules for transaction.
     * @param $activity
     * @return array
     */
    protected function rulesForTransaction($activity): array
    {
        $rules = [];
        $transactions = Arr::get($activity, 'transactions', []);

        foreach ($transactions as $idx => $transaction) {
            $tempRules = $this->getBaseRules((new TransactionRequest())->getRulesForTransaction($transaction, true, $activity), 'transactions.' . $idx, $transaction, false);

            foreach ($tempRules as $index => $rule) {
                $rules[$index] = $rule;
            }
        }

        return $rules;
    }

    /**
     * returns rules for result.
     *
     * @param array $activity
     *
     * @return array
     */
    protected function rulesForResult(array $activity): array
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
                $this->getRulesForIndicator(Arr::get($result, 'indicator', []), $resultBase, $result),
                (new ResultRequest())->getRulesForResult($result, true, $indicators),
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
    protected function getRulesForIndicator($indicators, $resultBase, $result): array
    {
        $rules = [];

        foreach ($indicators as $indicatorIndex => $indicator) {
            $indicatorBase = sprintf('indicator.%s', $indicatorIndex);
            $rules[sprintf('%s.ascending', $indicatorBase)] = 'nullable|in:1,0';

            $tempRules = [
                (new IndicatorRequest())->getRulesForIndicator($indicator, true, $result),
                $this->getRulesForPeriod(Arr::get($indicator, 'period', []) ?? [], $resultBase . '.' . $indicatorBase, $indicator),
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
    protected function getRulesForPeriod($formFields, $formBase, $indicator): array
    {
        $rules = [];

        foreach ($formFields as $periodIndex => $period) {
            $periodBase = sprintf('period.%s', $periodIndex);
            $tempRules = (new PeriodRequest())->getRulesForPeriod($period, true, $indicator, $formBase . '.' . $periodBase);

            foreach ($tempRules as $idx => $rule) {
                $rules[$periodBase . '.' . $idx] = $rule;
            }
        }

        return $rules;
    }

    /**
     * Get the valid codes from the respective code list.
     *
     * @param        $name
     * @param string $directory
     *
     * @return string
     */
    protected function validCodeList($name, string $directory = 'Activity'): string
    {
        return implode(',', array_keys($this->loadCodeList($name, $directory)));
    }

    /**
     * @param        $codeList
     * @param string $directory
     *
     * @return mixed
     * @throws \JsonException
     */
    protected function loadCodeList($codeList, string $directory = 'Activity'): mixed
    {
        return getCodeList($codeList, $directory, false);
    }

    /**
     * return rules for tag.
     *
     * @param array $activity
     * @return array
     */
    public function rulesForTag(array $activity): array
    {
        return (new TagRequest())->getRulesForTag(Arr::get($activity, 'tag', []));
    }

    /**
     * returns rules for default aid type.
     *
     * @param array $activity
     * @return array
     */
    protected function rulesForDefaultAidType(array $activity): array
    {
        return (new DefaultAidTypeRequest())->getRulesForDefaultAidType(Arr::get($activity, 'default_aid_type', []));
    }

    /**
     * Rules for reporting organization.
     *
     * @return array
     */
    protected function rulesForReportingOrganization(array $activity): array
    {
        return (new ReportingOrgRequest())->getRulesForReportingOrganization(Arr::get($activity, 'reporting_org', []));
    }
}
