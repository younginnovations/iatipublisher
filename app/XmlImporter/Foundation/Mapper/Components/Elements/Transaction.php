<?php

declare(strict_types=1);

namespace App\XmlImporter\Foundation\Mapper\Components\Elements;

use App\XmlImporter\Foundation\Support\Helpers\Traits\XmlHelper;
use Illuminate\Support\Arr;

class Transaction
{
    use XmlHelper;

    /**
     * @var array
     */
    protected array $transaction = [];

    /**
     * Maps reference value.
     *
     * @param $element
     * @param $index
     */
    protected function reference($element, $index): void
    {
        $this->transaction[$index]['reference'] = $this->attributes($element, 'ref');
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
        $this->transaction[$index]['humanitarian'] = $this->attributes($element, 'humanitarian');
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
        $this->transaction[$key]['value'][0]['currency'] = $this->attributes($fields, 'currency');
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
     *
     * @return void
     */
    protected function sector($subElement, $index): void
    {
        $this->transaction[$index]['sector'][0]['sector_vocabulary'] = ($vocabulary = $this->attributes($subElement, 'vocabulary'));
        $this->transaction[$index]['sector'][0]['code'] = ($vocabulary === 1) ? $this->attributes($subElement, 'code') : '';
        $this->transaction[$index]['sector'][0]['category_code'] = ($vocabulary === 2) ? $this->attributes($subElement, 'code') : '';
        $this->transaction[$index]['sector'][0]['text'] = ($vocabulary !== 1 && $vocabulary !== 2) ? $this->attributes($subElement, 'code') : '';
        $this->transaction[$index]['sector'][0]['vocabulary_uri'] = $this->attributes($subElement, 'vocabulary-uri');
        $this->transaction[$index]['sector'][0]['narrative'] = $this->narrative($subElement);
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
        $this->transaction[$index]['recipient_region'][0]['region_code'] = $this->attributes($subElement, 'code');
        $this->transaction[$index]['recipient_region'][0]['region_vocabulary'] = $this->attributes($subElement, 'vocabulary');
        $this->transaction[$index]['recipient_region'][0]['vocabulary_uri'] = $this->attributes($subElement, 'vocabulary-uri');
        $this->transaction[$index]['recipient_region'][0]['narrative'] = $this->narrative($subElement);
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

            foreach ($this->getValue($transaction) as $subElement) {
                $fieldName = $this->name($subElement['name']);
                $this->$fieldName($subElement, $index);
            }
        }

        return $this->transaction;
    }

    /**
     * @param $subElement
     * @param $index
     *
     * @return void
     */
    protected function aidType($subElement, $index): void
    {
        $vocabulary = $this->attributes($subElement, 'vocabulary');
        $code = $this->attributes($subElement, 'code');

        switch ($vocabulary) {
            case '1':
                $this->transaction[$index]['aid_type'][0]['aid_type_code'] = $code;
                break;
            case '2':
                $this->transaction[$index]['aid_type'][0]['earmarking_category'] = $code;
                break;
            case '3':
                $this->transaction[$index]['aid_type'][0]['earmarking_modality'] = $code;
                break;
            case '4':
                $this->transaction[$index]['aid_type'][0]['cash_and_voucher_modalities'] = $code;
                break;
        }

        $this->transaction[$index]['aid_type'][0]['aid_type_vocabulary'] = $vocabulary;
    }
}
