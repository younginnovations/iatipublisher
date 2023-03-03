<?php

namespace Tests\Unit\Xml;

use App\XmlImporter\Foundation\Mapper\Components\XmlMapper;
use App\XmlImporter\Foundation\Support\Factory\Validation;
use App\XmlImporter\Foundation\Support\Providers\TemplateServiceProvider;
use App\XmlImporter\Foundation\Support\Providers\XmlServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\Unit\ImportBaseTest;

class XmlBaseTest extends ImportBaseTest
{
    /**
     * @var string
     */
    private string $completeXmlFile = 'tests/Unit/TestFiles/Xml/complete.xml';

    /**
     * @var array
     */
    protected array $completeData;

    /**
     * @var object
     */
    protected object $validation;

    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->signIn();
        $this->getCompleteData();
        $this->validation = app()->make(Validation::class);
    }

    /**
     * @return array
     * @throws BindingResolutionException
     */
    public function getXmlActivity(): array
    {
        return $this->getMappedActivity();
    }

    /**
     * @return array
     * @throws BindingResolutionException
     * @throws \ReflectionException
     */
    public function getMappedActivity(): array
    {
        $xmlData = $this->loadXmlData();
        $template = app()->make(TemplateServiceProvider::class)->load();
        $userId = $this->user->id;
        $orgId = $this->organization->id;
        $orgRef = $this->organization->identifier;
        $identifier = $this->getIdentifiers();
        $reportingOrg = $this->user->organization->reporting_org;
        $mapper = new XmlMapper();

        return $mapper->map($xmlData, $template, $userId, $orgId, $orgRef, $identifier, $reportingOrg)->mappedActivity;
    }

    /**
     * @return array
     */
    public function loadXmlData(): array
    {
        $contents = file_get_contents($this->completeXmlFile);
        $xmlServiceProvider = app()->make(XmlServiceProvider::class);

        return $xmlServiceProvider->load($contents);
    }

    /**
     * Sets 100% complete xml file to array variable.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function getCompleteData(): void
    {
        $this->completeData = $this->getXmlActivity();
    }
}
