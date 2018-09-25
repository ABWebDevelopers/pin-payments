<?php
namespace ABWebDevelopers\PinPayments\Entity;

use ABWebDevelopers\PinPayments\Entity\Entity;

class Recipient extends Entity
{
    protected $attributes = [
        // Request attributes
        'token' => 'string',
        'name' => 'string',
        'email' => 'string',
        'bank_account' => 'ABWebDevelopers\PinPayments\Entity\BankAccount',

        // Response attributes
        'created_at' => 'datetime',

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
        'name',
        'email',
        'bank_account'
    ];
}
