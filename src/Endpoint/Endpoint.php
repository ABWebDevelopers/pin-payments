<?php
namespace ABWebDevelopers\PinPayments\Endpoint;

use ABWebDevelopers\PinPayments\ApiClient;

abstract class Endpoint
{
    protected $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }
}
