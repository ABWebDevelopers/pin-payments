<?php
namespace ABWebDevelopers\PinPayments\Tests\TestCase;

use ABWebDevelopers\PinPayments\Tests\Fixture\ParentEntity;
use ABWebDevelopers\PinPayments\Tests\Fixture\ChildEntity;
use PHPUnit\Framework\TestCase;

class EntityApiDataTest extends TestCase
{
    protected $parentEntity;

    protected function setUp()
    {
        $this->parentEntity = new ParentEntity;

        $this->parentEntity->setChildVal(new ChildEntity([
            'string_1_val' => 'String 1',
            'string_2_val' => 'String 2',
            'private_val' => 'Private'
        ]));
    }

    public function testApiDataRetrieval()
    {
        $data = $this->parentEntity->getApiData();

        $this->assertArraySubset([
            'string_val' => 'String',
            'child_val' => [
                'string_1_val' => 'String 1',
                'string_2_val' => 'String 2'
            ]
        ], $data);
    }
}
