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
        if (!isset($this->data['transaction']['reference'])) {
            $this->data['transaction']['reference'] = '';
        }

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
        if (!isset($this->data['transaction']['humanitarian'])) {
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
        if (!isset($this->data['transaction']['transaction_type'][0]['transaction_type_code'])) {
            $this->data['transaction']['transaction_type'][0]['transaction_type_code'] = '';
        }

        if ($key === $this->_csvHeaders[1]) {
            $validTransactionType = $this->loadCodeList('TransactionType', 'Activity');
            $value = $value ? trim($value) : '';

            if ($value) {
                foreach ($validTransactionType as $code => $name) {
                    if (strcasecmp($value, (string) $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            $this->data['transaction']['transaction_type'][0] = ['transaction_type_code' => $value];
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
        if (!isset($this->data['transaction']['transaction_date'][0]['date'])) {
            $this->data['transaction']['transaction_date'][0]['date'] = '';
        }

        if ($key === $this->_csvHeaders[2]) {
            $this->data['transaction']['transaction_date'][0] = ['date' => dateFormat('Y-m-d', $value)];
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
        if (!isset($this->data['transaction']['value'][0]['amount'])) {
            $this->data['transaction']['value'][0]['amount'] = '';
        }

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
        if (!isset($this->data['transaction']['value'][0]['date'])) {
            $this->data['transaction']['value'][0]['date'] = '';
        }

        if (!isset($this->data['transaction']['value'][0]['currency'])) {
            $this->data['transaction']['value'][0]['currency'] = '';
        }

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
        if (!isset($this->data['transaction']['description'][0]['narrative'][0]['narrative'])) {
            $this->data['transaction']['description'][0]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

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
        if (!isset($this->data['transaction']['provider_organization'][0]['organization_identifier_code'])) {
            $this->data['transaction']['provider_organization'][0]['organization_identifier_code'] = '';
        }

        if (!isset($this->data['transaction']['provider_organization'][0]['provider_activity_id'])) {
            $this->data['transaction']['provider_organization'][0]['provider_activity_id'] = '';
        }

        if (!isset($this->data['transaction']['provider_organization'][0]['type'])) {
            $this->data['transaction']['provider_organization'][0]['type'] = '';
        }

        if (!isset($this->data['transaction']['provider_organization'][0]['narrative'][0]['narrative'])) {
            $this->data['transaction']['provider_organization'][0]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

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
        if (!isset($this->data['transaction']['receiver_organization'][0]['organization_identifier_code'])) {
            $this->data['transaction']['receiver_organization'][0]['organization_identifier_code'] = '';
        }

        if (!isset($this->data['transaction']['receiver_organization'][0]['receiver_activity_id'])) {
            $this->data['transaction']['receiver_organization'][0]['receiver_activity_id'] = '';
        }

        if (!isset($this->data['transaction']['receiver_organization'][0]['type'])) {
            $this->data['transaction']['receiver_organization'][0]['type'] = '';
        }

        if (!isset($this->data['transaction']['receiver_organization'][0]['narrative'][0]['narrative'])) {
            $this->data['transaction']['receiver_organization'][0]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

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
        if (!isset($this->data['transaction']['disbursement_channel'][0]['disbursement_channel_code'])) {
            $this->data['transaction']['disbursement_channel'][0]['disbursement_channel_code'] = '';
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
        if (!isset($this->data['transaction']['sector'][0]['sector_vocabulary'])) {
            $this->data['transaction']['sector'][0]['sector_vocabulary'] = '';
        }

        if (!isset($this->data['transaction']['sector'][0]['code'])) {
            $this->data['transaction']['sector'][0]['code'] = '';
        }

        if (!isset($this->data['transaction']['sector'][0]['narrative'][0]['narrative'])) {
            $this->data['transaction']['sector'][0]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

        if ($key === $this->_csvHeaders[14]) {
            $validSectorVocabulary = $this->loadCodeList('SectorVocabulary');
            $value = $value ? trim($value) : '';

            if ($value) {
                foreach ($validSectorVocabulary as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
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
        $value = $value ? trim($value) : '';

        if ($sectorVocabulary === '1') {
            $validSectorCode = $this->loadCodeList('SectorCode');

            if ($value) {
                foreach ($validSectorCode as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
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
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
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
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
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
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
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
        if (!isset($this->data['transaction']['recipient_country'][0]['country_code'])) {
            $this->data['transaction']['recipient_country'][0]['country_code'] = '';
        }

        if (!isset($this->data['transaction']['recipient_country'][0]['narrative'][0]['narrative'])) {
            $this->data['transaction']['recipient_country'][0]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

        if ($key === $this->_csvHeaders[18]) {
            $validCountry = $this->loadCodeList('Country');
            $value = $value ? trim($value) : '';

            if ($value) {
                foreach ($validCountry as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
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
        if (!isset($this->data['transaction']['recipient_region'][0]['region_code'])) {
            $this->data['transaction']['recipient_region'][0]['region_code'] = '';
        }

        if (!isset($this->data['transaction']['recipient_region'][0]['region_vocabulary'])) {
            $this->data['transaction']['recipient_region'][0]['region_vocabulary'] = '';
        }

        if (!isset($this->data['transaction']['recipient_region'][0]['vocabulary_uri'])) {
            $this->data['transaction']['recipient_region'][0]['vocabulary_uri'] = '';
        }

        if (!isset($this->data['transaction']['recipient_region'][0]['narrative'][0]['narrative'])) {
            $this->data['transaction']['recipient_region'][0]['narrative'][0] = [
                'narrative' => '',
                'language'  => '',
            ];
        }

        if ($key === $this->_csvHeaders[19]) {
            $validRegion = $this->loadCodeList('Region');
            $value = $value ? trim($value) : '';

            if ($value) {
                foreach ($validRegion as $code => $name) {
                    if (strcasecmp($value, $name) === 0) {
                        $value = (string) $code;
                        break;
                    }
                }
            }

            if (isset($validRegion[$value])) {
                $this->data['transaction']['recipient_region'][0]['region_vocabulary'] = '1';
                $this->data['transaction']['recipient_region'][0]['region_code'] = $value;
            } else {
                $this->data['transaction']['recipient_region'][0]['region_vocabulary'] = '2';
                $this->data['transaction']['recipient_region'][0]['custom_code'] = $value;
            }

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
        if (!isset($this->data['transaction']['flow_type'][0]['flow_type'])) {
            $this->data['transaction']['flow_type'][0]['flow_type'] = '';
        }
    }

    /**
     * Set the Finance Type for the Transaction Element.
     *
     * @return void
     */
    protected function setFinanceType(): void
    {
        if (!isset($this->data['transaction']['finance_type'][0]['finance_type'])) {
            $this->data['transaction']['finance_type'][0]['finance_type'] = '';
        }
    }

    /**
     * Set the Aid Type for the Transaction Element.
     *
     * @return void
     */
    protected function setAidType(): void
    {
        if (!isset($this->data['transaction']['finance_type'][0]['aid_type_vocabulary'])) {
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
        if (!isset($this->data['transaction']['tied_status'][0]['tied_status_code'])) {
            $this->data['transaction']['tied_status'][0]['tied_status_code'] = '';
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
        $value = $value ? trim($value) : '';

        if ($value) {
            foreach ($validOrganizationType as $code => $name) {
                if (strcasecmp($value, $name) === 0) {
                    $value = (string) $code;
                    break;
                }
            }
        }

        return $value;
    }
}
