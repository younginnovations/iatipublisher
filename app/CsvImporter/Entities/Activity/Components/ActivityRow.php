<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components;

use App\CsvImporter\Entities\Row;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class ActivityRow.
 */
class ActivityRow extends Row
{
    /**
     * Base Namespace for the Activity Element classes.
     */
    public const BASE_NAMESPACE = 'App\CsvImporter\Entities\Activity\Components\Elements';

    /**
     * Directory where the validated Csv data is written before import.
     */
    public const CSV_DATA_STORAGE_PATH = 'csvImporter/tmp';

    /**
     * File in which the valid Csv data is written before import.
     */
    public const VALID_CSV_FILE = 'valid.json';

    /**
     * File in which the invalid Csv data is written before import.
     */
    public const INVALID_CSV_FILE = 'invalid.json';

    /**
     * Activity Elements for an Activity Row.
     *
     * @var array
     */
    protected array $activityElements = [
        'identifier',
        'title',
        'defaultFieldValues',
        'description',
        'activityStatus',
        'activityDate',
        'participatingOrganization',
        'recipientCountry',
        'recipientRegion',
        'sector',
    ];

    /**
     * Transaction Elements for an Activity Row.
     *
     * @var string
     */
    protected string $transactionElement = 'transaction';

    /**
     * @var array
     */
    protected array $transactionRows = [];

    /**
     * @var array
     */
    protected array $transactionCSVHeaders = [
        'transaction_internal_reference',
        'transaction_type',
        'transaction_date',
        'transaction_value',
        'transaction_value_date',
        'transaction_description',
        'transaction_provider_organisation_identifier',
        'transaction_provider_organisation_type',
        'transaction_provider_organisation_activity_identifier',
        'transaction_provider_organisation_description',
        'transaction_receiver_organisation_identifier',
        'transaction_receiver_organisation_type',
        'transaction_receiver_organisation_activity_identifier',
        'transaction_receiver_organisation_description',
        'transaction_sector_vocabulary',
        'transaction_sector_vocabulary_uri',
        'transaction_sector_code',
        'transaction_sector_narrative',
        'transaction_recipient_country_code',
        'transaction_recipient_region_code',
    ];

    /**
     * @var array
     */
    protected array $otherElements = [
        'activityScope',
        'budget',
        'policyMarker',
        'relatedActivity',
        'contactInfo',
    ];

    /**
     * All Elements for an Activity Row.
     *
     * @var array
     */
    protected array $elements;

    /**
     * Flag for existence of the identifier.
     */
    protected bool $existence = false;

    /**
     * @var
     */
    protected $identifier;

    /**
     * @var
     */
    protected $defaultFieldValues;

    /**
     * @var
     */
    public $title;

    /**
     * @var
     */
    protected $description;

    /**
     * @var
     */
    protected $activityStatus;

    /**
     * @var
     */
    protected $activityDate;

    /**
     * @var
     */
    protected $participatingOrganization;

    /**
     * @var
     */
    public $recipientCountry;

    /**
     * @var
     */
    public $recipientRegion;

    /**
     * @var
     */
    public $sector;

    /**
     * @var array
     */
    protected array $transaction = [];

    /**
     * @var
     */
    protected $budget;

    /**
     * @var
     */
    protected $activityScope;

    /**
     * @var
     */
    protected $policyMarker;

    /**
     * @var array
     */
    protected array $validElements = [];

    /**
     * Current Organization's id.
     */
    public $organizationId;

    /**
     * Current User's id.
     */
    protected $userId;

    /**
     * @var
     */
    protected $activityIdentifiers;

    /**
     * ActivityRow constructor.
     *
     * @param $fields
     * @param $organizationId
     * @param $userId
     * @param $activityIdentifiers
     */
    public function __construct($fields, $organizationId, $userId, $activityIdentifiers)
    {
        $this->fields = $fields;
        $this->organizationId = $organizationId;
        $this->userId = $userId;
        $this->init();
        $this->activityIdentifiers = $activityIdentifiers;
    }

    /**
     * Initialize the Row object.
     */
    public function init()
    {
        $method = $this->getMethodNameByType();

        if (method_exists($this, $method)) {
            $this->$method();
        }
    }

    /**
     * Initiate the ActivityRow elements with Activity, Transaction and Other Fields.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function otherFieldsWithTransaction(): void
    {
        $this->makeActivityElements()->makeTransactionElements()->makeOtherFieldsElements();
    }

    /**
     * Process the Row.
     *
     * @return $this
     */
    public function process(): static
    {
        return $this;
    }

    /**
     * Validate the Row.
     *
     * @return $this
     */
    public function validate(): static
    {
        $this->validateElements()->validateSelf();

        return $this;
    }

    /**
     * Store the Row in a temporary JSON File for further usage.
     *
     * @return void
     */
    public function keep()
    {
        $this->makeDirectoryIfNonExistent()
            ->writeCsvDataAsJson($this->getCsvFilepath());
    }

