<?php

declare(strict_types=1);

namespace App\XmlImporter\Foundation\Mapper\Components\Elements;

use App\XmlImporter\Foundation\Support\Helpers\Traits\XmlHelper;
use Illuminate\Support\Arr;

/**
 * Class Transaction.
 */
class Transaction
{
    use XmlHelper;

    /**
     * @var array
     */
    protected array $transaction = [];

    /**
     * @var array
     */
    protected array $reference = [];

    /**
     * @var array
     */
    protected array $sectorVariables = [
        'sector_vocabulary',
        'code',
        'category_code',
        'text',
        'vocabulary_uri',
        'sdg_goal',
        'sdg_target',
        'narrative',
    ];

    /**
     * @var array
     */
    protected array $aidTypeVariables = [
        'aid_type_code',
        'aid_type_vocabulary',
        'earmarking_category',
        'earmarking_modality',
        'cash_and_voucher_modalities',
    ];

    /**
     * Maps reference value.
     *
     * @param $element
     * @param $index
     */
    protected function reference($element, $index): void
    {
        $this->transaction[$index]['reference'] = $this->attributes($element, 'ref');

        if ($this->attributes($element, 'ref')) {
            $this->reference[] = $this->attributes($element, 'ref');
        }
    }

    /**
     * Return array containing references of transaction.
     *
     * @return array
     */
    public function getReferences(): array
    {
        return $this->reference;
    }

    /**
     * Maps humanitarian value.
     *
     * @param $element
     * @param $index
     *
     * @return void
     */
    protected function humanitarian($element, $index): void
    {
        $humanitarian = $this->attributes($element, 'humanitarian');
        $humanitarianValue = '';

        if ((is_string($humanitarian) && strtolower($humanitarian) === 'true') || $humanitarian === '1') {
            $humanitarianValue = '1';
        }

        if ((is_string($humanitarian) && strtolower($humanitarian) === 'false') || $humanitarian === '0') {
            $humanitarianValue = '0';
        }

        $this->transaction[$index]['humanitarian'] = $humanitarianValue;
    }

    /**
     * Maps transaction type value.
     *
     * @param $subElement
     * @param $index
     *
     * @return void
     */
    protected function transactionType($subElement, $index): void
    {
        $this->transaction[$index]['transaction_type'][0]['transaction_type_code'] = $this->attributes($subElement, 'code');
    }

    /**
     * Maps transaction date value.
     *
     * @param $subElement
     * @param $index
     *
     * @return void
     */
    protected function transactionDate($subElement, $index): void
    {
        $this->transaction[$index]['transaction_date'][0]['date'] = dateFormat('Y-m-d', $this->attributes($subElement, 'iso-date'));
    }

    /**
     * Maps value attributes.
     *
     * @param $fields
     * @param $key
     *
     * @return void
     */
    protected function value($fields, $key): void
    {
        $this->transaction[$key]['value'][0]['amount'] = $this->getValue($fields);
        $this->transaction[$key]['value'][0]['date'] = dateFormat('Y-m-d', $this->attributes($fields, 'value-date'));
        $this->transaction[$key]['value'][0]['currency'] = strtoupper($this->attributes($fields, 'currency'));
    }

    /**
     * Maps description value.
     *
     * @param $subElement
     * @param $index
     *
     * @return void
     */
    protected function description($subElement, $index): void
    {
        $this->transaction[$index]['description'][0]['narrative'] = $this->narrative($subElement);
    }

    /**
     * Maps provider org attributes.
     *
     * @param $subElement
     * @param $index
     *
     * @return void
     */
    protected function providerOrg($subElement, $index): void
    {
        $this->transaction[$index]['provider_organization'][0]['organization_identifier_code'] = $this->attributes($subElement, 'ref');
        $this->transaction[$index]['provider_organization'][0]['type'] = $this->attributes($subElement, 'type');
        $this->transaction[$index]['provider_organization'][0]['provider_activity_id'] = $this->attributes($subElement, 'provider-activity-id');
        $this->transaction[$index]['provider_organization'][0]['narrative'] = $this->narrative($subElement);
    }

