<?php

namespace App\Console\Commands;

use App\IATI\Services\Publisher\PublisherService;
use App\IATI\Traits\MigrateGeneralTrait;
use App\IATI\Traits\MigrateSettingTrait;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Class UnpublishAidstreamOrganizations.
 */
class UnpublishAidstreamOrganizations extends Command
{
    use MigrateSettingTrait;
    use MigrateGeneralTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unpublish:aidstream-organizations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unpublishes AidStream organizations from the IATI Registry.';

    /**
     * @var array
     */
    private array $organizationIds
        = [
            2310,
            2427,
            1543,
            1070,
            1585,
            2509,
            576,
            2505,
            466,
            1686,
            2202,
        ];

    /**
     * @param  DB  $db
     * @param  PublisherService  $publisherService
     */
    public function __construct(
        protected DB $db,
        protected PublisherService $publisherService,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws GuzzleException
     */
    public function handle(): void
    {
        try {
            $aidstreamOrganizationPublished = $this->db::connection('aidstream')->table('organization_published')->whereIn('organization_id', $this->organizationIds)->get();

            if (count($aidstreamOrganizationPublished)) {
                foreach ($aidstreamOrganizationPublished as $organizationPublished) {
                    $this->logInfo("Started process for organization id: {$organizationPublished->organization_id}");
                    $setting = $this->db::connection('aidstream')->table('settings')->where('organization_id', $organizationPublished->organization_id)->first();

                    if ($setting && $setting->registry_info) {
                        $registryInfo = $this->getPublishingInfo($setting->registry_info, $this->getPublisherId($organizationPublished->filename));

//                        if (Arr::get($registryInfo, 'publisher_verification', false) && Arr::get($registryInfo, 'token_verification', false)) {
                        $this->logInfo("Unpublishing organization id: {$organizationPublished->organization_id}");
                        $this->publisherService->unpublishOrganizationFile($registryInfo, $organizationPublished, false);
                        $this->logInfo("Unpublished organization id: {$organizationPublished->organization_id}");
//                        }
                    }

                    $this->logInfo("Finished process for organization id: {$organizationPublished->organization_id}");
                }
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
            $this->logError($exception->getMessage());
        }
    }

    /**
     * Returns publisher id.
     *
     * @param $filename
     *
     * @return string
     */
    public function getPublisherId($filename): string
    {
        $explodedElements = explode('.', $filename);
        $basename = Arr::get($explodedElements, 0, '');
        $explodedBasename = explode('-', $basename);
        array_pop($explodedBasename);

        return implode('-', $explodedBasename);
    }
}
