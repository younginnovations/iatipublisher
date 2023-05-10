<?php

declare(strict_types=1);

namespace App\Exports;

use App\IATI\Traits\XlsDownloadTrait;
use Illuminate\Support\Arr;
use JsonException;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * Class ActivityExport.
 */
class ActivityExport implements WithMultipleSheets
{
    use XlsDownloadTrait;

    /**
     * Holds activities data from database.
     *
     * @var object
     */
    protected object $data;

    /**
     * Sheets to be present in xls file.
     *
     * @var array|string[]
     */
    protected array $sheets = [
        'Settings' => 'settings',
        'Element with single field' => 'element_with_single_field',
        'Title' => 'title',
        'Description' => 'description',
        'Activity Date' => 'activity_date',
        'Recipient Country' => 'recipient_country',
        'Recipient Region' => 'recipient_region',
        'Conditions' => 'conditions',
        'Contact Info' => 'contact_info',
        'Planned Disbursement' => 'planned_disbursement',
        'Participating Org' => 'participating_org',
        'Budget' => 'budget',
        'Legacy Data' => 'legacy_data',
        'Humanitarian Scope' => 'humanitarian_scope',
        'Related Activity' => 'related_activity',
        'Other Identifier' => 'other_identifier',
        'Sector' => 'sector',
        'Tag' => 'tag',
        'Policy Marker' => 'policy_marker',
        'Default Aid Type' => 'default_aid_type',
        'Document Link' => 'document_link',
        'Country Budget Items' => 'country_budget_items',
        'Location' => 'location',
        'Transaction' => 'transactions',
    ];

    /**
     * Single field elements.
     *
     * @var array|string[]
     */
    protected array $elementWithSingleField = [
        'activity_status',
        'activity_scope',
        'collaboration_type',
        'default_flow_type',
        'default_finance_type',
        'default_tied_status',
        'capital_spend',
    ];

    /**
     * Field required for setting sheet in xls.
     *
     * @var array|string[]
     */
    protected array $settingsField = [
        'Default Currency' => 'default_currency',
        'Default Language' => 'default_language',
        'Hierarchy' => 'hierarchy',
        'Humanitarian' => 'humanitarian',
        'Budget Not Provided' => 'budget_not_provided',
        'Secondary Reporter' => 'secondary_reporter',
    ];

    /**
     * This tracks number of occurrence of the element's header
     * eg: title narrative  => 1.
     *
     * @var array
     */
    protected array $arrayLevelCount = [];

    /**
     * Array to replace different header to same.
     *
     * @var array|string[]
     */
    protected array $dynamicMultipleField = [
        'sector category_code' => 'sector code',
        'sector text' => 'sector code',
        'sector code' => 'sector code',
        'sector sdg_target' => 'sector code',
        'sector sdg_goal' => 'sector code',
        'sector' => [
            'code' => 'code',
            'text' => 'code',
            'category_code' => 'code',
            'sdg_target' => 'code',
            'sdg_goal' => 'code',
        ],
        'tag' => [
            'code' => 'code',
            'tag_text' => 'code',
            'goals_tag_code' => 'code',
            'targets_tag_code' => 'code',
        ],
        'policy_marker' => [
            'policy_marker' => 'code',
            'policy_marker_text' => 'code',
        ],
        'default_aid_type' => [
            'default_aid_type' => 'code',
            'cash_and_voucher_modalities' => 'code',
            'earmarking_category' => 'code',
            'earmarking_modality' => 'code',
        ],
        'recipient_region code' => 'recipient_region region_code',
        'recipient_region custom_code' => 'recipient_region region_code',
        'recipient_region' => [
            'region_code' => 'code',
            'custom_code' => 'code',
        ],
    ];

    /**
     * @var array|string[]
     */
    protected array $headerWithSingleLevel = [
        'aid_type', 'telephone', 'email', 'website', 'category', 'language',
    ];

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Populate data in sheets one by one.
     *
     * @return array
     *
     * @throws JsonException
     */
    public function sheets(): array
    {
        $xlsHeaders = readJsonFile('Exports/XlsExportTemplate/xlsHeaderTemplate.json');
        $data = $this->mappedData();
        $sheets = [];

        $identifiers = [
            'Activity Identifier' => array_keys($data['Settings']['Activity Identifier']),
        ];

        $sheets[] = new OptionExport('instructions', 'Instructions');

        foreach ($data as $key => $datum) {
            $sheets[] = new XlsExport(Arr::collapse($datum), $key, $xlsHeaders[$this->sheets[$key]], 'activity');
        }

        $sheets[] = new OptionExport('activity_options', 'Options');
        $sheets[] = new IdentifierExport($identifiers);

        return $sheets;
    }

    /**
     * Maps data into excel export compatible array.
     *
     * @return array
     *
     * @throws JsonException
     */
    public function mappedData(): array
    {
        $flippedSheet = array_flip($this->sheets);
        $sheets = array_fill_keys($flippedSheet, []);

        $this->data->chunk(100, function ($chunkedData) use ($flippedSheet, &$sheets) {
            $xlsHeaders = readJsonFile('Exports/XlsExportTemplate/xlsHeaderTemplate.json');

            foreach ($chunkedData as $data) {
                $data = $data->toArray();
                $this->prepareSettingsFieldData($data);
                $this->prepareSingleFieldData($data);
                foreach ($data as $key => $datum) {
                    if (in_array($key, $this->sheets, true)) {
                        if ($key === 'related_activity') {
                            $datum = $this->changeRelatedActivityArrayKey($datum);
                        }
                        $headerTemplate = array_fill_keys(array_column($xlsHeaders[$key], 'index'), '');
                        $identifier = $data['iati_identifier']['activity_identifier'];
                        $datum = $key === 'transactions' ? array_column($datum, 'transaction') : $datum;
                        $detail = !empty($datum) ? array_values($this->linearizeArray($datum, $headerTemplate, $key)) : [$headerTemplate];
                        $sheets[$flippedSheet[$key]]['Activity Identifier'][$identifier] = $detail;
                        $this->arrayLevelCount = [];
                    }
                }
            }
        });

        return $sheets;
    }

    /**
     * Populates value of element with single field into the array.
     *
     * @param $data
     *
     * @return void
     */
    public function prepareSingleFieldData(&$data): void
    {
        foreach ($this->elementWithSingleField as $singleField) {
            $data['element_with_single_field'][$singleField] = $data[$singleField];
            unset($data[$singleField]);
        }
    }

    /**
     * Populates value of settings field into the array.
     *
     * @param $data
     *
     * @return void
     */
    public function prepareSettingsFieldData(&$data): void
    {
        foreach ($this->settingsField as $settingField) {
            $value = Arr::get($data, 'default_field_values.' . $settingField, '');

            if ($settingField === 'secondary_reporter') {
                $value = Arr::get($data, 'reporting_org.0.secondary_reporter');
            }
            $data['settings'][$settingField] = $value;
        }
    }

    /**
     * Related activity array has "activity_identifier" as key rename to "reference".
     *
     * @param $datum
     *
     * @return array
     */
    public function changeRelatedActivityArrayKey($datum): array
    {
        $updatedDatum = [];

        if (empty($datum)) {
            return $updatedDatum;
        }

        foreach ($datum as $item) {
            $newItem = [
                'reference' => $item['activity_identifier'],
                'relationship_type' => $item['relationship_type'],
            ];
            $updatedDatum[] = $newItem;
        }

        return $updatedDatum;
    }
}
