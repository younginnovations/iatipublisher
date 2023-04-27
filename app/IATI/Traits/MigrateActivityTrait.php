<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use App\Exceptions\PublishException;
use App\IATI\Models\User\Role;
use App\IATI\Repositories\Activity\ActivityRepository;
use DOMException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use JsonException;

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
            'Crs Channel Code'  => 'crs_channel_code',
        ];

    /**
     * Contains values to be removed.
     *
     * @var array
     */
    protected array $participatingOrgRemoveArray = ['country', 'org_data_id', 'is_publisher'];

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
            '1'  => ['custom_code', 'region_code_input', 'vocabulary_uri', 'custom_vocabulary_uri', 'vocabulary-uri'],
            '2'  => ['region_code', 'region_code_input', 'vocabulary_uri', 'custom_vocabulary_uri', 'vocabulary-uri'],
            '99' => ['region_code', 'region_code_input', 'custom_vocabulary_uri', 'vocabulary-uri'],
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
            'language'      => [['language' => null]],
            'document_date' => [['date' => null]],
        ];

    /**
     * Empty template for narrative.
     *
     * @var array
     */
    protected array $emptyNarrativeTemplate
        = [
            [
                'narrative' => null,
                'language'  => null,
            ],
        ];

    /**
     * Returns vocabulary uri array.
     *
     * @var array
     */
    protected array $vocabularyUriArray
        = [
            'region_vocabulary' => 'vocabulary_uri',
            'sector_vocabulary' => 'vocabulary_uri',
            'vocabulary'        => 'vocabulary_uri', // Humanitarian Scope and Policy Marker
        ];

    /**
     * Empty budget value array.
     *
     * @var array
     */
    protected array $emptyValueArray
        = [
            [
                'amount'     => null,
                'currency'   => null,
                'value_date' => null,
            ],
        ];

    /**
     * Empty period data array.
     *
     * @var array
     */
    protected array $emptyPeriodDateArray
        = [
            [
                'date' => null,
            ],
        ];

    /**
     * Returns IATI activity data.
     *
     * @param $aidstreamActivity
     * @param $iatiOrganization
     * @param $aidStreamOrganization
     *
     * @return array
     *
     * @throws JsonException
     */
    public function getNewActivity($aidstreamActivity, $iatiOrganization, $aidStreamOrganization): array
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
        $newActivity['activity_date'] = $aidstreamActivity ? $this->getActivityDateData(
            $aidstreamActivity->activity_date
        ) : null;
        $newActivity['contact_info'] = $aidstreamActivity ? $this->getActivityFirstLevelData(
            $aidstreamActivity->contact_info,
            $this->contactInfoReplaceArray
        ) : null;
        $newActivity['activity_scope'] = $aidstreamActivity ? $this->getIntSelectValue(
            $aidstreamActivity->activity_scope,
            'ActivityScope',
            'Activity'
        ) : null;
        $newActivity['participating_org'] = $aidstreamActivity ? $this->getActivityParticipatingOrganizationData(
            $aidstreamActivity->participating_organization
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
            $aidstreamActivity,
            $iatiOrganization,
            $aidStreamOrganization
        ) : null;
        $newActivity['sector'] = $aidstreamActivity ? $this->getActivityUpdatedVocabularyData(
            $aidstreamActivity->sector,
            'sector_vocabulary',
            $this->sectorReplaceArray,
            $this->sectorRemoveArray,
            '1'
        ) : null;
        $newActivity['country_budget_items'] = $aidstreamActivity ? $this->getActivityCountryBudgetItemsData(
            $aidstreamActivity,
            $iatiOrganization,
            $aidStreamOrganization,
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
        $newActivity['budget'] = $aidstreamActivity ? $this->getActivityBudgetData($aidstreamActivity->budget) : null;
        $newActivity['planned_disbursement'] = $aidstreamActivity ? $this->getActivityPlannedDisbursementData(
            $aidstreamActivity->planned_disbursement
        ) : null;
        $newActivity['capital_spend'] = $aidstreamActivity ? $this->getActivityCapitalSpendData(
            $aidstreamActivity->capital_spend
        ) : null;
        $newActivity['document_link'] = $aidstreamActivity ? $this->getActivityDocumentLinkData(
            $aidstreamActivity,
            $iatiOrganization->id
        ) : null;
        $newActivity['related_activity'] = $this->getColumnValueArray($aidstreamActivity, 'related_activity');
        $newActivity['legacy_data'] = $aidstreamActivity ? $this->getActivityFirstLevelData(
            $aidstreamActivity->legacy_data,
            $this->legacyDataReplaceArray,
        ) : null;
        $newActivity['conditions'] = $this->getConditions($this->getColumnValueArray($aidstreamActivity, 'conditions'));
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
        $newActivity['reporting_org'] = $iatiOrganization->reporting_org;
        $newActivity['upload_medium'] = 'manual';
        $newActivity['migrated_from_aidstream'] = true;

        return $newActivity;
    }

    /**
     * Returns activity other identifier data.
     *
     * @param $aidstreamOtherIdentifiers
     *
     * @return array|null
     *
     * @throws JsonException
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
                        $this->emptyNarrativeTemplate
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
     * @throws JsonException
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
     * @param  string  $defaultVocabulary
     *
     * @return array|null
     *
     * @throws JsonException
     */
    public function getActivityUpdatedVocabularyData(
        $object,
        $vocabulary,
        $replaceArray,
        $removeArray,
        string $defaultVocabulary = '1'
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

                if (array_key_exists($vocabulary, $this->vocabularyUriArray) &&
                    (Arr::get($item, $vocabulary, '1') === '99' || Arr::get($item, $vocabulary, '1') === '98') &&
                    !array_key_exists($this->vocabularyUriArray[$vocabulary], $item)
                ) {
                    $item[$this->vocabularyUriArray[$vocabulary]] = null;
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
                if ($innerKey === 'narrative') {
                    $innerItem = $this->getNarrativeFromNested($innerItem);
                }

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
     *
     * @param $aidstreamActivity
     * @param $iatiOrganization
     * @param $aidstreamOrganization
     *
     * @return array|null
     *
     * @throws JsonException
     */
    public function getActivityLocationData($aidstreamActivity, $iatiOrganization, $aidstreamOrganization): ?array
    {
        $locations = $aidstreamActivity->location;

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
                $newLocations[$key]['name'] = Arr::get($locationArray, 'name', $this->emptyNarrativeTemplate);
                $newLocations[$key]['description'] = Arr::get($locationArray, 'location_description', $this->emptyNarrativeTemplate);
                $newLocations[$key]['activity_description'] = Arr::get($locationArray, 'activity_description', $this->emptyNarrativeTemplate);
                $newLocations[$key]['administrative'] = $this->getLocationAdministrativeData(
                    Arr::get($locationArray, 'administrative', null),
                    $aidstreamActivity,
                    $iatiOrganization,
                    $aidstreamOrganization,
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
     * @param $aidstreamActivity
     * @param $iatiOrganization
     * @param $aidstreamOrganization
     *
     * @return array
     *
     * @throws JsonException
     */
    public function getLocationAdministrativeData($administratives, $aidstreamActivity, $iatiOrganization, $aidstreamOrganization): array
    {
        if ($administratives && count($administratives)) {
            foreach (array_values($administratives) as $key => $administrative) {
                if (!empty(Arr::get($administrative, 'code', null)) && !array_key_exists(
                    strtoupper(Arr::get($administrative, 'code', null)),
                    getCodeList('Country', 'Activity', false)
                )) {
                    $message = "Free-text to select-option mismatch in Aidstream activity id: {$aidstreamActivity->id}, code: " . Arr::get($administrative, 'code', null);
                    $this->setGeneralError($message)->setDetailedError(
                        $message,
                        $aidstreamOrganization->id,
                        'activity_data',
                        $aidstreamActivity->id,
                        $iatiOrganization->id,
                        '',
                        'Activity > Local Administrative > Code'
                    );
                    $this->logInfo($message);

                    unset($administratives[$key]);
                } elseif (!empty(Arr::get($administrative, 'code', null)) && array_key_exists(
                    strtoupper(Arr::get($administrative, 'code', null)),
                    getCodeList('Country', 'Activity', false)
                )) {
                    $administratives[$key]['code'] = strtoupper(Arr::get($administrative, 'code', null));
                }
            }
        }

        return count($administratives) ? array_values($administratives) : $this->locationAdministrativeEmptyTemplate;
    }

    /**
     * Returns country budget items' data.
     *
     * @param $aidstreamActivity
     * @param $iatiOrganization
     * @param $aidstreamOrganization
     *
     * @return array|null
     *
     * @throws JsonException
     */
    public function getActivityCountryBudgetItemsData($aidstreamActivity, $iatiOrganization, $aidstreamOrganization): ?array
    {
        $countryBudgetItems = $aidstreamActivity->country_budget_items;

        if (!$countryBudgetItems) {
            return null;
        }

        $newCountryBudgetItem = [];
        $countryBudgetItemsArray = json_decode($countryBudgetItems, true, 512, JSON_THROW_ON_ERROR);

        if ($countryBudgetItemsArray && count($countryBudgetItemsArray) &&
            (string) Arr::get($countryBudgetItemsArray, '0.vocabulary', '1') === '1') {
            $message = "Aidstream activity id: {$aidstreamActivity->id} has Country budget item vocabulary =  1.";
            $this->setGeneralError($message)->setDetailedError(
                $message,
                $aidstreamOrganization->id,
                'activity_data',
                $aidstreamActivity->id,
                $iatiOrganization->id,
                '',
                'Activity > Country budget item > Vocabulary',
            );
            $this->logInfo($message);
        } elseif ($countryBudgetItemsArray && count($countryBudgetItemsArray) &&
            (string) Arr::get($countryBudgetItemsArray, '0.vocabulary', '1') !== '1') {
            $newCountryBudgetItem = [
                'country_budget_vocabulary' => Arr::get(
                    $countryBudgetItemsArray,
                    '0.vocabulary',
                    null
                ),
                'budget_item'               => $this->getBudgetItemsData(
                    Arr::get($countryBudgetItemsArray, '0.budget_item', null),
                    $aidstreamActivity,
                    $iatiOrganization,
                    $aidstreamOrganization,
                ),
            ];
        }

        return !empty($newCountryBudgetItem) ? $newCountryBudgetItem : null;
    }

    /**
     * Returns budget items array.
     *
     * @param $budgetItems
     * @param $aidstreamActivity
     * @param $iatiOrganization
     * @param $aidstreamOrganization
     *
     * @return array
     *
     * @throws JsonException
     */
    public function getBudgetItemsData($budgetItems, $aidstreamActivity, $iatiOrganization, $aidstreamOrganization): array
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
                    'description' => Arr::get($budgetItem, 'description', $this->emptyNarrativeTemplate),
                ];
            } else {
                $message = "Aidstream organization id: {$aidstreamOrganization->id} contains Code: '" . Arr::get($budgetItem, 'code_text', null) . "' in CodeList of activity id: {$aidstreamActivity->id}.";
                $this->setGeneralError($message)->setDetailedError(
                    $message,
                    $aidstreamOrganization->id,
                    'activity_data',
                    $aidstreamActivity->id,
                    $iatiOrganization->id,
                    '',
                    'Activity > Budget item > Code',
                );
                $this->logInfo($message);
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
     * @throws JsonException
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
            $newDefaultAidTypes = [];

            foreach (array_values($defaultAidTypesArray) as $key => $defaultAidType) {
                $newDefaultAidTypes[$key] = match ((string) Arr::get(
                    $defaultAidType,
                    'default_aidtype_vocabulary',
                    null
                )) {
                    '1' => [
                        'default_aid_type_vocabulary' => '1',
                        'default_aid_type'            => Arr::get($defaultAidType, 'default_aid_type', null),
                    ],
                    '2' => [
                        'default_aid_type_vocabulary' => '2',
                        'earmarking_category'         => Arr::get($defaultAidType, 'earmarking_category', null),
                    ],
                    '3' => [
                        'default_aid_type_vocabulary' => '3',
                        'earmarking_modality'         => Arr::get($defaultAidType, 'default_aid_type_text', null),
                    ],
                    '4' => [
                        'default_aid_type_vocabulary' => '4',
                        'cash_and_voucher_modalities' => Arr::get($defaultAidType, 'cash_and_voucher_modalities', null),
                    ],
                    default => [
                        'default_aid_type_vocabulary' => null,
                        'default_aid_type'            => null,
                    ],
                };
            }

            return count($newDefaultAidTypes) ? $newDefaultAidTypes : null;
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
     * @throws JsonException
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
                    'period_start'              => Arr::get(
                        $plannedDisbursement,
                        'period_start',
                        $this->emptyPeriodDateArray
                    ),
                    'period_end'                => Arr::get(
                        $plannedDisbursement,
                        'period_end',
                        $this->emptyPeriodDateArray
                    ),
                    'value'                     => Arr::get($plannedDisbursement, 'value', $this->emptyValueArray),
                    'provider_org'              => [
                        [
                            'ref'                  => Arr::get($plannedDisbursement, 'provider_org.0.ref', null),
                            'provider_activity_id' => Arr::get(
                                $plannedDisbursement,
                                'provider_org.0.activity_id',
                                null
                            ),
                            'type'                 => Arr::get($plannedDisbursement, 'provider_org.0.type', null),
                            'narrative'            => Arr::get(
                                $plannedDisbursement,
                                'provider_org.0.narrative',
                                $this->emptyNarrativeTemplate
                            ),
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
                            'narrative'            => Arr::get(
                                $plannedDisbursement,
                                'receiver_org.0.narrative',
                                $this->emptyNarrativeTemplate
                            ),
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
     * @throws JsonException
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
     * @param $iatiOrganizationId
     *
     * @return array|null
     *
     * @throws JsonException
     */
    public function getActivityDocumentLinkData($aidstreamActivity, $iatiOrganizationId): ?array
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
                'url'           => !empty(Arr::get($document, 'url', null)) ? $this->replaceDocumentLinkUrl(
                    Arr::get($document, 'url', null),
                    $iatiOrganizationId
                ) : null,
                'format'        => Arr::get($document, 'format', null),
                'title'         => Arr::get($document, 'title', $this->emptyDocumentLinkTemplate['title']),
                'description'   => Arr::get($document, 'description', $this->emptyDocumentLinkTemplate['description']),
                'category'      => Arr::get($document, 'category', $this->emptyDocumentLinkTemplate['category']),
                'language'      => $this->getDocumentLinkLanguage(Arr::get($document, 'language', null)),
                'document_date' => Arr::get(
                    $document,
                    'document_date',
                    $this->emptyDocumentLinkTemplate['document_date']
                ),
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
     *
     * @throws JsonException
     */
    public function getDocumentLinkLanguage($languages): array
    {
        if (!$languages) {
            return $this->documentLinkLanguageTemplate;
        }

        $newLanguages = [];

        if (is_string($languages)) {
            $languages = json_decode($languages, true, 512, JSON_THROW_ON_ERROR);
        }

        if ($languages && is_array($languages) && count($languages)) {
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
     * @throws JsonException
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
     * @throws JsonException
     */
    public function getActivityTagData($tags): ?array
    {
        if (!$tags) {
            return null;
        }

        $newTags = [];
        $tagsArray = json_decode($tags, true, 512, JSON_THROW_ON_ERROR);

        if ($tagsArray && count($tagsArray)) {
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
        return match ((string) Arr::get($tag, 'tag_vocabulary', null)) {
            '1' => [
                'tag_vocabulary' => Arr::get($tag, 'vocabulary', '1'),
                'tag_text'       => Arr::get($tag, 'tag_code', null),
                'narrative'      => Arr::get($tag, 'narrative', $this->emptyNarrativeTemplate),
            ],
            '2' => [
                'tag_vocabulary' => Arr::get($tag, 'vocabulary', '2'),
                'goals_tag_code' => Arr::get($tag, 'goals_tag_code', null),
                'narrative'      => Arr::get($tag, 'narrative', $this->emptyNarrativeTemplate),
            ],
            '3' => [
                'tag_vocabulary'   => Arr::get($tag, 'vocabulary', '3'),
                'targets_tag_code' => Arr::get($tag, 'targets_tag_code', null),
                'narrative'        => Arr::get($tag, 'narrative', $this->emptyNarrativeTemplate),
            ],
            '99' => [
                'tag_vocabulary' => Arr::get($tag, 'vocabulary', '99'),
                'tag_text'       => Arr::get($tag, 'tag_text', null),
                'vocabulary_uri' => Arr::get($tag, 'vocabulary_uri', null),
                'narrative'      => Arr::get($tag, 'narrative', $this->emptyNarrativeTemplate),
            ],
            default => [
                'tag_vocabulary' => null,
                'tag_text'       => null,
                'narrative'      => $this->emptyNarrativeTemplate,
            ],
        };
    }

    /**
     * Returns activity participating organization data.
     *
     * @param $participatingOrganizations
     *
     * @return array|null
     *
     * @throws JsonException
     */
    public function getActivityParticipatingOrganizationData($participatingOrganizations): ?array
    {
        if (!$participatingOrganizations) {
            return null;
        }

        $newParticipatingOrganizations = [];
        $participatingOrganizationsArray = json_decode($participatingOrganizations, true, 512, JSON_THROW_ON_ERROR);

        if ($participatingOrganizationsArray && count($participatingOrganizationsArray)) {
            foreach (array_values($participatingOrganizationsArray) as $key => $participatingOrganization) {
                $newParticipatingOrganizations[$key] = [
                    'organization_role' => Arr::get($participatingOrganization, 'organization_role', null),
                    'ref'               => Arr::get($participatingOrganization, 'identifier', null),
                    'type'              => Arr::get($participatingOrganization, 'organization_type', null),
                    'identifier'        => Arr::get($participatingOrganization, 'activity_id', null),
                    'crs_channel_code'  => Arr::get($participatingOrganization, 'crs_channel_code', null),
                    'narrative'         => Arr::get(
                        $participatingOrganization,
                        'narrative',
                        $this->emptyNarrativeTemplate
                    ),
                ];
            }
        }

        return count($newParticipatingOrganizations) ? $newParticipatingOrganizations : null;
    }

    /**
     * Returns activity budget data.
     *
     * @param $budgets
     *
     * @return array|null
     *
     * @throws JsonException
     */
    public function getActivityBudgetData($budgets): ?array
    {
        if (!$budgets) {
            return null;
        }

        $newBudgets = [];
        $budgetsArray = json_decode($budgets, true, 512, JSON_THROW_ON_ERROR);

        if ($budgetsArray && count($budgetsArray)) {
            foreach (array_values($budgetsArray) as $key => $budget) {
                $newBudgets[$key] = [
                    'budget_status' => Arr::get($budget, 'status', null),
                    'budget_type'   => Arr::get($budget, 'budget_type', null),
                    'period_start'  => Arr::get($budget, 'period_start', $this->emptyPeriodDateArray),
                    'period_end'    => Arr::get($budget, 'period_end', $this->emptyPeriodDateArray),
                    'budget_value'  => Arr::get($budget, 'value', $this->emptyValueArray),
                ];
            }
        }

        return count($newBudgets) ? $newBudgets : null;
    }

    /**
     * Returns activity date data.
     *
     * @param $dates
     *
     * @return array|null
     *
     * @throws JsonException
     */
    public function getActivityDateData($dates): ?array
    {
        if (!$dates) {
            return null;
        }

        $newDates = [];
        $datesArray = json_decode($dates, true, 512, JSON_THROW_ON_ERROR);

        if ($datesArray && count($datesArray)) {
            foreach (array_values($datesArray) as $key => $dateArray) {
                $newDates[$key] = [
                    'type'      => !is_null(Arr::get($dateArray, 'type', null)) ? (string) Arr::get(
                        $dateArray,
                        'type',
                        null
                    ) : null,
                    'date'      => !is_null(Arr::get($dateArray, 'date', null)) ? (string) Arr::get(
                        $dateArray,
                        'date',
                        null
                    ) : null,
                    'narrative' => $this->getNarrativeFromNested(Arr::get($dateArray, 'narrative', [])),
                ];
            }
        }

        return count($newDates) ? $newDates : null;
    }

    /**
     * Returns narrative for normal and single nested array.
     *
     * @param $narratives
     *
     * @return array
     */
    public function getNarrativeFromNested($narratives): array
    {
        if (!count($narratives)) {
            return $this->emptyNarrativeTemplate;
        }

        $newNarratives = [];

        foreach ($narratives as $narrative) {
            if (array_key_exists('narrative', $narrative) && array_key_exists('language', $narrative)) {
                $newNarratives[] = [
                    'narrative' => !empty(Arr::get($narrative, 'narrative', null)) ? Arr::get(
                        $narrative,
                        'narrative',
                        null
                    ) : null,
                    'language'  => !empty(Arr::get($narrative, 'language', null)) ? Arr::get(
                        $narrative,
                        'language',
                        null
                    ) : null,
                ];
            } elseif (array_key_exists(0, $narrative)) {
                $newNarratives[] = [
                    'narrative' => !empty(Arr::get($narrative, '0.narrative', null)) ? Arr::get(
                        $narrative,
                        '0.narrative',
                        null
                    ) : null,
                    'language'  => !empty(Arr::get($narrative, '0.language', null)) ? Arr::get(
                        $narrative,
                        '0.language',
                        null
                    ) : null,
                ];
            }
        }

        return count($newNarratives) ? $newNarratives : $this->emptyNarrativeTemplate;
    }

    /**
     * Returns proper condition.
     *
     * @param array|null $conditionArray
     * @return array|null
     */
    public function getConditions(?array $conditionArray): ?array
    {
        if ($conditionArray) {
            if (!$conditionArray['condition']) {
                $conditionArray['condition'] = null;
            }

            return  $conditionArray;
        }

        return null;
    }

    /**
     * Migrated aid stream activity snapshot to iati activity snapshot table.
     *
     * @param $iatiActivity
     * @param $aidstreamActivity
     *
     * @return void
     */
    public function migrateActivitySnapshot($iatiActivity, $aidstreamActivity): void
    {
        $aidStreamActivitySnapshots = $this->db::connection('aidstream')->table('activity_snapshots')->where(
            'activity_id',
            $aidstreamActivity->id
        )->get();

        if (count($aidStreamActivitySnapshots)) {
            $iatiActivitySnapshots = [];

            foreach ($aidStreamActivitySnapshots as $aidActivitySnapshot) {
                $iatiActivitySnapshots[] = [
                    'org_id'         => $iatiActivity->org_id,
                    'activity_id'    => $iatiActivity->id,
                    'published_data' => $aidActivitySnapshot->published_data,
                    'filename'       => $aidActivitySnapshot->filename,
                    'created_at'     => $aidActivitySnapshot->created_at,
                    'updated_at'     => $aidActivitySnapshot->updated_at,
                ];
            }
            $this->activitySnapshotService->insert($iatiActivitySnapshots);
            $this->logInfo(
                'Completed migrating activity snapshots for organization id ' . $aidstreamActivity->organization_id
            );
        }
    }

    /**
     * Set default values where empty.
     *
     * @param $iatiElement
     * @param $aidStreamOrganizationSetting
     * @param bool $activityLevel
     * @return void
     * @throws BindingResolutionException
     */
    private function setDefaultValues($iatiElement, $aidStreamOrganizationSetting, $activityLevel = true): void
    {
        $defaultFieldValues = $aidStreamOrganizationSetting->default_field_values;

        if ($activityLevel) {
            $activityRepository = app()->make(ActivityRepository::class);
            $defaultFieldValues = $activityRepository->resolveDefaultValues($iatiElement);
        }

        if ($defaultFieldValues) {
            $data = $iatiElement->toArray();
            $updatedIatiData = $this->populateDefaultFields($data, $defaultFieldValues);
            $iatiElement->timestamps = false;
            $iatiElement->updateQuietly($updatedIatiData, ['touch'=>false]);
        }
    }

    /**
     * Saves the organization complete status.
     *
     * @param $iatiOrganization
     *
     * @return void
     *
     * @throws JsonException
     */
    public function updateOrganizationCompleteStatus($iatiOrganization): void
    {
        $this->setElementStatus($iatiOrganization);
        $iatiOrganization->timestamps = false;
        $iatiOrganization->saveQuietly(['touch'=>false]);
    }

    /**
     * Migrates AidStream activities if needed.
     *
     * @param $iatiOrganization
     * @param $aidstreamActivities
     * @param $aidStreamOrganization
     * @param $aidStreamOrganizationSetting
     *
     * @return object|null
     *
     * @throws BindingResolutionException
     *
     * @throws JsonException|DOMException|PublishException
     */
    public function migrateActivitiesAndOthersIfNeeded($iatiOrganization, $aidstreamActivities, $aidStreamOrganization, $aidStreamOrganizationSetting): ?object
    {
        $migratedActivitiesLookupTable = [];
        $iatiActivities = $iatiOrganization->allActivities->pluck('iati_identifier.activity_identifier')->toArray();
        $activityPublished = null;

        if (count($aidstreamActivities)) {
            foreach ($aidstreamActivities as $aidstreamActivity) {
                $aidstreamIdentifier = $this->getActivityIdentifier($aidstreamActivity->identifier);

                if (!is_null($aidstreamIdentifier) && !in_array($aidstreamIdentifier, $iatiActivities, true)) {
                    $this->logInfo(
                        'Started activity migration for activity id: ' . $aidstreamActivity->id . ' of organization: ' . $aidStreamOrganization->name
                    );
                    $iatiActivity = $this->activityService->create(
                        $this->getNewActivity($aidstreamActivity, $iatiOrganization, $aidStreamOrganization)
                    );
                    $this->auditService->setAuditableId($iatiActivity->id)->auditMigrationEvent(
                        $iatiActivity,
                        'migrated-activity'
                    );
                    $migratedActivitiesLookupTable[$aidstreamActivity->id] = $iatiActivity->id;
                    $this->logInfo(
                        'Completed basic activity migration for activity id: ' . $aidstreamActivity->id . ' of organization: ' . $aidStreamOrganization->name
                    );

                    $this->migrateActivityTransactions($aidstreamActivity->id, $iatiActivity->id);
                    $this->migrateActivityResults($iatiActivity, $aidstreamActivity, $iatiOrganization);
                    $this->setDefaultValues($iatiActivity, $aidStreamOrganizationSetting);
                    $this->migrateActivitySnapshot($iatiActivity, $aidstreamActivity);
                }
            }

            if (!empty($migratedActivitiesLookupTable)) {
                $this->migrateActivitiesPublishedFiles(
                    $aidStreamOrganization,
                    $iatiOrganization,
                    $migratedActivitiesLookupTable
                );
                $this->migrateActivityPublishedTable(
                    $aidStreamOrganization,
                    $iatiOrganization,
                    $migratedActivitiesLookupTable
                );
                $activityPublished = $this->migrateActivityMergedFile(
                    $aidStreamOrganization,
                    $iatiOrganization,
                    true
                );
            }
        }

        $this->migrateDocumentFiles($aidStreamOrganization, $iatiOrganization);
        $this->migrateDocuments(
            $aidStreamOrganization->id,
            $iatiOrganization,
            $migratedActivitiesLookupTable
        );

        return $activityPublished;
    }

    /**
     * Returns AidStream activity identifier.
     *
     * @param $identifier
     *
     * @return string|null
     *
     * @throws JsonException
     */
    public function getActivityIdentifier($identifier): ?string
    {
        if (!$identifier) {
            return null;
        }

        $identifierArray = json_decode($identifier, true, 512, JSON_THROW_ON_ERROR);

        if (!$identifierArray || !is_array($identifierArray)) {
            return null;
        }

        return Arr::get($identifierArray, 'activity_identifier', null);
    }
}
