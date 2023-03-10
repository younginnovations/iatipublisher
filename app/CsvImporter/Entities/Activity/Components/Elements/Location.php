<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\Location\LocationRequest;
use App\IATI\Traits\DataSanitizeTrait;
use Illuminate\Support\Arr;

/**
 * Class Location.
 */
class Location extends Element
{
    use DataSanitizeTrait;

    /**
     * Csv Header for Location element.
     * @var array
     */
    private array $_csvHeaders
    = [
        'location_reference',
        'location_reach_code',
        'location_id_vocabulary',
        'location_id_code',
        'location_name',
        'location_description',
        'location_activity_description',
        'location_administrative_vocabulary',
        'location_administrative_code',
        'location_administrative_level',
        'location_point_srsname',
        'pos_latitude',
        'pos_longitude',
        'location_exactness',
        'location_class',
        'feature_designation',
    ];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'location';

    /**
     * @var LocationRequest
     */
    private LocationRequest $request;

    /**
     * Location constructor.
     *
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->request = new LocationRequest();
    }

    /**
     * Prepare Location element.
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

        $fields = is_array($fields) ? $this->sanitizeData($fields) : $fields;
    }

    /**
     * Map data from CSV file into Location data format.
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
            $this->setLocationReference($key, $value, $index);
            $this->setLocationReachCode($key, $value, $index);
            $this->setLocationId($key, $value, $index);
            $this->setNameNarrative($key, $value, $index);
            $this->setDescriptionNarrative($key, $value, $index);
            $this->setActivityDescriptionNarrative($key, $value, $index);
            $this->setAdministrative($key, $value, $index);
            $this->setPoint($key, $value, $index);
            $this->setExactness($key, $value, $index);
            $this->setLocationClass($key, $value, $index);
            $this->setFeatureDesignation($key, $value, $index);
        }
    }

    /**
     * Set document url for Location.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setLocationReference($key, $value, $index): void
    {
        if (!isset($this->data['location'][$index]['ref'])) {
            $this->data['location'][$index]['ref'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $this->data['location'][$index]['ref'] = $value;
        }
    }

    /**
     * Maps Location Reach Code.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setLocationReachCode($key, $value, $index): void
    {
        if (!isset($this->data['location'][$index]['location_reach'][0]['code'])) {
            $this->data['location'][$index]['location_reach'][0]['code'] = '';
        }

        if ($key === $this->_csvHeaders[1]) {
            $value = is_null($value) ? '' : trim($value);

            $validLocationReachCode = $this->loadCodeList('GeographicLocationReach');

            if ($value) {
                foreach ($validLocationReachCode as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['location'][$index]['location_reach'][0]['code'] = $value;
        }
    }

    /**
     * Maps Location Id Components.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setLocationId($key, $value, $index): void
    {
        if (!isset($this->data['location'][$index]['location_id'][0]['vocabulary'])) {
            $this->data['location'][$index]['location_id'][0]['vocabulary'] = '';
        }

        if (!isset($this->data['location'][$index]['location_id'][0]['code'])) {
            $this->data['location'][$index]['location_id'][0]['code'] = '';
        }

        if ($key === $this->_csvHeaders[2]) {
            $value = is_null($value) ? '' : trim($value);

            $validLocationIdVocabulary = $this->loadCodeList('GeographicVocabulary');

            if ($value) {
                foreach ($validLocationIdVocabulary as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['location'][$index]['location_id'][0]['vocabulary'] = strtoupper($value);
        } elseif ($key === $this->_csvHeaders[3]) {
            $value = is_null($value) ? '' : trim($value);

            $this->data['location'][$index]['location_id'][0]['code'] = $value;
        }
    }

    /**
     * Set narrative for Name.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setNameNarrative($key, $value, $index): void
    {
        if (!isset($this->data['location'][$index]['name'][0]['narrative'][0]['narrative'])) {
            $this->data['location'][$index]['name'][0]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

        if ($key === $this->_csvHeaders[4]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['location'][$index]['name'][0]['narrative'][0] = $narrative;
        }
    }

    /**
     * Set narrative for Description.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setDescriptionNarrative($key, $value, $index): void
    {
        if (!isset($this->data['location'][$index]['description'][0]['narrative'][0]['narrative'])) {
            $this->data['location'][$index]['description'][0]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

        if ($key === $this->_csvHeaders[5]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['location'][$index]['description'][0]['narrative'][0] = $narrative;
        }
    }

    /**
     * Set narrative for Activity Description.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setActivityDescriptionNarrative($key, $value, $index): void
    {
        if (!isset($this->data['location'][$index]['activity_description'][0]['narrative'][0]['narrative'])) {
            $this->data['location'][$index]['activity_description'][0]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

        if ($key === $this->_csvHeaders[6]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['location'][$index]['activity_description'][0]['narrative'][0] = $narrative;
        }
    }

    /**
     * Maps Administrative Component.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setAdministrative($key, $value, $index): void
    {
        if (!isset($this->data['location'][$index]['administrative'])) {
            $this->data['location'][$index]['administrative'][0]['vocabulary'] = '';
            $this->data['location'][$index]['administrative'][0]['code'] = '';
            $this->data['location'][$index]['administrative'][0]['level'] = '';
        }

        if ($key === $this->_csvHeaders[7]) {
            $value = is_null($value) ? '' : trim($value);

            $validAdministrativeVocabulary = $this->loadCodeList('GeographicVocabulary');

            if ($value) {
                foreach ($validAdministrativeVocabulary as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['location'][$index]['administrative'][0]['vocabulary'] = strtoupper($value);
        } elseif ($key === $this->_csvHeaders[8]) {
            $value = is_null($value) ? '' : trim($value);

            $validAdministrativeCode = $this->loadCodeList('Country');

            if ($value) {
                foreach ($validAdministrativeCode as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['location'][$index]['administrative'][0]['code'] = strtoupper($value);
        } elseif ($key === $this->_csvHeaders[9]) {
            $value = is_null($value) ? '' : trim($value);

            $this->data['location'][$index]['administrative'][0]['level'] = $value;
        }
    }

    /**
     * Maps Point Component.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setPoint($key, $value, $index): void
    {
        if (!isset($this->data['location'][$index]['point'][0]['srs_name'])) {
            $this->data['location'][$index]['point'][0]['srs_name'] = '';
        }

        if (!isset($this->data['location'][$index]['point'][0]['pos'][0]['latitude'])) {
            $this->data['location'][$index]['point'][0]['pos'][0]['latitude'] = '';
        }

        if (!isset($this->data['location'][$index]['point'][0]['pos'][0]['longitude'])) {
            $this->data['location'][$index]['point'][0]['pos'][0]['longitude'] = '';
        }

        if ($key === $this->_csvHeaders[10]) {
            $value = is_null($value) ? '' : trim($value);

            $this->data['location'][$index]['point'][0]['srs_name'] = $value;
        } elseif ($key === $this->_csvHeaders[11]) {
            $value = (!$value) ? '' : $value;

            $this->data['location'][$index]['point'][0]['pos'][0]['latitude'] = $value;
        } elseif ($key === $this->_csvHeaders[12]) {
            $value = (!$value) ? '' : $value;

            $this->data['location'][$index]['point'][0]['pos'][0]['longitude'] = $value;
        }
    }

    /**
     * Maps Location Exactness.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setExactness($key, $value, $index): void
    {
        if (!isset($this->data['location'][$index]['exactness'][0]['code'])) {
            $this->data['location'][$index]['exactness'][0]['code'] = '';
        }

        if ($key === $this->_csvHeaders[13]) {
            $value = is_null($value) ? '' : trim($value);

            $validLocationExactness = $this->loadCodeList('GeographicExactness');

            if ($value) {
                foreach ($validLocationExactness as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['location'][$index]['exactness'][0]['code'] = $value;
        }
    }

    /**
     * Maps Location Class.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setLocationClass($key, $value, $index): void
    {
        if (!isset($this->data['location'][$index]['location_class'][0]['code'])) {
            $this->data['location'][$index]['location_class'][0]['code'] = '';
        }

        if ($key === $this->_csvHeaders[14]) {
            $value = is_null($value) ? '' : trim($value);

            $validLocationClass = $this->loadCodeList('GeographicLocationClass');

            if ($value) {
                foreach ($validLocationClass as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['location'][$index]['location_class'][0]['code'] = $value;
        }
    }

    /**
     * Maps Feature Designation.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setFeatureDesignation($key, $value, $index): void
    {
        if (!isset($this->data['location'][$index]['feature_designation'][0]['code'])) {
            $this->data['location'][$index]['feature_designation'][0]['code'] = '';
        }

        if ($key === $this->_csvHeaders[15]) {
            $value = is_null($value) ? '' : trim($value);

            $validFeatureDesignation = $this->loadCodeList('LocationType');

            if ($value) {
                foreach ($validFeatureDesignation as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['location'][$index]['feature_designation'][0]['code'] = strtoupper($value);
        }
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function rules(): array
    {
        return $this->request->getWarningForLocation(Arr::get($this->data, 'location', []));
    }

    /**
     * Provides the critical rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function errorRules(): array
    {
        return $this->request->getErrorsForLocation(Arr::get($this->data, 'location', []));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getMessagesForLocation(Arr::get($this->data, 'location', []));
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
        $this->errorValidator = $this->factory->sign($this->data())
            ->with($this->errorRules(), $this->messages())
            ->getValidatorInstance();
        $this->setValidity();

        return $this;
    }
}
