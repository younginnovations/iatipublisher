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
    public function init($url, $key): static
    {
        $this->client = new CkanClient($url, $key);
        $this->apiKey = $key;

        return $this;
    }

    /**
     * Sets publisher value for class.
     *
     * @param $publisherId
     *
     * @return void
     */
    public function setPublisher($publisherId): void
    {
        $this->publisherId = $publisherId;
    }
}
