<?php

use Illuminate\Support\Arr;

function hasDeprecatedValue($element, $compareMap): bool
{
    foreach ($element as $key => $value) {
        if (is_array($value)) {
            if (hasDeprecatedValue($value, $compareMap)) {
                return true;
            }
        } else {
            if (isset($compareMap[$key])) {
                foreach ($compareMap[$key] as $item) {
                    if ($item['code'] == $value) {
                        return true;
                    }
                }
            }
        }
    }

    return false;
}

/**
 * @param $element
 * @param $compareMap
 * @param string $path
 *
 * @return array
 */
function generateDeprecationMap($element, $compareMap, string $path = ''): array
{
    $results = [];

    if ($results) {
        foreach ($element as $key => $value) {
            if (is_array($value)) {
                $nestedResults = generateDeprecationMap($value, $compareMap, $path . ($path === '' ? '' : '.') . $key);
                if (!empty($nestedResults)) {
                    $results[$key] = $nestedResults;
                }
            } else {
                if (isset($compareMap[$key])) {
                    $deprecated = false;
                    foreach ($compareMap[$key] as $item) {
                        if ($item['code'] == $value) {
                            $deprecated = (string) $value;
                            break;
                        }
                    }
                    $results[$key] = $deprecated;
                }
            }
        }
    }

    return $results;
}

function onlyDeprecatedItemsFromCodeList(string $path)
{
    $dataKey = explode('/', $path);
    $dataKey = $dataKey[count($dataKey) - 1];
    $dataKey = explode('.', $dataKey);
    $dataKey = $dataKey[0];

    $codeList = json_decode(getJsonFromSource($path), true);
    $codeItems = Arr::get($codeList, $dataKey, []);

    return array_filter($codeItems, function ($item) {
        return Arr::get($item, 'status', false) !== 'active';
    });
}

function doesIatiIdentifierHaveDeprecatedCode($iatiIdentifier): array
{
    return [];
}

