<?php

namespace App\XmlImporter\Foundation;

use App\XmlImporter\Foundation\Mapper\Components\XmlMapper;
use App\XmlImporter\Foundation\Support\Providers\TemplateServiceProvider;

/**
 * Class XmlProcessor.
 */
class XmlProcessor
{
    /**
     * @var TemplateServiceProvider
     */
    protected $templateServiceProvider;

    /**
     * @var array
     */
    protected $transactions = [];

    /**
     * @var
     */
    protected $xmlMapper;

    /**
     * Xml constructor.
     * @param TemplateServiceProvider $templateServiceProvider
     * @param XmlMapper               $xmlMapper
     */
    public function __construct(TemplateServiceProvider $templateServiceProvider, XmlMapper $xmlMapper)
    {
        $this->templateServiceProvider = $templateServiceProvider;
        $this->xmlMapper = $xmlMapper;
    }

    /**
     * Process the uploaded Xml data into AidStream compatible data format.
     *
     * @param array $xml
     * @param       $version
     * @param       $userId
     * @param       $orgId
     * @param       $dbIatiIdentifiers
     * @param       $consortium_id
     * @return      bool
     */
    public function process(array $xml, $userId, $orgId, $dbIatiIdentifiers)
    {
        if ($this->xmlMapper->isValidActivityFile($xml)) {
            $this->xmlMapper
                ->map($xml, $this->templateServiceProvider->load(), $userId, $orgId, $dbIatiIdentifiers);

            return true;
        }

        return false;
    }
}