    /**
     * Maps receiver org attributes.
     *
     * @param $subElement
     * @param $index
     *
     * @return void
     */
    protected function receiverOrg($subElement, $index): void
    {
        $this->transaction[$index]['receiver_organization'][0]['organization_identifier_code'] = $this->attributes($subElement, 'ref');
        $this->transaction[$index]['receiver_organization'][0]['type'] = $this->attributes($subElement, 'type');
        $this->transaction[$index]['receiver_organization'][0]['receiver_activity_id'] = $this->attributes($subElement, 'receiver-activity-id');
        $this->transaction[$index]['receiver_organization'][0]['narrative'] = $this->narrative($subElement);
    }

    /**
     * @param $subElement
     * @param $index
     *
     * @return void
     */
    protected function disbursementChannel($subElement, $index): void
    {
        $this->transaction[$index]['disbursement_channel'][0]['disbursement_channel_code'] = $this->attributes($subElement, 'code');
    }

    /**
     * Maps sector attributes.
     *
     * @param $subElement
     * @param $index
     * @param $sub_index
     *
     * @return void
     */
    protected function sector($subElement, $index, $sub_index): void
    {
        $this->transaction[$index]['sector'][$sub_index]['sector_vocabulary'] = ($vocabulary = (string) $this->attributes($subElement, 'vocabulary'));
        $this->transaction[$index]['sector'][$sub_index]['code'] = ($vocabulary === '1') ? $this->attributes($subElement, 'code') : '';
        $this->transaction[$index]['sector'][$sub_index]['category_code'] = ($vocabulary === '2') ? $this->attributes($subElement, 'code') : '';
        $this->transaction[$index]['sector'][$sub_index]['text'] = ($vocabulary !== '1' && $vocabulary !== '2') ? $this->attributes($subElement, 'code') : '';
        $this->transaction[$index]['sector'][$sub_index]['vocabulary_uri'] = $this->attributes($subElement, 'vocabulary-uri');
        $this->transaction[$index]['sector'][$sub_index]['narrative'] = $this->narrative($subElement);
    }

    /**
     * Maps recipient country attributes.
     *
     * @param $subElement
     * @param $index
     *
     * @return void
     */
    protected function recipientCountry($subElement, $index): void
    {
        $this->transaction[$index]['recipient_country'][0]['country_code'] = $this->attributes($subElement, 'code');
        $this->transaction[$index]['recipient_country'][0]['narrative'] = $this->narrative($subElement);
    }

    /**
     * Maps recipient region attributes.
     *
     * @param $subElement
     * @param $index
     *
     * @return void
     */
    protected function recipientRegion($subElement, $index): void
    {
        $this->transaction[$index]['recipient_region'][0]['region_vocabulary'] = $this->attributes($subElement, 'vocabulary');
        $this->transaction[$index]['recipient_region'][0]['vocabulary_uri'] = $this->attributes($subElement, 'vocabulary-uri');
        $this->transaction[$index]['recipient_region'][0]['narrative'] = $this->narrative($subElement);

        if ($this->attributes($subElement, 'vocabulary') === '1') {
            $this->transaction[$index]['recipient_region'][0]['region_code'] = $this->attributes($subElement, 'code');
        } else {
            $this->transaction[$index]['recipient_region'][0]['custom_code'] = $this->attributes($subElement, 'code');
        }
    }

    /**
     * Maps flow type attributes.
     *
     * @param $subElement
     * @param $index
     *
     * @return void
     */
    protected function flowType($subElement, $index): void
    {
        $this->transaction[$index]['flow_type'][0]['flow_type'] = $this->attributes($subElement, 'code');
    }

    /**
     * Maps finance type attributes.
     *
     * @param $subElement
     * @param $index
     *
     * @return void
     */
    protected function financeType($subElement, $index): void
    {
        $this->transaction[$index]['finance_type'][0]['finance_type'] = $this->attributes($subElement, 'code');
    }

