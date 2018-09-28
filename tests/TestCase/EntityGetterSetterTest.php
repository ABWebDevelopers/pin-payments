<?php
namespace ABWebDevelopers\PinPayments\Tests\TestCase;

use ABWebDevelopers\PinPayments\Tests\Fixture\TestEntity;
use PHPUnit\Framework\TestCase;
use ABWebDevelopers\PinPayments\Tests\Fixture\ChildEntity;

class EntitySetterGetterTest extends TestCase
{
    protected $entity;

    protected function setUp()
    {
        $this->entity = new TestEntity;
    }

    public function testMagicGets()
    {
        $this->assertSame('String', $this->entity->StringVal);
        $this->assertSame(31, $this->entity->IntVal);
        $this->assertSame(31.1, $this->entity->FloatVal);
        $this->assertArraySubset(['Item 1', 'Item 2'], $this->entity->ArrayVal);
        $this->assertTrue($this->entity->TrueVal);
        $this->assertFalse($this->entity->FalseVal);
        $this->assertNull($this->entity->EmptyVal);
        $this->assertInstanceOf(ChildEntity::class, $this->entity->ChildVal);
    }

    public function testMagicGetsUnderscored()
    {
        $this->assertSame('String', $this->entity->string_val);
        $this->assertSame(31, $this->entity->int_val);
        $this->assertSame(31.1, $this->entity->float_val);
        $this->assertArraySubset(['Item 1', 'Item 2'], $this->entity->array_val);
        $this->assertTrue($this->entity->true_val);
        $this->assertFalse($this->entity->false_val);
        $this->assertNull($this->entity->empty_val);
        $this->assertInstanceOf(ChildEntity::class, $this->entity->child_val);
    }

