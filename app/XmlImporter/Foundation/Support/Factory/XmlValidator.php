<?php

declare(strict_types=1);

namespace App\XmlImporter\Foundation\Support\Factory;

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

class XmlValidator
{
    /**
     * @var
     */
    protected $activity;

    /**
     * @var Validation
     */
    protected $factory;

    /**
     * @param Validation $factory
     */
    public function __construct(Validation $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $activity = $this->activity;
        $rules = [];

        $tempRules = [
            $this->rulesForActivityStatus($activity),
            $this->rulesForActivityScope($activity),
            $this->rulesForCollaborationType($activity),
            $this->rulesForDefaultFlowType($activity),
            $this->rulesForDefaultFinanceType($activity),
            $this->rulesForDefaultTiedStatus($activity),
            $this->rulesForCapitalSpend($activity),
            // $this->rulesForTitle($activity),
            $this->rulesForDescription($activity),
            $this->rulesForOtherIdentifier($activity),
            $this->rulesForActivityDate($activity),
            $this->rulesForDefaultAidType($activity),
            $this->rulesForContactInfo($activity),
            $this->rulesForParticipatingOrg($activity),
            $this->rulesForRecipientCountry($activity),
            $this->rulesForRecipientRegion($activity),
            $this->rulesForLocation($activity),
            $this->rulesForSector($activity),
            $this->rulesForTag($activity),
            $this->rulesForCountryBudgetItems($activity),
            $this->rulesForHumanitarianScope($activity),
            $this->rulesForPolicyMarker($activity),
            $this->rulesForBudget($activity),
            $this->rulesForPlannedDisbursement($activity),
            $this->rulesForDocumentLink($activity),
            $this->rulesForRelatedActivity($activity),
            $this->rulesForLegacyData($activity),
            $this->rulesForCondition($activity),
            $this->rulesForTransaction($activity),
            $this->rulesForResult($activity),
            $this->rulesForReportingOrganization($activity),
        ];

        foreach ($tempRules as $tempRule) {
            foreach ($tempRule as $idx => $rule) {
                $rules[$idx] = $rule;
            }
        }

        return $rules;
    }

    /**
     * Returns the required messages for the failed validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        $activity = $this->activity;
        $messages = [];

        $tempMessages = [
            $this->messagesForActivityStatus($activity),
            $this->messagesForActivityScope($activity),
            $this->messagesForCollaborationType($activity),
            $this->messagesForDefaultFlowType($activity),
            $this->messagesForDefaultFinanceType($activity),
            $this->messagesForDefaultTiedStatus($activity),
            $this->messagesForCapitalSpend($activity),
            // $this->messagesForTitle($activity),
            $this->messagesForDescription($activity),
            $this->messagesForOtherIdentifier($activity),
            $this->messagesForActivityDate($activity),
            $this->messagesForDefaultAidType($activity),
            $this->messagesForContactInfo($activity),
            $this->messagesForParticipatingOrg($activity),
            $this->messagesForRecipientCountry($activity),
            $this->messagesForRecipientRegion($activity),
            $this->messagesForLocation($activity),
            $this->messagesForSector($activity),
            $this->messagesForTag($activity),
            $this->messagesForCountryBudgetItems($activity),
            $this->messagesForHumanitarianScope($activity),
            $this->messagesForPolicyMarker($activity),
            $this->messagesForBudget($activity),
            $this->messagesForPlannedDisbursement($activity),
            $this->messagesForDocumentLink($activity),
            $this->messagesForRelatedActivity($activity),
            $this->messagesForLegacyData($activity),
            $this->messagesForCondition($activity),
            $this->messagesForTransaction($activity),
            $this->messagesForResult($activity),
            $this->messagesForReportingOrganization($activity),
        ];

        foreach ($tempMessages as $tempMessage) {
            foreach ($tempMessage as $idx => $message) {
                $messages[$idx] = $message;
            }
        }

        return $messages;
    }

    public function init($activity)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * @param bool $shouldBeUnique
     *
     * @return array
     */
    public function validateActivity(bool $shouldBeUnique = false): array
    {
        return $this->factory->initialize($this->activity, $this->rules(), $this->messages())
            ->passes()
            ->withErrors($shouldBeUnique);
    }

