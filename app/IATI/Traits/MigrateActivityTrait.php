<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use App\IATI\Models\User\Role;
use Illuminate\Support\Arr;

/**
 * Class MigrateActivityTrait.
 */
trait MigrateActivityTrait
{
    /**
     * Contains key value pair to be replaced.
     *
     * @var array
     */
    protected array $contactInfoReplaceArray = ['organization' => 'organisation'];

    /**
     * Contains key value pair to be replaced.
     *
     * @var array
     */
    protected array $participatingOrgReplaceArray
        = [
            'identifier'        => 'ref',
            'activity_id'       => 'identifier',
            'organization_type' => 'type',
        ];

    /**
     * Contains values to be removed.
     *
     * @var array
     */
    protected array $participatingOrgRemoveArray = ['country', 'org_data_id', 'Crs Channel Code', 'is_publisher'];

    /**
     * Contains key value pair to be replaced for each vocabulary.
     *
     * @var array
     */
    protected array $recipientRegionReplaceArray
        = [
            '2'  => [
                'region_code_input' => 'custom_code',
            ],
            '99' => [
                'region_code_input' => 'custom_code',
            ],
        ];

    /**
     * Contains values to be removed for each vocabulary.
     *
     * @var array
     */
    protected array $recipientRegionRemoveArray
        = [
            '1'  => ['custom_code', 'region_code_input', 'vocabulary_uri', 'custom_vocabulary_uri'],
            '2'  => ['region_code', 'region_code_input', 'vocabulary_uri', 'custom_vocabulary_uri'],
            '99' => ['region_code', 'region_code_input', 'custom_vocabulary_uri'],
        ];

    /**
     * Contains key value pair to be replaced for particular vocabulary.
     *
     * @var array
     */
    protected array $sectorReplaceArray
        = [
            '1'  => [
                'sector_code' => 'code',
            ],
            '2'  => [
                'sector_category_code' => 'category_code',
            ],
            '3'  => [
                'sector_text' => 'text',
            ],
            '4'  => [
                'sector_text' => 'text',
            ],
            '5'  => [
                'sector_text' => 'text',
            ],
            '6'  => [
                'sector_text' => 'text',
            ],
            '7'  => [
                'sector_sdg_goal' => 'sdg_goal',
            ],
            '8'  => [
                'sector_sdg_target' => 'sdg_target',
            ],
            '9'  => [
                'sector_text' => 'text',
            ],
            '10' => [
                'sector_text' => 'text',
            ],
            '99' => [
                'sector_text' => 'text',
            ],
            '98' => [
                'sector_text' => 'text',
            ],
        ];

