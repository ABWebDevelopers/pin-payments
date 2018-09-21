<?php
namespace ABWebDevelopers\PinPayments;

use ABWebDevelopers\PinPayments\ApiClient;
use ABWebDevelopers\PinPayments\ApiResponse;

class ApiRequest
{
    /**
     * The main API URLs
     *
     * @var array
     */
    protected $urls = [
        'live' => 'https://api.pinpayments.com/1/',
        'test' => 'https://test-api.pinpayments.com/1/'
    ];

    /**
     * The API client
     *
     * @var ABWebDevelopers\PinPayments\ApiClient
     */
    protected $client;

    /**
     * The API endpoint to use
     *
     * @var string
     */
    protected $endpoint;

    /**
     * The HTTP post method to use
     *
     * @var string
     */
    protected $method;

    /**
     * The data to send to the API
     *
     * @var array
     */
    protected $data = [];

    /**
     * Any endpoint variables that need to be injected into the URL
     *
     * @var array
     */
    protected $endpointVars = [];


    public function __construct(ApiClient $client, string $method, string $endpoint, array $data = [], array $endpointVars = [])
    {
        $this->client = $client;

        if (!in_array(strtoupper($method), ['GET', 'POST', 'PUT', 'DELETE'])) {
            throw new \InvalidArgumentException('Method must be one of the following: GET, POST, PUT or DELETE');
        }

        $this->method = $method;
        $this->endpoint = $endpoint;
        $this->data = $data;
        $this->endpointVars = $endpointVars;
    }

    public function send()
    {
        $response = $this->client->getHttpClient()->sendRequest(
            $this->createRequest()
        );

        return new ApiResponse($response);
    }

    protected function createRequest()
    {
        if ($this->method === 'GET') {
            return $this->client->getMessageProvider()->createRequest($this->method, $this->getRequestUrl());
        } else {
            return $this->client->getMessageProvider()->createRequest($this->method, $this->getRequestUrl(), [], $this->getPostData());
        }
    }

    protected function getRequestUrl()
    {
        $url = $this->urls[($this->client->getTestMode() === true) ? 'test' : 'live'];

        $endpoint = preg_replace_callback('/:([a-z0-9\-]+)/i', function ($placeholder) {
            if (!isset($this->endpointVars[$placeholder])) {
                throw new \InvalidArgumentException('You must provide a value for "' . $placeholder . '" in the API call.');
            }

            return strval($this->endpointVars[$placeholder]);
        }, $this->endpoint);

        return $url . $endpoint;
    }

    protected function getPostData()
    {
        return http_build_query($this->data);
    }
}
