<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use Illuminate\Support\Arr;

/**
 * Class Location.
 */
class Location extends Element
{
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
     * Location constructor.
     *
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
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
        if ($key === $this->_csvHeaders[1]) {
            $value = (!$value) ? '' : $value;

            $validLocationReachCode = $this->loadCodeList('GeographicLocationReach');

            if ($value) {
                foreach ($validLocationReachCode as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
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
        if ($key === $this->_csvHeaders[2]) {
            $value = (!$value) ? '' : $value;

            $validLocationIdVocabulary = $this->loadCodeList('GeographicVocabulary');

            if ($value) {
                foreach ($validLocationIdVocabulary as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['location'][$index]['location_id'][0]['vocabulary'] = strtoupper($value);
        } elseif ($key === $this->_csvHeaders[3]) {
            $value = (!$value) ? '' : $value;

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
        if ($key === $this->_csvHeaders[4]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['location'][$index]['name'][0]['narrative'][] = $narrative;
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
        if ($key === $this->_csvHeaders[5]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['location'][$index]['description'][0]['narrative'][] = $narrative;
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
        if ($key === $this->_csvHeaders[6]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['location'][$index]['activity_description'][0]['narrative'][] = $narrative;
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
        if ($key === $this->_csvHeaders[7]) {
            $value = (!$value) ? '' : $value;

            $validAdministrativeVocabulary = $this->loadCodeList('GeographicVocabulary');

            if ($value) {
                foreach ($validAdministrativeVocabulary as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['location'][$index]['administrative'][0]['vocabulary'] = strtoupper($value);
        } elseif ($key === $this->_csvHeaders[8]) {
            $value = (!$value) ? '' : $value;

            $validAdministrativeCode = $this->loadCodeList('Country');

            if ($value) {
                foreach ($validAdministrativeCode as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['location'][$index]['administrative'][0]['code'] = $value;
        } elseif ($key === $this->_csvHeaders[9]) {
            $value = (!$value) ? '' : $value;

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
        if ($key === $this->_csvHeaders[10]) {
            $value = (!$value) ? '' : $value;

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
        if ($key === $this->_csvHeaders[13]) {
            $value = (!$value) ? '' : $value;

            $validLocationExactness = $this->loadCodeList('GeographicExactness');

            if ($value) {
                foreach ($validLocationExactness as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
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
        if ($key === $this->_csvHeaders[14]) {
            $value = (!$value) ? '' : $value;

            $validLocationClass = $this->loadCodeList('GeographicLocationClass');

            if ($value) {
                foreach ($validLocationClass as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
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
        if ($key === $this->_csvHeaders[15]) {
            $value = (!$value) ? '' : $value;

            $validFeatureDesignation = $this->loadCodeList('LocationType');

            if ($value) {
                foreach ($validFeatureDesignation as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
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
        $validLocationReachCode = implode(',', $this->validLocationCodeList('GeographicLocationReach'));
        $validLocationIdVocabulary = implode(',', $this->validLocationCodeList('GeographicVocabulary'));
        $validAdministrativeCode = implode(',', $this->validLocationCodeList('Country'));
        $validExactnessCode = implode(',', $this->validLocationCodeList('GeographicExactness'));
        $validLocationClassCode = implode(',', $this->validLocationCodeList('GeographicLocationClass'));
        $validFeatureDesignationCode = implode(',', $this->validLocationCodeList('LocationType'));
        $rules = [];

        foreach (Arr::get($this->data(), 'location', []) as $key => $value) {
            $locationForm = sprintf('location.%s', $key);
            $rules[sprintf('%s.location_reach.0.code', $locationForm)] = sprintf(
                'in:%s|required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                $validLocationReachCode,
                sprintf('%s.ref', $locationForm),
                sprintf('%s.location_id.0.vocabulary', $locationForm),
                sprintf('%s.location_id.0.code', $locationForm),
                sprintf('%s.name.0.narrative.0.narrative', $locationForm),
                sprintf('%s.description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.activity_description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.administrative.0.vocabulary', $locationForm),
                sprintf('%s.administrative.0.code', $locationForm),
                sprintf('%s.administrative.0.level', $locationForm),
                sprintf('%s.point.0.srs_name', $locationForm),
                sprintf('%s.point.0.pos.0.latitude', $locationForm),
                sprintf('%s.point.0.pos.0.longitude', $locationForm),
                sprintf('%s.exactness.0.code', $locationForm),
                sprintf('%s.location_class.0.code', $locationForm),
                sprintf('%s.feature_designation.0.code', $locationForm),
            );
            $rules[sprintf('%s.location_id.0.vocabulary', $locationForm)] = sprintf(
                'in:%s|required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                $validLocationIdVocabulary,
                sprintf('%s.ref', $locationForm),
                sprintf('%s.location_reach.0.code', $locationForm),
                sprintf('%s.location_id.0.code', $locationForm),
                sprintf('%s.name.0.narrative.0.narrative', $locationForm),
                sprintf('%s.description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.activity_description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.administrative.0.vocabulary', $locationForm),
                sprintf('%s.administrative.0.code', $locationForm),
                sprintf('%s.administrative.0.level', $locationForm),
                sprintf('%s.point.0.srs_name', $locationForm),
                sprintf('%s.point.0.pos.0.latitude', $locationForm),
                sprintf('%s.point.0.pos.0.longitude', $locationForm),
                sprintf('%s.exactness.0.code', $locationForm),
                sprintf('%s.location_class.0.code', $locationForm),
                sprintf('%s.feature_designation.0.code', $locationForm),
            );
            $rules[sprintf('%s.location_id.0.code', $locationForm)] = sprintf(
                'required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                sprintf('%s.ref', $locationForm),
                sprintf('%s.location_reach.0.code', $locationForm),
                sprintf('%s.location_id.0.vocabulary', $locationForm),
                sprintf('%s.name.0.narrative.0.narrative', $locationForm),
                sprintf('%s.description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.activity_description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.administrative.0.vocabulary', $locationForm),
                sprintf('%s.administrative.0.code', $locationForm),
                sprintf('%s.administrative.0.level', $locationForm),
                sprintf('%s.point.0.srs_name', $locationForm),
                sprintf('%s.point.0.pos.0.latitude', $locationForm),
                sprintf('%s.point.0.pos.0.longitude', $locationForm),
                sprintf('%s.exactness.0.code', $locationForm),
                sprintf('%s.location_class.0.code', $locationForm),
                sprintf('%s.feature_designation.0.code', $locationForm),
            );
            $rules[sprintf('%s.name.0.narrative.0.narrative', $locationForm)] = sprintf(
                'required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                sprintf('%s.ref', $locationForm),
                sprintf('%s.location_reach.0.code', $locationForm),
                sprintf('%s.location_id.0.vocabulary', $locationForm),
                sprintf('%s.location_id.0.code', $locationForm),
                sprintf('%s.description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.activity_description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.administrative.0.vocabulary', $locationForm),
                sprintf('%s.administrative.0.code', $locationForm),
                sprintf('%s.administrative.0.level', $locationForm),
                sprintf('%s.point.0.srs_name', $locationForm),
                sprintf('%s.point.0.pos.0.latitude', $locationForm),
                sprintf('%s.point.0.pos.0.longitude', $locationForm),
                sprintf('%s.exactness.0.code', $locationForm),
                sprintf('%s.location_class.0.code', $locationForm),
                sprintf('%s.feature_designation.0.code', $locationForm),
            );
            $rules[sprintf('%s.description.0.narrative.0.narrative', $locationForm)] = sprintf(
                'required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                sprintf('%s.ref', $locationForm),
                sprintf('%s.location_reach.0.code', $locationForm),
                sprintf('%s.location_id.0.vocabulary', $locationForm),
                sprintf('%s.location_id.0.code', $locationForm),
                sprintf('%s.name.0.narrative.0.narrative', $locationForm),
                sprintf('%s.activity_description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.administrative.0.vocabulary', $locationForm),
                sprintf('%s.administrative.0.code', $locationForm),
                sprintf('%s.administrative.0.level', $locationForm),
                sprintf('%s.point.0.srs_name', $locationForm),
                sprintf('%s.point.0.pos.0.latitude', $locationForm),
                sprintf('%s.point.0.pos.0.longitude', $locationForm),
                sprintf('%s.exactness.0.code', $locationForm),
                sprintf('%s.location_class.0.code', $locationForm),
                sprintf('%s.feature_designation.0.code', $locationForm),
            );
            $rules[sprintf('%s.activity_description.0.narrative.0.narrative', $locationForm)] = sprintf(
                'required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                sprintf('%s.ref', $locationForm),
                sprintf('%s.location_reach.0.code', $locationForm),
                sprintf('%s.location_id.0.vocabulary', $locationForm),
                sprintf('%s.location_id.0.code', $locationForm),
                sprintf('%s.name.0.narrative.0.narrative', $locationForm),
                sprintf('%s.description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.administrative.0.vocabulary', $locationForm),
                sprintf('%s.administrative.0.code', $locationForm),
                sprintf('%s.administrative.0.level', $locationForm),
                sprintf('%s.point.0.srs_name', $locationForm),
                sprintf('%s.point.0.pos.0.latitude', $locationForm),
                sprintf('%s.point.0.pos.0.longitude', $locationForm),
                sprintf('%s.exactness.0.code', $locationForm),
                sprintf('%s.location_class.0.code', $locationForm),
                sprintf('%s.feature_designation.0.code', $locationForm),
            );
            $rules[sprintf('%s.administrative.0.vocabulary', $locationForm)] = sprintf(
                'in:%s|required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                $validLocationIdVocabulary,
                sprintf('%s.ref', $locationForm),
                sprintf('%s.location_reach.0.code', $locationForm),
                sprintf('%s.location_id.0.vocabulary', $locationForm),
                sprintf('%s.location_id.0.code', $locationForm),
                sprintf('%s.name.0.narrative.0.narrative', $locationForm),
                sprintf('%s.description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.activity_description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.administrative.0.code', $locationForm),
                sprintf('%s.administrative.0.level', $locationForm),
                sprintf('%s.point.0.srs_name', $locationForm),
                sprintf('%s.point.0.pos.0.latitude', $locationForm),
                sprintf('%s.point.0.pos.0.longitude', $locationForm),
                sprintf('%s.exactness.0.code', $locationForm),
                sprintf('%s.location_class.0.code', $locationForm),
                sprintf('%s.feature_designation.0.code', $locationForm),
            );
            $rules[sprintf('%s.administrative.0.code', $locationForm)] = sprintf(
                'in:%s|required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                $validAdministrativeCode,
                sprintf('%s.ref', $locationForm),
                sprintf('%s.location_reach.0.code', $locationForm),
                sprintf('%s.location_id.0.vocabulary', $locationForm),
                sprintf('%s.location_id.0.code', $locationForm),
                sprintf('%s.name.0.narrative.0.narrative', $locationForm),
                sprintf('%s.description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.activity_description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.administrative.0.vocabulary', $locationForm),
                sprintf('%s.administrative.0.level', $locationForm),
                sprintf('%s.point.0.srs_name', $locationForm),
                sprintf('%s.point.0.pos.0.latitude', $locationForm),
                sprintf('%s.point.0.pos.0.longitude', $locationForm),
                sprintf('%s.exactness.0.code', $locationForm),
                sprintf('%s.location_class.0.code', $locationForm),
                sprintf('%s.feature_designation.0.code', $locationForm),
            );
            $rules[sprintf('%s.administrative.0.level', $locationForm)] = 'nullable|min:0|integer';
            $rules[sprintf('%s.point.0.srs_name', $locationForm)] = sprintf(
                'required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                sprintf('%s.ref', $locationForm),
                sprintf('%s.location_reach.0.code', $locationForm),
                sprintf('%s.location_id.0.vocabulary', $locationForm),
                sprintf('%s.location_id.0.code', $locationForm),
                sprintf('%s.name.0.narrative.0.narrative', $locationForm),
                sprintf('%s.description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.activity_description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.administrative.0.vocabulary', $locationForm),
                sprintf('%s.administrative.0.code', $locationForm),
                sprintf('%s.administrative.0.level', $locationForm),
                sprintf('%s.point.0.pos.0.latitude', $locationForm),
                sprintf('%s.point.0.pos.0.longitude', $locationForm),
                sprintf('%s.exactness.0.code', $locationForm),
                sprintf('%s.location_class.0.code', $locationForm),
                sprintf('%s.feature_designation.0.code', $locationForm),
            );
            $rules[sprintf('%s.point.0.pos.0.latitude', $locationForm)] = sprintf(
                'nullable|numeric|required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                sprintf('%s.ref', $locationForm),
                sprintf('%s.location_reach.0.code', $locationForm),
                sprintf('%s.location_id.0.vocabulary', $locationForm),
                sprintf('%s.location_id.0.code', $locationForm),
                sprintf('%s.name.0.narrative.0.narrative', $locationForm),
                sprintf('%s.description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.activity_description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.administrative.0.vocabulary', $locationForm),
                sprintf('%s.administrative.0.code', $locationForm),
                sprintf('%s.administrative.0.level', $locationForm),
                sprintf('%s.point.0.srs_name', $locationForm),
                sprintf('%s.point.0.pos.0.longitude', $locationForm),
                sprintf('%s.exactness.0.code', $locationForm),
                sprintf('%s.location_class.0.code', $locationForm),
                sprintf('%s.feature_designation.0.code', $locationForm),
            );
            $rules[sprintf('%s.point.0.pos.0.longitude', $locationForm)] = sprintf(
                'nullable|numeric|required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                sprintf('%s.ref', $locationForm),
                sprintf('%s.location_reach.0.code', $locationForm),
                sprintf('%s.location_id.0.vocabulary', $locationForm),
                sprintf('%s.location_id.0.code', $locationForm),
                sprintf('%s.name.0.narrative.0.narrative', $locationForm),
                sprintf('%s.description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.activity_description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.administrative.0.vocabulary', $locationForm),
                sprintf('%s.administrative.0.code', $locationForm),
                sprintf('%s.administrative.0.level', $locationForm),
                sprintf('%s.point.0.srs_name', $locationForm),
                sprintf('%s.point.0.pos.0.latitude', $locationForm),
                sprintf('%s.exactness.0.code', $locationForm),
                sprintf('%s.location_class.0.code', $locationForm),
                sprintf('%s.feature_designation.0.code', $locationForm),
            );
            $rules[sprintf('%s.exactness.0.code', $locationForm)] = sprintf(
                'in:%s|required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                $validExactnessCode,
                sprintf('%s.ref', $locationForm),
                sprintf('%s.location_reach.0.code', $locationForm),
                sprintf('%s.location_id.0.vocabulary', $locationForm),
                sprintf('%s.location_id.0.code', $locationForm),
                sprintf('%s.name.0.narrative.0.narrative', $locationForm),
                sprintf('%s.description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.activity_description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.administrative.0.vocabulary', $locationForm),
                sprintf('%s.administrative.0.code', $locationForm),
                sprintf('%s.administrative.0.level', $locationForm),
                sprintf('%s.point.0.srs_name', $locationForm),
                sprintf('%s.point.0.pos.0.latitude', $locationForm),
                sprintf('%s.point.0.pos.0.longitude', $locationForm),
                sprintf('%s.location_class.0.code', $locationForm),
                sprintf('%s.feature_designation.0.code', $locationForm),
            );
            $rules[sprintf('%s.location_class.0.code', $locationForm)] = sprintf(
                'in:%s|required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                $validLocationClassCode,
                sprintf('%s.ref', $locationForm),
                sprintf('%s.location_reach.0.code', $locationForm),
                sprintf('%s.location_id.0.vocabulary', $locationForm),
                sprintf('%s.location_id.0.code', $locationForm),
                sprintf('%s.name.0.narrative.0.narrative', $locationForm),
                sprintf('%s.description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.activity_description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.administrative.0.vocabulary', $locationForm),
                sprintf('%s.administrative.0.code', $locationForm),
                sprintf('%s.administrative.0.level', $locationForm),
                sprintf('%s.point.0.srs_name', $locationForm),
                sprintf('%s.point.0.pos.0.latitude', $locationForm),
                sprintf('%s.point.0.pos.0.longitude', $locationForm),
                sprintf('%s.exactness.0.code', $locationForm),
                sprintf('%s.feature_designation.0.code', $locationForm),
            );
            $rules[sprintf('%s.feature_designation.0.code', $locationForm)] = sprintf(
                'in:%s|required_with: %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
                $validFeatureDesignationCode,
                sprintf('%s.ref', $locationForm),
                sprintf('%s.location_reach.0.code', $locationForm),
                sprintf('%s.location_id.0.vocabulary', $locationForm),
                sprintf('%s.location_id.0.code', $locationForm),
                sprintf('%s.name.0.narrative.0.narrative', $locationForm),
                sprintf('%s.description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.activity_description.0.narrative.0.narrative', $locationForm),
                sprintf('%s.administrative.0.vocabulary', $locationForm),
                sprintf('%s.administrative.0.code', $locationForm),
                sprintf('%s.administrative.0.level', $locationForm),
                sprintf('%s.point.0.srs_name', $locationForm),
                sprintf('%s.point.0.pos.0.latitude', $locationForm),
                sprintf('%s.point.0.pos.0.longitude', $locationForm),
                sprintf('%s.exactness.0.code', $locationForm),
                sprintf('%s.location_class.0.code', $locationForm),
            );
        }

        return $rules;
    }

    /**
     * Return Valid Location Type.
     *
     * @param $name
     *
     * @return array
     * @throws \JsonException
     */
    protected function validLocationCodeList($name): array
    {
        return array_keys($this->loadCodeList($name));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages = [];

        foreach (Arr::get($this->data(), 'location', []) as $key => $value) {
            $locationForm = sprintf('location.%s', $key);
            $messages[sprintf('%s.location_reach.0.code.%s', $locationForm, 'in')] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.location_reach_code')]
            );
            $messages[sprintf('%s.location_reach.0.code.%s', $locationForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.location_reach_code'), 'values' => 'any location element values']
            );
            $messages[sprintf('%s.location_id.0.vocabulary.%s', $locationForm, 'in')] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.location_id_vocabulary')]
            );
            $messages[sprintf('%s.location_id.0.vocabulary.%s', $locationForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.location_id_vocabulary'), 'values' => 'any location element values']
            );
            $messages[sprintf('%s.location_id.0.code.%s', $locationForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.location_id_code'), 'values' => 'any location element values']
            );
            $messages[sprintf('%s.name.0.narrative.0.narrative.%s', $locationForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.location_name_narrative'), 'values' => 'any location element values']
            );
            $messages[sprintf('%s.description.0.narrative.0.narrative.%s', $locationForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.location_description_narrative'), 'values' => 'any location element values']
            );
            $messages[sprintf('%s.activity_description.0.narrative.0.narrative.%s', $locationForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.location_activity_description_narrative'), 'values' => 'any location element values']
            );
            $messages[sprintf('%s.administrative.0.vocabulary.%s', $locationForm, 'in')] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.location_administrative_vocabulary')]
            );
            $messages[sprintf('%s.administrative.0.vocabulary.%s', $locationForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.location_administrative_vocabulary'), 'values' => 'any location element values']
            );
            $messages[sprintf('%s.administrative.0.code.%s', $locationForm, 'in')] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.location_administrative_code')]
            );
            $messages[sprintf('%s.administrative.0.code.%s', $locationForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.location_administrative_code'), 'values' => 'any location element values']
            );
            $messages[sprintf('%s.administrative.0.level.%s', $locationForm, 'min')] = trans(
                'validation.min.numeric',
                ['attribute' => trans('elementForm.location_administrative_level'), 'min' => '0']
            );
            $messages[sprintf('%s.administrative.0.level.%s', $locationForm, 'integer')] = trans(
                'validation.integer',
                ['attribute' => trans('elementForm.location_administrative_level')]
            );
            $messages[sprintf('%s.point.0.srs_name.%s', $locationForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.location_point_srs_name'), 'values' => 'any location element values']
            );
            $messages[sprintf('%s.point.0.pos.0.latitude.%s', $locationForm, 'numeric')] = trans(
                'validation.numeric',
                ['attribute' => trans('elementForm.location_pos_latitude')]
            );
            $messages[sprintf('%s.point.0.pos.0.latitude.%s', $locationForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.location_pos_latitude'), 'values' => 'any location element values']
            );
            $messages[sprintf('%s.point.0.pos.0.longitude.%s', $locationForm, 'numeric')] = trans(
                'validation.numeric',
                ['attribute' => trans('elementForm.location_pos_longitude')]
            );
            $messages[sprintf('%s.point.0.pos.0.longitude.%s', $locationForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.location_pos_longitude'), 'values' => 'any location element values']
            );
            $messages[sprintf('%s.exactness.0.code.%s', $locationForm, 'in')] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.location_exactness_code')]
            );
            $messages[sprintf('%s.exactness.0.code.%s', $locationForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.location_exactness_code'), 'values' => 'any location element values']
            );
            $messages[sprintf('%s.location_class.0.code.%s', $locationForm, 'in')] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.location_class_code')]
            );
            $messages[sprintf('%s.location_class.0.code.%s', $locationForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.location_class_code'), 'values' => 'any location element values']
            );
            $messages[sprintf('%s.feature_designation.0.code.%s', $locationForm, 'in')] = trans(
                'validation.code_list',
                ['attribute' => trans('elementForm.location_feature_designation_code')]
            );
            $messages[sprintf('%s.feature_designation.0.code.%s', $locationForm, 'required_with')] = trans(
                'validation.required_with',
                ['attribute' => trans('elementForm.location_feature_designation_code'), 'values' => 'any location element values']
            );
        }

        return $messages;
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
