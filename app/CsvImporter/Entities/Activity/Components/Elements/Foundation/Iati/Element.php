<?php

namespace App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati;

/**
 * Class Element.
 */
abstract class Element
{
//    use ManagesErrors;

    public $errors = [];

    /**
     * Index under which the data is stored within the object.
     * @var string
     */
    protected $index;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $template = [];

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
     */
    protected function setValidity()
    {
        $this->isValid = $this->validator->passes();
    }

    /**
     * @param null $popIndex
     * @return array
     */
    public function data($popIndex = null)
    {
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
     * @return array
     */
    public function template()
    {
        return $this->template;
    }

    /**
     * Load the provided Activity CodeList.
     * @param        $codeList
     * @param string $directory
     * @return array
     */
    protected function loadCodeList($codeList, $directory = 'Activity'): array
    {
        return getCodeList($codeList, $directory);
    }

    /**
     * Check the validity of an Element.
     * @return mixed
     */
    public function isValid(): mixed
    {
        return $this->isValid;
    }

    /**
     * Get the index under which the data is stored within the object.
     * @return mixed
     */
    public function pluckIndex(): mixed
    {
        return $this->index;
    }

    /**
     * Record all errors within the Element classes.
     */
    public function withErrors()
    {
        foreach ($this->validator->errors()->getMessages() as $element => $errors) {
            foreach ($errors as $error) {
                $this->errors[] = $error;
            }
        }

        $this->errors = array_unique($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }
}
