<?php
namespace ABWebDevelopers\PinPayments\Entity;

use ABWebDevelopers\PinPayments\Entity\Entity;

class Transfer extends Entity
{
    protected $attributes = [
        // Request attributes
        'token' => 'string',
        'description' => 'string',
        'amount' => 'int',
        'currency' => 'string',
        'recipient' => 'ABWebDevelopers\PinPayments\Entity\Recipient',
        'self' => 'bool',

        // Response attributes
        'status' => 'string',
        'total_debits' => 'int',
        'total_credits' => 'int',
        'created_at' => 'datetime',
        'paid_at' => 'datetime',
        'reference' => 'string',
        'bank_account' => 'ABWebDevelopers\PinPayments\Entity\BankAccount',

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
        'description',
        'amount',
        'currency',
        'recipient'
    ];
}
