<?php

declare(strict_types=1);

namespace App\XmlImporter\Foundation;

use App\XmlImporter\Foundation\Mapper\Components\XmlMapper;
use App\XmlImporter\Foundation\Support\Providers\TemplateServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class XmlProcessor.
 */
class XmlProcessor
{
    /**
     * @var TemplateServiceProvider
     */
    protected TemplateServiceProvider $templateServiceProvider;

    /**
     * @var array
     */
    protected array $transactions = [];

    /**
     * @var XmlMapper
     */
    protected XmlMapper $xmlMapper;

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
     * @param       $userId
     * @param       $orgId
     * @param       $dbIatiIdentifiers
     *
     * @return bool
     * @throws BindingResolutionException
     * @throws \JsonException
     */
    public function process(array $xml, $userId, $orgId, $dbIatiIdentifiers): bool
    {
        if ($this->xmlMapper->isValidActivityFile($xml)) {
            //file_put_contents('valid_test.json', sprintf('%s%s', 'isValidActivityFile passed ', PHP_EOL), FILE_APPEND);
            $this->xmlMapper
                ->map($xml, $this->templateServiceProvider->load(), $userId, $orgId, $dbIatiIdentifiers);

            return true;
        }

        return false;
    }
}
