<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati;

/**
 * Class Element.
 */
abstract class Element
{
    /**
     * @var array
     */
    public array $errors = [];

    /**
     * Index under which the data is stored within the object.
     * @var string
     */
    protected string $index;

    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @var array
     */
    protected array $template = [];

    /**
     * @var
     */
    public $validator;

    /**
     * @var
     */
    protected $isValid;

    /**
     * @var
     */
    protected $factory;

    /**
     * Prepare the IATI Element.
     * @param $fields
     */
    abstract protected function prepare($fields);

    /**
     * Provides the rules for the IATI Element validation.
     * @return array
     */
    abstract public function rules(): array;

    /**
     * Provides custom messages used for IATI Element Validation.
     * @return array
     */
    abstract public function messages(): array;

    /**
     * Validate data for IATI Element.
     */
    abstract public function validate();

    /**
     * Set the validity for the IATI Element data.
     *
     * @return void
     */
    protected function setValidity(): void
    {
        $this->isValid = $this->validator->passes();
    }

    /**
     * @param null $popIndex
     *
     * @return array|int
     */
    public function data($popIndex = null): array|int
    {
        // dump($popIndex);
        // if($popIndex=='activityStatus' || $popIndex=='activityScope'){
        // dump('testdd',$this);
        // }
        if (!$this->data) {
            $this->data = [];
        }

        if (!$popIndex) {
            return $this->data;
        }

        if (array_key_exists($popIndex, $this->data)) {
            return $this->data[$popIndex];
        }

        return [];
    }

    /**
     * Get the template for the IATI Element.
     *
     * @return array
     */
    public function template(): array
    {
        return $this->template;
    }

    /**
     * Load the provided Activity CodeList.
     *
     * @param        $codeList
     * @param string $directory
     *
     * @return array
     * @throws \JsonException
     */
    protected function loadCodeList($codeList, string $directory = 'Activity'): array
    {
        return getCodeList($codeList, $directory, false);
    }

    /**
     * Check the validity of an Element.
     *
     * @return mixed
     */
    public function isElementValid(): mixed
    {
        return $this->isValid;
    }

    /**
     * Get the index under which the data is stored within the object.
     *
     * @return string
     */
    public function pluckIndex(): string
    {
        return $this->index;
    }

    /**
     * Record all errors within the Element classes.
     *
     * @return void
     */
    public function withErrors(): void
    {
        foreach ($this->validator->errors()->getMessages() as $element => $errors) {
            foreach ($errors as $error) {
                $this->errors[] = $error;
            }
        }

        $this->errors = array_unique($this->errors);
    }

    /**
     * Returns error.
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
