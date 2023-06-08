<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Activity\Indicator;
use App\IATI\Models\Activity\Period;
use App\IATI\Models\Activity\Result;
use App\IATI\Models\Activity\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class FillDefaultValuesTrait.
 */
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
    public function populateDefaultFields(&$data, $defaultValues): array
    {
        foreach ($data as $key => &$datum) {
            if (is_array($datum)) {
                $this->populateDefaultFields($datum, $defaultValues);
            }

            $this->setTempNarrative((string) $key, $datum);
            $this->setLanguage($data, (string) $key, $datum, $defaultValues);
            $this->setTempAmount((string) $key, $datum);
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
        if (
            $key === 'language' && empty($datum) && !empty($this->tempNarrative) && array_key_exists(
                'narrative',
                $data
            )
        ) {
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
        $defaultFieldValues = $this->resolveDefaultValues($data);
        $data = $this->populateDefaultFields($data, $defaultFieldValues);
        $data['default_field_values'] = $defaultFieldValues;

        return $this->model->create($data);
    }

    /**
     * Overriding base Repository class's update method.
     * Modified to populate default field values on update.
     *
     * @param $id
     * @param $data
     * @param $refillDefaultValues
     *
     * @inheritDoc
     *
     * @return bool
     */
    public function update($id, $data, $refillDefaultValues = false): bool
    {
        $defaultFieldValues = $this->getDefaultValuesFromActivity($id, $this->getModel());

        if ($refillDefaultValues) {
            $defaultFieldValues = $this->resolveDefaultValues($data);
            $data['default_field_values'] = $defaultFieldValues;
        }

        $data = $this->populateDefaultFields($data, $defaultFieldValues);

        return $this->model->find($id)->update($data);
    }

    /**
     * Set Default values for the imported csv activities.
     *
     * @param $data
     *
     * @return array
     */
    public function resolveDefaultValues($data): array
    {
        $defaultValueTemplate = [
            'default_currency' => '',
            'default_language' => '',
            'hierarchy' => '',
            'budget_not_provided' => '',
            'humanitarian' => '',
            'linked_data_uri' => '',
            'default_collaboration_type' => '',
            'default_flow_type' => '',
            'default_finance_type' => '',
            'default_aid_type' => '',
            'default_tied_status' => '',
        ];
        $defaultValueFromData = Arr::get($data, 'default_field_values', []);

        $defaultValuesFromImport = !empty($defaultValueFromData)
            ? ($defaultValueFromData[0] ?? $defaultValueFromData)
            : [];

        $setting = auth()?->user()?->organization->settings ?? [];
        $defaultValuesFromSettings = [];

        if ($setting) {
            $defaultValuesFromSettings = array_merge(Arr::get($setting, 'default_values', []), Arr::get($setting, 'activity_default_values', []));
        }

        foreach ($defaultValueTemplate as $key => $value) {
            $defaultValueTemplate[$key] = $this->getDefaultValueBasedOnPriority(
                $defaultValuesFromImport[$key] ?? '',
                $defaultValuesFromSettings[$key] ?? ''
            );
        }

        return $defaultValueTemplate;
    }

    /**
     * Return default values of activity.
     *
     * @param int|string $id
     * @param string $calledForModel
     *
     * @return mixed
     */
    protected function getDefaultValuesFromActivity(int|string $id, string $calledForModel): mixed
    {
        $defaultFieldValues = [];

        switch ($calledForModel) {
            case get_class(new Activity):
                $defaultFieldValues = $this->model->find($id)->default_field_values;
                break;
            case get_class(new Result):
            case get_class(new Transaction):
                $defaultFieldValues = ($this->model->find($id))->activity->default_field_values;
                break;
            case get_class(new Indicator):
                $indicator = $this->model->find($id);
                $defaultFieldValues = $indicator->result->activity->default_field_values;
                break;
            case get_class(new Period):
                $period = $this->model->find($id);
                $defaultFieldValues = $period->indicator->result->activity->default_field_values;
        }

        return $defaultFieldValues;
    }

    /**
     * Returns the first non-empty value from the params
     * Returns empty string if all values in param are empty.
     *
     * @param ...$values
     *
     * @return string
     */
    protected function getDefaultValueBasedOnPriority(...$values): string
    {
        foreach ($values as $value) {
            if ($value || is_numeric($value)) {
                return (string) $value;
            }
        }

        return '';
    }
}
