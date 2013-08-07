<?php

namespace NetTeam\DDD\Tests\ValueObject;

use NetTeam\DDD\ValueObject\Range;

/**
 * @author Paweł A. Wacławczyk <p.a.waclawczyk@gmail.com>
 *
 * @group Unit
 */
class RangeTest extends \PHPUnit_Framework_TestCase
{

    public function testContainingValueInOpenRange()
    {
        $range = new Range(null, null);

        $this->assertTrue($range->contains(-5));
        $this->assertTrue($range->contains(0));
        $this->assertTrue($range->contains(5));
    }

    public function testContainingRangeInOpenRange()
    {
        $range = new Range(null, null);

        $closedRange = new Range(0, 10);
        $leftOpenRange = new Range(null, 0);
        $rightOpenRange = new Range(0, null);
        $openRange = new Range(null, null);

        $this->assertTrue($range->containsRange($closedRange));
        $this->assertTrue($range->containsRange($leftOpenRange));
        $this->assertTrue($range->containsRange($rightOpenRange));
        $this->assertTrue($range->containsRange($openRange));
    }

    public function testContainingValueInLeftOpenRange()
    {
        $range = new Range(null, 0);

        $this->assertTrue($range->contains(-5));
        $this->assertTrue($range->contains(0));
        $this->assertFalse($range->contains(5));
    }

    public function testContainingRangeInLeftOpenRange()
    {
        $range = new Range(null, 0);

        $closedRange = new Range(-10, 0);
        $leftOpenRange = new Range(null, -10);
        $rightOpenRange = new Range(-10, null);
        $openRange = new Range(null, null);

        $this->assertTrue($range->containsRange($closedRange));
        $this->assertTrue($range->containsRange($leftOpenRange));
        $this->assertFalse($range->containsRange($rightOpenRange));
        $this->assertFalse($range->containsRange($openRange));
    }

    public function testContainingValueInRightOpenRange()
    {
        $range = new Range(0, null);

        $this->assertFalse($range->contains(-5));
        $this->assertTrue($range->contains(0));
        $this->assertTrue($range->contains(5));
    }

    public function testContainingRangeInRightOpenRange()
    {
        $range = new Range(0, null);

        $closedRange = new Range(0, 10);
        $leftOpenRange = new Range(null, 10);
        $rightOpenRange = new Range(10, null);
        $openRange = new Range(null, null);

        $this->assertTrue($range->containsRange($closedRange));
        $this->assertFalse($range->containsRange($leftOpenRange));
        $this->assertTrue($range->containsRange($rightOpenRange));
        $this->assertFalse($range->containsRange($openRange));
    }

    public function testContainingValueInClosedRange()
    {
        $range = new Range(0, 2);

        $this->assertFalse($range->contains(-5));
        $this->assertTrue($range->contains(0));
        $this->assertFalse($range->contains(5));
    }

    public function testContainingRangeInClosedRange()
    {
        $range = new Range(0, 2);

        $closedRange = new Range(0, 2);
        $leftOpenRange = new Range(null, 10);
        $rightOpenRange = new Range(10, null);
        $openRange = new Range(null, null);

        $this->assertTrue($range->containsRange($closedRange));
        $this->assertFalse($range->containsRange($leftOpenRange));
        $this->assertFalse($range->containsRange($rightOpenRange));
        $this->assertFalse($range->containsRange($openRange));
    }

    /**
     * @expectedException \DomainException
     */
    public function testIfLowerLimitIsNotNullOrConveratbleToFloatThenThrowException()
    {
        $range = new Range("XYZ", 5);
    }

    /**
     * @expectedException \DomainException
     */
    public function testIfUpperLimitIsNotNullOrConveratbleToFloatThenThrowException()
    {
        $range = new Range(5, "XYZ");
    }

    /**
     * @expectedException \DomainException
     */
    public function testIfLowerLimitIsLowerOrEqualThanUpperLimitThenThrowException()
    {
        $range = new Range(5, 1);
    }

    /**
     * @expectedException \DomainException
     */
    public function testIfComparedRangeIsNotInstanceOfCorrectRangeTypeThenThrowException()
    {
        $range = new Range(1, 1);

        $range->containsRange(new OtherTypeRange(1, 1));
    }

    /**
     * @expectedException \DomainException
     */
    public function testIfComparedRangeThatIsInstanceOfCorrectRangeTypeButHaveLimitsOfNotCorrectTypesThenThrowException()
    {
        $range = new Range(1, 1);

        $range->containsRange(new RangeWithWrongLimitsTypes("X", "Y"));
    }

    public function testIfInversedRangeLimitsAndValidateSetToFalseThenCreateRangeAndDoNotValidate()
    {
        $range = new Range(5, 1, false);

        $this->assertInstanceOf('NetTeam\DDD\ValueObject\Range', $range);
    }
}

class OtherTypeRange
{
    private $min;
    private $max;

    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function min()
    {
        return $this->min;
    }

    public function max()
    {
        return $this->max;
    }
}

class RangeWithWrongLimitsTypes extends Range
{

    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function min()
    {
        return $this->min;
    }

    public function max()
    {
        return $this->max;
    }
}
