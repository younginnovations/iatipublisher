<?php

declare(strict_types=1);

namespace App\XmlImporter\Foundation\Support\Providers;

use App\IATI\Models\Organization\Organization;
use Sabre\Xml\ParseException;
use Sabre\Xml\Service;

/**
 * Class Xml.
 */
class XmlServiceProvider
{
    /**
     * @var Service
     */
    protected Service $xmlService;

    /**
     * @var XmlErrorServiceProvider
     */
    protected XmlErrorServiceProvider $xmlErrorServiceProvider;

    /**
     * @var Organization
     */
    protected Organization $organization;

    /**
     * Xml constructor.
     * @param Service                 $xmlService
     * @param XmlErrorServiceProvider $xmlErrorServiceProvider
     * @param Organization $organization
     */
    public function __construct(
        Service $xmlService,
        XmlErrorServiceProvider $xmlErrorServiceProvider,
        Organization $organization
    ) {
        $this->xmlService = $xmlService;
        $this->xmlErrorServiceProvider = $xmlErrorServiceProvider;
        $this->organization = $organization;
    }

    /**
     * Load xml data into an array|object|string.
     *
     * @param $data
     *
     * @return array|object|string
     * @throws ParseException
     */
    public function load($data): array|object|string
    {
        return $this->xmlService->parse($data);
    }

    /**
     * Returns the AidStream relevant name for the version, i.e., 'V103', 'V202', etc.
     *
     * @param $data
     *
     * @return string
     * @throws \Exception
     */
    public function version($data): string
    {
        $document = new \SimpleXMLElement($data);

        return $this->convertToVersion($document['version']);
    }

    /**
     * Convert xml version to string representation of version.
     *
     * @param $version
     *
     * @return string
     */
    protected function convertToVersion($version): string
    {
        return 'V' . str_replace('.', '', $version);
    }

    /**
     * Validate the uploaded Xml file against its schema.
     *
     * @param $contents
     *
     * @return bool
     */
    public function isValidAgainstSchema($contents): bool
    {
        return $this->xmlErrorServiceProvider
            ->load($contents)
            ->schemaValidate($this->getSchemaPath());
    }

    /**
     * Get the path for the Xml Schema according to the version of the Xml.
     *
     * @return string
     */
    protected function getSchemaPath(): string
    {
        return app_path('XmlImporter/Template/iati-activities-schema.xsd');
    }
}
