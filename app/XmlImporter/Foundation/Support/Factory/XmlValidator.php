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
use App\Http\Requests\Activity\LegacyData\LegacyDataRequest;
use App\Http\Requests\Activity\Location\LocationRequest;
use App\Http\Requests\Activity\OtherIdentifier\OtherIdentifierRequest;
use App\Http\Requests\Activity\ParticipatingOrganization\ParticipatingOrganizationRequest;
use App\Http\Requests\Activity\PlannedDisbursement\PlannedDisbursementRequest;
use App\Http\Requests\Activity\PolicyMarker\PolicyMarkerRequest;
use App\Http\Requests\Activity\RecipientCountry\RecipientCountryRequest;
use App\Http\Requests\Activity\RecipientRegion\RecipientRegionRequest;
use App\Http\Requests\Activity\RelatedActivity\RelatedActivityRequest;
use App\Http\Requests\Activity\ReportingOrg\ReportingOrgRequest;
use App\Http\Requests\Activity\Scope\ScopeRequest;
use App\Http\Requests\Activity\Sector\SectorRequest;
use App\Http\Requests\Activity\Status\StatusRequest;
use App\Http\Requests\Activity\Tag\TagRequest;
use App\Http\Requests\Activity\Title\TitleRequest;
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
            // $this->rulesForRecipientCountry($activity),
            // $this->rulesForRecipientRegion($activity),
            $this->rulesForLocation($activity),
            // $this->rulesForSector($activity),
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
            // $this->rulesForTransaction($activity),
            // $this->rulesForResult($activity),
            $this->rulesForReportingOrganization($activity),
        ];

        foreach ($tempRules as $tempRule) {
            foreach ($tempRule as $idx => $rule) {
                $rules[$idx] = $rule;
            }
        }

        dump($rules);

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
            // $this->messagesForRecipientCountry($activity),
            // $this->messagesForRecipientRegion($activity),
            $this->messagesForLocation($activity),
            // $this->messagesForSector($activity),
            $this->messagesForTag($activity),
            $this->messagesForCountryBudgetItems($activity),
            $this->messagesForHumanitarianScope($activity),
            $this->messagesForPolicyMarker($activity),
            // $this->messagesForDefaultAidType($activity),
            $this->messagesForBudget($activity),
            $this->messagesForPlannedDisbursement($activity),
            $this->messagesForDocumentLink($activity),
            $this->messagesForRelatedActivity($activity),
            $this->messagesForLegacyData($activity),
            $this->messagesForCondition($activity),
            // $this->messagesForTransaction($activity),
            // $this->messagesForResult($activity),
            $this->messagesForReportingOrganization($activity),
        ];

        foreach ($tempMessages as $tempMessage) {
            foreach ($tempMessage as $idx => $message) {
                $messages[$idx] = $message;
            }
        }

        dump($messages);

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
        return $this->getBaseRules((new TitleRequest())->rules(), 'title', Arr::get($activity, 'title', []));
    }

    /**
     * @param array $activity
     *
     * @return array
     */
    protected function messagesForTitle(array $activity): array
    {
        return $this->getBaseMessages((new TitleRequest())->messages(), 'title', Arr::get($activity, 'title', []));
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
        // $rules = [];
        // $participatingOrganizations = Arr::get($activity, 'participating_organization', []);
        // $participatingOrganization = Arr::get($activity, 'participating_org', []);
        // dump($participatingOrganizations, $participatingOrganization);

        return (new ParticipatingOrganizationRequest())->getRulesForParticipatingOrg(Arr::get($activity, 'participating_organization', []));

        // $rules['participating_organization'] = 'required';

        // foreach ($participatingOrganizations as $participatingOrgIndex => $participatingOrg) {
        //     $participatingOrgBase = 'participating_organization.' . $participatingOrgIndex;
        //     $rules[$participatingOrgBase . '.organization_role'] = sprintf(
        //         'required|in:%s',
        //         $this->validCodeList('OrganisationRole', 'Organization')
        //     );
        //     $rules[$participatingOrgBase . '.type'] = sprintf(
        //         'in:%s',
        //         $this->validCodeList('OrganizationType', 'Organization')
        //     );
        //     $identifier = $participatingOrgBase . '.identifier';
        //     $narrative = sprintf('%s.narrative.0.narrative', $participatingOrgBase);
        //     $rules[$identifier] = 'exclude_operators|required_without:' . $narrative;
        //     $rules[$participatingOrgBase . '.crs_channel_code'] = sprintf(
        //         'nullable|in:%s',
        //         $this->validCodeList('CRSChannelCode')
        //     );
        //     $rules[$narrative] = [];
        //     $rules[$narrative][] = 'required_without:' . $identifier;
        //     $tempRules = $this->factory->getRulesForNarrative($participatingOrg['narrative'], $participatingOrgBase);

        //     foreach ($tempRules as $idx => $tempRule) {
        //         $rules[$idx] = $tempRule;
        //     }
        // }

        // return $rules;
    }

    /**
     * returns messages for participating organization.
     * @param array $activity
     * @return array
     */
    public function messagesForParticipatingOrg(array $activity): array
    {
        $messages = [];
        $participatingOrganizations = Arr::get($activity, 'participating_organization', []);

        return (new ParticipatingOrganizationRequest())->getMessagesForParticipatingOrg(Arr::get($activity, 'activity_date', []));

        // $messages['participating_organization.required'] = trans(
        //     'validation.required',
        //     ['attribute' => trans('element.participating_organisation')]
        // );

        // foreach ($participatingOrganizations as $participatingOrgIndex => $participatingOrg) {
        //     $participatingOrgBase = 'participating_organization.' . $participatingOrgIndex;
        //     $messages[$participatingOrgBase . '.organization_role.required'] = trans(
        //         'validation.required',
        //         ['attribute' => trans('elementForm.organisation_role')]
        //     );
        //     $messages[$participatingOrgBase . '.organization_role.in'] = trans(
        //         'validation.code_list',
        //         ['attribute' => trans('elementForm.organisation_role')]
        //     );
        //     $messages[$participatingOrgBase . '.type.in'] = trans(
        //         'validation.code_list',
        //         ['attribute' => trans('elementForm.organisation_type')]
        //     );
        //     $identifier = $participatingOrgBase . '.identifier';
        //     $narrative = sprintf('%s.narrative.0.narrative', $participatingOrgBase);
        //     $messages[$identifier . '.required_without'] = trans(
        //         'validation.required_without',
        //         ['attribute' => trans('elementForm.identifier'), 'values' => trans('elementForm.narrative')]
        //     );
        //     $messages[$participatingOrgBase . '.crs_channel_code.in'] = trans(
        //         'validation.code_list',
        //         ['attribute' => trans('elementForm.organisation_crs_channel_code')]
        //     );
        //     $messages[$narrative . '.required_without'] = trans(
        //         'validation.required_without',
        //         ['attribute' => trans('elementForm.narrative'), 'values' => trans('elementForm.identifier')]
        //     );
        //     $tempMessages = $this->factory->getMessagesForNarrative($participatingOrg['narrative'], $participatingOrgBase);

        //     foreach ($tempMessages as $idx => $tempMessage) {
        //         $messages[$idx] = $tempMessage;
        //     }
        // }

        return $messages;
    }

    /**
     * returns rules for recipient country form.
     * @param array $activity
     * @return array
     */
    public function rulesForRecipientCountry(array $activity): array
    {
        // $rules = [];
        // $recipientCountries = Arr::get($activity, 'recipient_country', []);

        return (new RecipientCountryRequest())->getRulesForRecipientCountry(Arr::get($activity, 'recipient_country', []));

        // foreach ($recipientCountries as $recipientCountryIndex => $recipientCountry) {
        //     $recipientCountryBase = 'recipient_country.' . $recipientCountryIndex;
        //     $rules[$recipientCountryBase . '.country_code'] = sprintf(
        //         'required|in:%s',
        //         $this->validCodeList('Country', 'Organization')
        //     );
        //     $rules[$recipientCountryBase . '.percentage'] = 'nullable|numeric|max:100';
        //     if (count($recipientCountries) > 1) {
        //         $rules[$recipientCountryBase . '.percentage'] = 'required|numeric|max:100';
        //     }
        //     $tempRules = $this->factory->getRulesForNarrative($recipientCountry['narrative'], $recipientCountryBase);

        //     foreach ($tempRules as $idx => $tempRule) {
        //         $rules[$idx] = $tempRule;
        //     }
        // }

        // return $rules;
    }

    /**
     * returns messages for recipient country form rules.
     * @param array $activity
     * @return array
     */
    public function messagesForRecipientCountry(array $activity): array
    {
        // $messages = [];
        // $recipientCountries = Arr::get($activity, 'recipient_country', []);
        return (new RecipientCountryRequest())->getMessagesForRecipientCountry(Arr::get($activity, 'recipient_country', []));

        // foreach ($recipientCountries as $recipientCountryIndex => $recipientCountry) {
        //     $recipientCountryBase = 'recipient_country.' . $recipientCountryIndex;
        //     $messages[$recipientCountryBase . '.country_code.required'] = trans(
        //         'validation.required',
        //         ['attribute' => trans('elementForm.country_code')]
        //     );
        //     $messages[$recipientCountryBase . '.country_code.in'] = trans(
        //         'validation.code_list',
        //         ['attribute' => trans('elementForm.country_code')]
        //     );
        //     $messages[$recipientCountryBase . '.percentage.numeric'] = trans(
        //         'validation.numeric',
        //         ['attribute' => trans('elementForm.percentage')]
        //     );
        //     $messages[$recipientCountryBase . '.percentage.max'] = trans(
        //         'validation.max.numeric',
        //         ['attribute' => trans('elementForm.percentage'), 'max' => 100]
        //     );
        //     $messages[$recipientCountryBase . '.percentage.required'] = trans(
        //         'validation.required',
        //         ['attribute' => trans('elementForm.percentage')]
        //     );
        //     $tempMessages = $this->factory->getMessagesForNarrative($recipientCountry['narrative'], $recipientCountryBase);

        //     foreach ($tempMessages as $idx => $tempMessage) {
        //         $messages[$idx] = $tempMessage;
        //     }
        // }

        // return $messages;
    }

    /**
     * returns rules for recipient region.
     * @param array $activity
     * @return array
     */
    public function rulesForRecipientRegion(array $activity): array
    {
        // $rules = [];
        // $recipientRegions = Arr::get($activity, 'recipient_region', []);
        return (new RecipientRegionRequest())->getMessagesForRecipientRegion(Arr::get($activity, 'recipient_region', []));

        // foreach ($recipientRegions as $recipientRegionIndex => $recipientRegion) {
        //     $recipientRegionBase = 'recipient_region.' . $recipientRegionIndex;

        //     if (Arr::get($recipientRegion, 'region_vocabulary', 1) === 1 || Arr::get($recipientRegion, 'region_vocabulary', 1) === '1') {
        //         $rules[$recipientRegionBase . '.region_code'] = sprintf(
        //             'required|in:%s',
        //             $this->validCodeList('Region')
        //         );
        //     } else {
        //         $rules[$recipientRegionBase . '.custom_code'] = 'required';
        //     }

        //     $rules[$recipientRegionBase . '.percentage'] = 'nullable|numeric|max:100';
        //     if (count($recipientRegions) > 1) {
        //         $rules[$recipientRegionBase . '.percentage'] = 'required|numeric|max:100';
        //     }
        //     $tempRules = $this->factory->getRulesForNarrative(Arr::get($recipientRegion, 'narrative', []), $recipientRegionBase);

        //     foreach ($tempRules as $idx => $tempRule) {
        //         $rules[$idx] = $tempRule;
        //     }
        // }

        // return $rules;
    }

    /**
     * returns messages for recipient region m.
     * @param array $activity
     * @return array
     */
    public function messagesForRecipientRegion(array $activity): array
    {
        // $messages = [];
        // $recipientRegions = Arr::get($activity, 'recipient_region', []);
        return (new RecipientRegionRequest())->getMessagesForRecipientRegion(Arr::get($activity, 'recipient_region', []));

        // foreach ($recipientRegions as $recipientRegionIndex => $recipientRegion) {
        //     $recipientRegionBase = 'recipient_region.' . $recipientRegionIndex;

        //     if (Arr::get($recipientRegion, 'region_vocabulary', 1) === 1 || Arr::get($recipientRegion, 'region_vocabulary', 1) === '1') {
        //         $messages[$recipientRegionBase . '.region_code.required'] = trans(
        //             'validation.required',
        //             ['attribute' => trans('elementForm.recipient_region_code')]
        //         );
        //         $messages[$recipientRegionBase . '.region_code.in'] = trans(
        //             'validation.code_list',
        //             ['attribute' => trans('elementForm.region_code')]
        //         );
        //     } else {
        //         $messages[$recipientRegionBase . '.custom_code.required'] = trans(
        //             'validation.required',
        //             ['attribute' => trans('elementForm.recipient_region_code')]
        //         );
        //     }

        //     $messages[$recipientRegionBase . '.percentage.numeric'] = trans(
        //         'validation.numeric',
        //         ['attribute' => trans('elementForm.percentage')]
        //     );
        //     $messages[$recipientRegionBase . '.percentage.max'] = trans(
        //         'validation.max.numeric',
        //         ['attribute' => trans('elementForm.percentage'), 'max' => 100]
        //     );
        //     $messages[$recipientRegionBase . '.percentage.required'] = trans(
        //         'validation.required',
        //         ['attribute' => trans('elementForm.percentage')]
        //     );
        //     $tempMessages = $this->factory->getMessagesForNarrative(Arr::get($recipientRegion, 'narrative', []), $recipientRegionBase);

        //     foreach ($tempMessages as $idx => $tempMessage) {
        //         $messages[$idx] = $tempMessage;
        //     }
        // }

        // return $messages;
    }

    /**
     * returns rules for sector form.
     * @param array $activity
     * @return array
     */
    protected function rulesForSector(array $activity): array
    {
        return (new SectorRequest())->getRulesForSector(Arr::get($activity, 'sector', []));
    }

    /**
     * returns messages for sector form.
     * @param array $activity
     * @return array
     */
    protected function messagesForSector(array $activity): array
    {
        return (new SectorRequest())->getMessagesForSector(Arr::get($activity, 'sector', []));
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
        // $countryBudgetItems = Arr::get($activity, 'country_budget_items', [])
        // dump('country budget', $countryBudgetItems, Arr::get($countryBudgetItems, ' budget_item', 'none'));
        // dump('----------------------------------',(new CountryBudgetItemRequest())->getRulesForCountryBudgetItem(Arr::get($activity, 'country_budget_items', [])));
        return $this->getBaseRules((new CountryBudgetItemRequest())->getRulesForCountryBudgetItem(Arr::get($activity, 'country_budget_items', [])), 'country_budget_items', Arr::get($activity, 'country_budget_items', []));

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
        return $this->getBaseMessages((new CountryBudgetItemRequest())->getMessagesForCountryBudgetItem(Arr::get($activity, 'country_budget_items.0', [])), 'country_budget_items', Arr::get($activity, 'country_budget_items.0', ''));

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

    /**
     * returns budget item validation rules.
     * @param $budgetItems
     * @param $countryBudgetItemBase
     * @param $code
     * @param $countryBudgetItem
     * @return array
     */
    public function getBudgetItemRules($budgetItems, $countryBudgetItemBase, $code, $countryBudgetItem): array
    {
        $rules = [];
        foreach ($budgetItems as $budgetItemIndex => $budgetItem) {
            $budgetItemBase = sprintf('%s.budget_item.%s', $countryBudgetItemBase, $budgetItemIndex);
            $rules[sprintf('%s.percentage', $budgetItemBase)] = 'nullable|numeric|max:100';
            $rules[sprintf('%s.%s', $budgetItemBase, $code)] = 'required';
            ($code !== 'code') ?: $rules[sprintf('%s.%s', $budgetItemBase, $code)] = sprintf(
                'in:%s',
                $this->validCodeList('BudgetIdentifier')
            );
            $tempRules = [
                $this->getBudgetItemDescriptionRules(Arr::get($budgetItem, 'description', []), $budgetItemBase),
                $this->getRulesForBudgetPercentage($countryBudgetItemBase, $countryBudgetItem),
            ];

            foreach ($tempRules as $tempRule) {
                foreach ($tempRule as $idx => $rule) {
                    $rules[$idx] = $rule;
                }
            }
        }

        return $rules;
    }

    /**
     * return budget item error message.
     * @param       $budgetItems
     * @param       $countryBudgetItemBase
     * @param       $code
     * @param       $countryBudgetItem
     * @return array
     */
    public function getBudgetItemMessages($budgetItems, $countryBudgetItemBase, $code, $countryBudgetItem): array
    {
        $messages = [];

        foreach ($budgetItems as $budgetItemIndex => $budgetItem) {
            $budgetItemBase = sprintf('%s.budget_item.%s', $countryBudgetItemBase, $budgetItemIndex);
            $messages[sprintf('%s.%s.required', $budgetItemBase, $code)] = trans(
                'validation.required',
                ['attribute' => trans('elementForm.budget_item_code')]
            );
            $messages[sprintf('%s.%s.in', $budgetItemBase, $code)] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.budget_item_code')]
            );
            $messages[sprintf('%s.percentage.%s', $budgetItemBase, 'numeric')] = trans(
                'validation.numeric',
                ['attribute' => trans('elementForm.percentage')]
            );
            $messages[sprintf('%s.percentage.%s', $budgetItemBase, 'max')] = trans(
                'validation.numeric.max',
                ['attribute' => trans('elementForm.percentage'), 'max' => 100]
            );
            $messages[sprintf('%s.percentage.sum', $budgetItemBase)] = trans(
                'validation.sum',
                ['attribute' => trans('elementForm.budget_items)')]
            );
            $messages[sprintf('%s.percentage.required', $budgetItemBase)] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.percentage'), 'values' => trans('global.multiple_codes')]
            );
            $messages[sprintf('%s.percentage.total', $budgetItemBase)] = trans(
                'validation.total',
                ['attribute' => trans('elementForm.percentage'), 'values' => trans('elementForm.budget_item)')]
            );
            $tempMessages = [
                $this->getBudgetItemDescriptionMessages(Arr::get($budgetItem, 'description', []), $budgetItemBase),
                $this->getMessagesForBudgetPercentage($countryBudgetItemBase, $countryBudgetItem),
            ];

            foreach ($tempMessages as $idx => $tempMessage) {
                $messages[$idx] = $tempMessage;
            }
        }

        return $messages;
    }

    /**
     * return budget item description rule.
     * @param $descriptions
     * @param $budgetItemBase
     * @return array
     */
    public function getBudgetItemDescriptionRules($descriptions, $budgetItemBase): array
    {
        $rules = [];
        foreach ($descriptions as $descriptionIndex => $description) {
            $descriptionBase = sprintf('%s.description.%s', $budgetItemBase, $descriptionIndex);
            $rules = $this->factory->getRulesForNarrative($description['narrative'], $descriptionBase);
        }

        return $rules;
    }

    /**
     * return budget item description error message.
     * @param $descriptions
     * @param $budgetItemBase
     * @return array
     */
    public function getBudgetItemDescriptionMessages($descriptions, $budgetItemBase): array
    {
        $messages = [];

        foreach ($descriptions as $descriptionIndex => $description) {
            $descriptionBase = sprintf('%s.description.%s', $budgetItemBase, $descriptionIndex);
            $messages = $this->factory->getMessagesForNarrative($description['narrative'], $descriptionBase);
        }

        return $messages;
    }

    /** Returns rules for percentage.
     *
     * @param $countryBudgetItemBase
     * @param $countryBudget
     *
     * @return array
     */
    protected function getRulesForBudgetPercentage($countryBudgetItemBase, $countryBudget): array
    {
        $countryBudgetItems = Arr::get($countryBudget, 'budget_item', []);
        $totalPercentage = 0;
        $isEmpty = false;
        $countryBudgetPercentage = 0;
        $rules = [];

        if (count($countryBudgetItems) > 1) {
            foreach ($countryBudgetItems as $key => $countryBudgetItem) {
                ($countryBudgetItem['percentage'] !== '') ? $countryBudgetPercentage = $countryBudgetItem['percentage'] : $isEmpty = true;
                $totalPercentage = $totalPercentage + $countryBudgetPercentage;
            }

            foreach ($countryBudgetItems as $key => $countryBudgetItem) {
                if ($isEmpty) {
                    $rules[sprintf('%s.budget_item.%s.percentage', $countryBudgetItemBase, $key)] = 'required';
                } elseif ($totalPercentage !== 100) {
                    $rules[sprintf('%s.budget_item.%s.percentage', $countryBudgetItemBase, $key)] = 'sum';
                }
            }
        } else {
            $rules[sprintf('%s.budget_item.0.percentage', $countryBudgetItemBase)] = 'total';
        }

        return $rules;
    }

    /** Returns messages for percentage.
     *
     * @param $countryBudgetItemBase
     * @param $countryBudget
     *
     * @return array
     */
    protected function getMessagesForBudgetPercentage($countryBudgetItemBase, $countryBudget): array
    {
        $countryBudgetItems = Arr::get($countryBudget, 'budget_item', []);
        $messages = [];

        if (count($countryBudgetItems) > 1) {
            foreach ($countryBudgetItems as $key => $countryBudgetItem) {
                $messages[sprintf('%s.budget_item.%s.percentage.required', $countryBudgetItemBase, $key)] = trans('validation.required', ['attribute' => 'budget_item_percentage']);
                $messages[sprintf('%s.budget_item.%s.percentage.sum', $countryBudgetItemBase, $key)] = 'The sum of percentages must be 100.';
            }
        } else {
            $messages[sprintf('%s.budget_item.0.percentage.total', $countryBudgetItemBase)] = trans('validation.total', ['attribute' => 'budget_item_percentage', 'values' => 'budget_item']);
        }

        return $messages;
    }

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
        $transactions = Arr::get($activity, 'transaction', []);

        foreach ($transactions as $transactionIndex => $transaction) {
            $references = $this->getReferences($transactions, $transaction['id']);
            $transactionBase = sprintf('transaction.%s.transaction', $transactionIndex);

            $transactionReferences = [];
            foreach ($references as $referenceKey => $reference) {
                $transactionReferences[] = $reference;
            }

            $transactionReference = implode(',', $transactionReferences);
            $rules[sprintf('%s.humanitarian', $transactionBase)] = 'in:1,0';
            $rules[sprintf('%s.reference', $transactionBase)] = 'not_in:' . $transactionReference;
            $rules[sprintf(
                '%s.provider_organization.0.organization_identifier_code',
                $transactionBase
            )] = 'exclude_operators';
            $rules[sprintf(
                '%s.receiver_organization.0.organization_identifier_code',
                $transactionBase
            )] = 'exclude_operators';
            $rules[sprintf('%s.recipient_country.0.country_code', $transactionBase)] = sprintf(
                'in:%s',
                $this->validCodeList('Country', 'Organization')
            );
            $rules[sprintf('%s.recipient_region.0.region_code', $transactionBase)] = sprintf(
                'in:%s',
                $this->validCodeList('Region')
            );
            $rules[sprintf('%s.recipient_region.0.vocabulary', $transactionBase)] = sprintf(
                'in:%s',
                $this->validCodeList('RegionVocabulary')
            );
            $rules[sprintf('%s.flow_type.0.flow_type', $transactionBase)] = sprintf(
                'in:%s',
                $this->validCodeList('FlowType')
            );
            $rules[sprintf('%s.finance_type.0.finance_type', $transactionBase)] = sprintf(
                'in:%s',
                $this->validCodeList('FinanceType')
            );
            $rules[sprintf('%s.aid_type.0.aid_type', $transactionBase)] = sprintf(
                'in:%s',
                $this->validCodeList('AidType')
            );
            $rules[sprintf('%s.tied_status.0.tied_status_code', $transactionBase)] = sprintf(
                'in:%s',
                $this->validCodeList('TiedStatus')
            );
            $tempRules = [
                $this->getTransactionTypeRules(
                    Arr::get($transaction, 'transaction.transaction_type', []),
                    $transactionBase
                ),
                $this->getTransactionDateRules(
                    Arr::get($transaction, 'transaction.transaction_date', []),
                    $transactionBase
                ),
                $this->getValueRules(Arr::get($transaction, 'transaction', 'value', []), $transactionBase),
                $this->getDescriptionRules(Arr::get($transaction, 'transaction', 'description', []), $transactionBase),
                $this->getSectorsRules(Arr::get($transaction, 'transaction.sector', []), $transactionBase),
                $this->getRulesForTransactionProviderOrg(Arr::get(
                    $transaction,
                    'transaction.provider_organization',
                    []
                ), $transactionBase),
                $this->getRulesForTransactionReceiverOrg(Arr::get(
                    $transaction,
                    'transaction.receiver_organization',
                    []
                ), $transactionBase),
            ];

            foreach ($tempRules as $tempRule) {
                foreach ($tempRule as $idx => $rule) {
                    $rules[$idx] = $rule;
                }
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
        $transactions = Arr::get($activity, 'transaction', []);

        foreach ($transactions as $transactionIndex => $transaction) {
            $transactionBase = sprintf('transaction.%s.transaction', $transactionIndex);
            $messages[sprintf('%s.reference.not_in', $transactionBase)] = trans(
                'validation.unique',
                ['attribute' => trans('elementForm.reference')]
            );
            $messages[sprintf('%s.humanitarian.in', $transactionBase)] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.humanitarian_code')]
            );
            $messages[sprintf(
                '%s.recipient_country.0.country_code.in',
                $transactionBase
            )] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.recipient_country_code')]
            );
            $messages[sprintf('%s.recipient_region.0.region_code.in', $transactionBase)] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.recipient_region_code')]
            );
            $messages[sprintf('%s.recipient_region.0.vocabulary.in', $transactionBase)] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.recipient_region_vocabulary')]
            );
            $messages[sprintf('%s.flow_type.0.flow_type.in', $transactionBase)] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.flow_type')]
            );
            $messages[sprintf('%s.finance_type.0.finance_type.in', $transactionBase)] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.finance_type')]
            );
            $messages[sprintf('%s.aid_type.0.aid_type.in', $transactionBase)] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.aid_type')]
            );
            $messages[sprintf('%s.tied_status.0.tied_status_code.in', $transactionBase)] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.tied_status_code')]
            );

            $tempMessages = [
                $this->getTransactionTypeMessages(
                    Arr::get($transaction, 'transaction.transaction_type', []),
                    $transactionBase
                ),
                $this->getTransactionDateMessages(
                    Arr::get($transaction, 'transaction.transaction_date', []),
                    $transactionBase
                ),
                $this->getValueMessages(Arr::get($transaction, 'transaction', 'value', []), $transactionBase),
                $this->getDescriptionMessages(
                    Arr::get($transaction, 'transacton.description', []),
                    $transactionBase
                ),
                $this->getSectorsMessages(Arr::get($transaction, 'transaction.sector', []), $transactionBase),
                $this->getMessagesForTransactionProviderOrg(Arr::get(
                    $transaction,
                    'transaction.provider_organization',
                    []
                ), $transactionBase),
                $this->getMessagesForTransactionReceiverOrg(Arr::get(
                    $transaction,
                    'transaction.receiver_organization',
                    []
                ), $transactionBase),
            ];

            foreach ($tempMessages as $tempMessage) {
                foreach ($tempMessage as $idx => $message) {
                    $messages[$idx] = $message;
                }
            }
        }

        return $messages;
    }

    /**
     * @param $transactions
     * @param $transactionId
     * @return array
     */
    protected function getReferences($transactions, $transactionId): array
    {
        $references = [];

        foreach ($transactions as $transaction) {
            if (Arr::get($transaction, 'id', '') !== $transactionId) {
                $references[] = Arr::get($transaction, 'transaction.reference');
            }
        }

        return $references;
    }

    /**
     * @param array     $providers
     * @param           $transactionBase
     * @return array
     */
    protected function getRulesForTransactionProviderOrg(array $providers, $transactionBase): array
    {
        $rules = [];

        foreach ($providers as $providerOrgIndex => $providerOrg) {
            $providerOrgBase = sprintf('%s.provider_organization.%s', $transactionBase, $providerOrgIndex);
            $tempRules = $this->factory->getRulesForNarrative($providerOrg['narrative'], $providerOrgBase);

            foreach ($tempRules as $idx => $tempRule) {
                $rules[$idx] = $tempRule;
            }
        }

        return $rules;
    }

    /**
     * @param array   $providers
     * @param         $transactionBase
     * @return array
     */
    protected function getMessagesForTransactionProviderOrg(array $providers, $transactionBase): array
    {
        $message = [];

        foreach ($providers as $providerOrgIndex => $providerOrg) {
            $providerOrgBase = sprintf('%s.provider_organization.%s', $transactionBase, $providerOrgIndex);
            $tempMessages = $this->factory->getMessagesForNarrative($providerOrg['narrative'], $providerOrgBase);

            foreach ($tempMessages as $idx => $tempMessage) {
                $message[$idx] = $tempMessage;
            }
        }

        return $message;
    }

    /**
     * @param array $receivers
     * @param       $transactionBase
     *
     * @return array
     */
    protected function getRulesForTransactionReceiverOrg(array $receivers, $transactionBase): array
    {
        $rules = [];

        foreach ($receivers as $receiverOrgIndex => $receiverOrg) {
            $receiverOrgBase = sprintf('%s.receiver_organization.%s', $transactionBase, $receiverOrgIndex);
            $tempRules = $this->factory->getRulesForNarrative($receiverOrg['narrative'], $receiverOrgBase);

            foreach ($tempRules as $idx => $tempRule) {
                $rules[$idx] = $tempRule;
            }
        }

        return $rules;
    }

    /**
     * @param array $receivers
     * @param       $transactionBase
     * @return array
     */
    protected function getMessagesForTransactionReceiverOrg(array $receivers, $transactionBase): array
    {
        $message = [];

        foreach ($receivers as $receiverOrgIndex => $receiverOrg) {
            $receiverOrgBase = sprintf('%s.receiver_organization.%s', $transactionBase, $receiverOrgIndex);
            $tempMessages = $this->factory->getMessagesForNarrative($receiverOrg['narrative'], $receiverOrgBase);

            foreach ($tempMessages as $idx => $tempMessage) {
                $message[$idx] = $tempMessage;
            }
        }

        return $message;
    }

    /**
     * returns rules for sector.
     * @param $sectors
     * @param $transactionBase
     * @return array
     */
    public function getSectorsRules($sectors, $transactionBase): array
    {
        $rules = [];

        foreach ($sectors as $sectorIndex => $sector) {
            $sectorBase = sprintf('%s.sector.%s', $transactionBase, $sectorIndex);
            $rules[sprintf('%s.vocabulary_uri', $sectorBase)] = 'nullable|url';
            $rules[sprintf('%s.vocabulary', $sectorBase)] = sprintf(
                'in:%s',
                $this->validCodeList('SectorVocabulary')
            );
            $rules[sprintf('%s.code', $sectorBase)] = sprintf('in:%s', $this->validCodeList('SectorCode'));
            $rules[sprintf('%s.category_code', $sectorBase)] = sprintf(
                'in:%s',
                $this->validCodeList('SectorCategory')
            );

            if ($sector['sector_vocabulary'] === '1') {
                $rules[sprintf(
                    '%s.code',
                    $sectorBase
                )] = sprintf(
                    'in:%s|required_with:' . $sectorBase . '.sector_vocabulary',
                    $this->validCodeList('SectorCode')
                );
                $rules[sprintf(
                    '%s.sector_vocabulary',
                    $sectorBase
                )] = sprintf(
                    'in:%s|required_with:' . $sectorBase . '.code',
                    $this->validCodeList('SectorVocabulary')
                );
            } elseif ($sector['sector_vocabulary'] === '2') {
                $rules[sprintf(
                    '%s.category_code',
                    $sectorBase
                )] = sprintf(
                    'in:%s|required_with:' . $sectorBase . '.sector_vocabulary',
                    $this->validCodeList('SectorCategory')
                );
                $rules[sprintf(
                    '%s.sector_vocabulary',
                    $sectorBase
                )] = sprintf(
                    'in:%s|required_with:' . $sectorBase . '.category_code',
                    $this->validCodeList('SectorVocabulary')
                );
            } elseif ($sector['sector_vocabulary'] === '98' || $sector['sector_vocabulary'] === '99') {
                $rules[sprintf(
                    '%s.vocabulary_uri',
                    $sectorBase
                )] = 'url|required_with:' . $sectorBase . '.sector_vocabulary';
                foreach (Arr::get($sector, 'narrative', []) as $narrativeKey => $narrative) {
                    $rules[sprintf(
                        '%s.narrative.%s.narrative',
                        $sectorBase,
                        $narrativeKey
                    )] = 'required|required_with_language';
                }
            } elseif ($sector['sector_vocabulary'] !== '') {
                $rules[sprintf('%s.text', $sectorBase)] = 'required_with:' . $sectorBase . '.sector_vocabulary';
                $rules[sprintf(
                    '%s.sector_vocabulary',
                    $sectorBase
                )] = sprintf(
                    'in:%s|required_with:' . $sectorBase . '.text',
                    $this->validCodeList('SectorVocabulary')
                );
            }
        }
        $tempRules = $this->factory->getRulesForTransactionSectorNarrative($sector, $sector['narrative'], $sectorBase);

        foreach ($tempRules as $idx => $tempRule) {
            $rules[$idx] = $tempRule;
        }

        return $rules;
    }

    /**
     * returns messages for sector.
     * @param $sectors
     * @param $transactionBase
     * @return array
     */
    public function getSectorsMessages($sectors, $transactionBase): array
    {
        $messages = [];

        foreach ($sectors as $sectorIndex => $sector) {
            $sectorBase = sprintf('%s.sector.%s', $transactionBase, $sectorIndex);
            $messages[sprintf('%s.vocabulary_uri.url', $sectorBase)] = trans('validation.url');
            $messages[sprintf('%s.vocabulary', $sectorBase)] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.sector_vocabulary')]
            );
            $messages[sprintf('%s.code', $sectorBase)] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.code')]
            );
            $messages[sprintf('%s.category_code', $sectorBase)] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.code')]
            );

            if ($sector['sector_vocabulary'] === '1') {
                $messages[sprintf('%s.code.%s', $sectorBase, 'required_with')] = trans(
                    'validation.required_with',
                    ['attribute' => trans('elementForm.code'), 'values' => trans('sector_vocabulary')]
                );
                $messages[sprintf('%s.sector_vocabulary.%s', $sectorBase, 'required_with')] = trans(
                    'validation.required_with',
                    ['attribute' => trans('elementForm.sector_vocabulary'), 'values' => trans('sector_code')]
                );
            } elseif ($sector['sector_vocabulary'] === '2') {
                $messages[sprintf('%s.category_code.%s', $sectorBase, 'required_with')] = trans(
                    'validation.required_with',
                    ['attribute' => trans('elementForm.code'), 'values' => trans('sector_vocabulary')]
                );
                $messages[sprintf('%s.sector_vocabulary.%s', $sectorBase, 'required_with')] = trans(
                    'validation.required_with',
                    ['attribute' => trans('elementForm.sector_vocabulary'), 'values' => trans('sector_code')]
                );
            } elseif ($sector['sector_vocabulary'] === '98' || $sector['sector_vocabulary'] === '99') {
                $messages[sprintf('%s.vocabulary_uri.%s', $sectorBase, 'required_with')] = trans(
                    'validation.required_with',
                    [
                        'attribute' => trans('elementForm.vocabulary_uri'),
                        'values' => trans('elementForm.sector_vocabulary'),
                    ]
                );
                foreach (Arr::get($sector, 'narrative', []) as $narrativeKey => $narrative) {
                    $messages[sprintf(
                        '%s.narrative.%s.narrative.%s',
                        $sectorBase,
                        $narrativeKey,
                        'required'
                    )] = trans('validation.required', ['attribute' => trans('elementForm.narrative')]);
                    $messages[sprintf(
                        '%s.narrative.%s.narrative.required_with_language',
                        $sectorBase,
                        $narrativeKey
                    )] = trans(
                        'validation.required_with',
                        ['attribute' => trans('elementForm.narrative'), 'values' => trans('elementForm.languages')]
                    );
                }
            } elseif ($sector['sector_vocabulary'] !== '') {
                $messages[sprintf('%s.text.%s', $sectorBase, 'required_with')] = trans(
                    'validation.required_with',
                    ['attribute' => trans('elementForm.code'), 'values' => trans('sector_vocabulary')]
                );
                $messages[sprintf('%s.sector_vocabulary.%s', $sectorBase, 'required_with')] = trans(
                    'validation.required_with',
                    ['attribute' => trans('elementForm.sector_vocabulary'), 'values' => trans('sector_code')]
                );
            }
        }
        $tempMessages = $this->factory->getMessagesForTransactionSectorNarrative($sector, $sector['narrative'], $sectorBase);

        foreach ($tempMessages as $idx => $tempMessage) {
            $messages[$idx] = $tempMessage;
        }

        return $messages;
    }

    /**
     * returns rules for recipient region.
     * @param $recipientRegions
     * @param $transactionBase
     * @return array|mixed
     */
    public function getRecipientRegionRules($recipientRegions, $transactionBase)
    {
        $rules = [];

        foreach ($recipientRegions as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionBase = sprintf('%s.recipient_region.%s', $transactionBase, $recipientRegionIndex);
            $rules[$recipientRegionBase . '.region_code'] = 'required';
            $rules[$recipientRegionBase . '.vocabulary_uri'] = 'nullable|url';
            $tempRules = $this->factory->getRulesForNarrative($recipientRegion['narrative'], $recipientRegionBase);

            foreach ($tempRules as $idx => $tempRule) {
                $rules[$idx] = $tempRule;
            }
        }

        return $rules;
    }

    /**
     * returns messages for recipient region.
     * @param $recipientRegions
     * @param $transactionBase
     * @return array
     */
    public function getRecipientRegionMessages($recipientRegions, $transactionBase): array
    {
        $messages = [];

        foreach ($recipientRegions as $recipientRegionIndex => $recipientRegion) {
            $recipientRegionBase = sprintf('%s.recipient_region.%s', $transactionBase, $recipientRegionIndex);
            $messages[$recipientRegionBase . '.region_code.required'] = trans(
                'validation.required',
                ['attribute' => trans('elementForm.recipient_region_code')]
            );
            $messages[$recipientRegionBase . '.vocabulary_uri.url'] = trans('validation.url');
            $tempMessages = $this->factory->getMessagesForNarrative($recipientRegion['narrative'], $recipientRegionBase);

            foreach ($tempMessages as $idx => $tempMessage) {
                $messages[$idx] = $tempMessage;
            }
        }

        return $messages;
    }

    /**
     * get transaction type rules.
     * @param $types
     * @param $transactionBase
     * @return array
     */
    protected function getTransactionTypeRules($types, $transactionBase): array
    {
        $rules = [];

        foreach ($types as $typeIndex => $type) {
            $typeBase = sprintf('%s.transaction_type.%s', $transactionBase, $typeIndex);
            $rules[sprintf('%s.transaction_type_code', $typeBase)] = sprintf(
                'required|in:%s',
                $this->validCodeList('TransactionType')
            );
        }

        return $rules;
    }

    /**
     * get transaction type error message.
     * @param $types
     * @param $transactionBase
     * @return array
     */
    protected function getTransactionTypeMessages($types, $transactionBase): array
    {
        $messages = [];

        foreach ($types as $typeIndex => $type) {
            $typeBase = sprintf('%s.transaction_type.%s', $transactionBase, $typeIndex);
            $messages[sprintf('%s.transaction_type_code.required', $typeBase)] = trans(
                'validation.required',
                ['attribute' => trans('elementForm.transaction_type')]
            );
            $messages[sprintf('%s.transaction_type_code.in', $typeBase)] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.transaction_type')]
            );
        }

        return $messages;
    }

    /**
     * get transaction date rules.
     * @param $transactionDate
     * @param $transactionBase
     * @return array
     */
    protected function getTransactionDateRules($transactionDate, $transactionBase): array
    {
        $rules = [];

        foreach ($transactionDate as $dateIndex => $date) {
            $dateBase = sprintf('%s.transaction_date.%s', $transactionBase, $dateIndex);
            $rules[sprintf('%s.date', $dateBase)] = 'required';
        }

        return $rules;
    }

    /**
     * get transaction date error message.
     * @param $transactionDate
     * @param $transactionBase
     * @return array
     */
    protected function getTransactionDateMessages($transactionDate, $transactionBase): array
    {
        $messages = [];

        foreach ($transactionDate as $dateIndex => $date) {
            $dateBase = sprintf('%s.transaction_date.%s', $transactionBase, $dateIndex);
            $messages[sprintf('%s.date.required', $dateBase)] = trans(
                'validation.required',
                ['attribute' => trans('elementForm.date')]
            );
        }

        return $messages;
    }

    /**
     * get values rules.
     * @param $transactionValue
     * @param $transactionBase
     * @return array
     */
    protected function getValueRules($transactionValue, $transactionBase): array
    {
        $rules = [];

        foreach ($transactionValue as $valueIndex => $value) {
            $valueBase = sprintf('%s.value.%s', $transactionBase, $valueIndex);
            $rules[sprintf('%s.current', $valueBase)] = sprintf('in:%s', $this->validCodeList('Currency'));
            $rules[sprintf('%s.amount', $valueBase)] = 'required|numeric';
            $rules[sprintf('%s.date', $valueBase)] = 'required';
        }

        return $rules;
    }

    /**
     * get value error message.
     * @param $transactionValue
     * @param $transactionBase
     * @return array
     */
    protected function getValueMessages($transactionValue, $transactionBase): array
    {
        $messages = [];

        foreach ($transactionValue as $valueIndex => $value) {
            $valueBase = sprintf('%s.value.%s', $transactionBase, $valueIndex);
            $messages[sprintf('%s.amount.required', $valueBase)] = trans(
                'validation.required',
                ['attribute' => trans('elementForm.amount')]
            );
            $messages[sprintf('%s.amount.numeric', $valueBase)] = trans(
                'validation.numeric',
                ['attribute' => trans('elementForm.amount')]
            );
            $messages[sprintf('%s.date.required', $valueBase)] = trans(
                'validation.required',
                ['attribute' => trans('elementForm.date')]
            );
        }

        return $messages;
    }

    /**
     * get description rules.
     * @param $descriptions
     * @param $transactionBase
     * @return array
     */
    protected function getDescriptionRules($descriptions, $transactionBase): array
    {
        $rules = [];

        foreach ($descriptions as $descriptionIndex => $description) {
            $narrativeBase = sprintf('%s.description.%s', $transactionBase, $descriptionIndex);
            $tempRules = $this->factory->getRulesForNarrative($description['narrative'], $narrativeBase);

            foreach ($tempRules as $idx => $tempRule) {
                $rules[$idx] = $tempRule;
            }
        }

        return $rules;
    }

    /**
     * get description error message.
     * @param $descriptions
     * @param $transactionBase
     * @return array
     */
    protected function getDescriptionMessages($descriptions, $transactionBase): array
    {
        $messages = [];

        foreach ($descriptions as $descriptionIndex => $description) {
            $narrativeBase = sprintf('%s.description.%s', $transactionBase, $descriptionIndex);
            $tempMessages = $this->factory->getMessagesForNarrative($description['narrative'], $narrativeBase);

            foreach ($tempMessages as $idx => $tempMessage) {
                $messages[$idx] = $tempMessage;
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
        $rules = [];
        $results = Arr::get($activity, 'results', []);

        foreach ($results as $resultIndex => $result) {
            $resultBase = sprintf('results.%s.result', $resultIndex);
            $rules[sprintf('%s.type', $resultBase)] = sprintf(
                'required|in:%s',
                $this->validCodeList('ResultType')
            );

            $tempRules = [
                $this->factory->getRulesForRequiredNarrative(Arr::get($result, 'result.title.0.narrative', []), sprintf('%s.title.0', $resultBase)),
                $this->factory->getRulesForNarrative(Arr::get($result, 'result.description.0.narrative', []), sprintf('%s.description.0', $resultBase)),
                $this->getRulesForIndicator(Arr::get($result, 'result.indicator', []), $resultBase),
            ];

            foreach ($tempRules as $tempRule) {
                foreach ($tempRule as $idx => $rule) {
                    $rules[$idx] = $rule;
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
        $results = Arr::get($activity, 'results', []);

        foreach ($results as $resultIndex => $result) {
            $resultBase = sprintf('results.%s.result', $resultIndex);
            $messages[sprintf('%s.type.required', $resultBase)] = trans(
                'validation.required',
                ['attribute' => trans('elementForm.result_type')]
            );
            $messages[sprintf('%s.type.in', $resultBase)] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.result_type')]
            );
            $tempMessages = [
                $this->factory->getMessagesForRequiredNarrative(Arr::get($result, 'result.title.0.narrative', []), sprintf('%s.title.0', $resultBase)),
                $this->factory->getMessagesForNarrative(Arr::get($result, 'result.description.0.narrative', []), sprintf('%s.description.0', $resultBase)),
                $this->getMessagesForIndicator(Arr::get($result, 'result.indicator', []), $resultBase),
            ];

            foreach ($tempMessages as $tempMessage) {
                foreach ($tempMessage as $idx => $message) {
                    $messages[$idx] = $message;
                }
            }
        }

        return $messages;
    }

    /**
     * returns rules for indicator.
     * @param $indicators
     * @param $resultBase
     * @return array
     */
    protected function getRulesForIndicator($indicators, $resultBase): array
    {
        $rules = [];

        foreach ($indicators as $indicatorIndex => $indicator) {
            $indicatorBase = sprintf('%s.indicator.%s', $resultBase, $indicatorIndex);
            $rules[sprintf('%s.measure', $indicatorBase)] = sprintf(
                'required|in:%s',
                $this->validCodeList('IndicatorMeasure')
            );
            $rules[sprintf('%s.ascending', $indicatorBase)] = 'in:1,0';

            $tempRules = [
                $this->factory->getRulesForResultNarrative($indicator['title'], sprintf('%s.title.0', $indicatorBase)),
                $this->factory->getRulesForNarrative($indicator['description'], sprintf('%s.description.0', $indicatorBase)),
                $this->getRulesForReference($indicator['reference'], $indicatorBase),
                $this->getRulesForBaseline($indicator['baseline'], $indicatorBase),
                $this->getRulesForPeriod($indicator['period'], $indicatorBase),
            ];

            foreach ($tempRules as $tempRule) {
                foreach ($tempRule as $idx => $rule) {
                    $rules[$idx] = $rule;
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
                '%s.indicator.%s',
                $resultBase,
                $indicatorIndex
            );
            $messages[sprintf('%s.measure.required', $indicatorBase)] = trans(
                'validation.required',
                ['attribute' => trans('elementForm.measure')]
            );

            $tempMessages = [

                $this->factory->getMessagesForNarrative($indicator['title'], sprintf('%s.title.0', $indicatorBase)),
                $this->getMessagesForResultNarrative($indicator['title'], sprintf('%s.title.0', $indicatorBase)),
                $this->factory->getMessagesForNarrative(
                    $indicator['description'],
                    sprintf('%s.description.0', $indicatorBase)
                ),
                $this->getMessagesForReference($indicator['reference'], $indicatorBase),
                $this->getMessagesForBaseline($indicator['baseline'], $indicatorBase),
                $this->getMessagesForPeriod($indicator['period'], $indicatorBase),
            ];

            foreach ($tempMessages as $tempMessage) {
                foreach ($tempMessage as $idx => $message) {
                    $messages[$idx] = $message;
                }
            }
        }

        return $messages;
    }

    /**
     * returns rules for reference.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForReference($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $referenceIndex => $reference) {
            $referenceForm = sprintf(
                '%s.reference.%s',
                $formBase,
                $referenceIndex
            );
            $rules[sprintf('%s.indicator_uri', $referenceForm)] = 'nullable|url';
            $rules[sprintf('%s.vocabulary', $referenceForm)] = sprintf(
                'in:%s',
                $this->validCodeList('IndicatorVocabulary')
            );
        }

        return $rules;
    }

    /**
     * returns messages for reference.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForReference($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $referenceIndex => $reference) {
            $referenceForm = sprintf(
                '%s.reference.%s',
                $formBase,
                $referenceIndex
            );
            $messages[sprintf('%s.indicator_uri.url', $referenceForm)] = trans('validation.url');
            $messages[sprintf('%s.vocabulary.in', $referenceForm)] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.indicator_reference_vocabulary')]
            );
        }

        return $messages;
    }

    /**
     * returns rules for baseline.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForBaseline($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $baselineIndex => $baseline) {
            $baselineForm = sprintf('%s.baseline.%s', $formBase, $baselineIndex);
            $rules[$baselineForm] = 'year_value_narrative_validation:' . $baselineForm . '.comment.0.narrative';
            $rules[sprintf('%s.year', $baselineForm)] = sprintf('numeric|required_with:%s.value', $baselineForm);
            $rules[sprintf('%s.value', $baselineForm)] = sprintf('numeric|required_with:%s.year', $baselineForm);
            $tempRules = $this->factory->getRulesForNarrative($baseline['comment'][0]['narrative'], sprintf('%s.comment.0', $baselineForm));

            foreach ($tempRules as $idx => $tempRule) {
                $rules[$idx] = $tempRule;
            }
        }

        return $rules;
    }

    /**
     * returns messages for baseline.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForBaseline($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $baselineIndex => $baseline) {
            $baselineForm = sprintf('%s.baseline.%s', $formBase, $baselineIndex);
            $messages[sprintf('%s.year_value_narrative_validation', $baselineForm)] = trans(
                'validation.year_value_narrative_validation',
                [
                    'year' => trans('elementForm.year'),
                    'value' => trans('elementForm.value'),
                    'narrative' => trans('elementForm.narrative'),
                ]
            );
            $messages[sprintf('%s.year.required_with', $baselineForm)] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.year'), 'values' => trans('elementForm.value')]
            );
            $messages[sprintf('%s.year.numeric', $baselineForm)] = trans(
                'validation.numeric',
                ['attribute' => trans('elementForm.year')]
            );
            $messages[sprintf('%s.value.required_with', $baselineForm)] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.value'), 'values' => trans('elementForm.year')]
            );
            $messages[sprintf('%s.value.numeric', $baselineForm)] = trans(
                'validation.numeric',
                ['attribute' => trans('elementForm.value')]
            );
            $tempMessages = $this->factory->getMessagesForNarrative($baseline['comment'][0]['narrative'], sprintf('%s.comment.0', $baselineForm));

            foreach ($tempMessages as $idx => $tempMessage) {
                $messages[$idx] = $tempMessage;
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
    protected function getRulesForPeriod($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $periodIndex => $period) {
            $periodForm = sprintf('%s.period.%s', $formBase, $periodIndex);
            $tempRules = [
                $this->getRulesForResultPeriodStart($period['period_start'], $periodForm, $period['period_end']),
                $this->getRulesForResultPeriodEnd($period['period_end'], $periodForm, $period['period_start']),
                $this->getRulesForTarget($period['target'], sprintf('%s.target', $periodForm)),
                $this->getRulesForTarget($period['actual'], sprintf('%s.actual', $periodForm)),
            ];

            foreach ($tempRules as $tempRule) {
                foreach ($tempRules as $idx => $rule) {
                    $rules[$idx] = $rule;
                }
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
    protected function getMessagesForPeriod($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $periodIndex => $period) {
            $periodForm = sprintf('%s.period.%s', $formBase, $periodIndex);
            $tempMessages = [
                $this->getMessagesForResultPeriodStart($period['period_start'], $periodForm, $period['period_end']),
                $this->getMessagesForResultPeriodEnd($period['period_end'], $periodForm, $period['period_start']),
                $this->getMessagesForTarget($period['target'], sprintf('%s.target', $periodForm)),
                $this->getMessagesForTarget($period['actual'], sprintf('%s.actual', $periodForm)),
            ];

            foreach ($tempMessages as $tempMessage) {
                foreach ($tempMessage as $idx => $message) {
                    $messages[$idx] = $message;
                }
            }
        }

        return $messages;
    }

    /**
     * returns rules for target.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForTarget($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $targetIndex => $target) {
            $targetForm = sprintf('%s.%s', $formBase, $targetIndex);
            $rules[$targetForm] = 'year_value_narrative_validation';
            $tempRules = $this->factory->getRulesForNarrative($target['comment'][0]['narrative'], sprintf('%s.comment.0', $targetForm));

            foreach ($tempRules as $idx => $tempRule) {
                $rules[$idx] = $tempRule;
            }
        }

        return $rules;
    }

    /**
     * returns messages for target.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForTarget($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $targetIndex => $target) {
            $targetForm = sprintf('%s.%s', $formBase, $targetIndex);
            $messages[sprintf('%s.year_value_narrative_validation', $targetForm)] = trans(
                'validation.year_narrative_validation',
                ['year' => trans('elementForm.value'), 'narrative' => trans('elementForm.narrative')]
            );
            $tempMessages = $this->factory->getMessagesForNarrative($target['comment'][0]['narrative'], sprintf('%s.comment.0', $targetForm));

            foreach ($tempMessages as $idx => $tempMessage) {
                $messages[$idx] = $tempMessage;
            }
        }

        return $messages;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @param $periodEnd
     * @return array
     */
    protected function getRulesForResultPeriodStart($formFields, $formBase, $periodEnd): array
    {
        $rules = [];

        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $periodEndLocation = $formBase . '.period_end.' . $periodStartKey . '.date';
            if ($periodEnd[$periodStartKey]['date'] !== '') {
                $rules[$formBase . '.period_start.' . $periodStartKey . '.date'] = sprintf(
                    'required_with:%s|date',
                    $periodEndLocation
                );
            }
        }

        return $rules;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @param $periodEnd
     * @return array
     */
    protected function getMessagesForResultPeriodStart($formFields, $formBase, $periodEnd)
    {
        $messages = [];
        foreach ($formFields as $periodStartKey => $periodStartVal) {
            if ($periodEnd[$periodStartKey]['date'] !== '') {
                $messages[$formBase . '.period_start.' . $periodStartKey . '.date.required_with'] = trans(
                    'validation.required_with',
                    [
                        'attribute' => trans('elementForm.period_start'),
                        'values' => trans('elementForm.period_end'),
                    ]
                );
            }
            $messages[$formBase . '.period_end.' . $periodStartKey . '.date.date'] = trans(
                'validation.date',
                ['attribute' => trans('elementForm.period_start')]
            );
        }

        return $messages;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @param $periodStart
     * @return array
     */
    protected function getRulesForResultPeriodEnd($formFields, $formBase, $periodStart): array
    {
        $rules = [];

        foreach ($formFields as $periodEndKey => $periodEndVal) {
            $periodStartLocation = $formBase . '.period_start.' . $periodEndKey . '.date';
            if ($periodStart[$periodEndKey]['date'] !== '') {
                $rules[$formBase . '.period_end.' . $periodEndKey . '.date'] = sprintf(
                    'required_with:%s|date|after:%s',
                    $periodStartLocation,
                    $formBase . '.period_start.' . $periodEndKey . '.date'
                );
            }
        }

        return $rules;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @param $periodStart
     * @return array
     */
    protected function getMessagesForResultPeriodEnd($formFields, $formBase, $periodStart): array
    {
        $messages = [];

        foreach ($formFields as $periodEndKey => $periodEndVal) {
            if ($periodStart[$periodEndKey]['date'] !== '') {
                $messages[$formBase . '.period_end.' . $periodEndKey . '.date.required_with'] = trans(
                    'validation.required_with',
                    ['attribute' => trans('elementForm.period_end'), 'values' => trans('elementForm.period_start')]
                );
            }
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.date'] = trans(
                'validation.date',
                ['attribute' => trans('elementForm.period_end')]
            );
            $messages[$formBase . '.period_end.' . $periodEndKey . '.date.after'] = trans(
                'validation.after',
                ['attribute' => trans('elementForm.period_end'), 'date' => trans('elementForm.period_start')]
            );
        }

        return $messages;
    }

    /**
     * returns the message for indicator title.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForResultNarrative($formFields, $formBase): array
    {
        $messages = [];
        $messages[sprintf('%s.narrative.unique_lang', $formBase)] = trans(
            'validation.unique',
            ['attribute' => trans('elementForm.languages')]
        );

        foreach ($formFields as $narrativeIndex => $narrative) {
            $messages[sprintf(
                '%s.narrative.%s.narrative.required',
                $formBase,
                $narrativeIndex
            )] = trans('validation.required', ['attribute' => trans('elementForm.indicator_vocabulary')]);
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
