<?php

namespace App\Services\CsvImporter;

use App\CsvImporter\Entities\Activity\Transaction\Transaction;
use App\CsvImporter\Traits\ChecksCsvHeaders;
use Illuminate\Support\Arr;

/**
 * Class TransactionCsvProcessor.
 */
class TransactionCsvProcessor
{
    use ChecksCsvHeaders;

    /**
     * @var array
     */
    protected $csv;

    /**
     * @var
     */
    protected $data;

    /**
     * @var
     */
    protected $transaction;

    /**
     * Header count of V201 simple transaction.
     */
    const V201_SIMPLE_TRANSACTION_HEADERS_COUNT = 17;
    /**
     * Header count of V201 detailed transaction.
     */
    const V201_DETAILED_TRANSACTION_HEADERS_COUNT = 22;
    /**
     * Header count of V202 simple transaction.
     */
    const V202_SIMPLE_TRANSACTION_HEADERS_COUNT = 20;
    /**
     * Header count of V202 detailed transaction.
     */
    const V202_DETAILED_TRANSACTION_HEADERS_COUNT = 25;

    /**
     * Header count of V203 simple transaction.
     */
    const V203_SIMPLE_TRANSACTION_HEADERS_COUNT = 21;

    /**
     * Header count of V203 detailed transaction.
     */
    const V203_DETAILED_TRANSACTION_HEADERS_COUNT = 27;

    /**
     * TransactionCsvProcessor constructor.
     * @param array $csv
     */
    public function __construct(array $csv)
    {
        $this->csv = $csv;
    }

    /**
     * Checks the header of the uploaded csv.
     * If Correct starts the mapping process.
     * If incorrect writes the header mismatch status in json file.
     *
     * @param $orgId
     * @param $activityId
     * @param $userId
     * @param $version
     * @throws \Exception
     */
    public function handle($orgId, $activityId, $userId, $version)
    {
        try {
            $this->filterHeader();

            $this->initTransaction(
                [
                    'organization_id' => $orgId,
                    'activity_id'     => $activityId,
                    'user_id'         => $userId,
                    'version'         => $version,
                ]
            );
            $dataWriter = $this->transaction->dataWriterClass();

            if ($this->isCorrectCsv($version)) {
                $this->transaction->process();
            } else {
                if (!$this->csv) {
                    $dataWriter->storeStatus('no_data_available');
                } else {
                    $dataWriter->storeStatus('header_mismatch');
                }
            }
        } catch (\Exception $exception) {
            $dataWriter->storeStatus('complete');
            throw  $exception;
        }
    }

    /**
     * Checks if the csv is correct.
     *
     * @return bool
     */
    protected function isCorrectCsv($version)
    {
        return $this->hasCorrectTransactionHeaders($version);
    }

    /**
     * Checks the transaction headers with the uploaded csv headers.
     *
     * @return bool
     */
    protected function hasCorrectTransactionHeaders($version = 'V201')
    {
        $csvHeaders = array_keys(Arr::get((array) $this->csv, [0], []));

        if ($this->headerCountMatches($csvHeaders, self::V203_SIMPLE_TRANSACTION_HEADERS_COUNT)) {
            return $this->checkHeadersFor($csvHeaders, 'simple_transaction_headers', 'V203');
        }

        if ($this->headerCountMatches($csvHeaders, self::V203_DETAILED_TRANSACTION_HEADERS_COUNT)) {
            return $this->checkHeadersFor($csvHeaders, 'detailed_transaction_headers', 'V203');
        }

        return false;
    }

    /**
     * Filter unwanted keys generated while copying and pasting csv headers. For ex 0 index.
     * @return mixed
     */
    protected function filterHeader()
    {
        foreach ($this->csv as $index => $csvHeaders) {
            foreach ($csvHeaders as $headerIndex => $header) {
                if ($headerIndex === 0) {
                    unset($this->csv[$index][$headerIndex]);
                }
            }
        }
    }

    /**
     * Instantiate transaction class that starts mapping process.
     *
     * @param array $options
     */
    protected function initTransaction(array $options = [])
    {
        if (class_exists(Transaction::class)) {
            $this->transaction = new Transaction(
                $this->csv,
                Arr::get($options, 'organization_id'),
                Arr::get($options, 'activity_id'),
                Arr::get($options, 'user_id'),
                Arr::get($options, 'version')
            );
        }
    }
}
