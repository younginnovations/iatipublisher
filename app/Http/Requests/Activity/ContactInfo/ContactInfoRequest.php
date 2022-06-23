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
    public function rules()
    {
        return $this->getRulesForContactInfo($this->get('contact_info'));
    }

    /**
     * @return array
     */
    public function messages()
    {
        return $this->getMessagesForContactInfo($this->get('contact_info'));
    }

    /**
     * @param array $formFields
     * @return array
     */
    protected function getRulesForContactInfo(array $formFields)
    {
        $rules = [];

        foreach ($formFields as $contactInfoIndex => $contactInfo) {
            $contactInfoForm = sprintf('contact_info.%s', $contactInfoIndex);
            $rules = array_merge(
                $rules,
                $this->getRulesForDepartment($contactInfo['department'], $contactInfoForm),
                $this->getRulesForOrganisation($contactInfo['organisation'], $contactInfoForm),
                $this->getRulesForPersonName($contactInfo['person_name'], $contactInfoForm),
                $this->getRulesForJobTitle($contactInfo['job_title'], $contactInfoForm),
                $this->getRulesForMailingAddress($contactInfo['mailing_address'], $contactInfoForm),
                $this->getRulesForTelephone($contactInfo['telephone'], $contactInfoForm),
                $this->getRulesForEmail($contactInfo['email'], $contactInfoForm),
                $this->getRulesForWebsite($contactInfo['website'], $contactInfoForm)
            );
        }

        return $rules;
    }

    /**
     * @param array $formFields
     * @return array
     */
    protected function getMessagesForContactInfo(array $formFields)
    {
        $messages = [];

        foreach ($formFields as $contactInfoIndex => $contactInfo) {
            $contactInfoForm = sprintf('contact_info.%s', $contactInfoIndex);
            $messages = array_merge(
                $messages,
                $this->getMessagesForDepartment($contactInfo['department'], $contactInfoForm),
                $this->getMessagesForOrganisation($contactInfo['organisation'], $contactInfoForm),
                $this->getMessagesForPersonName($contactInfo['person_name'], $contactInfoForm),
                $this->getMessagesForJobTitle($contactInfo['job_title'], $contactInfoForm),
                $this->getMessagesForMailingAddress($contactInfo['mailing_address'], $contactInfoForm),
                $this->getMessagesForTelephone($contactInfo['telephone'], $contactInfoForm),
                $this->getMessagesForEmail($contactInfo['email'], $contactInfoForm),
                $this->getMessagesForWebsite($contactInfo['website'], $contactInfoForm)
            );
        }

        return $messages;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForOrganisation($formFields, $formBase)
    {
        $rules = [];

        foreach ($formFields as $organisationIndex => $organisation) {
            $organisationForm = sprintf('%s.organisation.%s', $formBase, $organisationIndex);
            $rules = array_merge($rules, $this->getRulesForNarrative($organisation['narrative'], $organisationForm));
        }

        return $rules;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForOrganisation($formFields, $formBase)
    {
        $messages = [];

        foreach ($formFields as $organisationIndex => $organisation) {
            $organisationForm = sprintf('%s.organisation.%s', $formBase, $organisationIndex);
            $messages = array_merge($messages, $this->getMessagesForNarrative($organisation['narrative'], $organisationForm));
        }

        return $messages;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForDepartment($formFields, $formBase)
    {
        $rules = [];

        foreach ($formFields as $departmentIndex => $department) {
            $departmentForm = sprintf('%s.department.%s', $formBase, $departmentIndex);
            $rules = array_merge($rules, $this->getRulesForNarrative($department['narrative'], $departmentForm));
        }

        return $rules;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForDepartment($formFields, $formBase)
    {
        $messages = [];

        foreach ($formFields as $departmentIndex => $department) {
            $departmentForm = sprintf('%s.department.%s', $formBase, $departmentIndex);
            $messages = array_merge($messages, $this->getMessagesForNarrative($department['narrative'], $departmentForm));
        }

        return $messages;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForPersonName($formFields, $formBase)
    {
        $rules = [];

        foreach ($formFields as $personNameIndex => $personName) {
            $personNameForm = sprintf('%s.person_name.%s', $formBase, $personNameIndex);
            $rules = array_merge($rules, $this->getRulesForNarrative($personName['narrative'], $personNameForm));
        }

        return $rules;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForPersonName($formFields, $formBase)
    {
        $messages = [];

        foreach ($formFields as $personNameIndex => $personName) {
            $personNameForm = sprintf('%s.person_name.%s', $formBase, $personNameIndex);
            $messages = array_merge($messages, $this->getMessagesForNarrative($personName['narrative'], $personNameForm));
        }

        return $messages;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForJobTitle($formFields, $formBase)
    {
        $rules = [];

        foreach ($formFields as $jobTitleIndex => $jobTitle) {
            $jobTitleForm = sprintf('%s.job_title.%s', $formBase, $jobTitleIndex);
            $rules = array_merge($rules, $this->getRulesForNarrative($jobTitle['narrative'], $jobTitleForm));
        }

        return $rules;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForJobTitle($formFields, $formBase)
    {
        $messages = [];

        foreach ($formFields as $jobTitleIndex => $jobTitle) {
            $jobTitleForm = sprintf('%s.job_title.%s', $formBase, $jobTitleIndex);
            $messages = array_merge($messages, $this->getMessagesForNarrative($jobTitle['narrative'], $jobTitleForm));
        }

        return $messages;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForMailingAddress($formFields, $formBase)
    {
        $rules = [];

        foreach ($formFields as $mailingAddressIndex => $mailingAddress) {
            $mailingAddressForm = sprintf('%s.mailing_address.%s', $formBase, $mailingAddressIndex);
            $rules = array_merge($rules, $this->getRulesForNarrative($mailingAddress['narrative'], $mailingAddressForm));
        }

        return $rules;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForMailingAddress($formFields, $formBase)
    {
        $messages = [];

        foreach ($formFields as $mailingAddressIndex => $mailingAddress) {
            $mailingAddressForm = sprintf('%s.mailing_address.%s', $formBase, $mailingAddressIndex);
            $messages = array_merge($messages, $this->getMessagesForNarrative($mailingAddress['narrative'], $mailingAddressForm));
        }

        return $messages;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForTelephone($formFields, $formBase)
    {
        $rules = [];

        foreach ($formFields as $telephoneIndex => $telephone) {
            $rules[sprintf('%s.telephone.%s.telephone', $formBase, $telephoneIndex)] = 'numeric';
        }

        return $rules;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForTelephone($formFields, $formBase)
    {
        $messages = [];

        foreach ($formFields as $telephoneIndex => $telephone) {
            $messages[sprintf('%s.telephone.%s.telephone.numeric', $formBase, $telephoneIndex)] = trans(
                'validation.number',
                ['attribute' => trans('elementForm.telephone')]
            );
        }

        return $messages;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForEmail($formFields, $formBase)
    {
        $rules = [];

        foreach ($formFields as $emailIndex => $email) {
            $rules[sprintf('%s.email.%s.email', $formBase, $emailIndex)] = 'email';
        }

        return $rules;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForEmail($formFields, $formBase)
    {
        $messages = [];

        foreach ($formFields as $emailIndex => $email) {
            $messages[sprintf('%s.email.%s.email.email', $formBase, $emailIndex)] = trans(
                'validation.email',
                ['attribute' => trans('elementForm.email')]
            );
        }

        return $messages;
    }

    /**
     * rule for website.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForWebsite($formFields, $formBase)
    {
        $rules = [];

        foreach ($formFields as $websiteIndex => $website) {
            $rules[sprintf('%s.website.%s.website', $formBase, $websiteIndex)] = 'nullable|url';
        }

        return $rules;
    }

    /**
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForWebsite($formFields, $formBase)
    {
        $messages = [];

        foreach ($formFields as $websiteIndex => $website) {
            $messages[sprintf('%s.website.%s.website.url', $formBase, $websiteIndex)] = trans(
                'validation.url'
            );
        }

        return $messages;
    }
}
