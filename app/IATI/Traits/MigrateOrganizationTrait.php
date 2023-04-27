<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use Illuminate\Support\Arr;

/**
 * Class MigrateOrganizationTrait.
 */
trait MigrateOrganizationTrait
{
    /**
     * @var
     */
    public $tempAmount;

    /**
     * @var
     */
    public $tempNarrative;

    /**
     * @var array
     */
    protected array $narrativeDefaultTemplate = [
          [
              'narrative' => [
                 [
                     'narrative' => null,
                     'language' => null,
                 ],
              ],
          ],
    ];

    /** Empty organization recipient region org template.
     *
     * @var array
     */
    protected array $emptyOrganizationRecipientOrgTemplate
        = [
            [
                'ref'       => null,
                'narrative' => [
                    [
                        'narrative' => null,
                        'language'  => null,
                    ],
                ],
            ],
        ];

    /**
     * Empty organization recipient country template.
     *
     * @var array
     */
    protected array $emptyOrganizationRecipientCountryTemplate
        = [
            [
                'code'      => null,
                'narrative' => [
                    [
                        'narrative' => null,
                        'language'  => null,
                    ],
                ],
            ],
        ];

    /**
     * Empty organization recipient region template.
     *
     * @var array
     */
    protected array $emptyOrganizationRecipientRegionTemplate
        = [
            [
                'region_vocabulary' => null,
                'region_code'       => null,
                'narrative'         => [
                    [
                        'narrative' => null,
                        'language'  => null,
                    ],
                ],
            ],
        ];

    /**
     * Returns required data for creating new IATI organization.
     *
     * @param $aidstreamOrganization
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function getNewOrganization($aidstreamOrganization): array
    {
        $newOrganization = [];
        $newOrganization['publisher_id'] = $aidstreamOrganization->user_identifier;
        $newOrganization['publisher_name'] = $aidstreamOrganization->name;
        $newOrganization['publisher_type'] = $this->getReportingOrgData(
            $aidstreamOrganization->reporting_org,
            'reporting_organization_type'
        ) ? (int) $this->getReportingOrgData(
            $aidstreamOrganization->reporting_org,
            'reporting_organization_type'
        ) : null;
        $newOrganization['identifier'] = $this->getReportingOrgData(
            $aidstreamOrganization->reporting_org,
            'reporting_organization_identifier'
        );
        $newOrganization['address'] = $aidstreamOrganization->address;
        $newOrganization['telephone'] = $aidstreamOrganization->telephone;
        $newOrganization['reporting_org'] = $this->getReportingOrgWithCorrectTemplate(
            $aidstreamOrganization->reporting_org,
            $aidstreamOrganization->secondary_reporter
        );

        $aidstreamOrganizationData = $this->db::connection('aidstream')->table('organization_data')->where(
            'organization_id',
            $aidstreamOrganization->id
        )->where('is_reporting_org', true)->first();

        $newOrganization['total_budget'] = $aidstreamOrganizationData ? $this->getOrganizationBudget(
            $aidstreamOrganizationData->total_budget,
            'total_budget_status',
            'budget_line'
        ) : null;
        $newOrganization['recipient_org_budget'] = $aidstreamOrganizationData ? $this->getOrganizationBudget(
            $aidstreamOrganizationData->recipient_organization_budget,
            'recipient_org',
            'budget_line'
        ) : null;
        $newOrganization['default_field_values'] = null;
        $newOrganization['recipient_region_budget'] = $aidstreamOrganizationData ? $this->getOrganizationRecipientRegionBudget(
            $aidstreamOrganizationData->recipient_region_budget,
        ) : null;
        $newOrganization['recipient_country_budget'] = $aidstreamOrganizationData ? $this->getOrganizationBudget(
            $aidstreamOrganizationData->recipient_country_budget,
            'recipient_country',
            'budget_line'
        ) : null;
        $newOrganization['document_link'] = $aidstreamOrganizationData ? $this->getOrganizationDocumentLink(
            $aidstreamOrganizationData->document_link,
        ) : null;
        $newOrganization['total_expenditure'] = $aidstreamOrganizationData ? $this->getOrganizationBudget(
            $aidstreamOrganizationData->total_expenditure,
            'total_expenditure',
            'expense_line'
        ) : null;
        $newOrganization['name'] = $this->getColumnValueArray(
            $aidstreamOrganizationData,
            'name'
        );
        $newOrganization['country'] = $aidstreamOrganization->country;
        $newOrganization['logo_url'] = $aidstreamOrganization->logo_url;
        $newOrganization['organization_url'] = $aidstreamOrganization->organization_url;

        $newOrganization['status'] = $aidstreamOrganizationData ? ($aidstreamOrganizationData->status === 3 ? 'published' : 'draft') : 'draft';
        $newOrganization['iati_status'] = 'pending';
        $newOrganization['is_published'] = $aidstreamOrganizationData && $aidstreamOrganizationData->status === 3;
        $newOrganization['registration_agency'] = $aidstreamOrganization->registration_agency;
        $newOrganization['registration_number'] = $aidstreamOrganization->registration_number;
        $newOrganization['element_status'] = null; // Will be updated by observer
        $newOrganization['created_at'] = $aidstreamOrganization->created_at;
        $newOrganization['updated_at'] = $aidstreamOrganization->updated_at;
        $newOrganization['org_status'] = 'active';
        $newOrganization['updated_by'] = null; // Updated after migrating users
        $newOrganization['migrated_from_aidstream'] = true;

        return $newOrganization;
    }

    /**
     * Returns reporting org data.
     *
     * @param $reportingOrg
     * @param $key
     *
     * @return string|null
     *
     * @throws \JsonException
     */
    public function getReportingOrgData($reportingOrg, $key): ?string
    {
        if (!$reportingOrg) {
            return null;
        }

        $reportingOrg = json_decode($reportingOrg, true, 512, JSON_THROW_ON_ERROR);

        if (!$reportingOrg) {
            return null;
        }

        return Arr::get($reportingOrg, '0.' . $key, null);
    }

