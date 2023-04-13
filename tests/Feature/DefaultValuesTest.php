<?php

//
//namespace Tests\Feature;
//
//use App\IATI\Repositories\Activity\ActivityRepository;
//use Tests\TestCase;
//
//class DefaultValuesTest extends TestCase
//{
//    public array $activityAllFilled =  [
//        "id" => 76,
//        "iati_identifier" => [
//            "activity_identifier" => "proper-excel-identifier",
//            "iati_identifier_text" => "-proper-excel-identifier",
//        ],
//        "other_identifier" => [
//            [
//                "reference" => "proper-excel-other-identifier",
//                "reference_type" => "A1",
//                "owner_org" => [
//                    [
//                        "ref" => "proper-excel-owner-org",
//                        "narrative" => [
//                            [
//                                "narrative" => "aaa",
//                                "language" => "en",
//                            ],
//                        ],
//                    ],
//                ],
//            ],
//        ],
//        "title" => [
//            [
//                "narrative" => "proper-excel-title",
//                "language" => "en",
//            ],
//        ],
//        "description" => [
//            [
//                "type" => "3",
//                "narrative" => [
//                    [
//                        "narrative" => "proper-excel-description-narrative",
//                        "language" => "en",
//                    ],
//                ],
//            ],
//        ],
//        "activity_status" => 2,
//        "status" => "draft",
//        "activity_date" => [
//            [
//                "date" => "2022-01-01",
//                "type" => "1",
//                "narrative" => [
//                    [
//                        "narrative" => "",
//                        "language" => "",
//                    ],
//                ],
//            ],
//            [
//                "date" => "2023-01-01",
//                "type" => "3",
//                "narrative" => [
//                    [
//                        "narrative" => "",
//                        "language" => "",
//                    ],
//                ],
//            ],
//        ],
//        "contact_info" => [
//            [
//                "type" => "",
//                "organisation" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "proper-excel-contact-info-title",
//                                "language" => "en",
//                            ],
//                        ],
//                    ],
//                ],
//                "department" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "proper-excel-contact-info-description",
//                                "language" => "en",
//                            ],
//                        ],
//                    ],
//                ],
//                "person_name" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "job_title" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "proper-excel-contact-info-job-title",
//                                "language" => "en",
//                            ],
//                        ],
//                    ],
//                ],
//                "telephone" => [
//                    [
//                        "telephone" => "",
//                    ],
//                ],
//                "email" => [
//                    [
//                        "email" => "",
//                    ],
//                ],
//                "website" => [
//                    [
//                        "website" => "",
//                    ],
//                ],
//                "mailing_address" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "proper-excel-contact-info-narrative",
//                                "language" => "en",
//                            ],
//                        ],
//                    ],
//                ],
//            ],
//        ],
//        "activity_scope" => 3,
//        "participating_org" => [
//            [
//                "organization_role" => "1",
//                "ref" => "",
//                "identifier" => "proper-excel-participating-org-activity-id",
//                "type" => "10",
//                "narrative" => [
//                    [
//                        "narrative" => "",
//                        "language" => "",
//                    ],
//                ],
//                "crs_channel_code" => "12000",
//            ],
//        ],
//        "recipient_country" => [
//            [
//                "country_code" => "AD",
//                "percentage" => "50",
//                "narrative" => [
//                    [
//                        "narrative" => "na",
//                        "language" => "en",
//                    ],
//                ],
//            ],
//            [
//                "country_code" => "AX",
//                "percentage" => "50",
//                "narrative" => [
//                    [
//                        "narrative" => "bruh",
//                        "language" => "en",
//                    ],
//                ],
//            ],
//        ],
//        "recipient_region" => [
//            [
//                "region_code" => "189",
//                "custom_code" => "",
//                "region_vocabulary" => "1",
//                "percentage" => "",
//                "narrative" => [
//                    [
//                        "narrative" => "",
//                        "language" => "",
//                    ],
//                ],
//            ],
//        ],
//        "location" => [
//            [
//                "ref" => "proper-excel-location",
//                "location_reach" => [
//                    [
//                        "code" => "1",
//                    ],
//                ],
//                "location_id" => [
//                    [
//                        "vocabulary" => "A1",
//                        "code" => "id-ho-yo",
//                    ],
//                ],
//                "name" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "proper-excel-location-name-narrative",
//                                "language" => "en",
//                            ],
//                        ],
//                    ],
//                ],
//                "description" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "location > description",
//                                "language" => "ab",
//                            ],
//                        ],
//                    ],
//                ],
//                "activity_description" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "proper-excel-location-activity-description",
//                                "language" => "en",
//                            ],
//                        ],
//                    ],
//                ],
//                "administrative" => [
//                    [
//                        "vocabulary" => "A1",
//                        "code" => "AF",
//                        "level" => null,
//                    ],
//                ],
//                "point" => [
//                    [
//                        "srs_name" => "proper-excel-location-srs-name",
//                        "pos" => [
//                            [
//                                "latitude" => "27.6625",
//                                "longitude" => "85.4376",
//                            ],
//                        ],
//                    ],
//                ],
//                "exactness" => [
//                    [
//                        "code" => "1",
//                    ],
//                ],
//                "location_class" => [
//                    [
//                        "code" => "2",
//                    ],
//                ],
//                "feature_designation" => [
//                    [
//                        "code" => "CMPQ",
//                    ],
//                ],
//            ],
//        ],
//        "sector" => [
//            [
//                "sector_vocabulary" => "1",
//                "code" => "11110",
//                "percentage" => "100",
//                "narrative" => [
//                    [
//                        "narrative" => "some narrative",
//                        "language" => "ab",
//                    ],
//                ],
//            ],
//        ],
//        "country_budget_items" => [
//            "country_budget_vocabulary" => "2",
//            "budget_item" => [
//                [
//                    "code" => "1.3.4",
//                    "percentage" => "100",
//                    "description" => [
//                        [
//                            "narrative" => [
//                                [
//                                    "narrative" => "drfghjk",
//                                    "language" => "en",
//                                ],
//                            ],
//                        ],
//                    ],
//                ],
//            ],
//        ],
//        "humanitarian_scope" => [
//            [
//                "type" => "2",
//                "vocabulary" => "1-2",
//                "code" => "2345tv",
//                "narrative" => [
//                    [
//                        "narrative" => "",
//                        "language" => "",
//                    ],
//                ],
//            ],
//        ],
//        "policy_marker" => [
//            [
//                "policy_marker_vocabulary" => "",
//                "significance" => "",
//                "policy_marker" => "",
//                "policy_marker_text" => "",
//                "narrative" => [
//                    [
//                        "narrative" => "na",
//                        "language" => "en",
//                    ],
//                ],
//            ],
//        ],
//        "collaboration_type" => 1,
//        "default_flow_type" => 30,
//        "default_finance_type" => 110,
//        "default_aid_type" => [
//            [
//                "default_aid_type_vocabulary" => "1",
//                "default_aid_type" => "B01",
//            ],
//        ],
//        "default_tied_status" => 3,
//        "budget" => [
//            [
//                "budget_type" => "1",
//                "budget_status" => "1",
//                "period_start" => [
//                    [
//                        "date" => "2022-01-01",
//                    ],
//                ],
//                "period_end" => [
//                    [
//                        "date" => "2022-12-12",
//                    ],
//                ],
//                "budget_value" => [
//                    [
//                        "amount" => "5000",
//                        "currency" => "USD",
//                        "value_date" => "2022-01-02",
//                    ],
//                ],
//            ],
//        ],
//        "planned_disbursement" => [
//            [
//                "planned_disbursement_type" => "1",
//                "period_start" => [
//                    [
//                        "date" => "2022-01-01",
//                    ],
//                ],
//                "period_end" => [
//                    [
//                        "date" => "2022-02-02",
//                    ],
//                ],
//                "value" => [
//                    [
//                        "amount" => "10000",
//                        "currency" => "USD",
//                        "value_date" => "2022-01-05",
//                    ],
//                ],
//                "provider_org" => [
//                    [
//                        "ref" => "",
//                        "provider_activity_id" => "",
//                        "type" => "",
//                        "narrative" => [
//                            [
//                                "narrative" => "",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "receiver_org" => [
//                    [
//                        "ref" => "",
//                        "provider_activity_id" => "",
//                        "type" => "",
//                        "narrative" => [
//                            [
//                                "narrative" => "",
//                                "language" => "",
//                            ],
//                        ],
//                        "receiver_activity_id" => "",
//                    ],
//                ],
//            ],
//        ],
//        "capital_spend" => 50,
//        "document_link" => [
//            [
//                "url" => "https://www.youtube.com/watch?v=H5v3kku4y6Q&list=RDyEnMLT0Iyhc&index=7&ab_channel=HarryStylesVEVO",
//                "format" => "application/1d-interleaved-parityfec",
//                "title" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "proper-excel-harry-styles-all-it-was",
//                                "language" => "en",
//                            ],
//                        ],
//                    ],
//                ],
//                "description" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "proper-excel-very-nice-song-by-harry-styles",
//                                "language" => "en",
//                            ],
//                        ],
//                    ],
//                ],
//                "category" => [
//                    [
//                        "code" => "A03",
//                    ],
//                ],
//                "language" => [
//                    [
//                        "code" => "en",
//                    ],
//                ],
//                "document_date" => [
//                    [
//                        "date" => "2022-01-01",
//                    ],
//                ],
//            ],
//        ],
//        "related_activity" => [
//            [
//                "activity_identifier" => "9uihj",
//                "relationship_type" => "1",
//            ],
//            [
//                "activity_identifier" => "123",
//                "relationship_type" => "2",
//            ],
//        ],
//        "legacy_data" => [
//            [
//                "legacy_name" => "proper-excel-legacy-data",
//                "value" => "10000",
//                "iati_equivalent" => "proper-legacy-data-gg",
//            ],
//        ],
//        "conditions" => [
//            "condition_attached" => "1",
//            "condition" => [
//                [
//                    "condition_type" => "2",
//                    "narrative" => [
//                        [
//                            "narrative" => "very nice condition",
//                            "language" => "en",
//                        ],
//                    ],
//                ],
//            ],
//        ],
//        "org_id" => 1,
//        "default_field_values" => [
//            "default_currency" => "USD",
//            "default_language" => "en",
//            "hierarchy" => null,
//            "humanitarian" => "0",
//            "budget_not_provided" => null,
//        ],
//        "linked_to_iati" => false,
//        "tag" => [
//            [
//                "tag_vocabulary" => "",
//                "tag_text" => "",
//                "narrative" => [
//                    [
//                        "narrative" => "n/a",
//                        "language" => "en",
//                    ],
//                ],
//            ],
//        ],
//        "element_status" => [
//            "iati_identifier" => true,
//            "title" => true,
//            "description" => true,
//            "activity_status" => true,
//            "activity_date" => true,
//            "participating_org" => true,
//            "recipient_country" => true,
//            "recipient_region" => true,
//            "sector" => true,
//            "policy_marker" => true,
//            "budget" => true,
//            "activity_scope" => true,
//            "contact_info" => true,
//            "related_activity" => true,
//            "other_identifier" => true,
//            "tag" => true,
//            "collaboration_type" => true,
//            "default_flow_type" => true,
//            "default_finance_type" => true,
//            "default_tied_status" => true,
//            "default_aid_type" => true,
//            "country_budget_items" => true,
//            "humanitarian_scope" => true,
//            "capital_spend" => true,
//            "conditions" => true,
//            "legacy_data" => true,
//            "document_link" => true,
//            "location" => true,
//            "planned_disbursement" => true,
//            "reporting_org" => true,
//            "transactions" => true,
//            "result" => false,
//        ],
//        "created_at" => "2023-04-12T07:16:28.000000Z",
//        "updated_at" => "2023-04-13T02:14:41.000000Z",
//        "created_by" => 2,
//        "updated_by" => 2,
//        "reporting_org" => [
//            [
//                "ref" => "NP-SWC-0987",
//                "type" => "23",
//                "secondary_reporter" => "0",
//                "narrative" => [
//                    [
//                        "narrative" => "narrative1",
//                        "language" => "en",
//                    ],
//                ],
//            ],
//        ],
//        "upload_medium" => "csv",
//        "results" => [
//            [
//                "id" => 5,
//                "activity_id" => 76,
//                "result" => [
//                    "type" => "3",
//                    "aggregation_status" => "0",
//                    "title" => [
//                        [
//                            "narrative" => [
//                                [
//                                    "narrative" => "title-narrative",
//                                    "language" => "en",
//                                ],
//                            ],
//                        ],
//                    ],
//                    "description" => [
//                        [
//                            "narrative" => [
//                                [
//                                    "narrative" => "description-narrative",
//                                    "language" => "en",
//                                ],
//                            ],
//                        ],
//                    ],
//                    "document_link" => [
//                        [
//                            "url" => "https://docs.google.com/spreadsheets/d/1Aow1jmblsLfNsPVWCXaJEMO5en4QIIFr_5LRi3-8VsM/edit#gid=1598545628",
//                            "format" => "application/3gpdash-qoe-report+xml",
//                            "title" => [
//                                [
//                                    "narrative" => [
//                                        [
//                                            "narrative" => "title-narrative-dl",
//                                            "language" => "ab",
//                                        ],
//                                    ],
//                                ],
//                            ],
//                            "description" => [
//                                [
//                                    "narrative" => [
//                                        [
//                                            "narrative" => "result > document-link > description",
//                                            "language" => "af",
//                                        ],
//                                    ],
//                                ],
//                            ],
//                            "category" => [
//                                [
//                                    "code" => "A04",
//                                ],
//                            ],
//                            "language" => [
//                                [
//                                    "language" => "ab",
//                                ],
//                            ],
//                            "document_date" => [
//                                [
//                                    "date" => "2022-01-01",
//                                ],
//                            ],
//                        ],
//                    ],
//                    "reference" => [
//                        [
//                            "vocabulary" => "99",
//                            "code" => "123",
//                            "vocabulary_uri" => "https://www.google.com/doodles",
//                        ],
//                    ],
//                ],
//                "created_at" => "2023-04-12T07:18:37.000000Z",
//                "updated_at" => "2023-04-13T02:14:41.000000Z",
//            ],
//        ],
//    ];
//    public array $resultsAllFilled =  [
//        [
//            "id" => 5,
//            "activity_id" => 76,
//            "result" => [
//                "type" => "3",
//                "aggregation_status" => "0",
//                "title" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "title-narrative",
//                                "language" => "en",
//                            ],
//                        ],
//                    ],
//                ],
//                "description" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "description-narrative",
//                                "language" => "en",
//                            ],
//                        ],
//                    ],
//                ],
//                "document_link" => [
//                    [
//                        "url" => "https://docs.google.com/spreadsheets/d/1Aow1jmblsLfNsPVWCXaJEMO5en4QIIFr_5LRi3-8VsM/edit#gid=1598545628",
//                        "format" => "application/3gpdash-qoe-report+xml",
//                        "title" => [
//                            [
//                                "narrative" => [
//                                    [
//                                        "narrative" => "title-narrative-dl",
//                                        "language" => "ab",
//                                    ],
//                                ],
//                            ],
//                        ],
//                        "description" => [
//                            [
//                                "narrative" => [
//                                    [
//                                        "narrative" => "result > document-link > description",
//                                        "language" => "af",
//                                    ],
//                                ],
//                            ],
//                        ],
//                        "category" => [
//                            [
//                                "code" => "A04",
//                            ],
//                        ],
//                        "language" => [
//                            [
//                                "language" => "ab",
//                            ],
//                        ],
//                        "document_date" => [
//                            [
//                                "date" => "2022-01-01",
//                            ],
//                        ],
//                    ],
//                ],
//                "reference" => [
//                    [
//                        "vocabulary" => "99",
//                        "code" => "123",
//                        "vocabulary_uri" => "https://www.google.com/doodles",
//                    ],
//                ],
//            ],
//            "created_at" => "2023-04-12T07:18:37.000000Z",
//            "updated_at" => "2023-04-13T02:14:41.000000Z",
//        ],
//    ];
//    public array $transactionsAllFilled = [
//        [
//            "id" => 59,
//            "activity_id" => 76,
//            "transaction" => [
//                "reference" => "",
//                "humanitarian" => "",
//                "transaction_type" => [
//                    [
//                        "transaction_type_code" => "1",
//                    ],
//                ],
//                "transaction_date" => [
//                    [
//                        "date" => "2022-01-01",
//                    ],
//                ],
//                "value" => [
//                    [
//                        "amount" => "5000",
//                        "date" => "2022-01-01",
//                        "currency" => "USD",
//                    ],
//                ],
//                "description" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "provider_organization" => [
//                    [
//                        "organization_identifier_code" => "",
//                        "provider_activity_id" => "",
//                        "type" => "",
//                        "narrative" => [
//                            [
//                                "narrative" => "",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "receiver_organization" => [
//                    [
//                        "organization_identifier_code" => "",
//                        "receiver_activity_id" => "",
//                        "type" => "",
//                        "narrative" => [
//                            [
//                                "narrative" => "",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "disbursement_channel" => [
//                    [
//                        "disbursement_channel_code" => "",
//                    ],
//                ],
//                "sector" => [
//                    [
//                        "sector_vocabulary" => "",
//                        "code" => "",
//                        "narrative" => [
//                            [
//                                "narrative" => "",
//                                "language" => "",
//                            ],
//                        ],
//                        "category_code" => "",
//                        "sdg_goal" => "",
//                        "sdg_target" => "",
//                        "text" => "",
//                    ],
//                ],
//                "recipient_country" => [
//                    [
//                        "country_code" => "",
//                        "narrative" => [
//                            [
//                                "narrative" => "",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "recipient_region" => [
//                    [
//                        "region_code" => "",
//                        "region_vocabulary" => "",
//                        "narrative" => [
//                            [
//                                "narrative" => "",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "flow_type" => [
//                    [
//                        "flow_type" => "",
//                    ],
//                ],
//                "finance_type" => [
//                    [
//                        "finance_type" => "",
//                    ],
//                ],
//                "aid_type" => [
//                    [
//                        "aid_type_vocabulary" => "",
//                        "aid_type_code" => "",
//                    ],
//                ],
//                "tied_status" => [
//                    [
//                        "tied_status_code" => "",
//                    ],
//                ],
//            ],
//            "created_at" => "2023-04-12T07:16:28.000000Z",
//            "updated_at" => "2023-04-12T07:16:28.000000Z",
//        ],
//    ];
//
//    public array $activityDefaultNotFilled = [
//        "id" => 76,
//        "iati_identifier" => [
//            "activity_identifier" => "proper-excel-identifier",
//            "iati_identifier_text" => "-proper-excel-identifier",
//        ],
//        "other_identifier" => [
//            [
//                "reference" => "proper-excel-other-identifier",
//                "reference_type" => "A1",
//                "owner_org" => [
//                    [
//                        "ref" => "proper-excel-owner-org",
//                        "narrative" => [
//                            [
//                                "narrative" => "owner-org test-narrative",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//            ],
//        ],
//        "title" => [
//            [
//                "narrative" => "proper-excel-title",
//                "language" => "",
//            ],
//        ],
//        "description" => [
//            [
//                "type" => "3",
//                "narrative" => [
//                    [
//                        "narrative" => "proper-excel-description-narrative",
//                        "language" => "",
//                    ],
//                ],
//            ],
//        ],
//        "activity_status" => 2,
//        "status" => "draft",
//        "activity_date" => [
//            [
//                "date" => "2022-01-01",
//                "type" => "1",
//                "narrative" => [
//                    [
//                        "narrative" => "activity-date test-narrative",
//                        "language" => "",
//                    ],
//                ],
//            ],
//            [
//                "date" => "2023-01-01",
//                "type" => "3",
//                "narrative" => [
//                    [
//                        "narrative" => "activity-date test-narrative",
//                        "language" => "",
//                    ],
//                ],
//            ],
//        ],
//        "contact_info" => [
//            [
//                "type" => "",
//                "organisation" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "proper-excel-contact-info-title",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "department" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "proper-excel-contact-info-description",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "person_name" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "person-name test-narrative",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "job_title" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "proper-excel-contact-info-job-title",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "telephone" => [
//                    [
//                        "telephone" => "",
//                    ],
//                ],
//                "email" => [
//                    [
//                        "email" => "",
//                    ],
//                ],
//                "website" => [
//                    [
//                        "website" => "",
//                    ],
//                ],
//                "mailing_address" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "proper-excel-contact-info-narrative",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//            ],
//        ],
//        "activity_scope" => 3,
//        "participating_org" => [
//            [
//                "organization_role" => "1",
//                "ref" => "",
//                "identifier" => "proper-excel-participating-org-activity-id",
//                "type" => "10",
//                "narrative" => [
//                    [
//                        "narrative" => "",
//                        "language" => "",
//                    ],
//                ],
//                "crs_channel_code" => "12000",
//            ],
//        ],
//        "recipient_country" => [
//            [
//                "country_code" => "AD",
//                "percentage" => "50",
//                "narrative" => [
//                    [
//                        "narrative" => "recipient-country test-narrative",
//                        "language" => "",
//                    ],
//                ],
//            ],
//            [
//                "country_code" => "AX",
//                "percentage" => "50",
//                "narrative" => [
//                    [
//                        "narrative" => "recipient-country test-narrative",
//                        "language" => "",
//                    ],
//                ],
//            ],
//        ],
//        "recipient_region" => [
//            [
//                "region_code" => "189",
//                "custom_code" => "",
//                "region_vocabulary" => "1",
//                "percentage" => "",
//                "narrative" => [
//                    [
//                        "narrative" => "recipient-region test-narrative",
//                        "language" => "",
//                    ],
//                ],
//            ],
//        ],
//        "location" => [
//            [
//                "ref" => "proper-excel-location",
//                "location_reach" => [
//                    [
//                        "code" => "1",
//                    ],
//                ],
//                "location_id" => [
//                    [
//                        "vocabulary" => "A1",
//                        "code" => "id-ho-yo",
//                    ],
//                ],
//                "name" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "proper-excel-location-name-narrative",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "description" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "location > description",
//                                "language" => "ab",
//                            ],
//                        ],
//                    ],
//                ],
//                "activity_description" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "proper-excel-location-activity-description",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "administrative" => [
//                    [
//                        "vocabulary" => "A1",
//                        "code" => "AF",
//                        "level" => null,
//                    ],
//                ],
//                "point" => [
//                    [
//                        "srs_name" => "proper-excel-location-srs-name",
//                        "pos" => [
//                            [
//                                "latitude" => "27.6625",
//                                "longitude" => "85.4376",
//                            ],
//                        ],
//                    ],
//                ],
//                "exactness" => [
//                    [
//                        "code" => "1",
//                    ],
//                ],
//                "location_class" => [
//                    [
//                        "code" => "2",
//                    ],
//                ],
//                "feature_designation" => [
//                    [
//                        "code" => "CMPQ",
//                    ],
//                ],
//            ],
//        ],
//        "sector" => [
//            [
//                "sector_vocabulary" => "1",
//                "code" => "11110",
//                "percentage" => "100",
//                "narrative" => [
//                    [
//                        "narrative" => "sector test-narrative",
//                        "language" => "",
//                    ],
//                ],
//            ],
//        ],
//        "country_budget_items" => [
//            "country_budget_vocabulary" => "2",
//            "budget_item" => [
//                [
//                    "code" => "1.3.4",
//                    "percentage" => "100",
//                    "description" => [
//                        [
//                            "narrative" => [
//                                [
//                                    "narrative" => "country budget description-narrative",
//                                    "language" => "",
//                                ],
//                            ],
//                        ],
//                    ],
//                ],
//            ],
//        ],
//        "humanitarian_scope" => [
//            [
//                "type" => "2",
//                "vocabulary" => "1-2",
//                "code" => "2345tv",
//                "narrative" => [
//                    [
//                        "narrative" => "humanitarian test-narrative",
//                        "language" => "",
//                    ],
//                ],
//            ],
//        ],
//        "policy_marker" => [
//            [
//                "policy_marker_vocabulary" => "",
//                "significance" => "",
//                "policy_marker" => "",
//                "policy_marker_text" => "",
//                "narrative" => [
//                    [
//                        "narrative" => "policy-marker test-narrative",
//                        "language" => "",
//                    ],
//                ],
//            ],
//        ],
//        "collaboration_type" => 1,
//        "default_flow_type" => 30,
//        "default_finance_type" => 110,
//        "default_aid_type" => [
//            [
//                "default_aid_type_vocabulary" => "1",
//                "default_aid_type" => "B01",
//            ],
//        ],
//        "default_tied_status" => 3,
//        "budget" => [
//            [
//                "budget_type" => "1",
//                "budget_status" => "1",
//                "period_start" => [
//                    [
//                        "date" => "2022-01-01",
//                    ],
//                ],
//                "period_end" => [
//                    [
//                        "date" => "2022-12-12",
//                    ],
//                ],
//                "budget_value" => [
//                    [
//                        "amount" => "5000",
//                        "currency" => "",
//                        "value_date" => "2022-01-02",
//                    ],
//                ],
//            ],
//        ],
//        "planned_disbursement" => [
//            [
//                "planned_disbursement_type" => "1",
//                "period_start" => [
//                    [
//                        "date" => "2022-01-01",
//                    ],
//                ],
//                "period_end" => [
//                    [
//                        "date" => "2022-02-02",
//                    ],
//                ],
//                "value" => [
//                    [
//                        "amount" => "10000",
//                        "currency" => "",
//                        "value_date" => "2022-01-05",
//                    ],
//                ],
//                "provider_org" => [
//                    [
//                        "ref" => "",
//                        "provider_activity_id" => "",
//                        "type" => "",
//                        "narrative" => [
//                            [
//                                "narrative" => "provider-org test-narrative",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "receiver_org" => [
//                    [
//                        "ref" => "",
//                        "provider_activity_id" => "",
//                        "type" => "",
//                        "narrative" => [
//                            [
//                                "narrative" => "",
//                                "language" => "",
//                            ],
//                        ],
//                        "receiver_activity_id" => "",
//                    ],
//                ],
//            ],
//        ],
//        "capital_spend" => 50,
//        "document_link" => [
//            [
//                "url" => "https://www.youtube.com/watch?v=H5v3kku4y6Q&list=RDyEnMLT0Iyhc&index=7&ab_channel=HarryStylesVEVO",
//                "format" => "application/1d-interleaved-parityfec",
//                "title" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "proper-excel-harry-styles-all-it-was",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "description" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "proper-excel-very-nice-song-by-harry-styles",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "category" => [
//                    [
//                        "code" => "A03",
//                    ],
//                ],
//                "language" => [
//                    [
//                        "code" => "en",
//                    ],
//                ],
//                "document_date" => [
//                    [
//                        "date" => "2022-01-01",
//                    ],
//                ],
//            ],
//        ],
//        "related_activity" => [
//            [
//                "activity_identifier" => "9uihj",
//                "relationship_type" => "1",
//            ],
//            [
//                "activity_identifier" => "123",
//                "relationship_type" => "2",
//            ],
//        ],
//        "legacy_data" => [
//            [
//                "legacy_name" => "proper-excel-legacy-data",
//                "value" => "10000",
//                "iati_equivalent" => "proper-legacy-data-gg",
//            ],
//        ],
//        "conditions" => [
//            "condition_attached" => "1",
//            "condition" => [
//                [
//                    "condition_type" => "2",
//                    "narrative" => [
//                        [
//                            "narrative" => "very nice condition",
//                            "language" => "",
//                        ],
//                    ],
//                ],
//            ],
//        ],
//        "org_id" => 1,
//        "default_field_values" => [
//            "default_currency" => "USD",
//            "default_language" => "en",
//            "hierarchy" => null,
//            "humanitarian" => "0",
//            "budget_not_provided" => null,
//        ],
//        "linked_to_iati" => false,
//        "tag" => [
//            [
//                "tag_vocabulary" => "",
//                "tag_text" => "",
//                "narrative" => [
//                    [
//                        "narrative" => "test-narrative",
//                        "language" => "",
//                    ],
//                ],
//            ],
//        ],
//        "element_status" => [
//            "iati_identifier" => true,
//            "title" => true,
//            "description" => true,
//            "activity_status" => true,
//            "activity_date" => true,
//            "participating_org" => true,
//            "recipient_country" => true,
//            "recipient_region" => true,
//            "sector" => true,
//            "policy_marker" => true,
//            "budget" => true,
//            "activity_scope" => true,
//            "contact_info" => true,
//            "related_activity" => true,
//            "other_identifier" => true,
//            "tag" => true,
//            "collaboration_type" => true,
//            "default_flow_type" => true,
//            "default_finance_type" => true,
//            "default_tied_status" => true,
//            "default_aid_type" => true,
//            "country_budget_items" => true,
//            "humanitarian_scope" => true,
//            "capital_spend" => true,
//            "conditions" => true,
//            "legacy_data" => true,
//            "document_link" => true,
//            "location" => true,
//            "planned_disbursement" => true,
//            "reporting_org" => true,
//            "transactions" => true,
//            "result" => false,
//        ],
//        "created_at" => "2023-04-12T07:16:28.000000Z",
//        "updated_at" => "2023-04-13T02:14:41.000000Z",
//        "created_by" => 2,
//        "updated_by" => 2,
//        "reporting_org" => [
//            [
//                "ref" => "NP-SWC-0987",
//                "type" => "23",
//                "secondary_reporter" => "0",
//                "narrative" => [
//                    [
//                        "narrative" => "test-narrative",
//                        "language" => "",
//                    ],
//                ],
//            ],
//        ],
//        "upload_medium" => "csv",
//    ];
//    public array $resultDefaultNotFilled =  [
//        [
//            "id" => 5,
//            "activity_id" => 76,
//            "result" => [
//                "type" => "3",
//                "aggregation_status" => "0",
//                "title" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "title-narrative",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "description" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "description-narrative",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "document_link" => [
//                    [
//                        "url" => "https://docs.google.com/spreadsheets/d/1Aow1jmblsLfNsPVWCXaJEMO5en4QIIFr_5LRi3-8VsM/edit#gid=1598545628",
//                        "format" => "application/3gpdash-qoe-report+xml",
//                        "title" => [
//                            [
//                                "narrative" => [
//                                    [
//                                        "narrative" => "title-narrative-dl",
//                                        "language" => "",
//                                    ],
//                                ],
//                            ],
//                        ],
//                        "description" => [
//                            [
//                                "narrative" => [
//                                    [
//                                        "narrative" => "result > document-link > description",
//                                        "language" => "",
//                                    ],
//                                ],
//                            ],
//                        ],
//                        "category" => [
//                            [
//                                "code" => "A04",
//                            ],
//                        ],
//                        "language" => [
//                            [
//                                "language" => "",
//                            ],
//                        ],
//                        "document_date" => [
//                            [
//                                "date" => "2022-01-01",
//                            ],
//                        ],
//                    ],
//                ],
//                "reference" => [
//                    [
//                        "vocabulary" => "99",
//                        "code" => "123",
//                        "vocabulary_uri" => "https://www.google.com/doodles",
//                    ],
//                ],
//            ],
//            "created_at" => "2023-04-12T07:18:37.000000Z",
//            "updated_at" => "2023-04-13T02:14:41.000000Z",
//        ],
//    ];
//    public array $transactionDefaultNotFilled = [
//        [
//            "id" => 59,
//            "activity_id" => 76,
//            "transaction" => [
//                "reference" => "",
//                "humanitarian" => "",
//                "transaction_type" => [
//                    [
//                        "transaction_type_code" => "1",
//                    ],
//                ],
//                "transaction_date" => [
//                    [
//                        "date" => "2022-01-01",
//                    ],
//                ],
//                "value" => [
//                    [
//                        "amount" => "5000",
//                        "date" => "2022-01-01",
//                        "currency" => "",
//                    ],
//                ],
//                "description" => [
//                    [
//                        "narrative" => [
//                            [
//                                "narrative" => "description filled",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "provider_organization" => [
//                    [
//                        "organization_identifier_code" => "",
//                        "provider_activity_id" => "",
//                        "type" => "",
//                        "narrative" => [
//                            [
//                                "narrative" => "narrative xa esma",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "receiver_organization" => [
//                    [
//                        "organization_identifier_code" => "",
//                        "receiver_activity_id" => "",
//                        "type" => "",
//                        "narrative" => [
//                            [
//                                "narrative" => "receiver org , esma ni narrative xa",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "disbursement_channel" => [
//                    [
//                        "disbursement_channel_code" => "",
//                    ],
//                ],
//                "sector" => [
//                    [
//                        "sector_vocabulary" => "",
//                        "code" => "",
//                        "narrative" => [
//                            [
//                                "narrative" => "",
//                                "language" => "",
//                            ],
//                        ],
//                        "category_code" => "",
//                        "sdg_goal" => "",
//                        "sdg_target" => "",
//                        "text" => "",
//                    ],
//                ],
//                "recipient_country" => [
//                    [
//                        "country_code" => "",
//                        "narrative" => [
//                            [
//                                "narrative" => "",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "recipient_region" => [
//                    [
//                        "region_code" => "",
//                        "region_vocabulary" => "",
//                        "narrative" => [
//                            [
//                                "narrative" => "",
//                                "language" => "",
//                            ],
//                        ],
//                    ],
//                ],
//                "flow_type" => [
//                    [
//                        "flow_type" => "",
//                    ],
//                ],
//                "finance_type" => [
//                    [
//                        "finance_type" => "",
//                    ],
//                ],
//                "aid_type" => [
//                    [
//                        "aid_type_vocabulary" => "",
//                        "aid_type_code" => "",
//                    ],
//                ],
//                "tied_status" => [
//                    [
//                        "tied_status_code" => "",
//                    ],
//                ],
//            ],
//            "created_at" => "2023-04-12T07:16:28.000000Z",
//            "updated_at" => "2023-04-12T07:16:28.000000Z",
//        ],
//    ];
//
//    public array $activityTemplate = [];
//    public array $resultsTemplate = [];
//    public array $transactionsTemplate = [];
//    public array $testableElements = ['title', 'contact_info', 'result', 'transaction'];
//
//    /**
//     * A basic feature test example.
//     *
//     * @return voidx
//     */
//    public function test_default_value_in_title()
//    {
//        $activityRepository = app()->make(ActivityRepository::class);
//        $response = $this->get('/');
//
//        $response->assertStatus(200);
//    }
//
//    /**
//     * A basic feature test example.
//     *
//     * @return void
//     */
//    public function test_default_value_in_description()
//    {
//        $response = $this->get('/');
//
//        $response->assertStatus(200);
//    }
//
//    /**
//     * A basic feature test example.
//     *
//     * @return void
//     */
//    public function test_default_value_in_contact_info()
//    {
//        $response = $this->get('/');
//
//        $response->assertStatus(200);
//    }
//
//    /**
//     * A basic feature test example.
//     *
//     * @return void
//     */
//    public function test_default_value_in_result()
//    {
//        $response = $this->get('/');
//
//        $response->assertStatus(200);
//    }
//
//    /**
//     * A basic feature test example.
//     *
//     * @return void
//     */
//    public function test_default_value_in_transaction()
//    {
//        $response = $this->get('/');
//
//        $response->assertStatus(200);
//    }
//}
