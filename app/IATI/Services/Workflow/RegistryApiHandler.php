<?php

namespace App\IATI\Services\Workflow;

use App\IATI\API\CkanClient;

/**
 * Class RegistryApiHandler.
 */
abstract class RegistryApiHandler
{
    /**
     * @var
     */
    protected $client;

    /**
     * @var
     */
    protected $publisherId;

    /**
     * @var
     */
    protected $apiKey;

    /**
     * Initialize an CkanClient instance.
     *
     * @param $url
     * @param $key
     *
     * @return RegistryApiHandler
     */
    public function init($url, $key)
    {
        $this->client = new CkanClient($url, $key);
        $this->apiKey = $key;

        return $this;
    }

    /**
     * @param $publisherId
     */
    public function setPublisher($publisherId)
    {
        $this->publisherId = $publisherId;
    }
}
