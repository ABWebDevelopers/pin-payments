<?php
namespace ABWebDevelopers\PinPayments\Tests\TestCase;

use ABWebDevelopers\PinPayments\Tests\Fixture\TestEntity;
use PHPUnit\Framework\TestCase;

class EntityCastTest extends TestCase
{
    protected $entity;

    protected function setUp()
    {
        $this->entity = new TestEntity;
    }
    /**
     * @expectedException \InvalidArgumentException
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
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidBoolSetToString()
    {
        $this->entity->true_val = 'true';
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidBoolSetToInt()
    {
        $this->entity->true_val = 1;
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidBoolSetToArray()
    {
        $this->entity->true_val = ['Item 1'];
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidIntSetToAlphaString()
    {
        $this->entity->int_val = 'abc123';
    }

    /**
     * @expectedException \InvalidArgumentException
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
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidFloatSetToAlphaString()
    {
        $this->entity->float_val = 'abc123';
    }

    /**
     * @expectedException \InvalidArgumentException
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
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArraySetToString()
    {
        $this->entity->array_val = 'true';
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArraySetToInt()
    {
        $this->entity->array_val = 1;
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArraySetToBool()
    {
        $this->entity->array_val = true;
    }
}
