<?php
namespace ABWebDevelopers\PinPayments\Tests\TestCase;

use ABWebDevelopers\PinPayments\Entity\Card;
use ABWebDevelopers\PinPayments\Tests\TestCase\HttpTestCase;

class CardsEndpointTest extends HttpTestCase
{
    protected $card;

    public function testPostCard()
    {
        $this->fakeResponse(200, [
            'response' => [
                'token' => 'card_LhYOX2rd5nWJKFFCJ85gyb',
                'scheme' => 'visa',
                'display_number' => 'XXXX-XXXX-XXXX-0000',
                'issuing_country' => 'US',
                'expiry_month' => 12,
                'expiry_year' => 2019,
                'name' => 'Test Person',
                'address_line1' => '1 Test Place',
                'address_line2' => '',
                'address_city' => 'Testington',
                'address_postcode' => '1000',
                'address_state' => 'Testate',
                'address_country' => 'Australia',
                'customer_token' => null,
                'primary' => null
            ],
            'ip_address' => '127.0.0.1'
        ]);

        $card = new Card([
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
        ]);

        $card = $this->client->cards->post($card);

        $this->assertInstanceOf(Card::class, $card);
        $this->assertTrue($card->isSubmitted());
        $this->assertTrue($card->isSuccessful());
        $this->assertTrue($card->isLoaded());
        $this->assertEquals('card_LhYOX2rd5nWJKFFCJ85gyb', $card->getToken());
        $this->assertEquals('XXXX-XXXX-XXXX-0000', $card->getNumber());
        $this->assertEquals('XXXX-XXXX-XXXX-0000', $card->getDisplayNumber());
    }

    public function testPostCardWithErrors()
    {
        $this->fakeResponse(422, '{
            "error": "invalid_resource",
            "error_description": "One or more parameters were missing or invalid",
            "messages": [
                {
                    "param": "number",
                    "code": "number_invalid",
                    "message": "Number is not a valid Pin Payments test card number. See https://pinpayments.com/docs/api/test-cards"
                },
                {
                    "param": "expiry_month",
                    "code": "expiry_month_invalid",
                    "message": "Expiry month is expired"
                },
                {
                    "param": "expiry_year",
                    "code": "expiry_year_invalid",
                    "message": "Expiry year is expired"
                }
            ]
        }');

        $card = new Card([
            'number' => '4444333322221111',
            'expiryMonth' => '12',
            'expiryYear' => '2016',
            'cvc' => '123',
            'name' => 'Test Person',
            'addressLine1' => '1 Test Place',
            'addressCity' => 'Testington',
            'addressPostcode' => '1000',
            'addressState' => 'Testate',
            'addressCountry' => 'Australia'
        ]);

        $card = $this->client->cards->post($card);

        $this->assertInstanceOf(Card::class, $card);
        $this->assertTrue($card->isSubmitted());
        $this->assertFalse($card->isSuccessful());
        $this->assertFalse($card->isLoaded());
        $this->assertEquals('One or more parameters were missing or invalid', $card->getError());
    }
}
