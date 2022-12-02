<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\ContactInfo;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class ContactInfoRequest.
 */
class ContactInfoRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRulesForContactInfo($this->get('contact_info'));
    }

    /**
     * Get validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getMessagesForContactInfo($this->get('contact_info'));
    }

    /**
     * Returns rules for contact info.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getRulesForContactInfo(array $formFields): array
    {
        $rules = [];

        foreach ($formFields as $contactInfoIndex => $contactInfo) {
            $contactInfoForm = sprintf('contact_info.%s', $contactInfoIndex);
            $rules[sprintf('%s.type', $contactInfoForm)] = 'nullable|in:' . implode(',', array_keys(getCodeList('ContactType', 'Activity', false)));
            $tempRules = [
                $this->getRulesForDepartment($contactInfo['department'], $contactInfoForm),
                $this->getRulesForOrganisation($contactInfo['organisation'], $contactInfoForm),
                $this->getRulesForPersonName($contactInfo['person_name'], $contactInfoForm),
                $this->getRulesForJobTitle($contactInfo['job_title'], $contactInfoForm),
                $this->getRulesForMailingAddress($contactInfo['mailing_address'], $contactInfoForm),
                $this->getRulesForTelephone($contactInfo['telephone'], $contactInfoForm),
                $this->getRulesForEmail($contactInfo['email'], $contactInfoForm),
                $this->getRulesForWebsite($contactInfo['website'], $contactInfoForm),
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
     * Returns messages for contact info.
     *
     * @param array $formFields
     *
     * @return array
     */
    public function getMessagesForContactInfo(array $formFields): array
    {
        $messages = [];

        foreach ($formFields as $contactInfoIndex => $contactInfo) {
            $contactInfoForm = sprintf('contact_info.%s', $contactInfoIndex);
            $messages[sprintf('%s.type.in', $contactInfoForm)] = 'The contact info type is invalid.';
            $tempMessages = [
                $this->getMessagesForDepartment($contactInfo['department'], $contactInfoForm),
                $this->getMessagesForOrganisation($contactInfo['organisation'], $contactInfoForm),
                $this->getMessagesForPersonName($contactInfo['person_name'], $contactInfoForm),
                $this->getMessagesForJobTitle($contactInfo['job_title'], $contactInfoForm),
                $this->getMessagesForMailingAddress($contactInfo['mailing_address'], $contactInfoForm),
                $this->getMessagesForTelephone($contactInfo['telephone'], $contactInfoForm),
                $this->getMessagesForEmail($contactInfo['email'], $contactInfoForm),
                $this->getMessagesForWebsite($contactInfo['website'], $contactInfoForm),
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
     * Returns rules for organisation.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getRulesForOrganisation($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $organisationIndex => $organisation) {
            $organisationForm = sprintf('%s.organisation.%s', $formBase, $organisationIndex);

            foreach ($this->getRulesForNarrative($organisation['narrative'], $organisationForm) as $organisationNarrativeIndex => $organisationNarrativeRules) {
                $rules[$organisationNarrativeIndex] = $organisationNarrativeRules;
            }
        }

        return $rules;
    }

    /**
     * Returns messages for organisation.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getMessagesForOrganisation($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $organisationIndex => $organisation) {
            $organisationForm = sprintf('%s.organisation.%s', $formBase, $organisationIndex);

            foreach ($this->getMessagesForNarrative($organisation['narrative'], $organisationForm) as $organisationNarrativeIndex => $organisationNarrativeMessages) {
                $messages[$organisationNarrativeIndex] = $organisationNarrativeMessages;
            }
        }

        return $messages;
    }

    /**
     * Returns rules for department.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getRulesForDepartment($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $departmentIndex => $department) {
            $departmentForm = sprintf('%s.department.%s', $formBase, $departmentIndex);

            foreach ($this->getRulesForNarrative($department['narrative'], $departmentForm) as $departmentNarrativeIndex => $departmentNarrativeRules) {
                $rules[$departmentNarrativeIndex] = $departmentNarrativeRules;
            }
        }

        return $rules;
    }

    /**
     * Returns messagess for department.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getMessagesForDepartment($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $departmentIndex => $department) {
            $departmentForm = sprintf('%s.department.%s', $formBase, $departmentIndex);

            foreach ($this->getMessagesForNarrative($department['narrative'], $departmentForm) as $departmentNarrativeIndex => $departmentNarrativeMessages) {
                $messages[$departmentNarrativeIndex] = $departmentNarrativeMessages;
            }
        }

        return $messages;
    }

    /**
     * Returns rules for person name.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getRulesForPersonName($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $personNameIndex => $personName) {
            $personNameForm = sprintf('%s.person_name.%s', $formBase, $personNameIndex);

            foreach ($this->getRulesForNarrative($personName['narrative'], $personNameForm) as $personNameNarrativeIndex => $personNameNarrativeRules) {
                $rules[$personNameNarrativeIndex] = $personNameNarrativeRules;
            }
        }

        return $rules;
    }

    /**
     * Returns messaged for person name.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getMessagesForPersonName($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $personNameIndex => $personName) {
            $personNameForm = sprintf('%s.person_name.%s', $formBase, $personNameIndex);

            foreach ($this->getMessagesForNarrative($personName['narrative'], $personNameForm) as $personNameNarrativeIndex => $personNameNarrativeMessages) {
                $messages[$personNameNarrativeIndex] = $personNameNarrativeMessages;
            }
        }

        return $messages;
    }

    /**
     * Returns rules for job title.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getRulesForJobTitle($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $jobTitleIndex => $jobTitle) {
            $jobTitleForm = sprintf('%s.job_title.%s', $formBase, $jobTitleIndex);

            foreach ($this->getRulesForNarrative($jobTitle['narrative'], $jobTitleForm) as $jobTitleNarrativeIndex => $jobTitleNarrativeRules) {
                $rules[$jobTitleNarrativeIndex] = $jobTitleNarrativeRules;
            }
        }

        return $rules;
    }

    /**
     * Returns messages for job title.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getMessagesForJobTitle($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $jobTitleIndex => $jobTitle) {
            $jobTitleForm = sprintf('%s.job_title.%s', $formBase, $jobTitleIndex);

            foreach ($this->getMessagesForNarrative($jobTitle['narrative'], $jobTitleForm) as $jobTitleNarrativeIndex => $jobTitleNarrativeMessages) {
                $messages[$jobTitleNarrativeIndex] = $jobTitleNarrativeMessages;
            }
        }

        return $messages;
    }

    /**
     * Returns rules for mailing address.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getRulesForMailingAddress($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $mailingAddressIndex => $mailingAddress) {
            $mailingAddressForm = sprintf('%s.mailing_address.%s', $formBase, $mailingAddressIndex);

            foreach ($this->getRulesForNarrative($mailingAddress['narrative'], $mailingAddressForm) as $mailingAddressNarrativeIndex => $mailingAddressNarrativeRules) {
                $rules[$mailingAddressNarrativeIndex] = $mailingAddressNarrativeRules;
            }
        }

        return $rules;
    }

    /**
     * Returns messages for mailing address.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getMessagesForMailingAddress($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $mailingAddressIndex => $mailingAddress) {
            $mailingAddressForm = sprintf('%s.mailing_address.%s', $formBase, $mailingAddressIndex);

            foreach ($this->getMessagesForNarrative($mailingAddress['narrative'], $mailingAddressForm) as $mailingAddressNarrativeIndex => $mailingAddressNarrativeMessages) {
                $messages[$mailingAddressNarrativeIndex] = $mailingAddressNarrativeMessages;
            }
        }

        return $messages;
    }

    /**
     * Returns rules for telephone.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getRulesForTelephone($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $telephoneIndex => $telephone) {
            $rules[sprintf('%s.telephone.%s.telephone', $formBase, $telephoneIndex)] = ['nullable', 'regex:/^[0-9*#+-]+$/', 'min:7', 'max:20'];
        }

        return $rules;
    }

    /**
     * Returns messages for telephone.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getMessagesForTelephone($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $telephoneIndex => $telephone) {
            $messages[sprintf('%s.telephone.%s.telephone.numeric', $formBase, $telephoneIndex)] = 'The contact info telephone number must be valid numeric value';
            $messages[sprintf('%s.telephone.%s.telephone.regex', $formBase, $telephoneIndex)] = 'The contact info telephone number is invalid';
            $messages[sprintf('%s.telephone.%s.telephone.min', $formBase, $telephoneIndex)] = 'The contact info telephone number must have atleast 7 digits.';
            $messages[sprintf('%s.telephone.%s.telephone.max', $formBase, $telephoneIndex)] = 'The contact info telephone number must not have more than 20 digits.';
        }

        return $messages;
    }

    /**
     * Returns rules for email.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getRulesForEmail($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $emailIndex => $email) {
            $rules[sprintf('%s.email.%s.email', $formBase, $emailIndex)] = ['nullable', ' email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'];
        }

        return $rules;
    }

    /**
     * Returns messages for email.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getMessagesForEmail($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $emailIndex => $email) {
            $messages[sprintf('%s.email.%s.email.email', $formBase, $emailIndex)] = 'The contact info email must be valid';
            $messages[sprintf('%s.email.%s.email.regex', $formBase, $emailIndex)] = 'The contact info email format is invalid';
        }

        return $messages;
    }

    /**
     * rule for website.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getRulesForWebsite($formFields, $formBase): array
    {
        $rules = [];

        foreach ($formFields as $websiteIndex => $website) {
            $rules[sprintf('%s.website.%s.website', $formBase, $websiteIndex)] = 'nullable|url';
        }

        return $rules;
    }

    /**
     * returns messages for website.
     *
     * @param $formFields
     * @param $formBase
     *
     * @return array
     */
    protected function getMessagesForWebsite($formFields, $formBase): array
    {
        $messages = [];

        foreach ($formFields as $websiteIndex => $website) {
            $messages[sprintf('%s.website.%s.website.url', $formBase, $websiteIndex)] = 'The contact info website url must be valid url.';
        }

        return $messages;
    }
}
