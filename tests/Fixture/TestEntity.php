<?php
namespace ABWebDevelopers\PinPayments\Tests\Fixture;

use ABWebDevelopers\PinPayments\Entity\Entity as BaseEntity;
use ABWebDevelopers\PinPayments\Tests\Fixture\ChildEntity;

class TestEntity extends BaseEntity
{
    protected $attributes = [
        'string_val' => 'string',
        'int_val' => 'int',
        'float_val' => 'float',
        'array_val' => 'array',
        'true_val' => 'bool',
        'false_val' => 'bool',
        'empty_val' => 'string',
        'child_val' => 'ABWebDevelopers\PinPayments\Tests\Fixture\ChildEntity'
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
        'empty_val' => null,
    ];

    public function __construct($data = [])
    {
        $this->data['child_val'] = new ChildEntity([
            'string_1_val' => 'String 1',
            'string_2_val' => 'String 2',
            'private_val' => 'Private'
        ]);

        parent::__construct($data);
    }
}
