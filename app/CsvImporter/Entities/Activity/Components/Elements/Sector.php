<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements;

use App\CsvImporter\Entities\Activity\Components\Elements\Foundation\Iati\Element;
use App\CsvImporter\Entities\Activity\Components\Factory\Validation;
use App\Http\Requests\Activity\Sector\SectorRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;

/**
 * Class Sector.
 */
class Sector extends Element
{
    /**
     * @var null|string
     */
    protected ?string $type;

    /**
     * CSV Header of Description with their code.
     */
    private array $_csvHeaders = ['sector_vocabulary', 'sector_code', 'sector_percentage', 'sector_vocabulary_uri', 'sector_narrative'];

    /**
     * Index under which the data is stored within the object.
     * @var string
     */
    protected string $index = 'sector';

    /**
     * @var array
     */
    protected array $vocabularies = [];

    /**
     * @var array
     */
    protected array $codes = [];

    /**
     * @var array
     */
    protected array $percentage = [];

    /**
     * @var array
     */
    protected array $template = [
        [
            'sector_vocabulary'    => '',
            'vocabulary_uri'       => '',
            'code'          => '',
            'category_code' => '',
            'sdg_goal'      => '',
            'sdg_target'    => '',
            'text'          => '',
            'percentage'           => '',
            'narrative'            => ['narrative' => '', 'language' => ''],
        ],
    ];

    /**
     * @var SectorRequest
     */
    private SectorRequest $request;

    /**
     * Description constructor.
     * @param            $fields
     * @param Validation $factory
     */
    public function __construct($fields, Validation $factory)
    {
        $this->prepare($fields);
        $this->factory = $factory;
        $this->type = $this->getCsvType($fields);
        $this->request = new SectorRequest();
    }

