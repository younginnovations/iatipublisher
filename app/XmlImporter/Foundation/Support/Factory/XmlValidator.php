<?php

declare(strict_types=1);

namespace App\XmlImporter\Foundation\Support\Factory;

use App\XmlImporter\Foundation\Support\Factory\Traits\CriticalValidationRules;
use App\XmlImporter\Foundation\Support\Factory\Traits\ValidationMessages;
use App\XmlImporter\Foundation\Support\Factory\Traits\ValidationRules;

/**
 * Class XmlValidator.
 */
class XmlValidator
{
    use CriticalValidationRules;
    use ValidationRules;
    use ValidationMessages;

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
            $this->rulesForTitle($activity),
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
     * @return array
     */
    public function criticalRules(): array
    {
        $activity = $this->activity;
        $rules = [];

        $tempRules = [
            $this->criticalRulesForActivityStatus($activity),
            $this->criticalRulesForActivityScope($activity),
            $this->criticalRulesForCollaborationType($activity),
            $this->criticalRulesForDefaultFlowType($activity),
            $this->criticalRulesForDefaultFinanceType($activity),
            $this->criticalRulesForDefaultTiedStatus($activity),
            $this->criticalRulesForCapitalSpend($activity),
            $this->criticalRulesForTitle($activity),
            $this->criticalRulesForDescription($activity),
            $this->criticalRulesForOtherIdentifier($activity),
            $this->criticalRulesForActivityDate($activity),
            $this->criticalRulesForDefaultAidType($activity),
            $this->criticalRulesForContactInfo($activity),
            $this->criticalRulesForParticipatingOrg($activity),
            $this->criticalRulesForRecipientCountry($activity),
            $this->criticalRulesForRecipientRegion($activity),
            $this->criticalRulesForLocation($activity),
            $this->criticalRulesForSector($activity),
            $this->criticalRulesForTag($activity),
            $this->criticalRulesForCountryBudgetItem($activity),
            $this->criticalRulesForHumanitarianScope($activity),
            $this->criticalRulesForPolicyMarker($activity),
            $this->criticalRulesForBudget($activity),
            $this->criticalRulesForPlannedDisbursement($activity),
            $this->criticalRulesForDocumentLink($activity),
            $this->criticalRulesForRelatedActivity($activity),
            $this->criticalRulesForLegacyData($activity),
            $this->criticalRulesForCondition($activity),
            $this->criticalRulesForTransaction($activity),
            $this->criticalRulesForResult($activity),
            $this->criticalRulesForReportingOrganization($activity),
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
            $this->messagesForTitle($activity),
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
     * @param bool $isDuplicate
     * @param bool $duplicateTransaction
     * @param bool $isIdentifierValid
     *
     * @return array
     */
    public function validateActivity(bool $isDuplicate, bool $duplicateTransaction, bool $isIdentifierValid): array
    {
        $errors = [
            'warning' => $this->factory->initialize($this->activity, $this->rules(), $this->messages())
                ->passes()
                ->withErrors(),
            'critical' => $this->factory->initialize($this->activity, $this->criticalRules(), $this->messages())
                ->passes()
                ->withErrors(),
        ];

        if ($isDuplicate) {
            $errors['critical']['activity_identifier']['activity_identifier.identifier'] = 'The activity has been duplicated.';
        }

        if ($duplicateTransaction) {
            $errors['critical']['transactions']['transaction.reference'] = 'The activity contains duplicate transactions.';
        }

        if (!$isIdentifierValid) {
            $errors['critical']['activity_identifier']['activity_identifier.activity_identifier'] = 'The activity is invalid. Please ensure that the activity identifier matches with organization identifier.';
        }

        return $errors;
    }

    /**
     * Create base rule for multilevel elements.
     *
     * @param $baseRules
     * @param $element
     * @param $data
     * @param $indexRequired
     *
     * @return array
     */
    public function getBaseRules($baseRules, $element, $data, $indexRequired = true): array
    {
        $rules = [];

        if (!empty($data)) {
            foreach ($data as $idx => $value) {
                foreach ($baseRules as $elementName => $baseRule) {
                    $fieldName = $indexRequired ? $element . '.' . $idx . '.' . $elementName : $element . '.' . $elementName;
                    $rules[$fieldName] = $baseRule;
                }
            }
        }

        return $rules;
    }

    /**
     * Create base messages for multilevel elements.
     *
     * @param $baseRules
     * @param $element
     * @param $data
     * @param $indexRequired
     *
     * @return array
     */
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
}
