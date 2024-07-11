<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Elements\Xml\OrganizationXmlGenerator;
use App\IATI\Models\Organization\Organization;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

/**
 * Class FixPublishedOrganizationXmlFile1393.
 */
class FixPublishedOrganizationXmlFile1393 extends Command
{
    public function __construct(protected OrganizationXmlGenerator $xmlGenerator)
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:published-organization-xml-document-link-recipient-country';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '
        One time run command
        This command will fetch published organization and its published xml file
        check if recipient-country present inside the document-link node
        if not then it will append recipient-country inside the document-link node and publishes it to registry
        without modifying the last updated date.
    ';

    /**
     * @return void
     */
    public function handle(): void
    {
        echo 'Do you want to continue? (yes/no)';

        if (strtolower(trim(fgets(STDIN))) === 'yes') {
            $publishedOrganizations = $this->getPublishedOrganizations();

            foreach ($publishedOrganizations as $organization) {
                if (array_key_exists('recipient_country', Arr::collapse($publishedOrganizations[0]->document_link)) && !is_array_value_empty(Arr::collapse($publishedOrganizations[0]->document_link)['recipient_country'])) {
                    $organizationXmlFile = awsGetFile("organizationXmlFiles/$organization->publisher_id-organisation.xml");

                    if ($organizationXmlFile) {
                        try {
                            $xmlFile = simplexml_load_string($organizationXmlFile);
                            $organization = Organization::find($organization->id);
                            $settings = $organization->settings;

                            if (!count($xmlFile->xpath('//iati-organisation/document-link/recipient-country'))) {
                                $this->takeOrganizationXmlFileBackup($organization);
                                $this->xmlGenerator->generateOrganizationXml($settings, $organization, false);
                                $this->info("organizationXmlFiles/$organization->publisher_id-organisation.xml");
                            }
                        } catch (\Exception | \Throwable $exception) {
                            $message = 'Organization Xml File generation failed - ' . $organization->publisher_name;
                            logger($message);
                            logger()->error($exception);
                            $this->info($message);
                        }
                    }
                }
            }
        }
    }

    /**
     * Takes backup from affected organizations.
     *
     * @param $organization
     *
     * @return void
     */
    public function takeOrganizationXmlFileBackup($organization): void
    {
        $getFile = awsGetFile("organizationXmlFiles/$organization->publisher_id-organisation.xml");

        if (awsUploadFile("organizationXmlBackupFiles/$organization->publisher_id-organisation.xml", $getFile)) {
            $this->info('Successfully backed up organization xml file - ' . $organization->publisher_name);
        }
    }

    /**
     * Get organization whose status is either published or draft.
     *
     * @return Collection|array
     */
    public function getPublishedOrganizations(): Collection|array
    {
        return Organization::query()
            ->whereNotNull('document_link')
            ->whereIn('status', ['published', 'draft'])
            ->get();
    }
}
