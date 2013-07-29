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
        $this->assertEquals(123, $money->amount());
        $this->assertEquals('USD', $money->currency());
    }

    public function testConstructionWithFloatValueAndCurrency()
    {
        $money = new Money(123.45, 'USD');
        $this->assertEquals(123.45, $money->amount());
        $this->assertEquals('USD', $money->currency());
    }

    public function testConstructionWithStringValueAndCurrency()
    {
        $money = new Money('123.45', 'USD');
        $this->assertEquals(123.45, $money->amount());
        $this->assertEquals('USD', $money->currency());
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testConstructionWithInvalidValue()
    {
        $money = new Money(new \stdClass(), 'USD');
    }

    /**
     * @expectedException \DomainException
     */
    public function testComparingMoneyWithDiffrentCurrencies()
    {
        $moneyPLN = new Money(100, 'PLN');
        $moneyUSD = new Money(100, 'USD');
        $moneyPLN->equals($moneyUSD);
    }

    public function testComparingToOther()
    {
        $money = new Money(100, 'PLN');
        $sameMoney = new Money(100, 'PLN');
        $moreMoney = new Money(1000, 'PLN');
        $lessMoney = new Money(10, 'PLN');

        $this->assertTrue($money->equals($sameMoney));
        $this->assertFalse($money->equals($moreMoney));
        $this->assertFalse($money->equals($lessMoney));

        $this->assertTrue($money->lessOrEqualThan($sameMoney));
        $this->assertTrue($money->lessOrEqualThan($moreMoney));
        $this->assertFalse($money->lessOrEqualThan($lessMoney));

        $this->assertTrue($money->greaterOrEqualThan($sameMoney));
        $this->assertFalse($money->greaterOrEqualThan($moreMoney));
        $this->assertTrue($money->greaterOrEqualThan($lessMoney));
    }

    /**
     * @expectedException \DomainException
     */
    public function testComparingWithNotMOneyObject()
    {
        $money = new Money(100, 'PLN');
        $money->compareTo(200);
    }
}
