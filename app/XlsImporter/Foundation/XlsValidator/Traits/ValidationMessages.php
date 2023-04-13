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
 * Class ValidationMessages.
 */
trait ValidationMessages
{
    /**
     * @param array $activity
     *
     * @return array
     */
    protected function messagesForActivityStatus(array $activity): array
    {
        return $this->getBaseMessages((new StatusRequest())->messages(), 'activity_status', Arr::get($activity, 'activity_status', ''));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function messagesForActivityScope(array $activity): array
    {
        return $this->getBaseMessages((new ScopeRequest())->messages(), 'activity_scope', Arr::get($activity, 'activity_scope', ''));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function messagesForCollaborationType(array $activity): array
    {
        return $this->getBaseMessages((new CollaborationTypeRequest())->messages(), 'collaboration_type', Arr::get($activity, 'collaboration_type', ''));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function messagesForDefaultFlowType(array $activity): array
    {
        return $this->getBaseMessages((new DefaultFlowTypeRequest())->messages(), 'default_flow_type', Arr::get($activity, 'default_flow_type', ''));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function messagesForDefaultFinanceType(array $activity): array
    {
        return $this->getBaseMessages((new DefaultFinanceTypeRequest())->messages(), 'default_finance_type', Arr::get($activity, 'default_finance_type', ''));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function messagesForDefaultTiedStatus(array $activity): array
    {
        return $this->getBaseMessages((new DefaultTiedStatusRequest())->messages(), 'default_tied_status', Arr::get($activity, 'default_tied_status', ''));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function messagesForCapitalSpend(array $activity): array
    {
        return $this->getBaseMessages((new CapitalSpendRequest())->messages(), 'capital_spend', Arr::get($activity, 'capital_spend', ''));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function messagesForTitle(array $activity): array
    {
        return (new TitleRequest())->messages('title', Arr::get($activity, 'title', []));
    }

    /**
     * Messages for Description.
     *
     * @param array $activity
     *
     * @return array
     */
    protected function messagesForDescription(array $activity): array
    {
        return (new DescriptionRequest())->getMessagesForDescription(Arr::get($activity, 'description', []));
    }

    /**
     * Messages for Other Identifier.
     *
     * @param array $activity
     *
     * @return array
     */
    public function messagesForOtherIdentifier(array $activity): array
    {
        return (new OtherIdentifierRequest())->getMessagesForOtherIdentifier(Arr::get($activity, 'other_identifier', []));
    }

    /**
     * Messages for Activity Date.
     *
     * @param array $activity
     * @return array
     */
    protected function messagesForActivityDate(array $activity): array
    {
        return (new DateRequest())->getMessagesForDate(Arr::get($activity, 'activity_date', []));
    }

    /**
     * Messages for Contact Info.
     *
     * @param array $activity
     * @return array
     */
    protected function messagesForContactInfo(array $activity): array
    {
        return (new ContactInfoRequest())->getMessagesForContactInfo(Arr::get($activity, 'contact_info', []));
    }

    /**
     * returns messages for participating organization.
     * @param array $activity
     * @return array
     */
    public function messagesForParticipatingOrg(array $activity): array
    {
        return (new ParticipatingOrganizationRequest())->getMessagesForParticipatingOrg(Arr::get($activity, 'participating_org', []));
    }

    /**
     * returns messages for recipient country form rules.
     * @param array $activity
     * @return array
     */
    public function messagesForRecipientCountry(array $activity): array
    {
        return (new RecipientCountryRequest())->getMessagesForRecipientCountry(Arr::get($activity, 'recipient_country', []));
    }

    /**
     * returns messages for recipient region m.
     * @param array $activity
     * @return array
     */
    public function messagesForRecipientRegion(array $activity): array
    {
        return (new RecipientRegionRequest())->getMessagesForRecipientRegion(Arr::get($activity, 'recipient_region', []));
    }

    /**
     * returns messages for sector form.
     * @param array $activity
     * @return array
     */
    protected function messagesForSector(array $activity): array
    {
        return (new SectorRequest())->getSectorsMessages(Arr::get($activity, 'sector', []));
    }

    /**
     * returns messages for location form.
     * @param array $activity
     * @return array
     */
    protected function messagesForLocation(array $activity): array
    {
        return (new LocationRequest())->getMessagesForLocation(Arr::get($activity, 'location', []));
    }

    /**
     * returns messages for country budget error messages.
     *
     * @param array $activity
     *
     * @return array
     */
    public function messagesForCountryBudgetItems(array $activity): array
    {
        $countryBudgetItems = Arr::get($activity, 'country_budget_items', []);

        return (new CountryBudgetItemRequest())->getMessagesForCountryBudgetItem($countryBudgetItems);
    }

    /**
     * Returns messages for HumanitarianScope.
     *
     * @param array $activity
     * @return array
     */
    public function messagesForHumanitarianScope(array $activity): array
    {
        return (new HumanitarianScopeRequest())->getMessagesForHumanitarianScope(Arr::get($activity, 'humanitarian_scope', []));
    }

    /**
     * Get messages for PolicyMarker.
     *
     * @param array $activity
     * @return array
     */
    public function messagesForPolicyMarker(array $activity): array
    {
        return (new PolicyMarkerRequest())->getMessagesForPolicyMarker(Arr::get($activity, 'policy_marker', []));
    }

    /**
     * Get messages for Budget.
     *
     * @param array $activity
     * @return array
     */
    protected function messagesForBudget(array $activity): array
    {
        return (new BudgetRequest())->getMessagesForBudget(Arr::get($activity, 'budget', []), true);
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function messagesForPlannedDisbursement(array $activity): array
    {
        return (new PlannedDisbursementRequest())->getMessagesForPlannedDisbursement(Arr::get($activity, 'planned_disbursement', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function messagesForDocumentLink(array $activity): array
    {
        return (new DocumentLinkRequest())->getMessagesForDocumentLink(Arr::get($activity, 'document_link', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function messagesForRelatedActivity(array $activity): array
    {
        return (new RelatedActivityRequest())->getMessagesForRelatedActivity(Arr::get($activity, 'related_activity', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function messagesForLegacyData(array $activity): array
    {
        return (new LegacyDataRequest())->getMessagesForActivityLegacyData(Arr::get($activity, 'legacy_data', []));
    }

    /**
     * @param array $activity
     * @return array
     */
    protected function messagesForCondition(array $activity): array
    {
        return $this->getBaseMessages((new ConditionRequest())->getMessagesForCondition(Arr::get($activity, 'conditions.condition', [])), 'conditions', Arr::get($activity, 'conditions.condition', ''), false);
    }

    /**
     * returns messages for transaction.
     * @param $activity
     * @return array
     */
    protected function messagesForTransaction($activity): array
    {
        $messages = [];
        $transactions = Arr::get($activity, 'transactions', []);

        foreach ($transactions as $idx => $transaction) {
            $tempMessage = $this->getBaseMessages((new TransactionRequest())->getMessagesForTransaction($transaction, true, $activity), 'transactions.' . $idx, $transaction, false);
            foreach ($tempMessage as $index => $message) {
                $messages[$index] = $message;
            }
        }

        return $messages;
    }

    /**
     * returns messages for result.
     * @param $activity
     * @return array
     */
    protected function messagesForResult($activity): array
    {
        $messages = [];
        $results = Arr::get($activity, 'result', []) ?? [];

        foreach ($results as $resultIndex => $result) {
            $resultBase = sprintf('result.%s', $resultIndex);

            $tempMessages = [
                (new ResultRequest())->getMessagesForResult($result, true),
                $this->getMessagesForIndicator(Arr::get($result, 'indicator', []), $resultBase),
            ];

            foreach ($tempMessages as $index => $tempMessage) {
                foreach ($tempMessage as $idx => $message) {
                    $messages[$resultBase . '.' . $idx] = $message;
                }
            }
        }

        return $messages;
    }

    /**
     * returns messages for indicator.
     * @param $indicators
     * @param $resultBase
     * @return array
     */
    protected function getMessagesForIndicator($indicators, $resultBase): array
    {
        $messages = [];

        foreach ($indicators as $indicatorIndex => $indicator) {
            $indicatorBase = sprintf(
                'indicator.%s',
                $indicatorIndex
            );

            $tempMessages = [
                (new IndicatorRequest())->getMessagesForIndicator($indicator),
                $this->getMessagesForPeriod(Arr::get($indicator, 'period', []) ?? [], $indicatorBase, $indicator),
            ];

            foreach ($tempMessages as $index => $tempMessage) {
                foreach ($tempMessage as $idx => $message) {
                    $messages[$indicatorBase . '.' . $idx] = $message;
                }
            }
        }

        return $messages;
    }

    /**
     * returns messages for period.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForPeriod($formFields, $formBase, $indicator): array
    {
        $messages = [];

        foreach ($formFields as $periodIndex => $period) {
            $periodBase = sprintf('period.%s', $periodIndex);

            $tempMessage = (new PeriodRequest())->getMessagesForPeriod($period, true, $indicator);

            foreach ($tempMessage as $idx => $message) {
                $messages[$periodBase . '.' . $idx] = $message;
            }
        }

        return $messages;
    }

    /**
     * returns messages for tag.
     *
     * @param array $activity
     * @return array
     */
    public function messagesForTag(array $activity): array
    {
        return (new TagRequest())->getMessagesForTag(Arr::get($activity, 'tag', []));
    }

    /**
     * returns messages for default aid type.
     *
     * @param array $activity
     * @return array
     */
    protected function messagesForDefaultAidType(array $activity): array
    {
        return (new DefaultAidTypeRequest())->getMessagesForDefaultAidType(Arr::get($activity, 'default_aid_type', []));
    }

    /**
     * Messages for reporting organization.
     *
     * @return array
     */
    public function messagesForReportingOrganization(array $activity): array
    {
        return (new ReportingOrgRequest())->getMessagesForReportingOrganization(Arr::get($activity, 'reporting_org', []));
    }
}
