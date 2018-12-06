<?php
namespace ABWebDevelopers\PinPayments\Entity;

use ABWebDevelopers\PinPayments\Entity\Entity;

class Refund extends Entity
{
    protected $attributes = [
        // Request attributes
        'token' => 'string',
        'amount' => 'int',

        // Response attributes
        'currency' => 'string',
        'charge' => 'ABWebDevelopers\PinPayments\Entity\Charge',
        'created_at' => 'datetime',

        'transfer' => 'array',
        'amount_refunded' => 'int',
        'total_fees' => 'int',
        'captured' => 'bool',
        'captured_at' => 'datetime',

        // Communication attributes
        'successful' => 'bool',
        'loaded' => 'bool',
        'submitted' => 'bool',
        'status_message' => 'string',
        'error' => 'string',
        'messages' => 'array'
    ];

    protected $apiAttributes = [
        'amount',
        'charge',
    ];
}
