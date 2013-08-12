<?php

namespace NetTeam\DDD\Tests\ValueObject;

use NetTeam\DDD\ValueObject\Money;
use NetTeam\DDD\ValueObject\Percent;

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

    public function testConstructionWithScale()
    {
        $money = new Money(123.456789, 'USD', 5);
        $this->assertEquals(123.45679, $money->amountRaw());
        $this->assertEquals('USD', $money->currency());

        $money = new Money(123.456789, 'USD', 1);
        $this->assertEquals(123.5, $money->amountRaw());
        $this->assertEquals('USD', $money->currency());
    }

    public function testConstructionWithStringValueAndCurrency()
    {
        $money = new Money('123.45', 'USD');
        $this->assertEquals(123.45, $money->amount());
        $this->assertEquals('USD', $money->currency());
    }

    public function testStaticFactory()
    {
        $money = Money::USD(123.45);
        $this->assertEquals(123.45, $money->amount());
        $this->assertEquals('USD', $money->currency());
    }

    public function testStaticFactoryWithScale()
    {
        $money = Money::USD(123.45678, 2);
        $this->assertEquals(123.46, $money->amount());
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
        $sameMoneyWithPrecision = new Money(100.002, 'PLN', 2);

        $this->assertTrue($money->equals($sameMoney));
        $this->assertFalse($money->equals($moreMoney));
        $this->assertFalse($money->equals($lessMoney));
        $this->assertTrue($money->equals($sameMoneyWithPrecision));

        $this->assertTrue($money->lessOrEqualThan($sameMoney));
        $this->assertTrue($money->lessOrEqualThan($moreMoney));
        $this->assertFalse($money->lessOrEqualThan($lessMoney));
        $this->assertTrue($money->lessOrEqualThan($sameMoneyWithPrecision));

        $this->assertTrue($money->greaterOrEqualThan($sameMoney));
        $this->assertFalse($money->greaterOrEqualThan($moreMoney));
        $this->assertTrue($money->greaterOrEqualThan($lessMoney));
        $this->assertTrue($money->greaterOrEqualThan($sameMoneyWithPrecision));
    }

    /**
     * @expectedException \DomainException
     */
    public function testComparingWithNotMoneyObject()
    {
        $money = new Money(100, 'PLN');
        $money->compareTo(200);
    }

    public function testAdd()
    {
        $m1 = new Money(100, 'EUR');
        $m2 = new Money(100, 'EUR');

        $result = $m1->add($m2);
        $expected = new Money(200, 'EUR');

        $this->assertEquals($expected, $result);

        $this->assertNotSame($result, $m1);
        $this->assertNotSame($result, $m2);
    }

    public function testAddWithDifferentScales()
    {
        $m1 = new Money(100, 'EUR', 2);
        $m2 = new Money(100, 'EUR', 6);

        $result = $m1->add($m2);
        $expected = new Money(200, 'EUR', 6);

        $this->assertEquals($expected, $result);
    }

    /**
     * @expectedException \DomainException
     */
    public function testAddWithDifferentCurrencies()
    {
        $m1 = new Money(100, 'EUR');
        $m2 = new Money(100, 'PLN');

        $m1->add($m2);
    }

    public function testSubtract()
    {
        $m1 = new Money(100, 'EUR');
        $m2 = new Money(300, 'EUR');

        $result = $m1->subtract($m2);
        $expected = new Money(-200, 'EUR');

        $this->assertEquals($expected, $result);

        $this->assertNotSame($result, $m1);
        $this->assertNotSame($result, $m2);
    }

    public function testSubtractWithDifferentScales()
    {
        $m1 = new Money(100, 'EUR', 6);
        $m2 = new Money(300, 'EUR', 10);

        $result = $m1->subtract($m2);
        $expected = new Money(-200, 'EUR', 10);

        $this->assertEquals($expected, $result);
    }

    /**
     * @expectedException \DomainException
     */
    public function testSubtractWithDifferentCurrencies()
    {
        $m1 = new Money(100, 'EUR');
        $m2 = new Money(100, 'PLN');

        $m1->subtract($m2);
    }

    public function testMultiply()
    {
        $m = new Money(2, 'EUR');

        $result = $m->multiply(1.5);
        $expected = new Money(3, 'EUR');

        $this->assertEquals($expected, $result);
        $this->assertNotSame($m, $result);
    }

    public function testMultiplyNumeric()
    {
        $m = new Money(20, 'EUR');

        $result = $m->multiply(new Percent(0.15));
        $expected = new Money(3, 'EUR');

        $this->assertEquals($expected, $result);
        $this->assertNotSame($m, $result);
    }

    public function testMultiplyWithScale()
    {
        $m = new Money(1.74, 'EUR');
        $scale = 4;

        $result = $m->multiply(1.59, $scale);
        $expected = new Money(2.7666, 'EUR', $scale);

        $this->assertEquals($expected, $result);
        $this->assertNotSame($m, $result);
    }

    /**
     * @expectedException \DomainException
     */
    public function testMultiplyWithInvalidMultiplier()
    {
        $m = new Money(1.5, 'EUR');

        $m->multiply('1.5');
    }

    public function testDivide()
    {
        $m = new Money(10, 'EUR');

        $result = $m->divide(2);
        $expected = new Money(5, 'EUR');

        $this->assertEquals($expected, $result);
        $this->assertNotSame($m, $result);
    }

    public function testDivideMoney()
    {
        $m = new Money(10, 'EUR');

        $result = $m->divide(new Money(20, 'EUR'));

        $this->assertEquals(0.5, $result);
    }

    public function testDivideNumeric()
    {
        $m = new Money(10, 'EUR');

        $result = $m->divide(new Percent(0.5));
        $expected = new Money(20, 'EUR');

        $this->assertEquals($expected, $result);
    }

    /**
     * @expectedException \DomainException
     */
    public function testDivideMoneyWithDifferentCurrency()
    {
        $m = new Money(10, 'EUR');

        $result = $m->divide(new Money(20, 'PLN'));
    }

    public function testDivideWithScale()
    {
        $m = new Money(10.74, 'EUR');
        $scale = 6;

        $result = $m->divide(1.59, $scale);
        $expected = new Money(6.7547, 'EUR', $scale);

        $this->assertEquals($expected, $result);
        $this->assertNotSame($m, $result);
    }

    /**
     * @expectedException \DomainException
     */
    public function testDivideWithInvalidDivisor()
    {
        $m = new Money(1.5, 'EUR');

        $m->divide('1.5');
    }

    public function testIsZero()
    {
        $m1 = new Money(0, 'EUR');
        $m2 = new Money(12, 'EUR');

        $this->assertTrue($m1->isZero());
        $this->assertFalse($m2->isZero());
    }

    public function testIsPositive()
    {
        $m1 = new Money(12, 'EUR');
        $m2 = new Money(0, 'EUR');
        $m3 = new Money(-12, 'EUR');

        $this->assertTrue($m1->isPositive());
        $this->assertFalse($m2->isPositive());
        $this->assertFalse($m3->isPositive());
    }

    public function testIsNegative()
    {
        $m1 = new Money(-12, 'EUR');
        $m2 = new Money(0, 'EUR');
        $m3 = new Money(12, 'EUR');

        $this->assertTrue($m1->isNegative());
        $this->assertFalse($m2->isNegative());
        $this->assertFalse($m3->isNegative());
    }
}