    /**
     * Maps tied status attributes.
     *
     * @param $subElement
     * @param $index
     *
     * @return void
     */
    protected function tiedStatus($subElement, $index): void
    {
        $this->transaction[$index]['tied_status'][0]['tied_status_code'] = $this->attributes($subElement, 'code');
    }

    /**
     * Gets all the attributes present in the transaction element.
     *
     * @param array $element
     *
     * @return mixed
     */
    protected function getValue(array $element): mixed
    {
        return Arr::get($element, 'value', []);
    }

    /**
     * Map raw Xml Transaction data for import.
     *
     * @param array $transactions
     * @param       $template
     *
     * @return array
     */
    public function map(array $transactions, $template): array
    {
        foreach ($transactions as $index => $transaction) {
            $this->transaction[$index] = $template['transaction'];
            $this->reference($transaction, $index);
            $this->humanitarian($transaction, $index);

            foreach ($this->getValue($transaction) as $sub_index => $subElement) {
                $fieldName = $this->name($subElement['name']);
                $this->$fieldName($subElement, $index, $sub_index);
            }
        }

        return $this->sanitizeTransactions();
    }

    /**
     * @param $subElement
     * @param $index
     * @param $sub_index
     *
     * @return void
     */
    protected function aidType($subElement, $index, $sub_index): void
    {
        $vocabulary = $this->attributes($subElement, 'vocabulary');
        $code = $this->attributes($subElement, 'code');

        switch ($vocabulary) {
            case '1':
                $this->transaction[$index]['aid_type'][$sub_index]['aid_type_code'] = $code;
                break;
            case '2':
                $this->transaction[$index]['aid_type'][$sub_index]['earmarking_category'] = $code;
                break;
            case '3':
                $this->transaction[$index]['aid_type'][$sub_index]['earmarking_modality'] = $code;
                break;
            case '4':
                $this->transaction[$index]['aid_type'][$sub_index]['cash_and_voucher_modalities'] = $code;
                break;
            default:
                $this->transaction[$index]['aid_type'][$sub_index]['aid_type_code'] = $code;
        }

        $this->transaction[$index]['aid_type'][$sub_index]['aid_type_vocabulary'] = $vocabulary;
    }

    /**
     * Returns sanitized transaction elements for those required.
     *
     * @return array
     */
    public function sanitizeTransactions(): array
    {
        foreach ($this->transaction as $index => $transaction) {
            $this->transaction[$index]['sector'] = $this->sanitizeTransactionData($transaction, $index, 'sector', $this->sectorVariables);
            $this->transaction[$index]['aid_type'] = $this->sanitizeTransactionData($transaction, $index, 'aid_type', $this->aidTypeVariables);
        }

        return $this->transaction;
    }

    /**
     * Sanitizes transaction data.
     *
     * @param $transaction
     * @param $index
     * @param string $element
     * @param array $variables
     *
     * @return array
     */
    public function sanitizeTransactionData($transaction, $index, string $element, array $variables): array
    {
        foreach (Arr::get($transaction, $element, []) as $key => $component) {
            if ($this->checkIfEmpty($component, $variables)) {
                unset($this->transaction[$index][$element][$key]);
            }
        }

        return array_values($this->transaction[$index][$element]);
    }

    /**
     * Checks if all parts of an element are empty.
     *
     * @param $element
     * @param $elementVariables
     *
     * @return bool
     */
    public function checkIfEmpty($element, $elementVariables): bool
    {
        foreach ($elementVariables as $variable) {
            if ($variable !== 'narrative' && !empty(Arr::get($element, $variable, null))) {
                return false;
            }

            if ($variable === 'narrative') {
                foreach (Arr::get($element, 'narrative', []) as $narrative) {
                    if (
                        !empty(Arr::get($narrative, 'narrative')) ||
                        !empty(Arr::get($narrative, 'language'))
                    ) {
                        return false;
                    }
                }
            }
        }

        return true;
    }
}