    /**
     * Get the name of a method according to the type of uploaded Csv.
     *
     * @return string
     */
    protected function getMethodNameByType(): string
    {
        return 'otherFieldsWithTransaction';
    }

    /**
     * Instantiate the Activity Element classes.
     *
     * @return $this
     * @throws BindingResolutionException
     */
    protected function makeActivityElements(): static
    {
        foreach ($this->activityElements() as $element) {
            if (class_exists($namespace = $this->getNamespace($element, self::BASE_NAMESPACE))) {
                if ($element === 'sector') {
                    $this->$element = $this->make($namespace, $this->fields(), $this->organizationId);
                } else {
                    $this->$element = $this->make($namespace, $this->fields());
                }

                if ($element === 'identifier') {
                    $this->$element->setOrganization($this->organizationId);
                }

                $this->elements[] = $element;
            }
        }

        return $this;
    }

    /**
     * Instantiate the Transaction Element classes.
     *
     * @return $this
     * @throws BindingResolutionException
     */
    protected function makeTransactionElements(): static
    {
        $this->mapTransactionData();

        foreach ($this->transactionRows as $transactionRow) {
            if (class_exists($namespace = $this->getNamespace($this->transactionElement(), self::BASE_NAMESPACE))) {
                $this->transaction[] = app()->makeWith($namespace, ['transactionRow' => $transactionRow, 'activityRow' => $this]);
            }
        }

        $this->elements[] = $this->transactionElement();

        return $this;
    }

    /**
     * Instantiate the Other Elements classes.
     *
     * @return $this
     */
    protected function makeOtherFieldsElements(): static
    {
        foreach ($this->otherElements() as $element) {
            if (class_exists($namespace = $this->getNamespace($element, self::BASE_NAMESPACE))) {
                $this->$element = $this->make($namespace, $this->fields());
                $this->elements[] = $element;
            }
        }

        return $this;
    }

    /**
     * Map Transaction data into singular Transaction block for each Activity.
     *
     * @return void
     */
    protected function mapTransactionData(): void
    {
        foreach ($this->fields() as $key => $values) {
            if (array_key_exists($key, array_flip($this->transactionCSVHeaders))) {
                foreach ($values as $index => $value) {
                    $this->transactionRows[$index][$key] = $value;
                }
            }
        }

        $this->removeEmptyTransactionData();
    }

    /**
     * Remove empty Transaction rows.
     *
     * @return void
     */
    protected function removeEmptyTransactionData(): void
    {
        foreach ($this->transactionRows as $index => $transactionRow) {
            $totalNull = 0;
            foreach ($transactionRow as $value) {
                if (!$value) {
                    $totalNull++;
                }
            }

            if ($totalNull === count($this->transactionCSVHeaders)) {
                unset($this->transactionRows[$index]);
            }
        }
    }

    /**
     * Get the Activity elements.
     *
     * @return array
     */
    protected function activityElements(): array
    {
        return $this->activityElements;
    }

    /**
     * Get the Transaction Elements.
     *
     * @return array|string
     */
    protected function transactionElement(): array|string
    {
        return $this->transactionElement;
    }

    /**
     * Get the other Elements.
     *
     * @return array
     */
    protected function otherElements(): array
    {
        return $this->otherElements;
    }

    /**
     * Validate all elements contained in the ActivityRow.
     *
     * @return $this
     */
    protected function validateElements(): static
    {
        foreach ($this->elements() as $element) {
            if ($element === 'transaction') {
                foreach ($this->$element as $transaction) {
                    $transaction->validate()->withErrors();
                    $this->recordErrors($transaction);

                    $this->validElements[] = $transaction->isValid();
                }
            } else {
                $this->$element->validate()->withErrors();
                $this->recordErrors($this->$element);

                $this->validElements[] = $this->$element->isValid();
            }
        }

        return $this;
    }

    /**
     * Set the validity for the whole ActivityRow.
     *
     * @return $this
     */
    protected function validateSelf(): static
    {
        if (in_array(false, $this->validElements, true)) {
            $this->isValid = false;
        } else {
            $this->isValid = true;
        }

        return $this;
    }

    /**
     * Make the storage directory, if it does not exist, to store the validated Csv data before import.
     *
     * @return $this
     */
    protected function makeDirectoryIfNonExistent(): static
    {
        $path = sprintf('%s/%s/', storage_path(self::CSV_DATA_STORAGE_PATH), $this->organizationId);

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        shell_exec(sprintf('chmod 777 -R %s', $path));

        return $this;
    }

    /**
     * Get the file path for the validated Csv data to be stored before import.
     *
     * @return string
     */
    protected function getCsvFilepath(): string
    {
        return storage_path(sprintf('%s/%s/%s', self::CSV_DATA_STORAGE_PATH, $this->organizationId, self::VALID_CSV_FILE));
    }