    public function testMagicCallsToGetFunctions()
    {
        $this->assertSame('String', $this->entity->getStringVal());
        $this->assertSame(31, $this->entity->getIntVal());
        $this->assertSame(31.1, $this->entity->getFloatVal());
        $this->assertArraySubset(['Item 1', 'Item 2'], $this->entity->getArrayVal());
        $this->assertTrue($this->entity->getTrueVal());
        $this->assertFalse($this->entity->getFalseVal());
        $this->assertNull($this->entity->getEmptyVal());
        $this->assertInstanceOf(ChildEntity::class, $this->entity->getChildVal());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidMagicGet()
    {
        $this->assertNotEmpty($this->entity->invalidVal);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidMagicCallToGetFunction()
    {
        $this->assertNotEmpty($this->entity->getInvalidVal());
    }

    public function testMagicSets()
    {
        $this->entity->StringVal = 'New String';
        $this->assertSame('New String', $this->entity->StringVal);

        $this->entity->IntVal = 32;
        $this->assertSame(32, $this->entity->IntVal);

        $this->entity->FloatVal = 32.2;
        $this->assertSame(32.2, $this->entity->FloatVal);

        $this->entity->ArrayVal = ['Item 1', 'Item 2', 'Item 3'];
        $this->assertArraySubset(['Item 1', 'Item 2', 'Item 3'], $this->entity->ArrayVal);

        $this->entity->TrueVal = false;
        $this->assertFalse($this->entity->TrueVal);

        $this->entity->FalseVal = true;
        $this->assertTrue($this->entity->FalseVal);

        $this->entity->EmptyVal = 'Not empty';
        $this->assertSame('Not empty', $this->entity->EmptyVal);

        $this->entity->ChildVal = new ChildEntity([
            'string_1_val' => 'String 1 New',
            'string_2_val' => 'String 2 New',
            'private_val' => 'Private New'
        ]);
        $this->assertInstanceOf(ChildEntity::class, $this->entity->ChildVal);
        $this->assertSame('String 1 New', $this->entity->ChildVal->string_1_val);
        $this->assertSame('String 2 New', $this->entity->ChildVal->string_2_val);
        $this->assertSame('Private New', $this->entity->ChildVal->PrivateVal);
    }

    public function testMagicSetsUnderscored()
    {
        $this->entity->string_val = 'New String';
        $this->assertSame('New String', $this->entity->string_val);

        $this->entity->int_val = 32;
        $this->assertSame(32, $this->entity->int_val);

        $this->entity->float_val = 32.2;
        $this->assertSame(32.2, $this->entity->float_val);

        $this->entity->array_val = ['Item 1', 'Item 2', 'Item 3'];
        $this->assertArraySubset(['Item 1', 'Item 2', 'Item 3'], $this->entity->array_val);

        $this->entity->true_val = false;
        $this->assertFalse($this->entity->true_val);

        $this->entity->false_val = true;
        $this->assertTrue($this->entity->false_val);

        $this->entity->empty_val = 'Not empty';
        $this->assertSame('Not empty', $this->entity->empty_val);

        $this->entity->child_val = new ChildEntity([
            'string_1_val' => 'String 1 New',
            'string_2_val' => 'String 2 New',
            'private_val' => 'Private New'
        ]);
        $this->assertInstanceOf(ChildEntity::class, $this->entity->child_val);
        $this->assertSame('String 1 New', $this->entity->child_val->string_1_val);
        $this->assertSame('String 2 New', $this->entity->child_val->string_2_val);
        $this->assertSame('Private New', $this->entity->child_val->PrivateVal);
    }

    public function testMagicCallsToSetFunctions()
    {
        $this->entity->setStringVal('New String');
        $this->assertSame('New String', $this->entity->getStringVal());

        $this->entity->setIntVal(32);
        $this->assertSame(32, $this->entity->getIntVal());

        $this->entity->setFloatVal(32.2);
        $this->assertSame(32.2, $this->entity->getFloatVal());

        $this->entity->setArrayVal(['Item 1', 'Item 2', 'Item 3']);
        $this->assertArraySubset(['Item 1', 'Item 2', 'Item 3'], $this->entity->getArrayVal());

        $this->entity->setTrueVal(false);
        $this->assertFalse($this->entity->getTrueVal());

        $this->entity->setFalseVal(true);
        $this->assertTrue($this->entity->getFalseVal());

        $this->entity->setEmptyVal('Not empty');
        $this->assertSame('Not empty', $this->entity->getEmptyVal());

        $this->entity->setChildVal(new ChildEntity([
            'string_1_val' => 'String 1 New',
            'string_2_val' => 'String 2 New',
            'private_val' => 'Private New'
        ]));
        $this->assertInstanceOf(ChildEntity::class, $this->entity->getChildVal());
        $this->assertSame('String 1 New', $this->entity->getChildVal()->getValue('string_1_val'));
        $this->assertSame('String 2 New', $this->entity->getChildVal()->getValue('string_2_val'));
        $this->assertSame('Private New', $this->entity->getChildVal()->getPrivateVal());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidMagicSet()
    {
        $this->entity->invalidVal = 'String';
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidMagicCallToSetFunction()
    {
        $this->assertNotEmpty($this->entity->setInvalidVal('String'));
    }

    public function testIssetCalls()
    {
        $this->assertTrue(isset($this->entity->string_val));
        $this->assertTrue(isset($this->entity->true_val));
        $this->assertTrue(isset($this->entity->false_val));
        $this->assertTrue(isset($this->entity->int_val));
        $this->assertTrue(isset($this->entity->float_val));
        $this->assertTrue(isset($this->entity->array_val));
        $this->assertFalse(isset($this->entity->empty_val));
    }

    public function testUnsetCalls()
    {
        unset($this->entity->string_val);
        unset($this->entity->true_val);
        unset($this->entity->false_val);
        unset($this->entity->int_val);
        unset($this->entity->float_val);
        unset($this->entity->array_val);

        $this->assertFalse(isset($this->entity->string_val));
        $this->assertFalse(isset($this->entity->true_val));
        $this->assertFalse(isset($this->entity->false_val));
        $this->assertFalse(isset($this->entity->int_val));
        $this->assertFalse(isset($this->entity->float_val));
        $this->assertFalse(isset($this->entity->array_val));
    }
}
