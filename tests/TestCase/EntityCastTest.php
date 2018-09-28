<?php
namespace ABWebDevelopers\PinPayments\Tests\TestCase;

use ABWebDevelopers\PinPayments\Tests\Fixture\TestEntity;
use PHPUnit\Framework\TestCase;
use ABWebDevelopers\PinPayments\Tests\Fixture\ChildEntity;

class EntityCastTest extends TestCase
{
    protected $entity;

    protected function setUp()
    {
        $this->entity = new TestEntity;
    }
    /**
     * @expectedException \ABWebDevelopers\PinPayments\Entity\Exception\MissingAttributeException
     */
    public function testInvalidStringSetToArray()
    {
        $this->entity->string_val = ['Item 1'];
    }

    public function testValidStringSets()
    {
        $this->entity->string_val = 12;
        $this->assertSame('12', $this->entity->string_val);

        $this->entity->string_val = 12.1;
        $this->assertSame('12.1', $this->entity->string_val);

        $this->entity->string_val = true;
        $this->assertSame('1', $this->entity->string_val);
    }

    /**
     * @expectedException \ABWebDevelopers\PinPayments\Entity\Exception\MissingAttributeException
     */
    public function testInvalidBoolSetToString()
    {
        $this->entity->true_val = 'true';
    }

    /**
     * @expectedException \ABWebDevelopers\PinPayments\Entity\Exception\MissingAttributeException
     */
    public function testInvalidBoolSetToInt()
    {
        $this->entity->true_val = 1;
    }

    /**
     * @expectedException \ABWebDevelopers\PinPayments\Entity\Exception\MissingAttributeException
     */
    public function testInvalidBoolSetToArray()
    {
        $this->entity->true_val = ['Item 1'];
    }

    /**
     * @expectedException \ABWebDevelopers\PinPayments\Entity\Exception\MissingAttributeException
     */
    public function testInvalidIntSetToAlphaString()
    {
        $this->entity->int_val = 'abc123';
    }

    /**
     * @expectedException \ABWebDevelopers\PinPayments\Entity\Exception\MissingAttributeException
     */
    public function testInvalidIntSetToArray()
    {
        $this->entity->int_val = ['Item 1'];
    }

    public function testValidIntSets()
    {
        $this->entity->int_val = '12';
        $this->assertSame(12, $this->entity->int_val);

        $this->entity->int_val = 12.1;
        $this->assertSame(12, $this->entity->int_val);

        $this->entity->int_val = true;
        $this->assertSame(1, $this->entity->int_val);
    }

    /**
     * @expectedException \ABWebDevelopers\PinPayments\Entity\Exception\MissingAttributeException
     */
    public function testInvalidFloatSetToAlphaString()
    {
        $this->entity->float_val = 'abc123';
    }

    /**
     * @expectedException \ABWebDevelopers\PinPayments\Entity\Exception\MissingAttributeException
     */
    public function testInvalidFloatSetToArray()
    {
        $this->entity->float_val = ['Item 1'];
    }

    public function testValidFloatSets()
    {
        $this->entity->float_val = '12';
        $this->assertSame(12.0, $this->entity->float_val);

        $this->entity->float_val = '12.1';
        $this->assertSame(12.1, $this->entity->float_val);

        $this->entity->float_val = 12.1;
        $this->assertSame(12.1, $this->entity->float_val);

        $this->entity->float_val = true;
        $this->assertSame(1.0, $this->entity->float_val);
    }

    /**
     * @expectedException \ABWebDevelopers\PinPayments\Entity\Exception\MissingAttributeException
     */
    public function testInvalidArraySetToString()
    {
        $this->entity->array_val = 'true';
    }

    /**
     * @expectedException \ABWebDevelopers\PinPayments\Entity\Exception\MissingAttributeException
     */
    public function testInvalidArraySetToInt()
    {
        $this->entity->array_val = 1;
    }

    /**
     * @expectedException \ABWebDevelopers\PinPayments\Entity\Exception\MissingAttributeException
     */
    public function testInvalidArraySetToBool()
    {
        $this->entity->array_val = true;
    }

    public function testValidChildClassSets()
    {
        $this->entity->ChildVal = new ChildEntity([
            'string_1_val' => 'String 1 New',
            'string_2_val' => 'String 2 New',
            'private_val' => 'Private New'
        ]);
        $this->assertInstanceOf(ChildEntity::class, $this->entity->ChildVal);
        $this->assertSame('String 1 New', $this->entity->ChildVal->string_1_val);
        $this->assertSame('String 2 New', $this->entity->ChildVal->string_2_val);
        $this->assertSame('Private New', $this->entity->ChildVal->PrivateVal);

        $this->entity->ChildVal = [
            'string_1_val' => 'String 1 New 2',
            'string_2_val' => 'String 2 New 2',
            'private_val' => 'Private New 2'
        ];
        $this->assertInstanceOf(ChildEntity::class, $this->entity->ChildVal);
        $this->assertSame('String 1 New 2', $this->entity->ChildVal->string_1_val);
        $this->assertSame('String 2 New 2', $this->entity->ChildVal->string_2_val);
        $this->assertSame('Private New 2', $this->entity->ChildVal->PrivateVal);
    }
}
