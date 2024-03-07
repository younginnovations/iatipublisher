<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

/**
 * This command will set app data json cache. This command will be executed at each deployment.
 *
 * This is for issue 1342: https://github.com/younginnovations/iatipublisher/issues/1342
 *
 * @class SetAppDataJsonCache
 */
class SetAppDataJsonCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SetAppDataJsonCache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will set app data json cache. This command will be executed at each deployment.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $allFiles = [
            'Activity' => [
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
            'ActivityArray' => [
                    'Languages.php',
                ],
            'Organization' => [
                'Country.json',
                'Currency.json',
                'Language.json',
                'OrganisationElements.json',
                'OrganisationElementsGroup.json',
                'OrganisationRole.json',
                'OrganizationRegistrationAgency.json',
                'OrganizationType.json',
            ],
            'OrganizationArray' => [
                'Country.php',
                'Currency.php',
                'OrganizationRegistrationAgency.php',
            ],
        ];

        $flattenedFilePaths = collect($allFiles)->flatMap(function ($files, $key) {
            return collect($files)->map(function ($file) use ($key) {
                return $key . '/' . $file;
            });
        })->values()->all();

        $message = 'Attempting to set AppData cache at: ' . now()->toDateTimeString();
        logger()->info($message);
        $this->info($message);

        foreach ($flattenedFilePaths as $filePath) {
            $cacheKey = "AppData/Data/$filePath";

            if (Cache::get($cacheKey)) {
                Cache::forget($cacheKey);
            }

            Cache::forever($cacheKey, awsGetFile($cacheKey));
        }

        $message = 'AppData cache set at: ' . now()->toDateTimeString();
        logger()->info($message);
        $this->info($message);
    }
}