    /**
     * Contains key value pair to be removed for particular vocabulary.
     *
     * @var array
     */
    protected array $sectorRemoveArray
        = [
            '1'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '2'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '3'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '4'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '5'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '6'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '7'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '8'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '9'  => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '10' => [
                'vocabulary_uri',
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '99' => [
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
            '98' => [
                'custom_vocabulary_uri',
                'sector_code',
                'sector_category_code',
                'sector_sdg_goal',
                'sector_sdg_target',
                'sector_text',
                'custom_code',
            ],
        ];

    /**
     * Empty budget item template.
     *
     * @var array
     */
    protected array $emptyBudgetItemTemplate
        = [
            [
                'code'        => null,
                'percentage'  => null,
                'description' => [
                    [
                        'narrative' => [
                            [
                                'narrative' => null,
                                'language'  => null,
                            ],
                        ],
                    ],
                ],
            ],
        ];

    /**
     * Empty location administrative template.
     *
     * @var array
     */
    protected array $locationAdministrativeEmptyTemplate
        = [
            [
                'vocabulary' => null,
                'code'       => null,
                'level'      => null,
            ],
        ];

    /**
     * Contains key value pair to be removed for particular vocabulary.
     *
     * @var array
     */
    protected array $humanitarianScopeRemoveArray
        = [
            '1-2' => ['vocabulary_uri', 'custom_vocabulary_uri', 'custom_code'],
            '2-1' => ['vocabulary_uri', 'custom_vocabulary_uri', 'custom_code'],
            '99'  => ['custom_vocabulary_uri', 'custom_code'],
        ];

    /**
     * Contains key value pair to be replaced for each vocabulary.
     *
     * @var array
     */
    protected array $policyMarkerReplaceArray
        = [
            '1'  => [
                'vocabulary' => 'policy_marker_vocabulary',
            ],
            '99' => [
                'vocabulary' => 'policy_marker_vocabulary',
            ],
        ];

    /**
     * Contains key value pair to be removed for particular vocabulary.
     *
     * @var array
     */
    protected array $policyMarkerRemoveArray
        = [
            '1'  => ['vocabulary', 'vocabulary_uri', 'custom_vocabulary_uri', 'custom_code', 'policy_marker_text'],
            '99' => ['vocabulary', 'custom_vocabulary_uri', 'custom_code', 'policy_marker'],
        ];

    /**
     * Contains key value pair to be replaced for particular vocabulary.
     *
     * @var array
     */
    protected array $defaultAidTypeReplaceArray
        = [
            '1' => [
                'default_aidtype_vocabulary' => 'default_aid_type_vocabulary',
            ],
            '2' => [
                'default_aidtype_vocabulary' => 'default_aid_type_vocabulary',
            ],
            '3' => [
                'default_aidtype_vocabulary' => 'default_aid_type_vocabulary',
                'default_aid_type_text'      => 'earmarking_modality',
            ],
            '4' => [
                'default_aidtype_vocabulary' => 'default_aid_type_vocabulary',
            ],
        ];

    /**
     * Contains key value pair to be removed for particular vocabulary.
     *
     * @var array
     */
    protected array $defaultAidTypeRemoveArray
        = [
            '1' => [
                'default_aidtype_vocabulary',
                'earmarking_category',
                'cash_and_voucher_modalities',
                'default_aid_type_text',
            ],
            '2' => [
                'default_aidtype_vocabulary',
                'default_aid_type',
                'cash_and_voucher_modalities',
                'default_aid_type_text',
            ],
            '3' => [
                'default_aidtype_vocabulary',
                'default_aid_type',
                'earmarking_category',
                'cash_and_voucher_modalities',
                'default_aid_type_text',
            ],
            '4' => ['default_aidtype_vocabulary', 'default_aid_type', 'earmarking_category', 'default_aid_type_text'],
        ];

    /**
     * Contains key value pair to be replaced.
     *
     * @var array
     */
    protected array $budgetReplaceArray
        = [
            'status' => 'budget_status',
            'value'  => 'budget_value',
        ];

    /**
     * Document link language template.
     *
     * @var array
     */
    protected array $documentLinkLanguageTemplate
        = [
            [
                'code' => null,
            ],
        ];

    /**
     * Contains key value pair to be replaced.
     *
     * @var array
     */
    protected array $legacyDataReplaceArray
        = [
            'name' => 'legacy_name',
        ];

    /**
     * Empty document link template.
     *
     * @var array
     */
    protected array $emptyDocumentLinkTemplate
        = [
            'url'           => null,
            'format'        => null,
            'title'         => [
                [
                    'narrative' => [
                        [
                            'narrative' => null,
                            'language'  => null,
                        ],
                    ],
                ],
            ],
            'description'   => [
                [
                    'narrative' => [
                        [
                            'narrative' => null,
                            'language'  => null,
                        ],
                    ],
                ],
            ],
            'category'      => [['code' => null]],
            'language'      => [['language' => 'en']],
            'document_date' => [['date' => null]],
        ];

    /**
     * Returns IATI activity data.
     *
     * @param $aidstreamActivity
     * @param $iatiOrganization
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getNewActivity($aidstreamActivity, $iatiOrganization): array
    {
        $newActivity = [];
        $newActivity['iati_identifier'] = $aidstreamActivity->identifier ? [
            'activity_identifier' => Arr::get(
                json_decode($aidstreamActivity->identifier, true, 512, JSON_THROW_ON_ERROR),
                'activity_identifier',
                null
            ),
        ] : null;
        $newActivity['other_identifier'] = $aidstreamActivity ? $this->getActivityOtherIdentifier(
            $aidstreamActivity->other_identifier
        ) : null;
        $newActivity['title'] = $this->getColumnValueArray($aidstreamActivity, 'title');
        $newActivity['description'] = $this->getColumnValueArray($aidstreamActivity, 'description');
        $newActivity['activity_status'] = $aidstreamActivity ? $this->getIntSelectValue(
            $aidstreamActivity->activity_status,
            'ActivityStatus',
            'Activity'
        ) : null;
        $newActivity['status'] = ($aidstreamActivity && $aidstreamActivity->activity_workflow === 3 && $aidstreamActivity->published_to_registry === 1) ? 'published' : 'draft';
        $newActivity['activity_date'] = $this->getColumnValueArray($aidstreamActivity, 'activity_date');
        $newActivity['contact_info'] = $aidstreamActivity ? $this->getActivityFirstLevelData(
            $aidstreamActivity->contact_info,
            $this->contactInfoReplaceArray
        ) : null;
        $newActivity['activity_scope'] = $aidstreamActivity ? $this->getIntSelectValue(
            $aidstreamActivity->activity_scope,
            'ActivityScope',
            'Activity'
        ) : null;
        $newActivity['participating_organization'] = $aidstreamActivity ? $this->getActivityFirstLevelData(
            $aidstreamActivity->participating_organization,
            $this->participatingOrgReplaceArray,
            $this->participatingOrgRemoveArray
        ) : null;
        $newActivity['recipient_country'] = $this->getColumnValueArray($aidstreamActivity, 'recipient_country');
        $newActivity['recipient_region'] = $aidstreamActivity ? $this->getActivityUpdatedVocabularyData(
            $aidstreamActivity->recipient_region,
            'region_vocabulary',
            $this->recipientRegionReplaceArray,
            $this->recipientRegionRemoveArray,
            '1'
        ) : null;
        $newActivity['location'] = $aidstreamActivity ? $this->getActivityLocationData(
            $aidstreamActivity->location
        ) : null;
        $newActivity['sector'] = $aidstreamActivity ? $this->getActivityUpdatedVocabularyData(
            $aidstreamActivity->sector,
            'sector_vocabulary',
            $this->sectorReplaceArray,
            $this->sectorRemoveArray,
            '1'
        ) : null;
        $newActivity['country_budget_items'] = $aidstreamActivity ? $this->getActivityCountryBudgetItemsData(
            $aidstreamActivity->country_budget_items
        ) : null;
        $newActivity['humanitarian_scope'] = $aidstreamActivity ? $this->getActivityUpdatedVocabularyData(
            $aidstreamActivity->humanitarian_scope,
            'vocabulary',
            [],
            $this->humanitarianScopeRemoveArray,
            '1-2'
        ) : null;
        $newActivity['policy_marker'] = $aidstreamActivity ? $this->getActivityUpdatedVocabularyData(
            $aidstreamActivity->policy_marker,
            'vocabulary',
            $this->policyMarkerReplaceArray,
            $this->policyMarkerRemoveArray,
            '1'
        ) : null;
        $newActivity['collaboration_type'] = $aidstreamActivity ? $this->getIntSelectValue(
            $aidstreamActivity->collaboration_type,
            'CollaborationType',
            'Activity'
        ) : null;
        $newActivity['default_flow_type'] = $aidstreamActivity ? $this->getIntSelectValue(
            $aidstreamActivity->default_flow_type,
            'FlowType',
            'Activity'
        ) : null;
        $newActivity['default_finance_type'] = $aidstreamActivity ? $this->getIntSelectValue(
            $aidstreamActivity->default_finance_type,
            'FinanceType',
            'Activity'
        ) : null;
        $newActivity['default_aid_type'] = $aidstreamActivity ? $this->getActivityDefaultAidTypeData(
            $aidstreamActivity->default_aid_type
        ) : null;
        $newActivity['default_tied_status'] = $aidstreamActivity ? $this->getIntSelectValue(
            $aidstreamActivity->default_tied_status,
            'TiedStatus',
            'Activity'
        ) : null;
        $newActivity['budget'] = $aidstreamActivity ? $this->getActivityFirstLevelData(
            $aidstreamActivity->budget,
            $this->budgetReplaceArray,
        ) : null;
        $newActivity['planned_disbursement'] = $aidstreamActivity ? $this->getActivityPlannedDisbursementData(
            $aidstreamActivity->planned_disbursement
        ) : null;
        $newActivity['capital_spend'] = $aidstreamActivity ? $this->getActivityCapitalSpendData(
            $aidstreamActivity->capital_spend
        ) : null;
        $newActivity['document_link'] = $aidstreamActivity ? $this->getActivityDocumentLinkData(
            $aidstreamActivity
        ) : null;
        $newActivity['related_activity'] = $this->getColumnValueArray($aidstreamActivity, 'related_activity');
        $newActivity['legacy_data'] = $aidstreamActivity ? $this->getActivityFirstLevelData(
            $aidstreamActivity->legacy_data,
            $this->legacyDataReplaceArray,
        ) : null;
        $newActivity['conditions'] = $this->getColumnValueArray($aidstreamActivity, 'conditions');
        $newActivity['org_id'] = $iatiOrganization->id;
        $newActivity['default_field_values'] = $aidstreamActivity ? $this->getActivityDefaultFieldValues(
            $aidstreamActivity->default_field_values
        ) : null;
        $newActivity['linked_to_iati'] = $aidstreamActivity && $aidstreamActivity->published_to_registry;
        $newActivity['tag'] = $aidstreamActivity ? $this->getActivityTagData($aidstreamActivity->tag) : null;
        $newActivity['element_status'] = null; // Will be updated by observer
        $newActivity['created_at'] = $aidstreamActivity ? $aidstreamActivity->created_at : null;
        $newActivity['updated_at'] = $aidstreamActivity ? $aidstreamActivity->updated_at : null;

        $adminId = $iatiOrganization->user->where('role_id', app(Role::class)->getOrganizationAdminId())->first()->id;
        $newActivity['created_by'] = $adminId;
        $newActivity['updated_by'] = $adminId;
        $newActivity['reporting_org'] = null;
        $newActivity['upload_medium'] = 'manual';

        return $newActivity;
    }

    /**
     * Returns activity other identifier data.
     *
     * @param $aidstreamOtherIdentifiers
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityOtherIdentifier($aidstreamOtherIdentifiers): ?array
    {
        if (!$aidstreamOtherIdentifiers) {
            return null;
        }

        $newOtherIdentifiers = [];
        $otherIdentifiersArray = json_decode($aidstreamOtherIdentifiers, true, 512, JSON_THROW_ON_ERROR);

        if ($otherIdentifiersArray && count($otherIdentifiersArray)) {
            foreach (array_values($otherIdentifiersArray) as $key => $otherIdentifier) {
                $newOtherIdentifiers[$key]['reference'] = Arr::get($otherIdentifier, 'reference', null);
                $newOtherIdentifiers[$key]['reference_type'] = Arr::get($otherIdentifier, 'type', null);

                foreach (Arr::get($otherIdentifier, 'owner_org', []) as $innerKey => $ownerOrg) {
                    $newOtherIdentifiers[$key]['owner_org'][$innerKey]['ref'] = Arr::get($ownerOrg, 'reference', null);
                    $newOtherIdentifiers[$key]['owner_org'][$innerKey]['narrative'] = Arr::get(
                        $ownerOrg,
                        'narrative',
                        null
                    );
                }
            }
        }

        return count($newOtherIdentifiers) ? $newOtherIdentifiers : null;
    }

    /**
     * Returns updated activity first level data.
     *
     * @param $object
     * @param $replaceArray
     * @param  array  $removeArray
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityFirstLevelData($object, $replaceArray, array $removeArray = []): ?array
    {
        if (!$object) {
            return null;
        }

        $newArray = [];
        $array = json_decode($object, true, 512, JSON_THROW_ON_ERROR);

        if ($array && count($array)) {
            foreach (array_values($array) as $key => $item) {
                foreach ($item as $innerKey => $innerItem) {
                    if (!in_array($innerKey, $removeArray, true)) {
                        if (array_key_exists($innerKey, $replaceArray)) {
                            $newArray[$key][$replaceArray[$innerKey]] = $innerItem;
                            continue;
                        }

                        $newArray[$key][$innerKey] = $innerItem;
                    } elseif (array_key_exists($innerKey, $replaceArray)) {
                        $newArray[$key][$replaceArray[$innerKey]] = $innerItem;
                    }
                }
            }
        }

        return count($newArray) ? $newArray : null;
    }

    /**
     * Updates activity element vocabulary data.
     *
     * @param $object
     * @param $vocabulary
     * @param $replaceArray
     * @param $removeArray
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityUpdatedVocabularyData(
        $object,
        $vocabulary,
        $replaceArray,
        $removeArray,
        $defaultVocabulary = '1'
    ): ?array {
        if (!$object) {
            return null;
        }

        $newArray = [];
        $array = json_decode($object, true, 512, JSON_THROW_ON_ERROR);

        if ($array && count($array)) {
            foreach (array_values($array) as $key => $item) {
                if (is_null(Arr::get($item, $vocabulary)) || (is_string(Arr::get($item, $vocabulary)) && trim(
                    Arr::get($item, $vocabulary)
                ) === '')) {
                    $item[$vocabulary] = $defaultVocabulary;
                }

                $newArray[$key] = $this->formatUpdatedVocabularyData(
                    $item,
                    Arr::get($replaceArray, Arr::get($item, $vocabulary, null), []),
                    Arr::get($removeArray, Arr::get($item, $vocabulary, null), []),
                );
            }
        }

        return count($newArray) ? $newArray : null;
    }

    /**
     * Formats updated vocabulary data.
     *
     * @param $item
     * @param $replaceArray
     * @param $removeArray
     *
     * @return array
     */
    public function formatUpdatedVocabularyData($item, $replaceArray, $removeArray): array
    {
        $newArray = [];

        if ($item && count($item)) {
            foreach ($item as $innerKey => $innerItem) {
                if (!in_array($innerKey, $removeArray, true)) {
                    if (array_key_exists($innerKey, $replaceArray)) {
                        $newArray[$replaceArray[$innerKey]] = $innerItem;
                        continue;
                    }

                    $newArray[$innerKey] = $innerItem;
                } elseif (array_key_exists($innerKey, $replaceArray)) {
                    $newArray[$replaceArray[$innerKey]] = $innerItem;
                }
            }
        }

        return $newArray;
    }

    /**
     * Returns activity location data.
     * @param $locations
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityLocationData($locations): ?array
    {
        if (!$locations) {
            return null;
        }

        $newLocations = [];
        $locationsArray = json_decode($locations, true, 512, JSON_THROW_ON_ERROR);

        if ($locationsArray && count($locationsArray)) {
            foreach (array_values($locationsArray) as $key => $locationArray) {
                $newLocations[$key]['ref'] = $this->locationReferenceValue(Arr::get($locationArray, 'reference', null));
                $newLocations[$key]['location_reach'] = Arr::get($locationArray, 'location_reach', null);
                $newLocations[$key]['location_id'] = Arr::get($locationArray, 'location_id', null);
                $newLocations[$key]['name'] = Arr::get($locationArray, 'name', null);
                $newLocations[$key]['description'] = Arr::get($locationArray, 'location_description', null);
                $newLocations[$key]['activity_description'] = Arr::get($locationArray, 'activity_description', null);
                $newLocations[$key]['administrative'] = $this->getLocationAdministrativeData(
                    Arr::get($locationArray, 'administrative', null)
                );
                $newLocations[$key]['point'] = [
                    [
                        'srs_name' => Arr::get($locationArray, 'point.0.srs_name', null),
                        'pos'      => Arr::get($locationArray, 'point.0.position', null),
                    ],
                ];
                $newLocations[$key]['exactness'] = Arr::get($locationArray, 'exactness', null);
                $newLocations[$key]['location_class'] = Arr::get($locationArray, 'location_class', null);
                $newLocations[$key]['feature_designation'] = Arr::get($locationArray, 'feature_designation', null);
            }
        }

        return count($newLocations) ? $newLocations : null;
    }

    /**
     * Returns location reference value using id.
     *
     * @param $locationReferenceId
     *
     * @return string|null
     */
    public function locationReferenceValue($locationReferenceId): ?string
    {
        if (!$locationReferenceId) {
            return null;
        }

        $locationReference = $this->db::connection('aidstream')->table('location_references')->find(
            $locationReferenceId
        );

        return $locationReference ? $locationReference->reference : null;
    }

    /**
     * Checks if location administrative code is valid.
     * Since AidStream has open text field and IATI Publisher has select field, we need to check if the code is valid.
     *
     * @param $administratives
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getLocationAdministrativeData($administratives): array
    {
        if (count($administratives)) {
            foreach (array_values($administratives) as $key => $administrative) {
                if (!empty(Arr::get($administrative, 'code', null)) && !array_key_exists(
                    strtoupper(Arr::get($administrative, 'code', null)),
                    getCodeList('Country', 'Activity', false)
                )) {
                    unset($administratives[$key]);
                } elseif (!empty(Arr::get($administrative, 'code', null))) {
                    $administratives[$key]['code'] = strtoupper(Arr::get($administrative, 'code', null));
                }
            }
        }

        return count($administratives) ? array_values($administratives) : $this->locationAdministrativeEmptyTemplate;
    }

    /**
     * Returns country budget items' data.
     *
     * @param $countryBudgetItems
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityCountryBudgetItemsData($countryBudgetItems): ?array
    {
        if (!$countryBudgetItems) {
            return null;
        }

        $newCountryBudgetItem = [];
        $countryBudgetItemsArray = json_decode($countryBudgetItems, true, 512, JSON_THROW_ON_ERROR);

        if ($countryBudgetItemsArray && count($countryBudgetItemsArray) && Arr::get(
            $countryBudgetItemsArray,
            '0.vocabulary',
            '1'
        ) !== '1') {
            $newCountryBudgetItem = [
                'country_budget_vocabulary' => Arr::get(
                    $countryBudgetItemsArray,
                    '0.vocabulary',
                    null
                ),
                'budget_item'               => $this->getBudgetItemsData(
                    Arr::get($countryBudgetItemsArray, '0.budget_item', null)
                ),
            ];
        }

        return !empty($newCountryBudgetItem) ? $newCountryBudgetItem : null;
    }

    /**
     * Returns budget items array.
     *
     * @param $budgetItems
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getBudgetItemsData($budgetItems): array
    {
        $newBudgetItems = [];

        foreach (array_values($budgetItems) as $key => $budgetItem) {
            if (array_key_exists(
                Arr::get($budgetItem, 'code_text', null),
                getCodeList('BudgetIdentifier', 'Activity', false)
            )) {
                $newBudgetItems[$key] = [
                    'code'        => Arr::get($budgetItem, 'code_text', null),
                    'percentage'  => Arr::get($budgetItem, 'percentage', null),
                    'description' => Arr::get($budgetItem, 'description', null),
                ];
            }
        }

        return count($newBudgetItems) ? $newBudgetItems : $this->emptyBudgetItemTemplate;
    }

    /**
     * Returns activity default aid type data.
     *
     * @param $defaultAidTypes
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityDefaultAidTypeData($defaultAidTypes): ?array
    {
        if (!$defaultAidTypes) {
            return null;
        }

        $defaultAidTypesArray = json_decode($defaultAidTypes, true, 512, JSON_THROW_ON_ERROR);

        if (!$defaultAidTypesArray) {
            return null;
        }

        if (is_array($defaultAidTypesArray)) {
            return $this->getActivityUpdatedVocabularyData(
                $defaultAidTypes,
                'default_aidtype_vocabulary',
                $this->defaultAidTypeReplaceArray,
                $this->defaultAidTypeRemoveArray,
                '1'
            );
        }

        if (array_key_exists($defaultAidTypesArray, getCodeList('AidType', 'Activity', false))) {
            return [
                [
                    'default_aid_type_vocabulary' => '1',
                    'default_aid_type'            => $defaultAidTypesArray,
                ],
            ];
        }

        return null;
    }

    /**
     * Returns activity planned disbursement data.
     *
     * @param $plannedDisbursements
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityPlannedDisbursementData($plannedDisbursements): ?array
    {
        if (!$plannedDisbursements) {
            return null;
        }

        $newPlannedDisbursements = [];
        $plannedDisbursementsArray = json_decode($plannedDisbursements, true, 512, JSON_THROW_ON_ERROR);

        if ($plannedDisbursementsArray && count($plannedDisbursementsArray)) {
            foreach (array_values($plannedDisbursementsArray) as $key => $plannedDisbursement) {
                $newPlannedDisbursements[$key] = [
                    'planned_disbursement_type' => Arr::get($plannedDisbursement, 'planned_disbursement_type', null),
                    'period_start'              => Arr::get($plannedDisbursement, 'period_start', null),
                    'period_end'                => Arr::get($plannedDisbursement, 'period_end', null),
                    'value'                     => Arr::get($plannedDisbursement, 'value', null),
                    'provider_org'              => [
                        [
                            'ref'                  => Arr::get($plannedDisbursement, 'provider_org.0.ref', null),
                            'provider_activity_id' => Arr::get(
                                $plannedDisbursement,
                                'provider_org.0.activity_id',
                                null
                            ),
                            'type'                 => Arr::get($plannedDisbursement, 'provider_org.0.type', null),
                            'narrative'            => Arr::get($plannedDisbursement, 'provider_org.0.narrative', null),
                        ],
                    ],
                    'receiver_org'              => [
                        [
                            'ref'                  => Arr::get($plannedDisbursement, 'receiver_org.0.ref', null),
                            'receiver_activity_id' => Arr::get(
                                $plannedDisbursement,
                                'receiver_org.0.activity_id',
                                null
                            ),
                            'type'                 => Arr::get($plannedDisbursement, 'receiver_org.0.type', null),
                            'narrative'            => Arr::get($plannedDisbursement, 'receiver_org.0.narrative', null),
                        ],
                    ],
                ];
            }
        }

        return count($newPlannedDisbursements) ? $newPlannedDisbursements : null;
    }

    /**
     * Returns activity capital spend data.
     *
     * @param $capitalSpend
     *
     * @return float|null
     *
     * @throws \JsonException
     */
    public function getActivityCapitalSpendData($capitalSpend): ?float
    {
        if (!$capitalSpend) {
            return null;
        }

        if (is_int($capitalSpend) || is_float($capitalSpend)) {
            return (float) $capitalSpend;
        }

        return (float) json_decode($capitalSpend, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Returns activity document link data.
     *
     * @param $aidstreamActivity
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityDocumentLinkData($aidstreamActivity): ?array
    {
        if (!$aidstreamActivity) {
            return null;
        }

        $documentLinks = $this->db::connection('aidstream')->table('activity_document_links')->where(
            'activity_id',
            $aidstreamActivity->id
        )->get();

        if (!count($documentLinks)) {
            return null;
        }

        $newDocumentLinks = [];

        foreach ($documentLinks as $documentLink) {
            $document = $documentLink->document_link ? json_decode(
                $documentLink->document_link,
                true,
                512,
                JSON_THROW_ON_ERROR
            ) : [];
            $newDocumentLinks[] = [
                'url'           => Arr::get($document, 'url', null),
                'format'        => Arr::get($document, 'format', null),
                'title'         => Arr::get($document, 'title', $this->emptyDocumentLinkTemplate['title']),
                'description'   => Arr::get($document, 'description', $this->emptyDocumentLinkTemplate['description']),
                'category'      => Arr::get($document, 'category', $this->emptyDocumentLinkTemplate['category']),
                'language'      => $this->getDocumentLinkLanguage(Arr::get($document, 'language', null)),
                'document_date' => Arr::get($document, 'document_date', $this->emptyDocumentLinkTemplate['document_date']),
            ];
        }

        return count($newDocumentLinks) ? $newDocumentLinks : null;
    }

    /**
     * Returns document link language data.
     *
     * @param $languages
     *
     * @return array
     */
    public function getDocumentLinkLanguage($languages): array
    {
        if (!$languages) {
            return $this->documentLinkLanguageTemplate;
        }

        $newLanguages = [];

        if (count($languages)) {
            foreach ($languages as $language) {
                $newLanguages[] = [
                    'code' => Arr::get($language, 'language', null),
                ];
            }
        }

        return count($newLanguages) ? $newLanguages : $this->documentLinkLanguageTemplate;
    }

    /**
     * Returns activity default values data.
     *
     * @param $defaultValues
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityDefaultFieldValues($defaultValues): ?array
    {
        if (!$defaultValues) {
            return null;
        }

        $defaultValues = json_decode($defaultValues, true, 512, JSON_THROW_ON_ERROR);

        if (!$defaultValues) {
            return null;
        }

        return [
            'default_currency'    => Arr::get($defaultValues, '0.default_currency', null),
            'default_language'    => Arr::get($defaultValues, '0.default_language', null),
            'hierarchy'           => !is_null(Arr::get($defaultValues, '0.default_hierarchy', null)) ? Arr::get(
                $defaultValues,
                '0.default_hierarchy',
                null
            ) : '1',
            'budget_not_provided' => Arr::get($defaultValues, '0.budget_not_provided', null),
            'humanitarian'        => !is_null(Arr::get($defaultValues, '0.humanitarian', null)) ? Arr::get(
                $defaultValues,
                '0.humanitarian',
                null
            ) : '1',
        ];
    }

    /**
     * Returns activity tag data.
     *
     * @param $tags
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getActivityTagData($tags): ?array
    {
        if (!$tags) {
            return null;
        }

        $newTags = [];
        $tagsArray = json_decode($tags, true, 512, JSON_THROW_ON_ERROR);

        if (count($tagsArray)) {
            foreach (array_values($tagsArray) as $key => $tag) {
                $newTags[$key] = $this->getTagData($tag);
            }
        }

        return count($newTags) ? $newTags : null;
    }

    /**
     * Returns tag data.
     *
     * @param $tag
     *
     * @return array
     */
    public function getTagData($tag): array
    {
        return match (Arr::get($tag, 'tag_vocabulary', '1')) {
            '2' => [
                'tag_vocabulary' => Arr::get($tag, 'vocabulary', '2'),
                'goals_tag_code' => Arr::get($tag, 'goals_tag_code', null),
                'narrative'      => Arr::get($tag, 'narrative', null),
            ],
            '3' => [
                'tag_vocabulary'   => Arr::get($tag, 'vocabulary', '3'),
                'targets_tag_code' => Arr::get($tag, 'targets_tag_code', null),
                'narrative'        => Arr::get($tag, 'narrative', null),
            ],
            '99' => [
                'tag_vocabulary' => Arr::get($tag, 'vocabulary', '99'),
                'tag_text'       => Arr::get($tag, 'tag_text', null),
                'vocabulary_uri' => Arr::get($tag, 'vocabulary_uri', null),
                'narrative'      => Arr::get($tag, 'narrative', null),
            ],
            default => [
                'tag_vocabulary' => Arr::get($tag, 'vocabulary', '1'),
                'tag_text'       => Arr::get($tag, 'tag_code', null),
                'narrative'      => Arr::get($tag, 'narrative', null),
            ],
        };
    }
}