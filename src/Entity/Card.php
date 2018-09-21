<?php
namespace ABWebDevelopers\PinPayments\Entity;

use ABWebDevelopers\PinPayments\Entity\Entity;

class Card extends Entity
{
    protected $attributes = [
        // Request attributes
        'token' => 'string',
        'number' => 'int',
        'expiry_month' => 'int',
        'expiry_year' => 'int',
        'cvc' => 'int',
        'name' => 'string',
        'address_line1' => 'string',
        'address_line2' => 'string',
        'address_city' => 'string',
        'address_postcode' => 'int',
        'address_state' => 'string',
        'address_country' => 'string',

        // Response attributes
        'scheme' => 'string',
        'display_number' => 'string',
        'issuing_country' => 'string',
        'customer_token' => 'string',
        'primary' => 'bool',

        // Communication attributes
        'successful' => 'bool',
        'loaded' => 'bool',
        'submitted' => 'bool',
        'status_message' => 'string',
        'error' => 'string',
        'messages' => 'array'
    ];
}
