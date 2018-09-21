<?php
namespace ABWebDevelopers\PinPayments\Entity;

use ABWebDevelopers\PinPayments\Entity\Entity;

class Balance extends Entity
{
    protected $attributes = [
        // Response attributes
        'available' => 'int',
        'available_currency' => 'string',
        'pending' => 'int',
        'pending_currency' => 'string',

        // Communication attributes
        'successful' => 'bool',
        'loaded' => 'bool'
    ];
}
