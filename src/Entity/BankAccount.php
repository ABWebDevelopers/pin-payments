<?php
namespace ABWebDevelopers\PinPayments\Entity;

use ABWebDevelopers\PinPayments\Entity\Entity;

class BankAccount extends Entity
{
    protected $attributes = [
        // Request attributes
        'token' => 'string',
        'name' => 'string',
        'bsb' => 'int',
        'number' => 'int',

        // Response attributes
        'display_number' => 'string',
        'bank_name' => 'string',
        'branch' => 'string',

        // Communication attributes
        'successful' => 'bool',
        'loaded' => 'bool',
        'submitted' => 'bool',
        'status_message' => 'string',
        'error' => 'string',
        'messages' => 'array'
    ];

    protected $masked = [
        'number' => 'display_number'
    ];

    protected $apiAttributes = [
        'token',
        'name',
        'bsb',
        'number'
    ];
}
