<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\ContactInfo\ContactInfoRequest;

/**
 * Class ContactInfo.
 */
class ContactInfo extends Element
{
    /**
     * Csv Header for ContactInfo element.
     * @var array
     */
    private array $_csvHeaders = [
        'contact_type',
        'contact_organization',
        'contact_department',
        'contact_person_name',
        'contact_job_title',
        'contact_telephone',
        'contact_email',
        'contact_website',
        'contact_mailing_address',
    ];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'contact_info';
    private ContactInfoRequest $request;

    /**
     * ContactInfo constructor.
     *
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->request = new ContactInfoRequest();
    }

    /**
     * Prepare ContactInfo element.
     *
     * @param $fields
     *
     * @return void
     */
    public function prepare($fields): void
    {
        foreach ($fields as $key => $values) {
            if (!is_null($values) && array_key_exists($key, array_flip($this->_csvHeaders))) {
                foreach ($values as $index => $value) {
                    $this->map($key, $index, $value);
                }
            }
        }
    }

    /**
     * Map data from CSV file into ContactInfo data format.
     *
     * @param $key
     * @param $index
     * @param $value
     *
     * @return void
     */
    public function map($key, $index, $value): void
    {
        if (!(is_null($value) || $value === '')) {
            $this->setContactType($key, $value, $index);
            $this->setContactOrganization($key, $value, $index);
            $this->setContactDepartment($key, $value, $index);
            $this->setContactPersonName($key, $value, $index);
            $this->setContactJobTitle($key, $value, $index);
            $this->setContactTelephone($key, $value, $index);
            $this->setContactEmail($key, $value, $index);
            $this->setContactWebsite($key, $value, $index);
            $this->setContactMailingAddress($key, $value, $index);
        }
    }

