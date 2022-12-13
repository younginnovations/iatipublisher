<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\Description\DescriptionRequest;

/**
 * Class Description.
 */
class Description extends Element
{
    /**
     * CSV Header of Description with their code.
     */
    private array $_csvHeaders = ['activity_description_general' => 1, 'activity_description_objectives' => 2, 'activity_description_target_groups' => 3, 'activity_description_others' => 4];

    /**
     * Index under which the data is stored within the object.
     * @var string
     */
    protected string $index = 'description';

    /**
     * @var array
     */
    protected array $narratives = [];

    /**
     * @var
     */
    protected $languages;

    /**
     * @var array
     */
    protected array $types = [];

    /**
     * @var array
     */
    protected array $template = [['type' => '', 'narrative' => ['narrative' => '', 'language' => '']]];
    private DescriptionRequest $request;

    /**
     * Description constructor.
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->request = new DescriptionRequest();
    }

    /**
     * Prepare the Description element.
     *
     * @param $fields
     *
     * @return void
     */
    public function prepare($fields): void
    {
        foreach ($fields as $key => $values) {
            if (!is_null($values) && array_key_exists($key, $this->_csvHeaders)) {
                foreach ($values as $value) {
                    $this->map($key, $value);
                }
            }
        }
    }

    /**
     * Map data from CSV file into Description data format.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    public function map($key, $value): void
    {
        if (!(is_null($value) || $value === '')) {
            $type = $this->setType($key);
            $this->data['description'][$type]['type'] = (string) $type;
            $this->data['description'][$type]['narrative'][] = $this->setNarrative($value);
        }
    }

    /**
     * Set the type for the Description element.
     *
     * @param $key
     *
     * @return mixed
     */
    public function setType($key): mixed
    {
        $this->types[] = $key;
        $this->types = array_unique($this->types);

        return $this->_csvHeaders[$key];
    }

    /**
     * Set the Narrative for the Description element.
     *
     * @param $value
     *
     * @return array
     */
    public function setNarrative($value): array
    {
        $narrative = ['narrative' => $value, 'language' => ''];
        $this->narratives[] = $narrative;

        return $narrative;
    }

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->request->getRulesForDescription($this->data('description'));
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getMessagesForDescription($this->data('description'));
    }

    /**
     * Validate data for IATI Element.
     *
     * @return $this
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
