<?php

namespace NetTeam\DDD\Tests\ValueObject;

use NetTeam\DDD\ValueObject\Percent;

/**
 * @author Paweł A. Wacławczyk <p.a.waclawczyk@gmail.com>
 *
 * @group Unit
 */
class PercentTest extends \PHPUnit_Framework_TestCase
{

    public function testGettingPercentValue()
    {
        $percent = new Percent(1.50);

        $this->assertEquals(1.5, $percent->get());
    }

    public function testConvertingToScalarValue()
    {
        $percent = new Percent(1.50);

        $this->assertEquals(0.015, $percent->scalar());
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testCreatingFromInvalidValue()
    {
        new Percent('Cannot convert to float.');
    }

}
