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
use App\Http\Requests\Activity\Identifier\IdentifierRequest;
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
use App\Http\Requests\Activity\Title\TitleRequest;
use App\Http\Requests\Activity\Transaction\TransactionRequest;
use Illuminate\Support\Arr;

/**
 * Class WarningValidationRules.
 */
trait WarningValidationRules
{
    /**
     * @param array $activity
     *
     * @return array
     */
    protected function warningForActivityStatus(array $activity): array
    {
        return (new StatusRequest())->getWarningForActivityStatus(Arr::get($activity, 'activity_status'));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function warningForActivityScope(array $activity): array
    {
        return (new ScopeRequest())->getWarningForActivityScope();
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function warningForCollaborationType(array $activity): array
    {
        return (new CollaborationTypeRequest())->getWarningForCollaborationType(Arr::get($activity, 'collaboration_type'));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function warningForDefaultFlowType(array $activity): array
    {
        return (new DefaultFlowTypeRequest())->getWarningForDefaultFlowType();
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function warningForDefaultFinanceType(array $activity): array
    {
        return (new DefaultFinanceTypeRequest())->getWarningForDefaultFinanceType();
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function warningForDefaultTiedStatus(array $activity): array
    {
        return (new DefaultTiedStatusRequest())->getWarningForDefaultTiedStatus();
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function warningForCapitalSpend(array $activity): array
    {
        return (new CapitalSpendRequest())->getWarningForCapitalSpend(Arr::get($activity, 'capital_spend'));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function warningForTitle(array $activity): array
    {
        return (new TitleRequest())->getWarningForTitle('title', Arr::get($activity, 'title', []));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function warningForIdentifier(array $activity): array
    {
        return (new IdentifierRequest())->getWarningForIdentifier(true);
    }

    /**
     * Rules for Description.
     *
     * @param array $activity
     *
     * @return array
     */
    protected function warningForDescription(array $activity): array
    {
        return (new DescriptionRequest())->getWarningForDescription(Arr::get($activity, 'description', []));
    }

    /**
     * Rules for Other Identifier.
     *
     * @param array $activity
     *
     * @return array
     */
    public function warningForOtherIdentifier(array $activity): array
    {
        return (new OtherIdentifierRequest())->getWarningForOtherIdentifier(Arr::get($activity, 'other_identifier', []));
    }

    /**
     * Rules for Activity Date.
     *
     * @param array $activity
     * @return array
     */
    protected function warningForActivityDate(array $activity): array
    {
        return (new DateRequest())->getWarningForActivityDate(Arr::get($activity, 'activity_date', []));
    }

    /**
     * Rules for Contact Info.
     *
     * @param array $activity
     * @return array
     */
    protected function warningForContactInfo(array $activity): array
    {
        return (new ContactInfoRequest())->getWarningforContactInfo(Arr::get($activity, 'contact_info', []));
    }

    /**
     * returns rules for participating organization.
     * @param array $activity
     * @return array
     */
    public function warningForParticipatingOrg(array $activity): array
    {
        return (new ParticipatingOrganizationRequest())->getWarningForParticipatingOrg(Arr::get($activity, 'participating_org', []));
    }

    /**
     * returns rules for recipient country form.
     * @param array $activity
     * @return array
     */
    public function warningForRecipientCountry(array $activity): array
    {
        return (new RecipientCountryRequest())->getWarningForRecipientCountry(Arr::get($activity, 'recipient_country', []), true, );
    }

    /**
     * returns rules for recipient region.
     * @param array $activity
     * @return array
     */
    public function warningForRecipientRegion(array $activity): array
    {
        return (new RecipientRegionRequest())->getWarningForRecipientRegion(Arr::get($activity, 'recipient_region', []), true, Arr::get($activity, 'recipient_country', []));
    }

    /**
     * returns rules for sector form.
     * @param array $activity
     * @return array
     */
    protected function warningForSector(array $activity): array
    {
        return (new SectorRequest())->getSectorsRules(Arr::get($activity, 'sector', []), true);
    }

    /**
     * returns rules for location form.
     * @param array $activity
     * @return array
     */
    protected function warningForLocation(array $activity): array
    {
        return (new LocationRequest())->getWarningForLocation(Arr::get($activity, 'location', []));
    }

    /**
     * returns rules for country budget item form.
     * @param array $activity
     * @return array
     */
    public function warningForCountryBudgetItems(array $activity): array
    {
        $countryBudgetItems = Arr::get($activity, 'country_budget_items', []);

        return (new CountryBudgetItemRequest())->getWarningForCountryBudgetItem($countryBudgetItems);
    }

    /**
     * returns rules for HumanitarianScope.
     *
     * @param array $activity
     *
     * @return array
     */
    public function warningForHumanitarianScope(array $activity): array
    {
        return (new HumanitarianScopeRequest())->getWarningForHumanitarianScope(Arr::get($activity, 'humanitarian_scope', []));
    }

    /**
     * Get rules for Policy Marker.
     *
     * @param array $activity
     * @return array
     */
    public function warningForPolicyMarker(array $activity): array
    {
        return (new PolicyMarkerRequest())->getWarningForPolicyMarker(Arr::get($activity, 'policy_marker', []));
    }

    /**
     * Get rules for Budget.
     *
     * @param array $activity
     * @return array
     */
    protected function warningForBudget(array $activity): array
    {
        return (new BudgetRequest())->getWarningForBudget(Arr::get($activity, 'budget', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function warningForPlannedDisbursement(array $activity): array
    {
        return (new PlannedDisbursementRequest())->getWarningForPlannedDisbursement(Arr::get($activity, 'planned_disbursement', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function warningForDocumentLink(array $activity): array
    {
        return (new DocumentLinkRequest())->getWarningForDocumentLink(Arr::get($activity, 'document_link', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function warningForRelatedActivity(array $activity): array
    {
        return (new RelatedActivityRequest())->getWarningForRelatedActivity(Arr::get($activity, 'related_activity', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function warningForLegacyData(array $activity): array
    {
        return (new LegacyDataRequest())->getWarningForActivityLegacyData();
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function warningForCondition(array $activity): array
    {
        return $this->getBaseRules((new ConditionRequest())->getWarningForCondition(Arr::get($activity, 'conditions.condition', [])), 'conditions', Arr::get($activity, 'conditions.condition', ''), false);
    }

    /**
     * returns rules for transaction.
     * @param $activity
     * @return array
     */
    protected function warningForTransaction($activity): array
    {
        $rules = [];
        $transactions = Arr::get($activity, 'transactions', []);

        foreach ($transactions as $idx => $transaction) {
            $tempRules = $this->getBaseRules((new TransactionRequest())->getWarningForTransaction($transaction, true, $activity, $transactions), 'transactions.' . $idx, $transaction, false);

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
    protected function warningForResult(array $activity): array
    {
        $results = Arr::get($activity, 'result', []) ?? [];
        $indicators = Arr::get($activity, 'indicator', []) ?? [];
        $rules = [];

        foreach ($results as $resultIndex => $result) {
            $resultBase = sprintf('result.%s', $resultIndex);

            $tempRules = [
                $this->getWarningForIndicator(Arr::get($result, 'indicator', []), $resultBase, $result),
                (new ResultRequest())->getWarningForResult($result, true, $indicators),
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
    protected function getWarningForIndicator($indicators, $resultBase, $result): array
    {
        $rules = [];

        foreach ($indicators as $indicatorIndex => $indicator) {
            $indicatorBase = sprintf('indicator.%s', $indicatorIndex);

            $tempRules = [
                (new IndicatorRequest())->getWarningForIndicator($indicator, true, $result),
                $this->getWarningForPeriod(Arr::get($indicator, 'period', []) ?? [], $resultBase . '.' . $indicatorBase, $indicator),
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
    protected function getWarningForPeriod($formFields, $formBase, $indicator): array
    {
        $rules = [];

        foreach ($formFields as $periodIndex => $period) {
            $periodBase = sprintf('period.%s', $periodIndex);
            $tempRules = (new PeriodRequest())->getWarningForPeriod($period, true, $indicator, $formBase . '.' . $periodBase);

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
    public function warningForTag(array $activity): array
    {
        return (new TagRequest())->getWarningForTag(Arr::get($activity, 'tag', []));
    }

    /**
     * returns rules for default aid type.
     *
     * @param array $activity
     * @return array
     */
    protected function warningForDefaultAidType(array $activity): array
    {
        return (new DefaultAidTypeRequest())->getWarningForDefaultAidType();
    }
}
