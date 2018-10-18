<?php
namespace ABWebDevelopers\PinPayments\Tests\TestCase;

use ABWebDevelopers\PinPayments\Entity\Card;
use ABWebDevelopers\PinPayments\Entity\Charge;
use ABWebDevelopers\PinPayments\Tests\TestCase\HttpTestCase;

class ChargesEndpointTest extends HttpTestCase
{
    public function testPostCharge()
    {
        $this->fakeResponse(200, '{
            "response": {
                "token": "ch_Hwv3Uq3v_Ms_xvvSPgOaNw",
                "success": true,
                "amount": 10000,
                "currency": "AUD",
                "description": "Test Charge",
                "email": "test@test.com",
                "ip_address": "127.0.0.1",
                "created_at": "2018-10-18T08:45:08Z",
                "status_message": "Success",
                "error_message": null,
                "card": {
                    "token": "card_AZJNLUJvJNhgYMdCcJoSfA",
                    "scheme": "visa",
                    "display_number": "XXXX-XXXX-XXXX-0000",
                    "issuing_country": "AU",
                    "expiry_month": 12,
                    "expiry_year": 2019,
                    "name": "Test Person",
                    "address_line1": "1 Test Place",
                    "address_line2": null,
                    "address_city": "Testington",
                    "address_postcode": "1000",
                    "address_state": "Testate",
                    "address_country": "Australia",
                    "customer_token": null,
                    "primary": null
                },
                "transfer": [],
                "amount_refunded": 0,
                "total_fees": 205,
                "merchant_entitlement": 9795,
                "refund_pending": false,
                "authorisation_expired": false,
                "captured": true,
                "captured_at": "2018-10-18T08:45:08Z",
                "settlement_currency": "AUD",
                "active_chargebacks": false,
                "metadata": {
                    "ordernumber": 123456
                }
            }
        }');

        $charge = new Charge([
            'email' => 'test@test.com',
            'description' => 'Test Charge',
            'amount' => 10000,
            'ipAddress' => '127.0.0.1',
            'currency' => 'AUD',
            'capture' => true,
            'metadata' => [
                'orderNumber' => 123456
            ],
            'card' => new Card([
                'number' => '4200000000000000',
                'expiryMonth' => '12',
                'expiryYear' => '2019',
                'cvc' => '123',
                'name' => 'Test Person',
                'addressLine1' => '1 Test Place',
                'addressCity' => 'Testington',
                'addressPostcode' => '1000',
                'addressState' => 'Testate',
                'addressCountry' => 'Australia'
            ])
        ]);

        $charge = $this->client->charges->post($charge);

        $this->assertInstanceOf(Charge::class, $charge);
        $this->assertTrue($charge->isSubmitted());
        $this->assertTrue($charge->isSuccessful());
        $this->assertTrue($charge->isLoaded());
        $this->assertEquals('ch_Hwv3Uq3v_Ms_xvvSPgOaNw', $charge->getToken());
        $this->assertEquals(10000, $charge->getAmount());

        $this->assertInstanceOf(Card::class, $charge->Card);
        $this->assertFalse($charge->Card->isSubmitted());
        $this->assertFalse($charge->Card->isSuccessful());
        $this->assertTrue($charge->Card->isLoaded());
        $this->assertEquals('card_AZJNLUJvJNhgYMdCcJoSfA', $charge->Card->getToken());
    }
}
