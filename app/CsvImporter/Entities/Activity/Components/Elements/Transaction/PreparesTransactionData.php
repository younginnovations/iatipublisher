<?php

declare(strict_types=1);

namespace App\CsvImporter\Entities\Activity\Components\Elements\Transaction;

/**
 * Class PreparesTransactionData.
 */
trait PreparesTransactionData
{
    /**
     * Set Internal Reference for Transaction.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setInternalReference($key, $value): void
    {
        if ($key === $this->_csvHeaders[0]) {
            $this->data['transaction']['reference'] = $value;
        }
    }

    /**
     * Set the Humanitarian field for the Transaction Element.
     *
     * @return void
     */
    protected function setHumanitarian(): void
    {
        if (array_key_exists('reference', $this->data['transaction'])) {
            $this->data['transaction']['humanitarian'] = '';
        }
    }

    /**
     * Set the Transaction Type for the Transaction Element.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setTransactionType($key, $value): void
    {
        if ($key === $this->_csvHeaders[1]) {
            $validTransactionType = $this->loadCodeList('TransactionType', 'Activity');

            if ($value) {
                foreach ($validTransactionType as $code => $name) {
                    if (strcasecmp(trim($value), (string) $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['transaction']['transaction_type'][] = ['transaction_type_code' => $value];
        }
    }

    /**
     * Set the date for the Transaction Element.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setTransactionDate($key, $value): void
    {
        if ($key === $this->_csvHeaders[2]) {
            $this->data['transaction']['transaction_date'][] = ['date' => dateFormat('Y-m-d', $value)];
        }
    }

    /**
     * Set the value for the Transaction Element.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setTransactionValue($key, $value): void
    {
        if ($key === $this->_csvHeaders[3]) {
            $this->data['transaction']['value'][0]['amount'] = str_replace(',', '', (string) $value);
        }
    }

    /**
     * Set the value date for the Transaction Element.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setTransactionValueDate($key, $value): void
    {
        if ($key === $this->_csvHeaders[4]) {
            $this->data['transaction']['value'][0]['date'] = dateFormat('Y-m-d', $value);
            $this->data['transaction']['value'][0]['currency'] = '';
        }
    }

    /**
     * Set the description for the Transaction Element.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setTransactionDescription($key, $value): void
    {
        if ($key === $this->_csvHeaders[5]) {
            $this->data['transaction']['description'][0]['narrative'][0] = ['narrative' => $value, 'language' => ''];
        }
    }

    /**
     * Set the Provider Organization for the Transaction Element.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setProviderOrganization($key, $value): void
    {
        if ($key === $this->_csvHeaders[6]) {
            $this->data['transaction']['provider_organization'][0]['organization_identifier_code'] = $value;
        }
        if ($key === $this->_csvHeaders[7]) {
            $this->data['transaction']['provider_organization'][0]['provider_activity_id'] = $value;
        }
        if ($key === $this->_csvHeaders[8]) {
            $this->data['transaction']['provider_organization'][0]['type'] = $this->setOrganizationTypeNameToCode($value);
        }
        if ($key === $this->_csvHeaders[9]) {
            $this->data['transaction']['provider_organization'][0]['narrative'][0] = ['narrative' => $value, 'language' => ''];
        }
    }

    /**
     * Set the Receiver Organization for the Transaction Element.
     *
     * @param $key
     * @param $value
     *
     * @return void
     * @throws \JsonException
     */
    protected function setReceiverOrganization($key, $value): void
    {
        if ($key === $this->_csvHeaders[10]) {
            $this->data['transaction']['receiver_organization'][0]['organization_identifier_code'] = $value;
        }
        if ($key === $this->_csvHeaders[11]) {
            $this->data['transaction']['receiver_organization'][0]['receiver_activity_id'] = $value;
        }
        if ($key === $this->_csvHeaders[12]) {
            $this->data['transaction']['receiver_organization'][0]['type'] = $this->setOrganizationTypeNameToCode($value);
        }
        if ($key === $this->_csvHeaders[13]) {
            $this->data['transaction']['receiver_organization'][0]['narrative'][0] = ['narrative' => $value, 'language' => ''];
        }
    }

    /**
     * Set the Disbursement Channel for the Transaction Element.
     *
     * @return void
     */
    protected function setDisbursementChannel(): void
    {
        if (array_key_exists('receiver_organization', $this->data['transaction'])) {
            $this->data['transaction']['disbursement_channel'][0] = ['disbursement_channel_code' => ''];
        }
    }

