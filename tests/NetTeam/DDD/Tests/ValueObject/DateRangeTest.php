<?php

namespace NetTeam\DDD\Tests\ValueObject;

use NetTeam\DDD\ValueObject\DateRange;

/**
 * @author Krzysztof Menżyk <krzysztof.menzyk@netteam.pl>
 *
 * @group Unit
 */
class DateRangeTest extends \PHPUnit_Framework_TestCase
{

    public function testShouldHandleNullRange()
    {
        $dateRange = new DateRange(null, null);

        $this->assertNull($dateRange->min());
        $this->assertNull($dateRange->max());
    }

    public function testContainingDateInRange()
    {
        $range = new DateRange(new \DateTime('2013-01-01'), new \DateTime('2013-12-31'));
        $this->assertTrue($range->contains(new \DateTime('2013-06-06')));
        $this->assertFalse($range->contains(new \DateTime('2012-06-06')));
    }

    public function testContainingRangeInRange()
    {
        $range = new DateRange(new \DateTime('2013-01-01'), new \DateTime('2013-12-31'));
        $innerRange = new DateRange(new \DateTime('2013-06-01'), new \DateTime('2013-06-30'));
        $outerRange = new DateRange(new \DateTime('2012-06-01'), new \DateTime('2014-06-30'));

        $this->assertTrue($range->containsRange($innerRange));
        $this->assertFalse($range->containsRange($outerRange));
    }
}
