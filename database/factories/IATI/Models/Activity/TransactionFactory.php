<?php

namespace Database\Factories\IATI\Models\Activity;

use App\IATI\Models\Activity\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory<Model>
 */
class TransactionFactory extends Factory
{
    /**
     * Transaction model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \JsonException
     */
    public function definition(): array
    {
        return [
            'transaction' => json_decode('{"reference":"ref test","humanitarian":"1","transaction_type":[{"transaction_type_code":"1"}],"transaction_date":[{"date":"2022-07-08"}],"value":[{"amount":"5000","date":"2022-07-08","currency":"AED"}],"description":[{"narrative":[{"narrative":"test description","language":"ab"},{"narrative":"description 2","language":"af"}]}],"provider_organization":[{"organization_identifier_code":"provider ref","provider_activity_id":"15","type":"15","narrative":[{"narrative":"narative 1","language":"ae"},{"narrative":"narrative 2","language":"am"}]}],"receiver_organization":[{"organization_identifier_code":"receiver org","receiver_activity_id":"16","type":"15","narrative":[{"narrative":"receiver narrative 1","language":"ab"},{"narrative":"receiver narrative 2","language":"ak"}]}],"disbursement_channel":[{"disbursement_channel_code":null}],"sector":[{"sector_vocabulary":null,"code":null,"narrative":[{"narrative":null,"language":null}]}],"recipient_country":[{"country_code":null,"narrative":[{"narrative":null,"language":null}]}],"recipient_region":[{"region_vocabulary":"99","custom_code":"test code","vocabulary_uri":"https:\/\/github.com\/younginnovations\/iatipublisher\/runs\/6980821807?check_suite_focus=true","narrative":[{"narrative":"narrative region 1","language":"aa"},{"narrative":"narrative region 2","language":"am"}]}],"flow_type":[{"flow_type":"10"}],"finance_type":[{"finance_type":"210"}],"aid_type":[{"aid_type_vocabulary":"1","aid_type_code":"A02"},{"aid_type_vocabulary":"4","cash_and_voucher_modalities":"1"}],"tied_status":[{"tied_status_code":"3"}]}', true, 512, JSON_THROW_ON_ERROR),
        ];
    }
}
