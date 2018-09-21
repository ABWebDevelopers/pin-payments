<?php
namespace ABWebDevelopers\PinPayments\Tests\TestCase;

use ABWebDevelopers\PinPayments\Endpoint\Exception\UnauthorizedException;

class BalanceEndpointTest extends HttpTestCase
{
    public function testBalance()
    {
        $this->fakeResponse(200, [
            'response' => [
                'available' => [
                    [
                        'amount' => 50000,
                        'currency' => 'AUD'
                    ]
                ],
                'pending' => [
                    [
                        'amount' => 50000,
                        'currency' => 'AUD'
                    ]
                ]
            ]
        ]);

        $balance = $this->client->balance->get();

        $this->assertEquals(50000, $balance->getAvailable());
        $this->assertEquals(50000, $balance->getPending());
    }

    public function testBalanceUnauthenticated()
    {
        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionCode(401);

        $this->fakeResponse(401, [
            'error' => 'unauthenticated',
            'error_description' => 'Not authorised. (Check API Key).'
        ]);

        $balance = $this->client->balance->get();
    }
}