    /**
     * Prepare data for Sector Element.
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
                    $this->map($key, $value, $index);
                }
            }
        }
    }

    /**
     * Map data from CSV File to Sector data format.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    public function map($key, $value, $index): void
    {
        if (!(is_null($value) || $value === '')) {
            $this->setSectorVocabulary($key, $value, $index);
            $this->setVocabularyUri($key, $value, $index);
            $this->setSectorCode($key, $value, $index);
            $this->setSectorPercentage($key, $value, $index);
            $this->setNarrative($key, $value, $index);
        }
    }

    /**
     * Set sector vocabulary for Sector.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setSectorVocabulary($key, $value, $index): void
    {
        if (!isset($this->data['sector'][$index]['sector_vocabulary'])) {
            $this->data['sector'][$index]['sector_vocabulary'] = '';
        }

        if ($key === $this->_csvHeaders[0]) {
            $value = is_null($value) ? '' : trim($value);
            $this->vocabularies[] = $value;

            $validSectorVocab = $this->loadCodeList('SectorVocabulary');

            if ($value) {
                foreach ($validSectorVocab as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['sector'][$index]['sector_vocabulary'] = $value;
        }
    }

    /**
     * Set sector code for Sector.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setSectorCode($key, $value, $index): void
    {
        if (!isset($this->data['sector'][$index]['text'])) {
            $this->data['sector'][$index]['text'] = '';
        }

        if ($key === $this->_csvHeaders[1]) {
            $sectorVocabulary = Arr::get($this->data['sector'], $index . '.sector_vocabulary', null);

            if ($sectorVocabulary === '1') {
                $value = $value ? trim($value) : '';
                $this->codes[] = $value;
                $validSectorCode = $this->loadCodeList('SectorCode');

                if ($value) {
                    foreach ($validSectorCode as $code => $name) {
                        if (strcasecmp($value, $name) === 0) {
                            $value = (string) $code;
                            break;
                        }
                    }
                }

                $this->data['sector'][$index]['code'] = $value;
            } elseif ($sectorVocabulary === '2') {
                $this->setSectorCategoryCode($value, $index);
            } elseif ($sectorVocabulary === '7') {
                $this->setSectorSdgGoal($value, $index);
            } elseif ($sectorVocabulary === '8') {
                $this->setSectorSdgTarget($value, $index);
            } else {
                $this->setSectorText($value, $index);
            }
        }
    }

    /**
     * Set vocabulary uri for Sector.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setVocabularyUri($key, $value, $index): void
    {
        if ($key === $this->_csvHeaders[3] && (Arr::get($this->data(), 'sector.' . $index . '.sector_vocabulary') === '98' || Arr::get($this->data(), 'sector.' . $index . '.sector_vocabulary') === '99')) {
            $this->data['sector'][$index]['vocabulary_uri'] = $value;
        }
    }

    /**
     * Set sector category code for Sector.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setSectorCategoryCode($value, $index): void
    {
        $validCategoryCode = $this->loadCodeList('SectorCategory');
        $value = $value ? trim($value) : '';

        if ($value) {
            foreach ($validCategoryCode as $code => $name) {
                if (strcasecmp($value, $name) === 0) {
                    $value = (string) $code;
                    break;
                }
            }
        }

        $this->data['sector'][$index]['category_code'] = $value;
    }

    /**
     * Set sector sdg goal for Sector.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setSectorSdgGoal($value, $index): void
    {
        $validSdgGoal = $this->loadCodeList('UNSDG-Goals');

        foreach ($validSdgGoal as $code => $name) {
            if ($value === $name) {
                $value = (string) $code;
                break;
            }
        }

        $this->data['sector'][$index]['sdg_goal'] = $value;
    }

    /**
     * Set sector sdg target for Sector.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setSectorSdgTarget($value, $index): void
    {
        $validSdgTarget = $this->loadCodeList('UNSDG-Targets');

        foreach ($validSdgTarget as $code => $name) {
            if ($value === $name) {
                $value = (string) $code;
                break;
            }
        }
        $this->data['sector'][$index]['sdg_target'] = $value;
    }

    /**
     * Set sector text for Sector.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setSectorText($value, $index): void
    {
        ($value) ?: $value = '';
        $this->codes[] = $value;
        $this->data['sector'][$index]['text'] = $value;
    }

    /**
     * Set sector percentage for Sector.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setSectorPercentage($key, $value, $index): void
    {
        if (!isset($this->data['sector'][$index]['percentage'])) {
            $this->data['sector'][$index]['percentage'] = '';
        }

        if ($key === $this->_csvHeaders[2]) {
            ($value) ?: $value = '';
            $this->percentage[] = $value;
            $this->data['sector'][$index]['percentage'] = $value;
        }
    }

    /**
     * Set narrative for Sector.
     *
     * @param $key
     * @param $value
     * @param $index
     *
     * @return void
     */
    protected function setNarrative($key, $value, $index): void
    {
        if (!isset($this->data['sector'][$index]['narrative'][0]['narrative'])) {
            $this->data['sector'][$index]['narrative'][0] = [
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

            $this->data['sector'][$index]['narrative'][0] = $narrative;
            $this->isEmptySector($index);
        }
    }

    /**
     * Check if the sector array is empty.
     *
     * @param $index
     *
     * @return void
     */
    protected function isEmptySector($index): void
    {
        if (
            Arr::get($this->data['sector'], $index . '.sector_vocabulary', false)
            && Arr::get($this->data['sector'], $index . '.vocabulary_uri', false)
            && Arr::get($this->data['sector'], $index . '.code', false)
            && Arr::get($this->data['sector'], $index . '.category_code', false)
            && Arr::get($this->data['sector'], $index . '.sdg_goal', false)
            && Arr::get($this->data['sector'], $index . '.sdg_target', false)
            && Arr::get($this->data['sector'], $index . '.text', false)
            && Arr::get($this->data['sector'], $index . '.percentage', false)
        ) {
            unset($this->data['sector'][$index]);
        }
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

    /**
     * Provides the rules for the IATI Element validation.
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function rules(): array
    {
        return $this->request->getSectorsRules(Arr::get($this->data(), 'sector', []), true);
    }

    /**
     * Provides the critical rules for the IATI Element validation.
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function errorRules(): array
    {
        return $this->request->getErrorsForSector(Arr::get($this->data(), 'sector', []), true);
    }

    /**
     * Provides custom messages used for IATI Element Validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return $this->request->getSectorsMessages(Arr::get($this->data(), 'sector', []));
    }

    /**
     * Return Valid Sector Vocabulary Code.
     *
     * @param $name
     *
     * @return array
     * @throws \JsonException
     */
    protected function validSectorCodeList($name): array
    {
        return array_keys($this->loadCodeList($name));
    }

    /**
     * @param $fields
     *
     * @return string|null
     */
    protected function getCsvType($fields): ?string
    {
        if (count($fields) === getCsvHeaderCount()) {
            return 'activity';
        }

        return null;
    }
}