    /**
     * Maps ContactInfo Identifiers.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setContactType($key, $value, $index): void
    {
        if (!isset($this->data['contact_info'][$index]['type'])) {
            $this->data['contact_info'][$index]['type'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $relatedActivityType = $this->loadCodeList('ContactType');

            if ($value) {
                foreach ($relatedActivityType as $code => $name) {
                    if (strcasecmp(trim($value), (string) $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['contact_info'][$index]['type'] = $value;
        }
    }

    /**
     * Maps ContactInfo Type.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setContactOrganization($key, $value, $index): void
    {
        if (!isset($this->data['contact_info'][$index]['organisation'][0]['narrative'][0]['narrative'])) {
            $this->data['contact_info'][$index]['organisation'][0]['narrative'][0]['narrative'] = '';
        }

        $this->data['contact_info'][$index]['organisation'][0]['narrative'][0]['language'] = '';

        if ($key === $this->_csvHeaders[1]) {
            $this->data['contact_info'][$index]['organisation'][0]['narrative'][0]['narrative'] = $value;
        }
    }

    /**
     * Maps Contact Department.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setContactDepartment($key, $value, $index): void
    {
        if (!isset($this->data['contact_info'][$index]['department'][0]['narrative'][0]['narrative'])) {
            $this->data['contact_info'][$index]['department'][0]['narrative'][0]['narrative'] = '';
        }

        $this->data['contact_info'][$index]['department'][0]['narrative'][0]['language'] = '';

        if ($key === $this->_csvHeaders[2]) {
            $this->data['contact_info'][$index]['department'][0]['narrative'][0]['narrative'] = $value;
        }
    }

    /**
     * Maps Contact Person's Name.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setContactPersonName($key, $value, $index): void
    {
        if (!isset($this->data['contact_info'][$index]['person_name'][0]['narrative'][0]['narrative'])) {
            $this->data['contact_info'][$index]['person_name'][0]['narrative'][0]['narrative'] = '';
        }

        $this->data['contact_info'][$index]['person_name'][0]['narrative'][0]['language'] = '';

        if ($key === $this->_csvHeaders[3]) {
            $this->data['contact_info'][$index]['person_name'][0]['narrative'][0]['narrative'] = $value;
        }
    }

    /**
     * Define Contact Job Title.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setContactJobTitle($key, $value, $index): void
    {
        if (!isset($this->data['contact_info'][$index]['job_title'][0]['narrative'][0]['narrative'])) {
            $this->data['contact_info'][$index]['job_title'][0]['narrative'][0]['narrative'] = '';
        }

        $this->data['contact_info'][$index]['job_title'][0]['narrative'][0]['language'] = '';

        if ($key === $this->_csvHeaders[4]) {
            $this->data['contact_info'][$index]['job_title'][0]['narrative'][0]['narrative'] = $value;
        }
    }

    /**
     * Maps Contact Telephone.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setContactTelephone($key, $value, $index): void
    {
        if (!isset($this->data['contact_info'][$index]['telephone'][0]['telephone'])) {
            $this->data['contact_info'][$index]['telephone'][0]['telephone'] = '';
        }

        if ($key === $this->_csvHeaders[5]) {
            $this->data['contact_info'][$index]['telephone'][0]['telephone'] = $value;
        }
    }

    /**
     * Maps Contact Email.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setContactEmail($key, $value, $index): void
    {
        if (!isset($this->data['contact_info'][$index]['email'][0]['email'])) {
            $this->data['contact_info'][$index]['email'][0]['email'] = '';
        }

        if ($key === $this->_csvHeaders[6]) {
            $this->data['contact_info'][$index]['email'][0]['email'] = $value;
        }
    }

    /**
     * Maps Contact Website.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setContactWebsite($key, $value, $index): void
    {
        if (!isset($this->data['contact_info'][$index]['website'][0]['website'])) {
            $this->data['contact_info'][$index]['website'][0]['website'] = '';
        }

        if ($key === $this->_csvHeaders[7]) {
            $this->data['contact_info'][$index]['website'][0]['website'] = $value;
        }
    }

    /**
     * Maps Contact Mailing Address.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setContactMailingAddress($key, $value, $index): void
    {
        if (!isset($this->data['contact_info'][$index]['mailing_address'][0]['narrative'][0]['narrative'])) {
            $this->data['contact_info'][$index]['mailing_address'][0]['narrative'][0]['narrative'] = '';
        }

        $this->data['contact_info'][$index]['mailing_address'][0]['narrative'][0]['language'] = '';

        if ($key === $this->_csvHeaders[8]) {
            $this->data['contact_info'][$index]['mailing_address'][0]['narrative'][0]['narrative'] = $value;
        }
    }

    /**
     * Provides ContactType Code.
     *
     * @return string
     * @throws \JsonException
     */
    protected function contactTypeCode(): string
    {
        return implode(',', array_keys($this->loadCodeList('ContactType')));
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function rules(): array
    {
        return $this->getBaseRules($this->request->rules());

//        $rules = [];
//
//        $rules['contact_info.*.type'] = sprintf('in:%s', $this->contactTypeCode());
//        $rules['contact_info.*.email.0.email'] = 'email';
//        $rules['contact_info.*.website.0.website'] = 'nullable|url';
//
//        return $rules;
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->getBaseMessages($this->request->messages());

//        $messages = [];
//
//        $messages['contact_info.*.type.in'] = trans('validation.code_list', ['attribute' => trans('contact info element contact_type')]);
//        $messages['contact_info.*.email.0.email.email'] = trans('validation.email', ['attribute' => trans('contact info element email')]);
//        $messages['contact_info.*.website.0.website.url'] = trans('validation.url', ['attribute' => trans('contact info element website')]);
//
//        return $messages;
    }

    /**
     * Validate data for IATI Element.
     *
     * @return $this
     * @throws \JsonException
     */
    public function validate(): static
    {
        $this->validator = $this->factory->sign($this->data())
            ->with($this->rules(), $this->messages())
            ->getValidatorInstance();
        $this->setValidity();

        return $this;
    }
}
