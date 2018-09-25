<?php
namespace ABWebDevelopers\PinPayments\Tests\Fixture;

use ABWebDevelopers\PinPayments\Entity\Entity as BaseEntity;

class ParentEntity extends BaseEntity
{
    protected $attributes = [
        'string_val' => 'string',
        'private_val' => 'string',
        'child_val' => 'ABWebDevelopers\PinPayments\Tests\Fixture\ChildEntity'
    ];

    protected $data = [
        'string_val' => 'String',
        'private_val' => 'Private',
    ];

    protected $apiAttributes = [
        'string_val',
        'child_val'
    ];
}