    /**
     * Returns required budget data for IATI organization.
     *
     * @param $orgBudget
     * @param $firstKey
     * @param $secondKey
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getOrganizationBudget($orgBudget, $firstKey, $secondKey): ?array
    {
        if (!$orgBudget) {
            return null;
        }

        $newOrgBudget = [];
        $orgBudgetArray = json_decode($orgBudget, true, 512, JSON_THROW_ON_ERROR);

        if ($orgBudgetArray && count($orgBudgetArray)) {
            foreach (array_values($orgBudgetArray) as $key => $array) {
                $newOrgBudget[$key] = match ($firstKey) {
                    'total_budget_status' => [
                        'total_budget_status' => Arr::get($array, 'status', null),
                        'period_start'        => Arr::get($array, 'period_start', $this->emptyPeriodDateArray),
                        'period_end'          => Arr::get($array, 'period_end', $this->emptyPeriodDateArray),
                        'value'               => Arr::get($array, 'value', $this->emptyValueArray),
                    ],
                    'recipient_org' => [
                        'status'        => Arr::get($array, 'status', null),
                        'recipient_org' => Arr::get(
                            $array,
                            'recipient_organization',
                            $this->emptyOrganizationRecipientOrgTemplate
                        ),
                        'period_start'  => Arr::get($array, 'period_start', $this->emptyPeriodDateArray),
                        'period_end'    => Arr::get($array, 'period_end', $this->emptyPeriodDateArray),
                        'value'         => Arr::get($array, 'value', $this->emptyValueArray),
                    ],
                    'recipient_country' => [
                        'status'            => Arr::get($array, 'status', null),
                        'recipient_country' => Arr::get(
                            $array,
                            'recipient_country',
                            $this->emptyOrganizationRecipientCountryTemplate
                        ),
                        'period_start'      => Arr::get($array, 'period_start', $this->emptyPeriodDateArray),
                        'period_end'        => Arr::get($array, 'period_end', $this->emptyPeriodDateArray),
                        'value'             => Arr::get($array, 'value', $this->emptyValueArray),
                    ],
                    default => [
                        'period_start' => Arr::get($array, 'period_start', $this->emptyPeriodDateArray),
                        'period_end'   => Arr::get($array, 'period_end', $this->emptyPeriodDateArray),
                        'value'        => Arr::get($array, 'value', $this->emptyValueArray),
                    ],
                };

                foreach (array_values(Arr::get($array, $secondKey, [])) as $innerKey => $innerArray) {
                    $newOrgBudget[$key][$secondKey][$innerKey] = [
                        'ref'       => Arr::get($innerArray, 'reference', null),
                        'value'     => Arr::get($innerArray, 'value', $this->emptyValueArray),
                        'narrative' => Arr::get($innerArray, 'narrative', $this->emptyNarrativeTemplate),
                    ];
                }
            }
        }

        return count($newOrgBudget) ? $newOrgBudget : null;
    }

    /**
     * Returns required recipient region budget for IATI organization.
     *
     * @param $recipientRegionBudget
     *
     * @return array|null
     *
     * @throws \JsonException
     */
    public function getOrganizationRecipientRegionBudget($recipientRegionBudget): ?array
    {
        if (!$recipientRegionBudget) {
            return null;
        }

        $newRecipientRegionBudget = [];
        $recipientRegionBudgetArray = json_decode($recipientRegionBudget, true, 512, JSON_THROW_ON_ERROR);

        if ($recipientRegionBudgetArray && count($recipientRegionBudgetArray)) {
            foreach (array_values($recipientRegionBudgetArray) as $key => $array) {
                $newRecipientRegionBudget[$key] = [
                    'status'           => Arr::get($array, 'status', null),
                    'recipient_region' => $this->getOrganizationRecipientRegionData(
                        Arr::get($array, 'recipient_region', [])
                    ),
                    'period_start'     => Arr::get($array, 'period_start', $this->emptyPeriodDateArray),
                    'period_end'       => Arr::get($array, 'period_end', $this->emptyPeriodDateArray),
                    'value'            => Arr::get($array, 'value', $this->emptyValueArray),
                ];

                foreach (array_values(Arr::get($array, 'budget_line', [])) as $innerKey => $innerArray) {
                    $newRecipientRegionBudget[$key]['budget_line'][$innerKey] = [
                        'ref'       => Arr::get($innerArray, 'reference', null),
                        'value'     => Arr::get($innerArray, 'value', $this->emptyValueArray),
                        'narrative' => Arr::get($innerArray, 'narrative', $this->emptyNarrativeTemplate),
                    ];
                }
            }
        }

        return count($newRecipientRegionBudget) ? $newRecipientRegionBudget : null;
    }

