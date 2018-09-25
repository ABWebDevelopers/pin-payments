<?php
namespace ABWebDevelopers\PinPayments\Entity;

use Entity;

class Charge extends Entity
{
    protected $attributes = [
        // Request attributes
        'token' => 'string',
        'email' => 'string',
        'description' => 'string',
        'amount' => 'int',
        'ip_address' => 'string',
        'currency' => 'string',
        'capture' => 'bool',
        'metadata' => 'array',

        // Response attributes
        'created_at' => 'string',
        'transfer' => 'array',
        'amount_refunded' => 'int',
        'total_fees' => 'int',
        'merchant_entitlement' => 'int',
        'refund_pending' => 'bool',
        'authorisation_expired' => 'bool',
        'captured' => 'bool',
        'captured_at' => 'string',
        'settlement_currency' => 'string',

        // Communication attributes
        'successful' => 'bool',
        'loaded' => 'bool',
        'submitted' => 'bool',
        'status_message' => 'string',
        'error' => 'string',
        'messages' => 'array'
    ];

    protected $apiAttributes = [
        'token',
        'email',
        'description',
        'amount',
        'ip_address',
        'currency',
        'capture',
        'metadata'
    ];
}
