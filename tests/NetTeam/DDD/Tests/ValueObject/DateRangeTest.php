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

        $this->assertNull($dateRange->getStart());
        $this->assertNull($dateRange->getEnd());
    }
}