    /**
     * Returns required recipient region data for IATI organization.
     *
     * @param $recipientRegions
     *
     * @return array
     */
    public function getOrganizationRecipientRegionData($recipientRegions): array
    {
        $array = [];

        if (count($recipientRegions) === 0) {
            return $this->emptyOrganizationRecipientRegionTemplate;
        }

        foreach (array_values($recipientRegions) as $key => $recipientRegion) {
            $array[$key]['region_vocabulary'] = Arr::get($recipientRegion, 'vocabulary', null);

            if (Arr::get($recipientRegion, 'vocabulary', null) === '1') {
                $array[$key]['region_code'] = Arr::get($recipientRegion, 'code', null);
            } else {
                $array[$key]['code'] = Arr::get($recipientRegion, 'code', null);

                if (Arr::get($recipientRegion, 'vocabulary', null) === '99') {
                    $array[$key]['vocabulary_uri'] = Arr::get($recipientRegion, 'vocabulary_uri', null);
                }
            }

            $array[$key]['narrative'] = Arr::get($recipientRegion, 'narrative', $this->emptyNarrativeTemplate);
        }

        return $array;
    }

    /**
     * Updates organization updated by.
     *
     * @param $aidstreamOrganizationId
     * @param $iatiOrganization
     * @param $mappedUsers
     *
     * @return void
     */
    public function updateOrganizationUpdatedBy($aidstreamOrganizationId, $iatiOrganization, $mappedUsers): void
    {
        $orgUpdated = $this->db::connection('aidstream')->table('user_activities')
                               ->where('organization_id', $aidstreamOrganizationId)
                               ->where('action', 'LIKE', 'organization%')
                               ->orderBy('updated_at', 'desc')
                               ->first();

        if ($orgUpdated) {
            if (array_key_exists($orgUpdated->user_id, $mappedUsers[$aidstreamOrganizationId])) {
                $iatiOrganization->updated_by = $mappedUsers[$aidstreamOrganizationId][$orgUpdated->user_id];
            } else {
                $adminUser = $this->db::connection('aidstream')->table('users')
                                      ->where('role_id', 1)
                                      ->where('org_id', $aidstreamOrganizationId)
                                      ->first();

                $iatiOrganization->updated_by = $mappedUsers[$aidstreamOrganizationId][$adminUser->id];
            }

            $iatiOrganization->saveQuietly();
        }
    }

