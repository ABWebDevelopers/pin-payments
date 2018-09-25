<?php
namespace ABWebDevelopers\PinPayments\Tests\Fixture;

use ABWebDevelopers\PinPayments\Entity\Entity as BaseEntity;

class ChildEntity extends BaseEntity
{
    protected $attributes = [
        'string_1_val' => 'string',
        'string_2_val' => 'string',
        'private_val' => 'string'
    ];

    protected $apiAttributes = [
        'string_1_val',
        'string_2_val'
    ];
}