    /**
     * Get the data in the current ActivityRow.
     *
     * @return array
     */
    protected function data(): array
    {
        $this->data = [];

        foreach ($this->elements() as $element) {
            if ($element === 'transaction') {
                foreach ($this->$element as $transaction) {
                    $this->data[$element][] = $transaction->data($transaction->pluckIndex());
                }
            } else {
                $this->data[Str::snake($element)] = ($element === 'identifier')
                    ? $this->$element->data()
                    : $this->$element->data(Str::snake($this->$element->pluckIndex()));
            }
        }

        return $this->data;
    }

    /**
     * Write the validated data into the designated destination file.
     *
     * @param $destinationFilePath
     *
     * @return void
     */
    protected function writeCsvDataAsJson($destinationFilePath): void
    {
        if (file_exists($destinationFilePath)) {
            $this->appendDataIntoFile($destinationFilePath);
        } else {
            $this->createNewFile($destinationFilePath);
        }
    }

    /**
     * Append data into the file containing previous data.
     *
     * @param $destinationFilePath
     *
     * @return void
     * @throws \JsonException
     */
    protected function appendDataIntoFile($destinationFilePath): void
    {
        if ($currentContents = json_decode(file_get_contents($destinationFilePath), true, 512, JSON_THROW_ON_ERROR)) {
            $currentContents[] = ['data' => $this->data(), 'errors' => $this->errors(), 'status' => 'processed', 'existence' => $this->existence];

            file_put_contents($destinationFilePath, json_encode($currentContents, JSON_THROW_ON_ERROR));
        } else {
            $this->createNewFile($destinationFilePath);
        }
    }

    /**
     * Write the validated data into a new file.
     *
     * @param $destinationFilePath
     *
     * @return void
     * @throws \JsonException
     */
    protected function createNewFile($destinationFilePath): void
    {
        file_put_contents($destinationFilePath, json_encode([['data' => $this->data(), 'errors' => $this->errors(), 'status' => 'processed', 'existence' => $this->existence]], JSON_THROW_ON_ERROR));
        shell_exec(sprintf('chmod 777 -R %s', $destinationFilePath));
    }

    /**
     * Get all the errors associated with the current ActivityRow.
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Record errors within the ActivityRow.
     *
     * @param $element
     */
    protected function recordErrors($element): void
    {
        foreach ($element->errors() as $errors) {
            $this->errors[] = $errors;
        }
    }

    /**
     * Validate unique against Identifiers and Transaction Internal References within the uploaded CSV file.
     *
     * @param $rows
     *
     * @return $this
     */
    public function validateUnique($rows): static
    {
        $commonIdentifierCount = $this->countDuplicateActivityIdentifiers($rows);
        $references = $this->getTransactionInternalReferences();

        if ($this->containsDuplicateActivities($commonIdentifierCount) || $this->containsDuplicateTransactions($references)) {
            $this->isValid = false;
        }

        return $this;
    }

    /**
     * Checks if the activityIdentifiers already exists or not.
     *
     * @param $row
     *
     * @return $this
     */
    public function checkExistence($row): static
    {
        if (array_intersect($this->activityIdentifiers, Arr::get($row, 'activity_identifier', []))) {
            $this->existence = true;
        }

        return $this;
    }

    /**
     * Get the Transactions for the ActivityRow.
     *
     * @return array
     */
    public function getTransactions(): array
    {
        return $this->transaction;
    }

    /**
     * Get all the internal references for an Activity's Transactions.
     *
     * @return array
     */
    protected function getTransactionInternalReferences(): array
    {
        $references = [];

        foreach ($this->getTransactions() as $transaction) {
            if (($reference = Arr::get($transaction->data(), 'transaction.reference')) != '') {
                $references[] = $reference;
            }
        }

        return $references;
    }

    /**
     * Get the count of duplicated Activity Identifiers.
     *
     * @param $rows
     *
     * @return int
     */
    protected function countDuplicateActivityIdentifiers($rows): int
    {
        $commonIdentifierCount = 0;

        foreach ($rows as $row) {
            if (array_key_exists('activity_identifier', $row) && $this->identifier->data() && $this->identifier->data()['activity_identifier'] === Arr::get($row, 'activity_identifier.0')) {
                $commonIdentifierCount++;
            }
        }

        return $commonIdentifierCount;
    }

    /**
     * Check if the Transaction Internal References are duplicated within the uploaded CSV file.
     *
     * @param $references
     *
     * @return bool
     */
    protected function containsDuplicateTransactions($references): bool
    {
        if ((!empty($references)) && (count(array_unique($references)) !== count($this->getTransactions()))) {
            $this->errors[] = 'There are duplicate Transactions for this Activity in the uploaded Csv File.';

            return true;
        }

        return false;
    }

    /**
     * Check if the Activity Identifiers are duplicated within the uploaded CSV file.
     *
     * @param $commonIdentifierCount
     *
     * @return bool
     */
    protected function containsDuplicateActivities($commonIdentifierCount): bool
    {
        if ($commonIdentifierCount > 1) {
            $this->errors[] = 'This Activity has been duplicated in the uploaded Csv File.';

            return true;
        }

        return false;
    }
}