function doesOtherIdentifierHaveDeprecatedCode($otherIdentifier): array
{
    $compareMap = [
        'reference_type' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/OtherIdentifierType.json'),
        'language'       => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($otherIdentifier, $compareMap, '');
}

function doesTitleHaveDeprecatedCode($title): array
{
    $compareMap = [
        'language' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($title, $compareMap);
}

function doesDescriptionHaveDeprecatedCode($description): array
{
    $compareMap = [
        'type'     => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/DescriptionType.json'),
        'language' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($description, $compareMap);
}

function doesActivityStatusHaveDeprecatedCode($activityStatus): array
{
    $compareMap = [
        'code' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/ActivityStatus.json'),
    ];

    return generateDeprecationMap($activityStatus, $compareMap);
}

function doesActivityDateHaveDeprecatedCode($activityDate): array
{
    $compareMap = [
        'type'     => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/ActivityDateType.json'),
        'language' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($activityDate, $compareMap);
}

function doesContactInfoHaveDeprecatedCode($contactInfo): array
{
    $compareMap = [
        'type'     => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/ContactType.json'),
        'language' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($contactInfo, $compareMap);
}

function doesActivityScopeHaveDeprecatedCode($activityScope): array
{
    $compareMap = [
        'code' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/ActivityScope.json'),
    ];

    return generateDeprecationMap($activityScope, $compareMap);
}

function doesParticipatingOrgHaveDeprecatedCode($participatingOrg): array
{
    $compareMap = [
        'organization_role' => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/OrganisationRole.json'),
        'type'              => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/OrganizationType.json'),
        'crs_channel_code'  => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/CRSChannelCode.json'),
        'language'          => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($participatingOrg, $compareMap);
}

function doesRecipientCountryHaveDeprecatedCode($recipientCountry): array
{
    $compareMap = [
        'country_code' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Country.json'),
        'language'     => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($recipientCountry, $compareMap);
}

function doesRecipientRegionHaveDeprecatedCode($recipientRegion): array
{
    $compareMap = [
        'region_vocabulary' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/RegionVocabulary.json'),
        'region_code'       => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Region.json'),
        'language'          => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($recipientRegion, $compareMap);
}

function doesLocationHaveDeprecatedCode($location): array
{
    $compareMap = [
        'location_reach'      => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/GeographicLocationReach.json'),
        'location_id'         => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/GeographicVocabulary.json'),
        'administrative'      => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/GeographicVocabulary.json'),
        'exactness'           => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/GeographicExactness.json'),
        'location_class'      => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/LocationType.json'),
        'feature_designation' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/LocationType.json'),
        'language'            => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
        'code', 'country_code' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Country.json'),
    ];

    return generateDeprecationMap($location, $compareMap);
}

function doesSectorHaveDeprecatedCode($sector): array
{
    $compareMap = [
        'sector_vocabulary' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/SectorVocabulary.json'),
        'category_code'     => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/SectorCategory.json'),
        'code'              => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/SectorCode.json'),
        'language'          => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($sector, $compareMap);
}

function doesCountryBudgetItemsHaveDeprecatedCode($countryBudgetItems): array
{
    $compareMap = [
        'country_budget_vocabulary' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/BudgetIdentifierVocabulary.json'),
        'code'                      => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/BudgetIdentifier.json'),
        'language'                  => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($countryBudgetItems, $compareMap);
}

function doesHumanitarianScopeHaveDeprecatedCode($humanitarianScope): array
{
    $compareMap = [
        'type'       => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/HumanitarianScopeType.json'),
        'vocabulary' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/HumanitarianScopeVocabulary.json'),
        'language'   => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($humanitarianScope, $compareMap);
}

function doesPolicyMarkerHaveDeprecatedCode($policyMarker): array
{
    $compareMap = [
        'policy_marker_vocabulary' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/PolicyMarkerVocabulary.json'),
        'significance'             => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/PolicySignificance.json'),
        'policy_marker'            => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/PolicyMarker.json'),
    ];

    return generateDeprecationMap($policyMarker, $compareMap);
}

function doesCollaborationTypeHaveDeprecatedCode($collaborationType): array
{
    return [];
}

function doesDefaultFlowTypeHaveDeprecatedCode($defaultFlowType): array
{
    $compareMap = [
        'code' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/FlowType.json'),
    ];

    return generateDeprecationMap($defaultFlowType, $compareMap);
}

function doesDefaultFinanceTypeHaveDeprecatedCode($defaultFinanceType): array
{
    $compareMap = [
        'code' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/FinanceType.json'),
    ];

    return generateDeprecationMap($defaultFinanceType, $compareMap);
}

function doesDefaultAidTypeHaveDeprecatedCode($defaultAidType): array
{
    $compareMap = [
        'default_aid_type_vocabulary' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/AidTypeVocabulary.json'),
        'default_aid_type'            => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/AidType.json'),
    ];

    return generateDeprecationMap($defaultAidType, $compareMap);
}

function doesDefaultTiedStatusHaveDeprecatedCode($defaultTiedStatus): array
{
    $compareMap = [
        'code' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/TiedStatus.json'),
    ];

    return generateDeprecationMap($defaultTiedStatus, $compareMap);
}

function doesBudgetHaveDeprecatedCode($budget): array
{
    $compareMap = [
        'budget_status' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/BudgetStatus.json'),
        'budget_type'   => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/BudgetType.json'),
        'currency'      => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Currency.json'),
    ];

    return generateDeprecationMap($budget, $compareMap);
}

function doesPlannedDisbursementHaveDeprecatedCode($plannedDisbursement): array
{
    $compareMap = [
        'planned_disbursement_type' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/BudgetType.json'),
        'type'                      => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/OrganizationType.json'),
        'language'                  => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
        'currency'                  => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Currency.json'),
    ];

    return generateDeprecationMap($plannedDisbursement, $compareMap);
}

function doesCapitalSpendHaveDeprecatedCode($capitalSpend): array
{
    return [];
}

function doesDocumentLinkHaveDeprecatedCode($documentLink): array
{
    $compareMap = [
        'code'     => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/DocumentCategory.json'),
        'format'   => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/FileFormat.json'),
        'language' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($documentLink, $compareMap);
}

function doesRelatedActivityHaveDeprecatedCode($relatedActivity): array
{
    $compareMap = [
        'relationship_type' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/RelatedActivityType.json'),
    ];

    return generateDeprecationMap($relatedActivity, $compareMap);
}

function doesLegacyDataHaveDeprecatedCode($legacyData): array
{
    return [];
}

function doesConditionsHaveDeprecatedCode($conditions): array
{
    $compareMap = [
        'type'     => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/ConditionType.json'),
        'language' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($conditions, $compareMap);
}

function doesTagHaveDeprecatedCode($tag): array
{
    $compareMap = [
        'tag_vocabulary' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/TagVocabulary.json'),
        'language'       => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($tag, $compareMap);
}

function doesFlowTypeHaveDeprecatedCode($defaultFlowType): array
{
    $compareMap = [
        'flow_type' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/FlowType.json'),
    ];

    return generateDeprecationMap($defaultFlowType, $compareMap);
}

function doesFinanceTypeHaveDeprecatedCode($defaultFinanceType): array
{
    $compareMap = [
        'finance_type' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/FinanceType.json'),
    ];

    return generateDeprecationMap($defaultFinanceType, $compareMap);
}

function doesAidTypeHaveDeprecatedCode($defaultAidType): array
{
    $compareMap = [
        'aid_type_vocabulary' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/AidTypeVocabulary.json'),
        'aid_type'            => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/AidType.json'),
    ];

    return generateDeprecationMap($defaultAidType, $compareMap);
}

function doesTiedStatusHaveDeprecatedCode($defaultTiedStatus): array
{
    $compareMap = [
        'tied_status_code' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/TiedStatus.json'),
    ];

    return generateDeprecationMap($defaultTiedStatus, $compareMap);
}

function doesDisbursementChannelHaveDeprecatedCode($defaultTiedStatus): array
{
    $compareMap = [
        'disbursement_channel_code' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/TiedStatus.json'),
    ];

    return generateDeprecationMap($defaultTiedStatus, $compareMap);
}

function doesProviderOrganizationHaveDeprecatedCode($providerOrganization): array
{
    $compareMap = [
        'type'     => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/OrganizationType.json'),
        'language' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($providerOrganization, $compareMap);
}

function doesReceiverOrganizationHaveDeprecatedCode($receiverOrganization): array
{
    $compareMap = [
        'type'     => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/OrganizationType.json'),
        'language' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($receiverOrganization, $compareMap);
}

function doesTransactionTypeHaveDeprecatedCode($transactionType): array
{
    $compareMap = [
        'transaction_type_code' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/TransactionType.json'),
    ];

    return generateDeprecationMap($transactionType, $compareMap);
}

function doesHumanitarianHaveDeprecatedCode($humanitarian): array
{
    return [];
}

function doesValueHaveDeprecatedCode($element): array
{
    $compareMap = [
        'currency' => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Currency.json'),
    ];

    return generateDeprecationMap($element, $compareMap);
}

function doesOrganisationIdentifierHaveDeprecatedCode($element): array
{
    $compareMap = [
        'country'             => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Country.json'),
        'registration_agency' => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/OrganizationRegistrationAgency.json'),
    ];

    return generateDeprecationMap($element, $compareMap);
}

function doesOrganisationNameHaveDeprecatedCode($element): array
{
    $compareMap = [
        'language' => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Language.json'),
    ];

    return generateDeprecationMap($element, $compareMap);
}

function doesOrganisationReportingOrgHaveDeprecatedCode($element): array
{
    $compareMap = [
        'type'     => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/OrganizationType.json'),
        'language' => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Language.json'),
    ];

    return generateDeprecationMap($element, $compareMap);
}

function doesOrganisationTotalBudgetHaveDeprecatedCode($element): array
{
    $compareMap = [
        'currency' => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Currency.json'),
        'language' => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Language.json'),
    ];

    return generateDeprecationMap($element, $compareMap);
}

function doesOrganisationRecipientOrgBudgetHaveDeprecatedCode($element): array
{
    $compareMap = [
        'currency' => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Currency.json'),
        'language' => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Language.json'),
    ];

    return generateDeprecationMap($element, $compareMap);
}

function doesOrganisationRecipientRegionBudgetHaveDeprecatedCode($element): array
{
    $compareMap = [
        'region_vocabulary' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/RegionVocabulary.json'),
        'region_code'       => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Region.json'),
        'currency'          => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Currency.json'),
        'language'          => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Language.json'),
    ];

    return generateDeprecationMap($element, $compareMap);
}

function doesOrganisationRecipientCountryBudgetHaveDeprecatedCode($element): array
{
    $compareMap = [
        'country_code' => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Country.json'),
        'currency'     => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Currency.json'),
        'language'     => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Language.json'),
    ];

    return generateDeprecationMap($element, $compareMap);
}

function doesOrganisationTotalExpenditureHaveDeprecatedCode($element): array
{
    $compareMap = [
        'currency' => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Currency.json'),
        'language' => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Language.json'),
    ];

    return generateDeprecationMap($element, $compareMap);
}

function doesOrganisationDocumentLinkHaveDeprecatedCode($element): array
{
    $noRC = array_map(function ($elm) {
        unset($elm['recipient_country']);

        return $elm;
    }, $element);

    $compareMap1 = [
        'format'   => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/FileFormat.json'),
        'code'     => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/DocumentCategory.json'),
        'language' => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Language.json'),
    ];

    $array1 = generateDeprecationMap($noRC, $compareMap1);

    $compareMap2 = [
        'code' => onlyDeprecatedItemsFromCodeList('AppData/Data/Organization/Country.json'),
    ];

    $onlyRc = array_map(function ($elm) {
        return $elm['recipient_country'];
    }, $element);

    $array2 = generateDeprecationMap($onlyRc, $compareMap2);

    $returnArray = [];

    foreach ($array1 as $index => $elementInstanceWithNoRc) {
        $elementInstanceWithNoRc['recipient_country'] = Arr::get($array2, $index, []);
        $returnArray[$index] = $elementInstanceWithNoRc;
    }

    return $returnArray;
}

function doesMeasureHaveDeprecatedCode($element): array
{
    $compareMap = [
        'code' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/IndicatorMeasure.json'),
    ];

    return generateDeprecationMap($element, $compareMap);
}

function doesReferenceHaveDeprecatedCode($element): array
{
    $compareMap = [
        'vocabulary' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/IndicatorVocabulary.json'),

    ];

    return generateDeprecationMap($element, $compareMap);
}

function doesBaselineHaveDeprecatedCode($element): array
{
    $compareMap = [
        'code'     => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/DocumentCategory.json'),
        'format'   => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/FileFormat.json'),
        'language' => onlyDeprecatedItemsFromCodeList('AppData/Data/Activity/Language.json'),
    ];

    return generateDeprecationMap($element, $compareMap);
}

/**
 * @param string $completePath
 *
 * @return array|string[]
 */
function getKeysThatUseThisCodeList(string $completePath): array
{
    return [
        'AppData/Data/Activity/OtherIdentifierType.json'                => ['reference_type'],
        'AppData/Data/Activity/Language.json'                           => ['language'],
        'AppData/Data/Activity/DescriptionType.json'                    => ['type'],
        'AppData/Data/Activity/ActivityStatus.json'                     => ['code'],
        'AppData/Data/Activity/ActivityDateType.json'                   => ['type'],
        'AppData/Data/Activity/ContactType.json'                        => ['type'],
        'AppData/Data/Activity/ActivityScope.json'                      => ['code'],
        'AppData/Data/Organization/OrganisationRole.json'               => ['organization_role'],
        'AppData/Data/Organization/OrganizationType.json'               => ['type'],
        'AppData/Data/Activity/CRSChannelCode.json'                     => ['crs_channel_code'],
        'AppData/Data/Activity/Country.json'                            => ['country_code', 'country', 'code'],
        'AppData/Data/Activity/RegionVocabulary.json'                   => ['region_vocabulary'],
        'AppData/Data/Activity/Region.json'                             => ['region_code'],
        'AppData/Data/Activity/GeographicLocationReach.json'            => ['location_reach'],
        'AppData/Data/Activity/GeographicVocabulary.json'               => ['location_id', 'administrative'],
        'AppData/Data/Activity/GeographicExactness.json'                => ['exactness'],
        'AppData/Data/Activity/LocationType.json'                       => ['location_class', 'feature_designation'],
        'AppData/Data/Activity/SectorVocabulary.json'                   => ['sector_vocabulary'],
        'AppData/Data/Activity/SectorCategory.json'                     => ['category_code'],
        'AppData/Data/Activity/SectorCode.json'                         => ['code'],
        'AppData/Data/Activity/BudgetIdentifierVocabulary.json'         => ['country_budget_vocabulary'],
        'AppData/Data/Activity/BudgetIdentifier.json'                   => ['code'],
        'AppData/Data/Activity/HumanitarianScopeType.json'              => ['type'],
        'AppData/Data/Activity/HumanitarianScopeVocabulary.json'        => ['vocabulary'],
        'AppData/Data/Activity/PolicyMarkerVocabulary.json'             => ['policy_marker_vocabulary'],
        'AppData/Data/Activity/PolicySignificance.json'                 => ['significance'],
        'AppData/Data/Activity/PolicyMarker.json'                       => ['policy_marker'],
        'AppData/Data/Activity/FlowType.json'                           => ['code', 'flow_type'],
        'AppData/Data/Activity/FinanceType.json'                        => ['code', 'finance_type'],
        'AppData/Data/Activity/AidTypeVocabulary.json'                  => ['default_aid_type_vocabulary', 'aid_type_vocabulary'],
        'AppData/Data/Activity/AidType.json'                            => ['default_aid_type', 'aid_type'],
        'AppData/Data/Activity/TiedStatus.json'                         => ['code', 'tied_status_code', 'disbursement_channel_code'],
        'AppData/Data/Activity/BudgetStatus.json'                       => ['budget_status'],
        'AppData/Data/Activity/BudgetType.json'                         => ['budget_type', 'planned_disbursement_type'],
        'AppData/Data/Activity/Currency.json'                           => ['currency'],
        'AppData/Data/Activity/DocumentCategory.json'                   => ['code'],
        'AppData/Data/Activity/FileFormat.json'                         => ['format'],
        'AppData/Data/Activity/RelatedActivityType.json'                => ['relationship_type'],
        'AppData/Data/Activity/ConditionType.json'                      => ['type'],
        'AppData/Data/Activity/TagVocabulary.json'                      => ['tag_vocabulary'],
        'AppData/Data/Activity/ResultVocabulary.json'                   => ['vocabulary'],
        'AppData/Data/Activity/TransactionType.json'                    => ['transaction_type_code'],
        'AppData/Data/Organization/Country.json'                        => ['country_code', 'country', 'code'],
        'AppData/Data/Organization/OrganizationRegistrationAgency.json' => ['registration_agency'],
        'AppData/Data/Organization/Language.json'                       => ['language'],
        'AppData/Data/Organization/Currency.json'                       => ['currency'],
        'AppData/Data/Organization/DocumentCategory.json'               => ['code'],
        'AppData/Data/Activity/IndicatorMeasure.json'                   => ['code'],
        'AppData/Data/Activity/IndicatorVocabulary.json'                => ['vocabulary'],
    ][$completePath] ?? [];
}

/**
 * @param array $array
 * @param array $possibleSuffixes
 *
 * @return array
 */
function filterArrayByKeyEndsWithPossibleSuffixes(array $array, array $possibleSuffixes): array
{
    return array_filter($array, function ($key) use ($possibleSuffixes) {
        foreach ($possibleSuffixes as $suffix) {
            if (str_ends_with($key, $suffix)) {
                return true;
            }
        }

        return false;
    }, ARRAY_FILTER_USE_KEY);
}

/**
 * @param array $item
 * @param array $deprecatedCodesInUse
 *
 * @return bool
 */
function filterDeprecated(array $item, array $deprecatedCodesInUse): bool
{
    return Arr::get($item, 'status', 'active') === 'active' || in_array((string) Arr::get($item, 'code', ''), $deprecatedCodesInUse);
}
