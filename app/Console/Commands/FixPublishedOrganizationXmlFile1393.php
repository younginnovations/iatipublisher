<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\IATI\Models\Organization\Organization;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class FixPublishedOrganizationXmlFile1393.
 */
class FixPublishedOrganizationXmlFile1393 extends Command
{
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

    public function handle()
    {
        $publishedOrganizations = $this->getPublishedOrganizations();
        dd($publishedOrganizations);
    }

    /**
     * @return Collection|array
     */
    public function getPublishedOrganizations(): Collection|array
    {
        return Organization::query()
            ->whereNotNull('document_link')
            ->where('status', 'published')
            ->whereJsonLength('document_link->0->recipient_country', '>', 0)
            ->get();
    }
}
