<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Location;

use App\Http\Requests\Activity\ActivityBaseRequest;

/**
 * Class LocationRequest.
 */
class LocationRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getRulesForLocation($this->get('location'));
    }

    /**
     * prepare the error message.
     * @return array
     */
    public function messages()
    {
        return $this->getMessagesForLocation($this->get('location'));
    }

    /**
     * returns rules for location form.
     * @param $formFields
     * @return array
     */
    protected function getRulesForLocation($formFields)
    {
        $rules = [];
        foreach ($formFields as $locationIndex => $location) {
            $locationForm = 'location.' . $locationIndex;
            $rules = array_merge(
                $rules,
                $this->getRulesForLocationId($location['location_id'], $locationForm),
                $this->getRulesForName($location['name'], $locationForm),
                $this->getRulesForLocationDescription($location['description'], $locationForm),
                $this->getRulesForActivityDescription($location['activity_description'], $locationForm),
                $this->getRulesForAdministrative($location['administrative'], $locationForm),
                $this->getRulesForPoint($location['point'], $locationForm)
            );
        }

        return $rules;
    }

    /**
     * returns messages for location form.
     * @param $formFields
     * @return array
     */
    protected function getMessagesForLocation($formFields)
    {
        $messages = [];
        foreach ($formFields as $locationIndex => $location) {
            $locationForm = 'location.' . $locationIndex;
            $messages = array_merge(
                $messages,
                $this->getMessagesForLocationId($location['location_id'], $locationForm),
                $this->getMessagesForName($location['name'], $locationForm),
                $this->getMessagesForLocationDescription($location['description'], $locationForm),
                $this->getMessagesForActivityDescription($location['activity_description'], $locationForm),
                $this->getMessagesForAdministrative($location['administrative'], $locationForm),
                $this->getMessagesForPoint($location['point'], $locationForm)
            );
        }

        return $messages;
    }

    /**
     * returns rules for location id.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForLocationId($formFields, $formBase)
    {
        $rules = [];
        foreach ($formFields as $locationIdIndex => $locationId) {
            $locationIdForm = sprintf('%s.location_id.%s', $formBase, $locationIdIndex);
        }

        return $rules;
    }

    /**
     * returns messages for location id.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForLocationId($formFields, $formBase)
    {
        $messages = [];

        foreach ($formFields as $locationIdIndex => $locationId) {
            $locationIdForm = sprintf('%s.location_id.%s', $formBase, $locationIdIndex);
        }

        return $messages;
    }

    /**
     * returns rules for name.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForName($formFields, $formBase)
    {
        $rules = [];
        foreach ($formFields as $nameIndex => $name) {
            $narrativeForm = sprintf('%s.name.%s', $formBase, $nameIndex);
            $rules = array_merge($rules, $this->getRulesForRequiredNarrative($name['narrative'], $narrativeForm));
        }

        return $rules;
    }

    /**
     * returns messages for name.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForName($formFields, $formBase)
    {
        $messages = [];
        foreach ($formFields as $nameIndex => $name) {
            $narrativeForm = sprintf('%s.name.%s', $formBase, $nameIndex);
            $messages = array_merge($messages, $this->getMessagesForRequiredNarrative($name['narrative'], $narrativeForm));
        }

        return $messages;
    }

    /**
     * returns rules for location description.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForLocationDescription($formFields, $formBase)
    {
        $rules = [];
        foreach ($formFields as $descriptionIndex => $description) {
            $narrativeForm = sprintf('%s.description.%s', $formBase, $descriptionIndex);
            $rules = array_merge($rules, $this->getRulesForNarrative($description['narrative'], $narrativeForm));
        }

        return $rules;
    }

    /**
     * returns messages for location description.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForLocationDescription($formFields, $formBase)
    {
        $messages = [];
        foreach ($formFields as $descriptionIndex => $description) {
            $narrativeForm = sprintf('%s.description.%s', $formBase, $descriptionIndex);
            $messages = array_merge($messages, $this->getMessagesForNarrative($description['narrative'], $narrativeForm));
        }

        return $messages;
    }

    /**
     * returns rules for activity description.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForActivityDescription($formFields, $formBase)
    {
        $rules = [];
        foreach ($formFields as $descriptionIndex => $description) {
            $narrativeForm = sprintf('%s.activity_description.%s', $formBase, $descriptionIndex);
            $rules = array_merge($rules, $this->getRulesForNarrative($description['narrative'], $narrativeForm));
        }

        return $rules;
    }

    /**
     * returns messages for activity description.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForActivityDescription($formFields, $formBase)
    {
        $messages = [];
        foreach ($formFields as $descriptionIndex => $description) {
            $narrativeForm = sprintf('%s.activity_description.%s', $formBase, $descriptionIndex);
            $messages = array_merge($messages, $this->getMessagesForNarrative($description['narrative'], $narrativeForm));
        }

        return $messages;
    }

    /**
     * returns rules for administrative.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForAdministrative($formFields, $formBase)
    {
        $rules = [];

        foreach ($formFields as $administrativeIndex => $administrative) {
            $administrativeForm = sprintf('%s.administrative.%s', $formBase, $administrativeIndex);
            $rules[sprintf('%s.level', $administrativeForm)] = 'nullable|min:0|integer';
        }

        return $rules;
    }

    /**
     * returns messages for administrative.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForAdministrative($formFields, $formBase)
    {
        $messages = [];
        foreach ($formFields as $administrativeIndex => $administrative) {
            $administrativeForm = sprintf('%s.administrative.%s', $formBase, $administrativeIndex);
            if ($administrative['code'] != '') {
                $messages[sprintf('%s.vocabulary.required_with', $administrativeForm)] = trans(
                    'validation.required_with',
                    ['attribute' => trans('elementForm.vocabulary'), 'values' => trans('elementForm.code')]
                );
            }

            if ($administrative['vocabulary'] != '') {
                $messages[sprintf('%s.code.required_with', $administrativeForm)] = trans(
                    'validation.required_with',
                    ['attribute' => trans('elementForm.code'), 'values' => trans('elementForm.vocabulary')]
                );
            }

            if ($administrative['level'] != '') {
                $messages[sprintf('%s.vocabulary.required_with', $administrativeForm)] = trans(
                    'validation.required_with',
                    ['attribute' => trans('elementForm.vocabulary'), 'values' => trans('elementForm.level')]
                );
                $messages[sprintf('%s.code.required_with', $administrativeForm)] = trans(
                    'validation.required_with',
                    ['attribute' => trans('elementForm.code'), 'values' => trans('elementForm.level')]
                );
            }

            $messages[sprintf('%s.level.integer', $administrativeForm)] = trans('validation.integer', ['attribute' => trans('elementForm.level')]);
        }

        return $messages;
    }

    /**
     * returns rules for point.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getRulesForPoint($formFields, $formBase)
    {
        $rules = [];
        $pointForm = sprintf('%s.point.0', $formBase);
        $positionForm = sprintf('%s.position.0', $pointForm);
        $latitude = sprintf('%s.latitude', $positionForm);
        $longitude = sprintf('%s.longitude', $positionForm);
        $rules[$latitude] = sprintf('nullable|numeric', $longitude);
        $rules[$longitude] = sprintf('nullable|numeric', $latitude);

        return $rules;
    }

    /**
     * returns messages for point.
     * @param $formFields
     * @param $formBase
     * @return array
     */
    protected function getMessagesForPoint($formFields, $formBase)
    {
        $messages = [];
        $pointForm = sprintf('%s.point.0', $formBase);
        $messages[sprintf('%s.srs_name.required', $pointForm)] = trans('validation.required', ['attribute' => trans('elementForm.srs_name')]);
        $positionForm = sprintf('%s.position.0', $pointForm);
        $messages[sprintf('%s.latitude.required_with', $positionForm)] = trans('validation.required_with', ['attribute' => trans('elementForm.latitude'), 'values' => trans('elementForm.longitude')]);
        $messages[sprintf('%s.latitude.numeric', $positionForm)] = trans('validation.numeric', ['attribute' => trans('elementForm.latitude')]);
        $messages[sprintf('%s.longitude.required_with', $positionForm)] = trans(
            'validation.required_with',
            ['attribute' => trans('elementForm.longitude'), 'values' => trans('elementForm.latitude')]
        );
        $messages[sprintf('%s.longitude.numeric', $positionForm)] = trans('validation.numeric', ['attribute' => trans('elementForm.longitude')]);

        return $messages;
    }
}