    /**
     * Fill reporting org in proper format.
     *
     * @param $reportingOrg
     * @param $secondaryReporter
     *
     * @return array
     */
    public function getReportingOrgWithCorrectTemplate($reportingOrg, $secondaryReporter): array
    {
        $reportingOrg = json_decode($reportingOrg);
        $reportingOrgTemplate = [];

        $reportingOrgTemplate[0]['ref'] = $reportingOrg[0]->reporting_organization_identifier ?? '';
        $reportingOrgTemplate[0]['type'] = $reportingOrg[0]->reporting_organization_type ?? '';
        $reportingOrgTemplate[0]['secondary_reporter'] = $secondaryReporter ?? '';
        $reportingOrgTemplate[0]['narrative'] = $reportingOrg[0]->narrative ?? [['narrative' => '', 'language' => '']];

        return $reportingOrgTemplate;
    }

    /**
     * Populates default fields
     * [language and currency].
     *
     * @param $data
     * @param $defaultValues
     *
     * @return mixed
     */
    public function populateDefaultFields(&$data, $defaultValues): mixed
    {
        foreach ($data as $key => &$datum) {
            if (is_array($datum)) {
                $this->populateDefaultFields($datum, $defaultValues);
            }

            $this->setTempNarrative((string) $key, $datum);
            $this->setTempAmount((string) $key, $datum);
            $this->setLanguage($data, (string) $key, $datum, $defaultValues);
            $this->setCurrency($data, (string) $key, $datum, $defaultValues);
        }

        return $data;
    }

    /**
     * Sets $tempNarrative.
     *
     * @param  string  $key
     * @param $datum
     *
     * @return void
     */
    public function setTempNarrative(string $key, $datum): void
    {
        if ($key === 'narrative') {
            $this->tempNarrative = $datum;
        }
    }

    /**
     * Sets $tempAmount.
     *
     * @param  string  $key
     * @param $datum
     *
     * @return void
     */
    public function setTempAmount(string $key, $datum): void
    {
        if ($key === 'amount') {
            $this->tempAmount = $datum;
        }
    }

    /**
     * Sets default language if language is empty && non-empty narrative['narrative'].
     *
     * @param  array  $data
     * @param  string  $key
     * @param $datum
     * @param $defaultValues
     *
     * @return void
     */
    public function setLanguage(array &$data, string $key, $datum, $defaultValues): void
    {
        if ($key === 'language' && empty($datum) && !empty($this->tempNarrative) && array_key_exists(
            'narrative',
            $data
        )) {
            $defaultValues = json_decode($defaultValues);
            $defaultValues = $defaultValues[0];
            $defaultLanguage = $defaultValues?->default_language ?? '';
            $data['language'] = $defaultLanguage;
        }
    }

