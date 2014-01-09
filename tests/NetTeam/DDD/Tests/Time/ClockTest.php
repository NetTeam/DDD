<?php

namespace NetTeam\DDD\Tests\Time;

use NetTeam\DDD\Time\Clock;

/**
 * Testy dla serwisu Time
 *
 * @author Piotr Walków <piotr.walkow@netteam.pl>
 */
class ClockTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Sprawdzenie czy Time pobiera datę przy metodzie 'now'
     */
    public function testNowIfReturnsDateTimeObject()
    {
        $clock = new Clock();

        $this->assertInstanceOf('DateTime', $clock->now());
    }

    /**
     * Sprawdzenie czy Time pobiera datę pierwszego dnia aktualnego miesiąca przy metodzie
     * 'firstDayOfMonth'
     */
    public function testFirstDayOfMonthIfReturnsFirstDayOfTheMonth()
    {
        $clock = new Clock();

        $firstDayOfTheMonth = $clock->firstDayOfMonth();

        $this->assertInstanceOf('DateTime', $firstDayOfTheMonth);
        $this->assertEquals(new \DateTime('first day of this month'), $firstDayOfTheMonth);
    }

}
