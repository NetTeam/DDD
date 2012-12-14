<?php

namespace NetTeam\DDD\Test;

use NetTeam\DDD\Enum;

/**
 * EnumTest
 *
 * @author Krzysztof Menżyk <krzysztof.menzyk@netteam.pl>
 *
 * @group Unit
 */
class EnumTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructValidValue()
    {
        new ExampleEnum(ExampleEnum::ONE);
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testConstructInvalidValue()
    {
        new ExampleEnum(-1);
    }

    public function testConstructInvalidValueWithNoValidation()
    {
        $enum = new ExampleEnum(-1, false);

        $this->assertEquals(-1, $enum->get());
    }

    public function testGet()
    {
        $enum = new ExampleEnum(ExampleEnum::ONE);

        $this->assertEquals(ExampleEnum::ONE, $enum->get());
        $this->assertNotEquals(ExampleEnum::TWO, $enum->get());
    }

    public function testIs()
    {
        $enum = new ExampleEnum(ExampleEnum::ONE);

        $this->assertTrue($enum->is(ExampleEnum::ONE));
        $this->assertFalse($enum->is(ExampleEnum::TWO));
        $this->assertFalse($enum->is(ExampleEnum::THREE));
    }

    public function testEquals()
    {
        $enum = new ExampleEnum(ExampleEnum::ONE);

        $this->assertTrue($enum->equals(new ExampleEnum(ExampleEnum::ONE)));
        $this->assertFalse($enum->is(new ExampleEnum(ExampleEnum::TWO)));
        $this->assertFalse($enum->is(new ExampleEnum(ExampleEnum::THREE)));
    }

    public function testIsOneOf()
    {
        $enum = new ExampleEnum(ExampleEnum::TWO);

        $this->assertTrue($enum->isOneOf(array(ExampleEnum::ONE, ExampleEnum::TWO)));
        $this->assertFalse($enum->isOneOf(array(ExampleEnum::ONE, ExampleEnum::THREE)));
    }
}

class ExampleEnum extends Enum
{
    const ONE   = 1;
    const TWO   = 2;
    const THREE = 3;
}
