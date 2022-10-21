<?php

declare(strict_types=1);

namespace App\XmlImporter\Foundation\Mapper\Components;

use App\XmlImporter\Foundation\Mapper\Components\Elements\Result;
use App\XmlImporter\Foundation\Mapper\Components\Elements\Transaction;
use App\XmlImporter\Foundation\Support\Helpers\Traits\XmlHelper;
use App\XmlImporter\Foundation\XmlQueueWriter;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;

/**
 * Class XmlMapper.
 */
class XmlMapper
{
    use XmlHelper;

    /**
     * @var
     */
    protected $activity;

    /**
     * @var array
     */
    protected $iatiActivity;

    /**
     * @var array
     */
    protected array $transaction = [];

    /**
     * @var Transaction
     */
    protected Transaction $transactionElement;

    /**
     * @var
     */
    protected $resultElement;

    /**
     * @var array
     */
    protected array $result = [];

    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @var array
     */
    protected array $activityElements = [
        'iatiIdentifier',
        'otherIdentifier',
        'reportingOrg',
        'title',
        'description',
        'activityStatus',
        'activityDate',
        'activityScope',
        'contactInfo',
        'participatingOrg',
        'tag',
        'recipientCountry',
        'recipientRegion',
        'sector',
        'collaborationType',
        'defaultFlowType',
        'defaultFinanceType',
        'defaultAidType',
        'defaultTiedStatus',
        'budget',
        'location',
        'plannedDisbursement',
        'countryBudgetItems',
        'documentLink',
        'policyMarker',
        'conditions',
        'legacyData',
        'humanitarianScope',
        'collaborationType',
        'capitalSpend',
        'relatedActivity',
    ];

    /**
     * Xml constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * Initialize XmlMapper components according to the Xml Version.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function initComponents(): void
    {
        $this->iatiActivity = [];
        $this->activity = app()->make(Activity::class);
        $this->transactionElement = app()->make(Transaction::class);
        $this->resultElement = app()->make(Result::class);
    }

    /**
     * Map raw Xml data into AidStream database compatible data for import.
     *
     * @param array $activities
     * @param       $template
     * @param       $userId
     * @param       $orgId
     * @param       $dbIatiIdentifiers
     *
     * @return $this
     * @throws BindingResolutionException
     */
    public function map(array $activities, $template, $userId, $orgId, $dbIatiIdentifiers): static
    {
        $xmlQueueWriter = app()->makeWith(XmlQueueWriter::class, ['userId' => $userId, 'orgId' => $orgId, 'dbIatiIdentifiers' => $dbIatiIdentifiers]);

        $totalActivities = count($activities);
        $mappedData = [];
        file_put_contents('valid_test.json', sprintf('%s%s%s', 'Total Activities: ', $totalActivities, PHP_EOL), FILE_APPEND);

        foreach ($activities as $index => $activity) {
            $this->initComponents();
            $mappedData[$index] = $this->activity->map($this->filter($activity, 'iatiActivity'), $template);
            $mappedData[$index]['default_field_values'] = $this->defaultFieldValues($activity, $template);
            $mappedData[$index]['transactions'] = $this->transactionElement->map($this->filter($activity, 'transaction'), $template);
            $mappedData[$index]['result'] = $this->resultElement->map($this->filter($activity, 'result'), $template);

            $xmlQueueWriter->save($mappedData[$index], $totalActivities, $index);
        }

        return $this;
    }

    /**
     * Returns false if the xml is not activity file.
     *
     * @param $activities
     *
     * @return bool
     */
    public function isValidActivityFile($activities): bool
    {
        foreach ($activities as $activity) {
            if ($this->name(Arr::get($activity, 'name')) !== 'iatiActivity') {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the mapped Xml data.
     *
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * Store the mapped Xml data in a temporary json file.
     */
    public function keep(): void
    {
    }

    /**
     * Filter the default field values from the xml data.
     *
     * @param $activity
     * @param $template
     *
     * @return array
     */
    protected function defaultFieldValues($activity, $template): array
    {
        $defaultFieldValues[0] = $template['default_field_values'];
        $defaultFieldValues[0]['default_currency'] = $this->attributes($activity, 'default-currency');
        $defaultFieldValues[0]['default_language'] = $this->attributes($activity, 'language');
        $defaultFieldValues[0]['default_hierarchy'] = $this->attributes($activity, 'hierarchy');
        $defaultFieldValues[0]['linked_data_uri'] = $this->attributes($activity, 'linked-data-uri');
        $defaultFieldValues[0]['humanitarian'] = $this->attributes($activity, 'humanitarian');

        return $defaultFieldValues;
    }

    /**
     * Filter raw Xml data for a certain element with a specific elementName.
     *
     * @param $xmlData
     * @param $elementName
     *
     * @return mixed
     */
    protected function filter($xmlData, $elementName): mixed
    {
        [$this->transaction, $this->result] = [[], []];
        foreach ($this->value($xmlData) as $subElement) {
            if ($elementName === 'transaction') {
                $this->filterForTransactions($subElement, $elementName);
            } elseif ($elementName === 'result') {
                $this->filterForResults($subElement, $elementName);
            } elseif ($elementName === 'iatiActivity') {
                $this->filterForActivity($subElement, $elementName);
            }
        }

        return $this->{$elementName};
    }

    /**
     * Filter data for Activity Elements.
     *
     * @param $subElement
     * @param $elementName
     *
     * @return void
     */
    protected function filterForActivity($subElement, $elementName): void
    {
        if (in_array($this->name($subElement), $this->activityElements, true)) {
            $this->{$elementName}[] = $subElement;
        }
    }

    /**
     * Filter data for Transactions Elements.
     *
     * @param $subElement
     * @param $elementName
     *
     * @return void
     */
    protected function filterForTransactions($subElement, $elementName): void
    {
        if ($this->name($subElement) === $elementName) {
            $this->{$elementName}[] = $subElement;
        }
    }

    /**
     * @param $subElement
     * @param $elementName
     *
     * @return void
     */
    protected function filterForResults($subElement, $elementName): void
    {
        if ($this->name($subElement) === $elementName) {
            $this->{$elementName}[] = $subElement;
        }
    }
}
