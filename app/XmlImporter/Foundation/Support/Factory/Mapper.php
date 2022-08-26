<?php

namespace App\XmlImporter\Foundation\Support\Factory;

use App\XmlImporter\Foundation\Mapper\Components\Activity as V1Activity;
use App\XmlImporter\Foundation\Mapper\Components\Activity as V2Activity;
use App\XmlImporter\Foundation\Mapper\Components\Activity as V3Activity;
use App\XmlImporter\Foundation\Mapper\Components\Elements\Result as V1Result;
use App\XmlImporter\Foundation\Mapper\Components\Elements\Result as V3Result;
use App\XmlImporter\Foundation\Mapper\Components\Elements\Transaction as V1Transaction;
use App\XmlImporter\Foundation\Mapper\Components\Elements\Transaction as V3Transaction;
use App\XmlImporter\Foundation\Mapper\Components\V105\Activity as V105Activity;
use App\XmlImporter\Foundation\Mapper\Components\Version\V2\Elements\Result as V2Result;
use App\XmlImporter\Foundation\Mapper\Components\Version\V2\Elements\Transaction as V2Transaction;

/**
 * Class XmlImportFactory.
 */
trait Mapper
{
    /**
     * Mapper bindings according to the Xml Version.
     *
     * @var array
     */
    protected $bindings = [
        'V103' => [V1Activity::class, V1Transaction::class, V1Result::class],
        'V105' => [V105Activity::class, V1Transaction::class, V1Result::class],
        'V201' => [V2Activity::class, V2Transaction::class, V2Result::class],
        'V202' => [V2Activity::class, V2Transaction::class, V2Result::class],
        'V203' => [V3Activity::class, V3Transaction::class, V3Result::class],
    ];

    /**
     * Initialize XmlMapper components according to the Xml Version.
     *
     * @return mixed
     */
    public function initComponents()
    {
        $this->iatiActivity = null;

        list($this->activity, $this->transactionElement, $this->resultElement) = $this->getMapping('V203');
    }

    /**
     * Get the mapping for a specific version.
     *
     * @param $version
     * @return mixed
     */
    protected function getMapping($version)
    {
        $elements = [];

        foreach ($this->getBindings($version) as $binding) {
            $elements[] = app()->make($binding);
        }

        return $elements;
    }

    /**
     * Get the binding for any specific version.
     *
     * @param $version
     * @return mixed
     */
    protected function getBindings($version)
    {
        return $this->bindings[$version];
    }
}
