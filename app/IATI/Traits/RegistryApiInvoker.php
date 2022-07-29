<?php

namespace App\IATI\Traits;

use GuzzleHttp\Client;

/**
 * Class RegistryApiInvoker.
 */
trait RegistryApiInvoker
{
    /**
     * Initialize the GuzzleHttp\Client instance.
     *
     * @return mixed
     */
    protected function initGuzzleClient()
    {
        return app()->make(Client::class);
    }

    /**
     * Make an api request to the given action.
     *
     * @param        $action
     * @param        $requestParameter
     * @param null   $apiKey
     *
     * @return mixed
     */
    protected function request($action, $requestParameter = null, $apiKey = null)
    {
        $apiHost = env('REGISTRY_URL');
        $url = ($requestParameter) ? sprintf('%saction/%s?id=%s', $apiHost, $action, $requestParameter) :
            sprintf('%saction/%s', $apiHost, $action);
        $client = $this->initGuzzleClient();

        return $client->get($url, ['headers' => ['authorization' => $apiKey]])->getBody()->getContents();
    }

    /**
     * Search for a publisher with a specific publisherId.
     *
     * @param $publisherId
     *
     * @return string
     */
    public function searchForPublisher($publisherId)
    {
        return $this->request('organization_show', $publisherId);
    }
}
