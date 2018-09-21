<?php
namespace ABWebDevelopers\PinPayments;

use Psr\Http\Message\ResponseInterface;
use ABWebDevelopers\PinPayments\Endpoint\Exception\UnauthorizedException;

class ApiResponse
{
    protected $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;

        if ($this->response->getStatusCode() === 401) {
            throw new UnauthorizedException;
        }
    }

    public function successful()
    {
        return ($this->response->getStatusCode() === 200);
    }

    public function data()
    {
        return json_decode($this->response->getBody()->getContents(), true)['response'];
    }
}