    /**
     * Set the Sector for the Transaction Element.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setSector($key, $value): void
    {
        if ($key === $this->_csvHeaders[14]) {
            $validSectorVocabulary = $this->loadCodeList('SectorVocabulary');

            if ($value) {
                foreach ($validSectorVocabulary as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['transaction']['sector'][0]['sector_vocabulary'] = $value;
        }

        if ($key === $this->_csvHeaders[15]) {
            $this->data['transaction']['sector'][0]['vocabulary_uri'] = $value;
        }

        if ($key === $this->_csvHeaders[16]) {
            $sectorVocabulary = $this->data['transaction']['sector'][0]['sector_vocabulary'];

            $this->setSectorCode($sectorVocabulary, $value);
        }

        if ($key === $this->_csvHeaders[17]) {
            $value = $value ?: '';
            $narrative = [
                'narrative' => $value,
                'language'  => '',
            ];

            $this->data['transaction']['sector'][0]['narrative'][0] = $narrative;
        }
    }

    /**
     * Set the Sector code for the Transaction Element's Sector.
     *
     * @param $sectorVocabulary
     * @param $value
     *
     * @return void
     */
    protected function setSectorCode($sectorVocabulary, $value): void
    {
        if ($sectorVocabulary === '1') {
            $validSectorCode = $this->loadCodeList('SectorCode');

            if ($value) {
                foreach ($validSectorCode as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['transaction']['sector'][0]['code'] = $value;
        } else {
            $this->data['transaction']['sector'][0]['code'] = '';
        }

        if ($sectorVocabulary === '2') {
            $validCategoryCode = $this->loadCodeList('SectorCategory');

            if ($value) {
                foreach ($validCategoryCode as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['transaction']['sector'][0]['category_code'] = $value;
        } else {
            $this->data['transaction']['sector'][0]['category_code'] = '';
        }

        if ($sectorVocabulary === '7') {
            $validSdgGoals = $this->loadCodeList('UNSDG-Goals');

            if ($value) {
                foreach ($validSdgGoals as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['transaction']['sector'][0]['sdg_goal'] = $value;
        } else {
            $this->data['transaction']['sector'][0]['sdg_goal'] = '';
        }

        if ($sectorVocabulary === '8') {
            $validSdgTarget = $this->loadCodeList('UNSDG-Targets');

            if ($value) {
                foreach ($validSdgTarget as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['transaction']['sector'][0]['sdg_target'] = $value;
        } else {
            $this->data['transaction']['sector'][0]['sdg_target'] = '';
        }

        if ($sectorVocabulary !== '1' && $sectorVocabulary !== '2' && $sectorVocabulary !== '7' && $sectorVocabulary !== '8') {
            $this->data['transaction']['sector'][0]['text'] = $value;
        } else {
            $this->data['transaction']['sector'][0]['text'] = '';
        }
    }

    /**
     * Set the Recipient Country for the Transaction Element.
     *
     * @param $key
     * @param $value
     *
     * @void
     */
    protected function setRecipientCountry($key, $value): void
    {
        if ($key === $this->_csvHeaders[18]) {
            $validCountry = $this->loadCodeList('Country');

            if ($value) {
                foreach ($validCountry as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['transaction']['recipient_country'][0]['country_code'] = $value;
            $this->data['transaction']['recipient_country'][0]['narrative'][0] = ['narrative' => '', 'language' => ''];
        }
    }

    /**
     * Set the Recipient Region for the Transaction Element.
     *
     * @param $key
     * @param $value
     *
     * @return void
     */
    protected function setRecipientRegion($key, $value): void
    {
        if ($key === $this->_csvHeaders[19]) {
            $validRegion = $this->loadCodeList('Region');

            if ($value) {
                foreach ($validRegion as $code => $name) {
                    if (strcasecmp(trim($value), $name) === 0) {
                        $value = strval($code);
                        break;
                    }
                }
            }

            $this->data['transaction']['recipient_region'][0]['region_code'] = $value;
            $this->data['transaction']['recipient_region'][0]['region_vocabulary'] = '';
            $this->data['transaction']['recipient_region'][0]['vocabulary_uri'] = '';
            $this->data['transaction']['recipient_region'][0]['narrative'][0] = ['narrative' => '', 'language' => ''];
        }
    }

    /**
     * Set the Flow Type for the Transaction Element.
     *
     * @return void
     */
    protected function setFlowType(): void
    {
        if (array_key_exists('recipient_region', $this->data['transaction'])) {
            $this->data['transaction']['flow_type'][0] = ['flow_type' => ''];
        }
    }

    /**
     * Set the Finance Type for the Transaction Element.
     *
     * @return void
     */
    protected function setFinanceType(): void
    {
        if (array_key_exists('flow_type', $this->data['transaction'])) {
            $this->data['transaction']['finance_type'][0] = ['finance_type' => ''];
        }
    }

    /**
     * Set the Aid Type for the Transaction Element.
     *
     * @return void
     */
    protected function setAidType(): void
    {
        if (array_key_exists('finance_type', $this->data['transaction'])) {
            $this->data['transaction']['aid_type'][0] = ['aid_type_vocabulary' => '', 'aid_type_code' => ''];
        }
    }

    /**
     * Set Ties Status for Transaction Element.
     *
     * @return void
     */
    protected function setTiedStatus(): void
    {
        if (array_key_exists('aid_type', $this->data['transaction'])) {
            $this->data['transaction']['tied_status'][0] = ['tied_status_code' => ''];
        }
    }

    /**
     * Load the provided Activity CodeList.
     *
     * @param        $codeList
     * @param string $directory
     *
     * @return array
     */
    protected function loadCodeList($codeList, $directory = 'Activity'): array
    {
        return getCodeList($codeList, $directory, false);
    }

    /**
     * Set organization type name.
     *
     * @param $value
     *
     * @return mixed
     */
    protected function setOrganizationTypeNameToCode($value): mixed
    {
        $validOrganizationType = $this->loadCodeList('OrganizationType', 'Organization');

        if ($value) {
            foreach ($validOrganizationType as $code => $name) {
                if (strcasecmp(trim($value), $name) === 0) {
                    $value = strval($code);
                    break;
                }
            }
        }

        return $value;
    }
}
