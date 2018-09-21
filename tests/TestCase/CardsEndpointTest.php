<?php
namespace ABWebDevelopers\PinPayments\Tests\TestCase;

use ABWebDevelopers\PinPayments\Entity\Card;
use ABWebDevelopers\PinPayments\Tests\TestCase\HttpTestCase;

class CardsEndpointTest extends HttpTestCase
{
    protected $card;

    protected function setUp()
    {
        parent::setUp();

        $this->card = new Card([
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
    }

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

        $card = $this->client->cards->post($this->card);

        $this->assertEquals('card_LhYOX2rd5nWJKFFCJ85gyb', $card->getToken());
    }
}