    public function getBaseRules($baseRules, $element, $data, $indexRequired = true): array
    {
        $rules = [];

        foreach ($data as $idx => $value) {
            foreach ($baseRules as $elementName => $baseRule) {
                $fieldName = $indexRequired ? $element . '.' . $idx . '.' . $elementName : $element . '.' . $elementName;
                $rules[$fieldName] = $baseRule;
            }
        }

        return $rules;
    }

    public function getBaseMessages($baseMessages, $element, $data, $indexRequired = true): array
    {
        $messages = [];

        if (is_array($data)) {
            foreach ($data as $idx => $value) {
                foreach ($baseMessages as $elementName => $baseMessage) {
                    $fieldName = $indexRequired ? $element . '.' . $idx . '.' . $elementName : $element . '.' . $elementName;
                    $messages[$fieldName] = $baseMessage;
                }
            }
        } else {
            foreach ($baseMessages as $elementName => $baseMessage) {
                $messages[$element . '.' . $elementName] = $baseMessage;
            }
        }

        return $messages;
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function rulesForActivityStatus(array $activity): array
    {
        return (new StatusRequest())->rules(Arr::get($activity, 'activity_status'));
    }

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
    protected function rulesForActivityScope(array $activity): array
    {
        return (new ScopeRequest())->rules(Arr::get($activity, 'activity_scope'));
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
    protected function rulesForCollaborationType(array $activity): array
    {
        return (new CollaborationTypeRequest())->rules(Arr::get($activity, 'collaboration_type'));
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
    protected function rulesForDefaultFlowType(array $activity): array
    {
        return (new DefaultFlowTypeRequest())->rules(Arr::get($activity, 'default_flow_type'));
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
    protected function rulesForDefaultFinanceType(array $activity): array
    {
        return (new DefaultFinanceTypeRequest())->rules(Arr::get($activity, 'default_finance_type'));
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
    protected function rulesForDefaultTiedStatus(array $activity): array
    {
        return (new DefaultTiedStatusRequest())->rules(Arr::get($activity, 'default_tied_status'));
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
    protected function rulesForCapitalSpend(array $activity): array
    {
        return (new CapitalSpendRequest())->rules(Arr::get($activity, 'capital_spend'));
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
    protected function rulesForTitle(array $activity): array
    {
        // needs work
        $rules = $this->getBaseRules((new TitleRequest())->rules(), 'title', Arr::get($activity, 'title', []));

        return $rules;
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function messagesForTitle(array $activity): array
    {
        // needs work
        $messages = $this->getBaseMessages((new TitleRequest())->messages(), 'title', Arr::get($activity, 'title', []));

        return $messages;
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
        return (new DescriptionRequest())->getRulesForDescription(Arr::get($activity, 'description'));
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
        return (new DescriptionRequest())->getMessagesForDescription(Arr::get($activity, 'description'));
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
        return (new OtherIdentifierRequest())->getRulesForOtherIdentifier(Arr::get($activity, 'other_identifier'));
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
        return (new OtherIdentifierRequest())->getMessagesForOtherIdentifier(Arr::get($activity, 'other_identifier'));
    }

    /**
     * Rules for Activity Date.
     *
     * @param array $activity
     * @return array
     */
    protected function rulesForActivityDate(array $activity): array
    {
        return (new DateRequest())->getRulesForDate(Arr::get($activity, 'activity_date', []));
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
     * returns rules for participating organization.
     * @param array $activity
     * @return array
     */
    public function rulesForParticipatingOrg(array $activity): array
    {
        return (new ParticipatingOrganizationRequest())->getRulesForParticipatingOrg(Arr::get($activity, 'participating_org', []));
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
     * returns rules for recipient country form.
     * @param array $activity
     * @return array
     */
    public function rulesForRecipientCountry(array $activity): array
    {
        return (new RecipientCountryRequest())->getRulesForRecipientCountry(Arr::get($activity, 'recipient_country', []), true, );
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
     * returns rules for recipient region.
     * @param array $activity
     * @return array
     */
    public function rulesForRecipientRegion(array $activity): array
    {
        return (new RecipientRegionRequest())->getRulesForRecipientRegion(Arr::get($activity, 'recipient_region', []), true, Arr::get($activity, 'recipient_country', []));
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
     * returns rules for sector form.
     * @param array $activity
     * @return array
     */
    protected function rulesForSector(array $activity): array
    {
        return (new SectorRequest())->getSectorsRules(Arr::get($activity, 'sector', []), true);
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
     * returns rules for location form.
     * @param array $activity
     * @return array
     */
    protected function rulesForLocation(array $activity): array
    {
        return (new LocationRequest())->getRulesForLocation(Arr::get($activity, 'location', []));
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
            $rules['country_budget_item.0.' . $idx] = $rule;
        }

        return $rules;

        // $rules = [];

        // foreach ($countryBudgetItems as $countryBudgetItemIndex => $countryBudgetItem) {
        //     $countryBudgetItemBase = sprintf('country_budget_items.%s', $countryBudgetItemIndex);
        //     $rules[sprintf('%s.budget_item.0.%s', $countryBudgetItemBase, 'code')] = 'required';
        //     $rules[sprintf('%s.country_budget_vocabulary', $countryBudgetItemBase)] = sprintf(
        //         'required|in:%s',
        //         $this->validCodeList('BudgetIdentifierVocabulary')
        //     );

        //     $tempRules = $this->getBudgetItemRules($countryBudgetItem['budget_item'], $countryBudgetItemBase, 'code', $countryBudgetItem);

        //     foreach ($tempRules as $idx => $tempRule) {
        //         $rules[$idx] = $tempRule;
        //     }
        // }

        // return $rules;
    }

    /**
     * returns messages for country budget error messages.
     * @param array $activity
     * @return array
     */
    public function messagesForCountryBudgetItems(array $activity): array
    {
        $countryBudgetItems = Arr::get($activity, 'country_budget_items', []);
        $tempMessages = (new CountryBudgetItemRequest())->getMessagesForCountryBudgetItem(Arr::get($countryBudgetItems, key($countryBudgetItems), []));
        $messages = [];

        foreach ($tempMessages as $idx => $message) {
            $messages['country_budget_item.0.' . $idx] = $message;
        }

        return $messages;

        // return (new CountryBudgetItemRequest())->getMessagesForCountryBudgetItem(Arr::get($activity, 'country_budget_items', []));

        // $messages = [];
        // $countryBudgetItems = Arr::get($activity, 'country_budget_items', []);

        // foreach ($countryBudgetItems as $countryBudgetItemIndex => $countryBudgetItem) {
        //     $countryBudgetItemBase = sprintf('country_budget_items.%s', $countryBudgetItemIndex);
        //     $code = 'code';
        //     $messages[sprintf(
        //         '%s.budget_item.0.%s.required',
        //         $countryBudgetItemBase,
        //         $code
        //     )] = trans('validation.required', ['attribute' => trans('elementForm.code')]);
        //     $messages[sprintf('%s.country_budget_vocabulary.required', $countryBudgetItemBase)] = trans(
        //         'validation.required',
        //         ['attribute' => trans('elementForm.country_budget_item_vocabulary')]
        //     );
        //     $messages[sprintf('%s.country_budget_vocabulary.in', $countryBudgetItemBase)] = trans(
        //         'validation.code_list',
        //         ['attribute' => trans('elementForm.country_budget_item_vocabulary')]
        //     );
        //     $tempMessages = $this->getBudgetItemMessages(Arr::get($countryBudgetItem, 'budget_item', []), $countryBudgetItemBase, $code, $countryBudgetItem);

        //     foreach ($tempMessages as $idx => $tempMessage) {
        //         $messages[$idx] = $tempMessage;
        //     }
        // }

        // return $messages;
    }

    // /**
    //  * returns budget item validation rules.
    //  * @param $budgetItems
    //  * @param $countryBudgetItemBase
    //  * @param $code
    //  * @param $countryBudgetItem
    //  * @return array
    //  */
    // public function getBudgetItemRules($budgetItems, $countryBudgetItemBase, $code, $countryBudgetItem): array
    // {
    //     $rules = [];
    //     foreach ($budgetItems as $budgetItemIndex => $budgetItem) {
    //         $budgetItemBase = sprintf('%s.budget_item.%s', $countryBudgetItemBase, $budgetItemIndex);
    //         $rules[sprintf('%s.percentage', $budgetItemBase)] = 'nullable|numeric|max:100';
    //         $rules[sprintf('%s.%s', $budgetItemBase, $code)] = 'required';
    //         ($code !== 'code') ?: $rules[sprintf('%s.%s', $budgetItemBase, $code)] = sprintf(
    //             'in:%s',
    //             $this->validCodeList('BudgetIdentifier')
    //         );
    //         $tempRules = [
    //             $this->getBudgetItemDescriptionRules(Arr::get($budgetItem, 'description', []), $budgetItemBase),
    //             $this->getRulesForBudgetPercentage($countryBudgetItemBase, $countryBudgetItem),
    //         ];

    //         foreach ($tempRules as $tempRule) {
    //             foreach ($tempRule as $idx => $rule) {
    //                 $rules[$idx] = $rule;
    //             }
    //         }
    //     }

    //     return $rules;
    // }

    // /**
    //  * return budget item error message.
    //  * @param       $budgetItems
    //  * @param       $countryBudgetItemBase
    //  * @param       $code
    //  * @param       $countryBudgetItem
    //  * @return array
    //  */
    // public function getBudgetItemMessages($budgetItems, $countryBudgetItemBase, $code, $countryBudgetItem): array
    // {
    //     $messages = [];

    //     foreach ($budgetItems as $budgetItemIndex => $budgetItem) {
    //         $budgetItemBase = sprintf('%s.budget_item.%s', $countryBudgetItemBase, $budgetItemIndex);
    //         $messages[sprintf('%s.%s.required', $budgetItemBase, $code)] = trans(
    //             'validation.required',
    //             ['attribute' => trans('elementForm.budget_item_code')]
    //         );
    //         $messages[sprintf('%s.%s.in', $budgetItemBase, $code)] = trans(
    //             'validation.code_list',
    //             ['attribute' => trans('elementForm.budget_item_code')]
    //         );
    //         $messages[sprintf('%s.percentage.%s', $budgetItemBase, 'numeric')] = trans(
    //             'validation.numeric',
    //             ['attribute' => trans('elementForm.percentage')]
    //         );
    //         $messages[sprintf('%s.percentage.%s', $budgetItemBase, 'max')] = trans(
    //             'validation.numeric.max',
    //             ['attribute' => trans('elementForm.percentage'), 'max' => 100]
    //         );
    //         $messages[sprintf('%s.percentage.sum', $budgetItemBase)] = trans(
    //             'validation.sum',
    //             ['attribute' => trans('elementForm.budget_items)')]
    //         );
    //         $messages[sprintf('%s.percentage.required', $budgetItemBase)] = trans(
    //             'validation.required_with',
    //             ['attribute' => trans('elementForm.percentage'), 'values' => trans('global.multiple_codes')]
    //         );
    //         $messages[sprintf('%s.percentage.total', $budgetItemBase)] = trans(
    //             'validation.total',
    //             ['attribute' => trans('elementForm.percentage'), 'values' => trans('elementForm.budget_item)')]
    //         );
    //         $tempMessages = [
    //             $this->getBudgetItemDescriptionMessages(Arr::get($budgetItem, 'description', []), $budgetItemBase),
    //             $this->getMessagesForBudgetPercentage($countryBudgetItemBase, $countryBudgetItem),
    //         ];

    //         foreach ($tempMessages as $idx => $tempMessage) {
    //             $messages[$idx] = $tempMessage;
    //         }
    //     }

    //     return $messages;
    // }

    // /**
    //  * return budget item description rule.
    //  * @param $descriptions
    //  * @param $budgetItemBase
    //  * @return array
    //  */
    // public function getBudgetItemDescriptionRules($descriptions, $budgetItemBase): array
    // {
    //     $rules = [];
    //     foreach ($descriptions as $descriptionIndex => $description) {
    //         $descriptionBase = sprintf('%s.description.%s', $budgetItemBase, $descriptionIndex);
    //         $rules = $this->factory->getRulesForNarrative($description['narrative'], $descriptionBase);
    //     }

    //     return $rules;
    // }

    // /**
    //  * return budget item description error message.
    //  * @param $descriptions
    //  * @param $budgetItemBase
    //  * @return array
    //  */
    // public function getBudgetItemDescriptionMessages($descriptions, $budgetItemBase): array
    // {
    //     $messages = [];

    //     foreach ($descriptions as $descriptionIndex => $description) {
    //         $descriptionBase = sprintf('%s.description.%s', $budgetItemBase, $descriptionIndex);
    //         $messages = $this->factory->getMessagesForNarrative($description['narrative'], $descriptionBase);
    //     }

    //     return $messages;
    // }

    // /** Returns rules for percentage.
    //  *
    //  * @param $countryBudgetItemBase
    //  * @param $countryBudget
    //  *
    //  * @return array
    //  */
    // protected function getRulesForBudgetPercentage($countryBudgetItemBase, $countryBudget): array
    // {
    //     $countryBudgetItems = Arr::get($countryBudget, 'budget_item', []);
    //     $totalPercentage = 0;
    //     $isEmpty = false;
    //     $countryBudgetPercentage = 0;
    //     $rules = [];

    //     if (count($countryBudgetItems) > 1) {
    //         foreach ($countryBudgetItems as $key => $countryBudgetItem) {
    //             ($countryBudgetItem['percentage'] !== '') ? $countryBudgetPercentage = $countryBudgetItem['percentage'] : $isEmpty = true;
    //             $totalPercentage = $totalPercentage + $countryBudgetPercentage;
    //         }

    //         foreach ($countryBudgetItems as $key => $countryBudgetItem) {
    //             if ($isEmpty) {
    //                 $rules[sprintf('%s.budget_item.%s.percentage', $countryBudgetItemBase, $key)] = 'required';
    //             } elseif ($totalPercentage !== 100) {
    //                 $rules[sprintf('%s.budget_item.%s.percentage', $countryBudgetItemBase, $key)] = 'sum';
    //             }
    //         }
    //     } else {
    //         $rules[sprintf('%s.budget_item.0.percentage', $countryBudgetItemBase)] = 'total';
    //     }

    //     return $rules;
    // }

    // /** Returns messages for percentage.
    //  *
    //  * @param $countryBudgetItemBase
    //  * @param $countryBudget
    //  *
    //  * @return array
    //  */
    // protected function getMessagesForBudgetPercentage($countryBudgetItemBase, $countryBudget): array
    // {
    //     $countryBudgetItems = Arr::get($countryBudget, 'budget_item', []);
    //     $messages = [];

    //     if (count($countryBudgetItems) > 1) {
    //         foreach ($countryBudgetItems as $key => $countryBudgetItem) {
    //             $messages[sprintf('%s.budget_item.%s.percentage.required', $countryBudgetItemBase, $key)] = trans('validation.required', ['attribute' => 'budget_item_percentage']);
    //             $messages[sprintf('%s.budget_item.%s.percentage.sum', $countryBudgetItemBase, $key)] = 'The sum of percentages must be 100.';
    //         }
    //     } else {
    //         $messages[sprintf('%s.budget_item.0.percentage.total', $countryBudgetItemBase)] = trans('validation.total', ['attribute' => 'budget_item_percentage', 'values' => 'budget_item']);
    //     }

    //     return $messages;
    // }

    /**
     * returns rules for HumanitarianScope.
     * @param array $activity
     * @return array
     */
    public function rulesForHumanitarianScope(array $activity): array
    {
        return (new HumanitarianScopeRequest())->getRulesForHumanitarianScope(Arr::get($activity, 'humanitarian_scope', []));
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
     * Get messages for Budget.
     *
     * @param array $activity
     * @return array
     */
    protected function messagesForBudget(array $activity): array
    {
        return (new BudgetRequest())->getMessagesForBudget(Arr::get($activity, 'budget', []));
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
    protected function messagesForPlannedDisbursement(array $activity): array
    {
        return (new PlannedDisbursementRequest())->getMessagesForPlannedDisbursement(Arr::get($activity, 'planned_disbursement', []));
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
    protected function messagesForDocumentLink(array $activity): array
    {
        return (new DocumentLinkRequest())->getMessagesForDocumentLink(Arr::get($activity, 'document_link', []));
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
    protected function messagesForRelatedActivity(array $activity): array
    {
        return (new RelatedActivityRequest())->getMessagesForRelatedActivity(Arr::get($activity, 'related_activity', []));
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
    protected function messagesForLegacyData(array $activity): array
    {
        return (new LegacyDataRequest())->getMessagesForActivityLegacyData(Arr::get($activity, 'legacy_data', []));
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
     * @param array $activity
     * @return array
     */
    protected function messagesForCondition(array $activity): array
    {
        return $this->getBaseMessages((new ConditionRequest())->getMessagesForCondition(Arr::get($activity, 'conditions.condition', [])), 'conditions', Arr::get($activity, 'conditions.condition', ''), false);
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
     * returns rules for result.
     * @param array $activity
     * @return array
     */
    protected function rulesForResult(array $activity): array
    {
        $results = Arr::get($activity, 'result', []);
        $indicators = Arr::get($activity, 'indicator', []);
        $rules = [];

        foreach ($results as $resultIndex => $result) {
            $resultBase = sprintf('result.%s', $resultIndex);
            $rules[sprintf('%s.type', $resultBase)] = sprintf(
                'required|in:%s',
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
     * returns messages for result.
     * @param $activity
     * @return array
     */
    protected function messagesForResult($activity): array
    {
        $messages = [];
        $results = Arr::get($activity, 'result', []);

        foreach ($results as $resultIndex => $result) {
            $resultBase = sprintf('result.%s', $resultIndex);
            $messages[sprintf('%s.type.required', $resultBase)] = trans(
                'validation.required',
                ['attribute' => trans('elementForm.result_type')]
            );
            $messages[sprintf('%s.type.in', $resultBase)] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.result_type')]
            );

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
            $rules[sprintf('%s.ascending', $indicatorBase)] = 'in:1,0';

            $tempRules = [
                (new IndicatorRequest())->getRulesForIndicator($indicator, true, $result),
                $this->getRulesForPeriod($indicator['period'], $indicatorBase, $indicator),
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

            $messages[sprintf('%s.measure.required', $indicatorBase)] = trans(
                'validation.required',
                ['attribute' => trans('elementForm.measure')]
            );

            $tempMessages = [
                (new IndicatorRequest())->getMessagesForIndicator($indicator),
                $this->getMessagesForPeriod($indicator['period'], $indicatorBase, $indicator),
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
            $tempRules = (new PeriodRequest())->getRulesForPeriod($period, true, $indicator);

            foreach ($tempRules as $idx => $rule) {
                $rules[$periodBase . '.' . $idx] = $rule;
            }
        }

        return $rules;
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
     * Rules for reporting organization.
     *
     * @return array
     */
    protected function rulesForReportingOrganization(array $activity): array
    {
        return (new ReportingOrgRequest())->getRulesForReportingOrganization(Arr::get($activity, 'reporting_org', []));
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
