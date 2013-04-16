<?php

namespace NetTeam\DDD\Tests\ValueObject;

use NetTeam\DDD\ValueObject\Money;

/**
 * @author Paweł A. Wacławczyk <p.a.waclawczyk@gmail.com>
 *
 * @group Unit
 */
class MoneyTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructionWithIntegerValueAndCurrency()
    {
        $money = new Money(123, 'USD');
        $this->assertEquals(123, $money->getValue());
        $this->assertEquals('USD', $money->getCurrency());
        $this->assertEquals('123.00 USD', $money->__toString());
    }

    public function testConstructionWithFloatValueAndCurrency()
    {
        $money = new Money(123.45, 'USD');
        $this->assertEquals(123.45, $money->getValue());
        $this->assertEquals('USD', $money->getCurrency());
        $this->assertEquals('123.45 USD', $money->__toString());
    }

    public function testConstructionWithStringValueAndCurrency()
    {
        $money = new Money('123.45', 'USD');
        $this->assertEquals(123.45, $money->getValue());
        $this->assertEquals('USD', $money->getCurrency());
        $this->assertEquals('123.45 USD', $money->__toString());
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testConstructionWithInvalidValue()
    {
        $money = new Money(new \stdClass(), 'USD');
    }

}
