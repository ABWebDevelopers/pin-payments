<?php
namespace ABWebDevelopers\PinPayments\Tests\Fixture;

use ABWebDevelopers\PinPayments\Entity\Entity as BaseEntity;

class TestEntity extends BaseEntity
{
    protected $attributes = [
        'string_val' => 'string',
        'int_val' => 'int',
        'float_val' => 'float',
        'array_val' => 'array',
        'true_val' => 'bool',
        'false_val' => 'bool',
        'empty_val' => 'string'
    ];

    protected $data = [
        'string_val' => 'String',
        'int_val' => 31,
        'float_val' => 31.1,
        'array_val' => [
            'Item 1',
            'Item 2'
        ],
        'true_val' => true,
        'false_val' => false,
        'empty_val' => null
    ];
}