    /**
     * Sets default currency if currency is empty && non-empty amount['amount'].
     *
     * @param  array  $data
     * @param  string  $key
     * @param $datum
     * @param $defaultValues
     *
     * @return void
     */
    public function setCurrency(array &$data, string $key, $datum, $defaultValues): void
    {
        if ($key === 'currency' && empty($datum) && !empty($this->tempAmount)) {
            $defaultValues = json_decode($defaultValues);
            $defaultValues = $defaultValues[0];
            $defaultCurrency = $defaultValues?->default_currency ?? '';
            $data['currency'] = $defaultCurrency;
        }
    }

    /**
     * Gets published status of aidstream organization.
     *
     * @param $aidstreamOrganization
     *
     * @return string
     */
    public function getPublishedStatus($aidstreamOrganization): string
    {
        $aidstreamOrganizationData = $this->db::connection('aidstream')->table('organization_data')->where(
            'organization_id',
            $aidstreamOrganization->id
        )->where('is_reporting_org', true)->first();

        return $aidstreamOrganizationData ? ($aidstreamOrganizationData->status === 3 ? 'published' : 'draft') : 'draft';
    }

    /**
     * Gets Organization data compatible to IATI.
     *
     * @param $orgDocumentLink
     *
     * @return null|array
     * @throws \JsonException
     */
    public function getOrganizationDocumentLink($orgDocumentLink): ?array
    {
        if (empty($orgDocumentLink)) {
            return null;
        }

        $newOrgDocumentLink = [];
        $orgDocumentLinkArray = json_decode($orgDocumentLink, true, 512, JSON_THROW_ON_ERROR);

        if ($orgDocumentLinkArray && count($orgDocumentLinkArray)) {
            foreach (array_values($orgDocumentLinkArray) as $key => $array) {
                $newOrgDocumentLink[$key] = [
                    'url'   => Arr::get($array, 'url'),
                    'format' => Arr::get($array, 'format'),
                    'title'  => Arr::get($array, 'title', $this->narrativeDefaultTemplate),
                    'description' => Arr::get($array, 'description', $this->narrativeDefaultTemplate),
                    'category' => Arr::get($array, 'category', [['code' => null]]),
                    'language' => Arr::get($array, 'language', [['language' => null]]),
                    'recipient_country' => Arr::get($array, 'recipient_country', [['code' => null, $this->narrativeDefaultTemplate]]),
                    'document_date' => Arr::get($array, 'document_date', [['date' => null]]),
                ];
            }
        }

        return count($newOrgDocumentLink) ? $newOrgDocumentLink : null;
    }

    /**
     * Sets the complete status of elements.
     *
     * @param      $model
     * @param bool $isNew
     *
     * @return void
     * @throws \JsonException
     */
    public function setElementStatus($model, bool $isNew = false): void
    {
        $elementStatus = $model->element_status;
        $updatedElements = ($isNew) ? $this->getUpdatedElement($model->getAttributes()) : $this->getUpdatedElement($model->getChanges());

        foreach ($updatedElements as $attribute => $value) {
            $elementStatus[$attribute] = call_user_func([$this->organizationElementCompleteService, dashesToCamelCase('is_' . $attribute . '_element_completed')], $model);
        }

        $model->element_status = $elementStatus;
    }

    /**
     * @param $updatedAttributes
     *
     * @return array
     * @throws \JsonException
     */
    public function getUpdatedElement($updatedAttributes): array
    {
        $elements = getOrganizationElements();
        $updatedElements = [];

        $elements[] = 'identifier';

        foreach ($updatedAttributes as $element => $updatedAttribute) {
            if (in_array($element, $elements, true)) {
                $updatedElements[$element] = $updatedAttribute;
            }
        }

        return $updatedElements;
    }

    /**
     * Updates the created_at and updated_at of the IATI model.
     *
     * @param $aidstreamModel
     * @param $iatiModel
     *
     * @return object
     */
    public function updateOnlyDates($aidstreamModel, $iatiModel): object
    {
        $iatiModel->updateQuietly([
            'created_at' => $aidstreamModel->created_at,
            'updated_at' => $aidstreamModel->updated_at,
        ]);

        return $iatiModel->refresh();
    }
}
