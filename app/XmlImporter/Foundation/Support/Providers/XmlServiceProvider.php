<?php

namespace App\XmlImporter\Foundation\Support\Providers;

use App\IATI\Models\Organization\Organization;
use Sabre\Xml\Service;

/**
 * Class Xml.
 */
class XmlServiceProvider
{
    /**
     * @var Service
     */
    protected $xmlService;

    /**
     * @var XmlErrorServiceProvider
     */
    protected $xmlErrorServiceProvider;

    /**
     * @var Organization
     */
    protected $organization;

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
     * @return array|object|string
     */
    public function load($data)
    {
        return $this->xmlService->parse($data);
    }

    /**
     * Returns the AidStream relevant name for the version, i.e., 'V103', 'V202', etc.
     *
     * @param $data
     * @return string
     */
    public function version($data)
    {
        $document = new \SimpleXMLElement($data);

        return $this->convertToVersion($document['version']);
    }

    /**
     * Convert xml version to string representation of version.
     *
     * @param string $version
     * @return string
     */
    protected function convertToVersion($version)
    {
        return 'V' . str_replace('.', '', $version);
    }

    /**
     * Validate the uploaded Xml file against its schema.
     *
     * @param $contents
     * @return bool
     */
    public function isValidAgainstSchema($contents)
    {
        return $this->xmlErrorServiceProvider
            ->load($contents)
            ->schemaValidate($this->getSchemaPath());
    }

    /**
     * Get the path for the Xml Schema according to the version of the Xml.
     *
     * @param $version
     * @return string
     */
    protected function getSchemaPath()
    {
        return app_path('XmlImporter/Template/iati-activities-schema.xsd');
    }
}
