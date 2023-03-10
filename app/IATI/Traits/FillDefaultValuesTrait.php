<?php

namespace App\IATI\Traits;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Activity\Result;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

trait FillDefaultValuesTrait
{
    /**
     * Temp amount to be used during recursion.
     *
     * @var mixed
     */
    public mixed $tempAmount;

    /**
     * Temp narrative to be used during recursion.
     *
     * @var mixed
     */
    public mixed $tempNarrative;

    /**
     * Populated default values
     * For language and currency.
     *
     * @param $data
     * @param $defaultValues
     *
     * @return array
     */
    public function populateDefaultFields(&$data, $defaultValues):array
    {
        foreach ($data as $key => &$datum) {
            if (is_array($datum)) {
                $this->populateDefaultFields($datum, $defaultValues);
            }

            $this->setTempNarrative((string) $key, $datum);
            $this->setTempAmount((string) $key, $datum);
            $this->setLanguage($data, (string) $key, $datum, $defaultValues);
            $this->setCurrency($data, (string) $key, $datum, $defaultValues);
        }

        return $data;
    }

    /**
     * Sets $tempNarrative.
     *
     * @param string $key
     * @param $datum
     *
     * @return void
     */
    public function setTempNarrative(string $key, $datum): void
    {
        if ($key === 'narrative') {
            $this->tempNarrative = $datum;
        }
    }

    /**
     * Sets $tempAmount.
     *
     * @param string $key
     * @param $datum
     *
     * @return void
     */
    public function setTempAmount(string $key, $datum): void
    {
        if ($key === 'amount') {
            $this->tempAmount = $datum;
        }
    }

    /**
     * Sets default language if language is empty && non-empty narrative['narrative'].
     *
     * @param array $data
     * @param string $key
     * @param $datum
     * @param $defaultValues
     *
     * @return void
     */
    public function setLanguage(array &$data, string $key, $datum, $defaultValues): void
    {
        if ($key === 'language' && empty($datum) && !empty($this->tempNarrative)) {
            $data['language'] = Arr::get($defaultValues, 'default_language', null);
        }
    }

    /**
     * Sets default currency if currency is empty && non-empty amount['amount'].
     *
     * @param array $data
     * @param string $key
     * @param $datum
     * @param $defaultValues
     *
     * @return void
     */
    public function setCurrency(array &$data, string $key, $datum, $defaultValues): void
    {
        if ($key === 'currency' && empty($datum) && !empty($this->tempAmount)) {
            $data['currency'] = Arr::get($defaultValues, 'default_currency', null);
        }
    }

    /**
     * Overriding base Repository class's store method.
     * Modified to populate default field values on save.
     *
     * @param array $data
     *
     * @inheritDoc
     *
     * @return Model
     */
    public function store(array $data): Model
    {
        $defaultFieldValues = $data['default_field_values'];
        $data = $this->populateDefaultFields($data, $defaultFieldValues);

        return $this->model->create($data);
    }

    /**
     * Return default values of activity.
     *
     * @param int|string $id
     * @param string $calledForModel
     *
     * @return mixed
     */
    public function getDefaultValuesFromActivity(int|string $id, string $calledForModel = ''): mixed
    {
        if ($calledForModel) {
            switch ($calledForModel) {
                case    'result':
                case 'transaction':
                    $id = $this->model->find($id)->activity_id;
                    break;
                case 'indicator':
                    $resultId = $this->model->find($id)->result_id;
                    $id = (new Result())->find($resultId)->activity_id;
                    break;
            }
        }

        $defaultFieldValues = (new Activity())->find($id)->default_field_values;

        return $defaultFieldValues ?? false;
    }
}
