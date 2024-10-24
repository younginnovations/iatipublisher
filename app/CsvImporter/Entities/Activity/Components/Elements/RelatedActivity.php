<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\RelatedActivity\RelatedActivityRequest;
use App\IATI\Traits\DataSanitizeTrait;
use Illuminate\Support\Arr;

/**
 * Class RelatedActivity.
 */
class RelatedActivity extends Element
{
    use DataSanitizeTrait;

    /**
     * Csv Header for RelatedActivity element.
     *
     * @var array
     */
    private array $_csvHeaders = ['related_activity_identifier', 'related_activity_type'];

    /**
     * Index under which the data is stored within the object.
     *
     * @var string
     */
    protected string $index = 'related_activity';

    /**
     * @var RelatedActivityRequest
     */
    private RelatedActivityRequest $request;

    /**
     * RelatedActivity constructor.
     *
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->request = new RelatedActivityRequest();
    }

    /**
     * Prepare RelatedActivity element.
     *
     * @param $fields
     *
     * @return void
     * @throws \JsonException
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
     * Map data from CSV file into RelatedActivity data format.
     *
     * @param $key
     * @param $index
     * @param $value
     *
     * @return void
     * @throws \JsonException
     */
    public function map($key, $index, $value): void
    {
        if (!(is_null($value) || $value === '')) {
            $this->setRelatedActivityIdentifier($key, $value, $index);
            $this->setRelatedActivityType($key, $value, $index);
        }
    }

    /**
     * Maps RelatedActivity Identifiers.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setRelatedActivityIdentifier($key, $value, $index): void
    {
        if (!isset($this->data['related_activity'][$index]['activity_identifier'])) {
            $this->data['related_activity'][$index]['activity_identifier'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $this->data['related_activity'][$index]['activity_identifier'] = $value;
        }
    }

    /**
     * Maps RelatedActivity Type.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setRelatedActivityType($key, $value, $index): void
    {
        if (!isset($this->data['related_activity'][$index]['relationship_type'])) {
            $this->data['related_activity'][$index]['relationship_type'] = '';
        }

        if ($key === $this->_csvHeaders[1]) {
            $value = is_null($value) ? '' : trim($value);

            $validRelatedActivity = $this->loadCodeList('RelatedActivityType');

            if ($value) {
                foreach ($validRelatedActivity as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['related_activity'][$index]['relationship_type'] = $value;
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
        return $this->request->getWarningForRelatedActivity(Arr::get($this->data(), 'related_activity', []));
    }

    /**
     * Provides the critical rules for the IATI Element validation.
     *
     * @return array
     * @throws \JsonException
     */
    public function errorRules(): array
    {
        return $this->request->getErrorsForRelatedActivity(Arr::get($this->data(), 'related_activity', []));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getMessagesForRelatedActivity(Arr::get($this->data(), 'related_activity', []));
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
