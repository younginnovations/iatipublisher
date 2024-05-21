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

    /**
     * @var array|string[]
     */
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
        ];

    /**
     * @var array|string[]
     */
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

    /**
     * @var array|array[]
     */
    protected array $codeListWithAdditionalProperties
        = [
            'FileFormat.json' => ['category-name', 'name'],
        ];

    /**
     * @var array|array[]
     */
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

    /**
     * @var array|array[]
     */
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
                'OrganizationType.json'               => 'OrganisationType.json',
            ],
        ];

    /**
     * @var array|string[]
     */
    private array $specialCases
        = [
            'SectorCode.json',
            'BudgetIdentifier.json',
            'DocumentCategory.json',
            'LocationType.json',
        ];

    /**
     * @var array|array[]
     */
    private array  $combinationMap
        = [
            'SectorCode.json'       => ['Sector.json', 'SectorCategory.json'],
            'BudgetIdentifier.json' => ['BudgetIdentifierSector.json', 'BudgetIdentifier.json'],
            'DocumentCategory.json' => ['DocumentCategory.json', 'DocumentCategory-category.json'],
            'LocationType.json'     => ['LocationType.json', 'LocationType-category.json'],
        ];

    /**
     * @var string
     */
    private string $modifiedDate;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->modifiedDate = now()->format('Y-m-d H:i:s');

        foreach ($this->allFiles as $folderName => $fileNames) {
            foreach ($fileNames as $fileName) {
                if (in_array($fileName, $this->ignoreables)) {
                    continue;
                }

                if (in_array($fileName, $this->specialCases)) {
                    switch ($fileName) {
                        case 'SectorCode.json':
                            $this->combineAndProceedForSector($folderName, $fileName, Arr::get($this->combinationMap, $fileName));
                            break;
                        case 'BudgetIdentifier.json':
                            $this->combineAndProceedForBudgetIdentifier($folderName, $fileName, Arr::get($this->combinationMap, $fileName));
                            break;
                        case 'DocumentCategory.json':
                            $this->combineAndProceedForDocumentCategory($folderName, $fileName, Arr::get($this->combinationMap, $fileName));
                            break;
                        case 'LocationType.json':
                            $this->combineAndProceedForLocationType($folderName, $fileName, Arr::get($this->combinationMap, $fileName));
                            break;
                    }
                } else {
                    $this->proceedNormally($folderName, $fileName, $this->urlSuffixMap[$folderName][$fileName]);
                }

                $this->info("Done for $fileName");
            }
        }
    }

    /**
     * Proceed for BudgetIdentifier.json.
     *
     * @param string $folderName
     * @param string $filename
     * @param array $mapCombination
     *
     * @return void
     */
    public function combineAndProceedForBudgetIdentifier(string $folderName, string $filename, array $mapCombination): void
    {
        $temp = ['baseData' => '', 'categoryData' => ''];

        foreach ($mapCombination as $key => $urlSuffix) {
            $type = $key === 0 ? 'baseData' : 'categoryData';
            $url = $this->getUrl($urlSuffix);
            $temp[$type] = $this->getCurlResult($url, $urlSuffix);
        }

        $combinedData = $this->combineBudgetIdentifier($temp['baseData']['data'], $temp['categoryData']['data']);
        $contentForFile = $this->parseToPublisherJson($combinedData, $filename);

        $filePath = "AppData/Data/$folderName/$filename";

        awsUploadFile($filePath, $contentForFile);
        Cache::set($filePath, $contentForFile);
        file_put_contents(public_path($filePath), $contentForFile);
    }

    /**
     * Proceed for DocumentCategory.json.
     *
     * @param string $folderName
     * @param string $filename
     * @param array $mapCombination
     *
     * @return void
     */
    public function combineAndProceedForDocumentCategory(string $folderName, string $filename, array $mapCombination): void
    {
        $temp = ['baseData' => '', 'categoryData' => ''];

        foreach ($mapCombination as $key => $urlSuffix) {
            $type = $key === 0 ? 'baseData' : 'categoryData';
            $url = $this->getUrl($urlSuffix);
            $temp[$type] = $this->getCurlResult($url, $urlSuffix);
        }

        $filteredDocumentCategoryItems = array_filter($temp['baseData']['data'], function ($baseData) use ($folderName) {
            if ($folderName === 'Activity') {
                return $baseData['category'] === 'A';
            } else {
                return $baseData['category'] === 'B';
            }
        });

        $category = $folderName === 'Activity' ? 'Activity Level' : 'Organisation Level';

        foreach ($filteredDocumentCategoryItems as &$documentCategoryItem) {
            $documentCategoryItem['category-name'] = $category;
        }

        $contentForFile = $this->parseToPublisherJson($filteredDocumentCategoryItems, $filename);
        $filePath = "AppData/Data/$folderName/$filename";

        file_put_contents(public_path($filePath), $contentForFile);
        awsUploadFile($filePath, $contentForFile);
        Cache::set($filePath, $contentForFile);
    }

    /**
     * Proceed for LocationType.json.
     *
     * @param string $folderName
     * @param string $fileName
     * @param array $mapCombination
     *
     * @return void
     */
    private function combineAndProceedForLocationType(string $folderName, string $fileName, array $mapCombination): void
    {
        $temp = ['baseData' => '', 'categoryData' => ''];

        foreach ($mapCombination as $key => $urlSuffix) {
            $type = $key === 0 ? 'baseData' : 'categoryData';
            $url = $this->getUrl($urlSuffix);
            $temp[$type] = $this->getCurlResult($url, $urlSuffix);
        }

        $baseData = $temp['baseData']['data'];
        $categoryData = $temp['categoryData']['data'];

        foreach ($baseData as $key => $data) {
            $categoryCode = $data['category'];
            $categoryName = $this->pluckFromLocationCategory($categoryData, $categoryCode, 'name');

            $baseData[$key]['category-name'] = $categoryName;
        }

        $contentForFile = $this->parseToPublisherJson($baseData, $fileName);

        $filePath = "AppData/Data/$folderName/$fileName";

        file_put_contents(public_path($filePath), $contentForFile);
        awsUploadFile($filePath, $contentForFile);
        Cache::set($filePath, $contentForFile);
    }

    /**
     * Proceed for all json.
     *
     * @param $folderName
     * @param $filename
     * @param $urlSuffix
     *
     * @return void
     */
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

    /**
     * @param string $urlSuffix
     *
     * @return string
     */
    private function getUrl(string $urlSuffix): string
    {
        return "https://cdn.iatistandard.org/prod-iati-website/reference_downloads/203/codelists/downloads/clv3/json/en/{$urlSuffix}";
    }

    public function getCurlResult($url, $filename)
    {
        $response = Http::timeout(30)->get($url); // increase timeout for this

        return $response->json();
    }

    /**
     * @param $baseData
     * @param $categoryData
     *
     * @return array
     */
    private function combineBudgetIdentifier($baseData, $categoryData): array
    {
        foreach ($baseData as $datum) {
            $baseData[$datum['code']] = $datum;
        }

        foreach ($categoryData as &$data) {
            $data['category-name'] = $baseData[$data['category']]['name'];
        }

        return $categoryData;
    }

    /**
     * Parse json to IATI-Publisher codelist json.
     *
     * @param $data
     * @param string $filename
     * @return bool|string
     */
    private function parseToPublisherJson($data, string $filename): bool|string
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

        foreach ($dataToWriteInFile[$fileNameNoExt] as &$item) {
            if (Arr::get($item, 'status', 'active') === 'withdrawn' && Arr::get($item, 'name', false)) {
                $item['name'] = $item['name'] . ' (deprecated)';
            }
        }

        if ($filename === 'FileFormat.json') {
            foreach ($dataToWriteInFile[$fileNameNoExt] as &$datum) {
                foreach ($this->codeListWithAdditionalProperties[$filename] as $property) {
                    $datum[$property] = '';
                }
            }
        }

        return json_encode($dataToWriteInFile, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $categoryData
     * @param $code
     * @param $neededKey
     *
     * @return string
     */
    public function pluckFromLocationCategory($categoryData, $code, $neededKey)
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

    /**
     * @param string $filename
     *
     * @return bool
     */
    private function hasLanguageProperty(string $filename): bool
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

    private function pluckFromCategoryData($categoryData, $code, $neededKey)
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

    /**
     * Proceed for Sector.json.
     *
     * @param string $folderName
     * @param mixed $fileName
     * @param array $mapCombination
     *
     * @return void
     */
    private function combineAndProceedForSector(string $folderName, mixed $fileName, array $mapCombination): void
    {
        $temp = ['baseData' => '', 'categoryData' => ''];

        foreach ($mapCombination as $key => $urlSuffix) {
            $type = $key === 0 ? 'baseData' : 'categoryData';
            $url = $this->getUrl($urlSuffix);
            $temp[$type] = $this->getCurlResult($url, $urlSuffix);
        }

        $baseData = $temp['baseData']['data'];
        $categoryData = $temp['categoryData']['data'];

        foreach ($baseData as $key => $data) {
            $categoryCode = $data['category'];
            $categoryName = $this->pluckFromSectorCategory($categoryData, $categoryCode, 'name');

            $baseData[$key]['category-name'] = $categoryName;
        }

        $contentForFile = $this->parseToPublisherJson($baseData, $fileName);

        $filePath = "AppData/Data/$folderName/$fileName";

        file_put_contents(public_path($filePath), $contentForFile);
        awsUploadFile($filePath, $contentForFile);
        Cache::set($filePath, $contentForFile);
    }

    /**
     * @param $categoryData
     * @param $code
     * @param $neededKey
     *
     * @return string
     */
    public function pluckFromSectorCategory($categoryData, $code, $neededKey)
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
}
