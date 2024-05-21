<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class UpdateJsonFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UpdateJsonFiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update code list json files.';

    private array $allFiles
        = [
            'Activity'     => [
                'ActivityDateType.json',
                'ActivityScope.json',
                'ActivityStatus.json',
                'AdditionalExtension.json',
                'AidType.json',
                'AidTypeVocabulary.json',
                'BudgetIdentifier.json',
                'BudgetIdentifierVocabulary.json',
                'BudgetNotProvided.json',
                'BudgetStatus.json',
                'BudgetType.json',
                'CashandVoucherModalities.json',
                'CollaborationType.json',
                'ConditionType.json',
                'ContactType.json',
                'Country.json',
                'CRSChannelCode.json',
                'Currency.json',
                'DataLicense.json',
                'DescriptionType.json',
                'DisbursementChannel.json',
                'DocumentCategory.json',
                'EarmarkingCategory.json',
                'EarmarkingModality.json',
                'Element.json',
                'ElementGroup.json',
                'Extension.json',
                'FileFormat.json',
                'FinanceType.json',
                'FlowType.json',
                'GeographicExactness.json',
                'GeographicLocationClass.json',
                'GeographicLocationReach.json',
                'GeographicVocabulary.json',
                'HumanitarianScopeType.json',
                'HumanitarianScopeVocabulary.json',
                'IndicatorMeasure.json',
                'IndicatorVocabulary.json',
                'Language.json',
                'LocationType.json',
                'OtherIdentifierType.json',
                'PolicyMarker.json',
                'PolicyMarkerVocabulary.json',
                'PolicySignificance.json',
                'Region.json',
                'RegionVocabulary.json',
                'RelatedActivityType.json',
                'ResultType.json',
                'ResultVocabulary.json',
                'SectorCategory.json',
                'SectorCode.json',
                'SectorVocabulary.json',
                'Source.json',
                'TagVocabulary.json',
                'TiedStatus.json',
                'TransactionType.json',
                'UNSDG-Goals.json',
                'UNSDG-Targets.json',
            ],
            'Organization' => [
                'Country.json',
                'Currency.json',
                'DocumentCategory.json',
                'Language.json',
                'OrganisationElements.json',
                'OrganisationElementsGroup.json',
                'OrganisationRole.json',
                'OrganizationRegistrationAgency.json',
                'OrganizationType.json',
            ],
        ];

    protected array $ignoreables
        = [
            'AdditionalExtension.json',
            'DataLicense.json',
            'EarmarkingModality.json',
            'Element.json',
            'ElementGroup.json',
            'Extension.json',
            'Source.json',
            'OrganisationElements.json',
            'OrganisationElementsGroup.json',
            'OrganizationRegistrationAgency.json',
            'OrganizationType.json',
        ];

    private array $urlSuffixMap
        = [
            'Activity'     => [
                'ActivityDateType.json'            => 'ActivityDateType.json',
                'ActivityScope.json'               => 'ActivityScope.json',
                'ActivityStatus.json'              => 'ActivityStatus.json',
                'AdditionalExtension.json'         => null,
                'AidType.json'                     => 'AidType.json',
                'AidTypeVocabulary.json'           => 'AidTypeVocabulary.json',
                'BudgetIdentifier.json'            => 'BudgetIdentifier.json',
                'BudgetIdentifierVocabulary.json'  => 'BudgetIdentifierVocabulary.json',
                'BudgetNotProvided.json'           => 'BudgetNotProvided.json',
                'BudgetStatus.json'                => 'BudgetStatus.json',
                'BudgetType.json'                  => 'BudgetType.json',
                'CashandVoucherModalities.json'    => 'CashandVoucherModalities.json',
                'CollaborationType.json'           => 'CollaborationType.json',
                'ConditionType.json'               => 'ConditionType.json',
                'ContactType.json'                 => 'ContactType.json',
                'Country.json'                     => 'Country.json',
                'CRSChannelCode.json'              => 'CRSChannelCode.json',
                'Currency.json'                    => 'Currency.json',
                'DataLicense.json'                 => null,
                'DescriptionType.json'             => 'DescriptionType.json',
                'DisbursementChannel.json'         => 'DisbursementChannel.json',
                'DocumentCategory.json'            => 'DocumentCategory.json',
                'EarmarkingCategory.json'          => 'EarmarkingCategory.json',
                'EarmarkingModality.json'          => null,
                'Element.json'                     => null,
                'ElementGroup.json'                => null,
                'Extension.json'                   => null,
                'FileFormat.json'                  => 'FileFormat.json',
                'FinanceType.json'                 => 'FinanceType.json',
                'FlowType.json'                    => 'FlowType.json',
                'GeographicExactness.json'         => 'GeographicExactness.json',
                'GeographicLocationClass.json'     => 'GeographicLocationClass.json',
                'GeographicLocationReach.json'     => 'GeographicLocationReach.json',
                'GeographicVocabulary.json'        => 'GeographicVocabulary.json',
                'HumanitarianScopeType.json'       => 'HumanitarianScopeType.json',
                'HumanitarianScopeVocabulary.json' => 'HumanitarianScopeVocabulary.json',
                'IndicatorMeasure.json'            => 'IndicatorMeasure.json',
                'IndicatorVocabulary.json'         => 'IndicatorVocabulary.json',
                'Language.json'                    => 'Language.json',
                'LocationType.json'                => 'LocationType.json',
                'OtherIdentifierType.json'         => 'OtherIdentifierType.json',
                'PolicyMarker.json'                => 'PolicyMarker.json',
                'PolicyMarkerVocabulary.json'      => 'PolicyMarkerVocabulary.json',
                'PolicySignificance.json'          => 'PolicySignificance.json',
                'Region.json'                      => 'Region.json',
                'RegionVocabulary.json'            => 'RegionVocabulary.json',
                'RelatedActivityType.json'         => 'RelatedActivityType.json',
                'ResultType.json'                  => 'ResultType.json',
                'ResultVocabulary.json'            => 'ResultVocabulary.json',
                'SectorCategory.json'              => 'SectorCategory.json',
                'SectorCode.json'                  => 'Sector.json',
                'SectorVocabulary.json'            => 'SectorVocabulary.json',
                'Source.json'                      => null,
                'TagVocabulary.json'               => 'TagVocabulary.json',
                'TiedStatus.json'                  => 'TiedStatus.json',
                'TransactionType.json'             => 'TransactionType.json',
                'UNSDG-Goals.json'                 => 'UNSDG-Goals.json',
                'UNSDG-Targets.json'               => 'UNSDG-Targets.json',
            ],
            'Organization' => [
                'Country.json'                        => 'Country.json',
                'Currency.json'                       => 'Currency.json',
                'DocumentCategory.json'               => 'DocumentCategory.json',
                'Language.json'                       => 'Language.json',
                'OrganisationElements.json'           => null,
                'OrganisationElementsGroup.json'      => null,
                'OrganisationRole.json'               => 'OrganisationRole.json',
                'OrganizationRegistrationAgency.json' => null,
                'OrganizationType.json'               => null,
            ],
        ];

    private array $specialCases
        = [
            'BudgetIdentifier.json',
            'DocumentCategory.json',
            'LocationType.json',
        ];
    private array $combinationMap
        = [
            'BudgetIdentifier.json' => ['BudgetIdentifierSector.json', 'BudgetIdentifier.json'],
            'DocumentCategory.json' => ['DocumentCategory.json', 'DocumentCategory-category.json'],
            'LocationType.json'     => ['LocationType.json', 'LocationType-category.json'],
        ];

    protected array $codelistWithLanguageProperty
        = [
            'ActivityDateType.json',
            'ActivityScope.json',
            'ActivityStatus.json',
            'BudgetIdentifier.json',
            'BudgetIdentifierVocabulary.json',
            'BudgetStatus.json',
            'BudgetType.json',
            'CollaborationType.json',
            'ConditionType.json',
            'ContactType.json',
            'Country.json',
            'Currency.json',
            'DescriptionType.json',
            'DisbursementChannel.json',
            'DocumentCategory.json',
            'FileFormat.json',
            'FlowType.json',
            'GeographicExactness.json',
            'GeographicLocationClass.json',
            'GeographicLocationReach.json',
            'GeographicVocabulary.json',
            'HumanitarianScopeType.json',
            'HumanitarianScopeVocabulary.json',
            'IndicatorMeasure.json',
            'IndicatorVocabulary.json',
            'Language.json',
            'LocationType.json',
            'OtherIdentifierType.json',
            'PolicyMarker.json',
            'PolicyMarkerVocabulary.json',
            'PolicySignificance.json',
            'Region.json',
            'RegionVocabulary.json',
            'RelatedActivityType.json',
            'ResultType.json',
            'SectorCategory.json',
            'SectorCode.json',
            'SectorVocabulary.json',
            'TagVocabulary.json',
            'TiedStatus.json',
            'UNSDG-Goals.json',
            'UNSDG-Targets.json',
            'OrganisationRole.json',
        ];

    private string $modifiedDate;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->modifiedDate = now()->format('Y-m-d H:i:s');

        foreach ($this->allFiles as $folderName => $fileNames) {
            foreach ($fileNames as $fileName) {
                if (in_array($fileName, $this->ignoreables)) {
                    continue;
                }

                if (in_array($fileName, $this->specialCases)) {
                    $this->proceedForCombinedCodelist($folderName, $fileName, Arr::get($this->combinationMap, $fileName));
                } else {
                    $this->proceedNormally($folderName, $fileName, $this->urlSuffixMap[$folderName][$fileName]);
                }
            }
        }
    }

    public function getCurlResult($url, $filename)
    {
        $response = Http::get($url);

        return $response->json();
    }

    public function combineData($baseData, $categoryData): array
    {
        foreach ($baseData as $key => $data) {
            $categoryCode = $data['category'];
            $categoryName = $this->pluckFromCategoryData($categoryData, $categoryCode, 'name');
            $categoryDescription = $this->pluckFromCategoryData($categoryData, $categoryCode, 'description');

            $baseData[$key]['category-name'] = $categoryName;
            $baseData[$key]['category-description'] = $categoryDescription;
        }

        return $baseData;
    }

    public function pluckFromCategoryData($categoryData, $code, $neededKey)
    {
        foreach ($categoryData as $key => $data) {
            if ($data['code'] === $code) {
                if (empty($data[$neededKey])) {
                    return '';
                } else {
                    return $data[$neededKey];
                }
            }
        }

        return '';
    }

    private function proceedNormally($folderName, $filename, $urlSuffix): void
    {
        $url = $this->getUrl($urlSuffix);
        $result = $this->getCurlResult($url, $filename);

        $contentForFile = $this->parseToPublisherJson($result, $filename);
        $filePath = "AppData/Data/$folderName/$filename";

        file_put_contents(public_path($filePath), $contentForFile);
        awsUploadFile($filePath, $contentForFile);
        Cache::set($filePath, $contentForFile);
    }

    private function parseToPublisherJson($data, $filename): bool|string
    {
        $fileDetails = explode('.', $filename);
        $fileNameNoExt = $fileDetails[0];

        $dataToWriteInFile = [];
        $dataToWriteInFile['date-last-modified'] = $this->modifiedDate;
        $dataToWriteInFile['version'] = '';
        $dataToWriteInFile['name'] = $fileNameNoExt;
        $dataToWriteInFile['xml:lang'] = 'en';

        $dataToWriteInFile[$fileNameNoExt] = Arr::get($data, 'data', $data);

        if ($this->hasLanguageProperty($filename)) {
            $dataToWriteInFile[$fileNameNoExt] = $this->addLanguageProperty($dataToWriteInFile[$fileNameNoExt]);
        }

        return json_encode($dataToWriteInFile, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function proceedForCombinedCodelist(string $folderName, string $filename, array $mapCombination): void
    {
        $temp = ['baseData' => '', 'categoryData' => ''];

        foreach ($mapCombination as $key => $urlSuffix) {
            $type = $key === 0 ? 'baseData' : 'categoryData';
            $url = $this->getUrl($urlSuffix);
            $temp[$type] = $this->getCurlResult($url, $urlSuffix);
        }

        $combinedData = $this->combineData($temp['baseData']['data'], $temp['categoryData']['data']);
        $contentForFile = $this->parseToPublisherJson($combinedData, $filename);

        $filePath = "AppData/Data/$folderName/$filename";

        file_put_contents(public_path($filePath), $contentForFile);
        awsUploadFile($filePath, $contentForFile);
        Cache::set($filePath, $contentForFile);
    }

    private function getUrl($urlSuffix): string
    {
        return "https://cdn.iatistandard.org/prod-iati-website/reference_downloads/203/codelists/downloads/clv3/json/en/{$urlSuffix}";
    }

    private function hasLanguageProperty($filename): bool
    {
        return in_array($filename, $this->codelistWithLanguageProperty);
    }

    private function addLanguageProperty(array $data): array
    {
        foreach ($data as &$datum) {
            $datum['language'] = 'en';
        }

        return $data;
    }
}
