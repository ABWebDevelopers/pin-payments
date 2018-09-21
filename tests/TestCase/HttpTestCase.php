<?php
namespace ABWebDevelopers\PinPayments\Tests\TestCase;

use ABWebDevelopers\PinPayments\ApiClient;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;

class HttpTestCase extends TestCase
{
    protected $httpClient;
    protected $client;

    protected function setUp()
    {
        $this->httpClient = new \Http\Mock\Client;
        $this->client = new ApiClient('H3bXbf8NFiFKZ_pZd4ZmBA', true, $this->httpClient);
    }

    public function fakeResponse(int $statusCode = 200, $responseData = null): void
    {
        // Set stream
        $stream = $this->createMock('Psr\Http\Message\StreamInterface');

        // Stream content
        if (isset($responseData) && is_array($responseData)) {
            $responseData = json_encode($responseData);
        } else if (isset($responseData)) {
            $responseData = strval($responseData);
        }

        $stream->method('getContents')
            ->willReturn($responseData);

        // Set response
        $response = $this->createMock('Psr\Http\Message\ResponseInterface');

        $response->method('getStatusCode')
            ->willReturn($statusCode);

        $response->method('getBody')
            ->willReturn($stream);

        $this->httpClient->addResponse($response);
    }
}
