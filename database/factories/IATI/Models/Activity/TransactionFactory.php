<?php

namespace Database\Factories\IATI\Models\Activity;

use App\IATI\Models\Activity\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use JsonException;

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
     * @throws JsonException
     */
    public function definition(): array
    {
        return [
            'transaction' => json_decode(
                '{
                    "aid_type": [
                        {
                            "aid_type_code": "A02",
                            "aid_type_vocabulary": "1"
                        },
                        {
                            "aid_type_vocabulary": "4",
                            "cash_and_voucher_modalities": "1"
                        }
                    ],
                    "description": [
                        {
                            "narrative": [
                                {
                                    "language": "ab",
                                    "narrative": "test description"
                                },
                                {
                                    "language": "af",
                                    "narrative": "description 2"
                                }
                            ]
                        }
                    ],
                    "disbursement_channel": [
                        {
                            "disbursement_channel_code": null
                        }
                    ],
                    "finance_type": [
                        {
                            "finance_type": "210"
                        }
                    ],
                    "flow_type": [
                        {
                            "flow_type": "10"
                        }
                    ],
                    "humanitarian": "1",
                    "provider_organization": [
                        {
                            "narrative": [
                                {
                                    "language": "ae",
                                    "narrative": "narative 1"
                                },
                                {
                                    "language": "am",
                                    "narrative": "narrative 2"
                                }
                            ],
                            "organization_identifier_code": "provider ref",
                            "provider_activity_id": "15",
                            "type": "15"
                        }
                    ],
                    "receiver_organization": [
                        {
                            "narrative": [
                                {
                                    "language": "ab",
                                    "narrative": "receiver narrative 1"
                                },
                                {
                                    "language": "ak",
                                    "narrative": "receiver narrative 2"
                                }
                            ],
                            "organization_identifier_code": "receiver org",
                            "receiver_activity_id": "16",
                            "type": "15"
                        }
                    ],
                    "recipient_country": [
                        {
                            "country_code": null,
                            "narrative": [
                                {
                                    "language": null,
                                    "narrative": null
                                }
                            ]
                        }
                    ],
                    "recipient_region": [
                        {
                            "custom_code": "test code",
                            "narrative": [
                                {
                                    "language": "aa",
                                    "narrative": "narrative region 1"
                                },
                                {
                                    "language": "am",
                                    "narrative": "narrative region 2"
                                }
                            ],
                            "region_vocabulary": "99",
                            "vocabulary_uri": "https://github.com/younginnovations/iatipublisher/runs/6980821807?check_suite_focus=true"
                        }
                    ],
                    "reference": "ref test",
                    "sector": [
                        {
                            "code": null,
                            "narrative": [
                                {
                                    "language": null,
                                    "narrative": null
                                }
                            ],
                            "sector_vocabulary": null
                        }
                    ],
                    "tied_status": [
                        {
                            "tied_status_code": "3"
                        }
                    ],
                    "transaction_date": [
                        {
                            "date": "2022-07-08"
                        }
                    ],
                    "transaction_type": [
                        {
                            "transaction_type_code": "1"
                        }
                    ],
                    "value": [
                        {
                            "amount": "5000",
                            "currency": "AED",
                            "date": "2022-07-08"
                        }
                    ]
                }',
                true,
                512,
                JSON_THROW_ON_ERROR
            ),
        ];
    }
}
