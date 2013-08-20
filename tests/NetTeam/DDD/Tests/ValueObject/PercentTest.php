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
        $percent = new Percent(.15);

        $this->assertEquals(.15, $percent->value());
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testCreatingFromInvalidValue()
    {
        new Percent('Cannot convert to float.');
    }

    public function testCompareTo()
    {
        $percent = new Percent(0.5);
        $samePercent = new Percent(0.50);
        $morePercent = new Percent(0.7);
        $lessPercent = new Percent(0.3);

        $this->assertTrue($percent->equals($samePercent));
        $this->assertFalse($percent->equals($morePercent));
        $this->assertFalse($percent->equals($lessPercent));

        $this->assertTrue($percent->lessOrEqualThan($samePercent));
        $this->assertTrue($percent->lessOrEqualThan($morePercent));
        $this->assertFalse($percent->lessOrEqualThan($lessPercent));

        $this->assertTrue($percent->greaterOrEqualThan($samePercent));
        $this->assertFalse($percent->greaterOrEqualThan($morePercent));
        $this->assertTrue($percent->greaterOrEqualThan($lessPercent));
    }

    /**
     * @expectedException \DomainException
     */
    public function testCompareToWithNotPercent()
    {
        $money = new Percent(0.5);
        $money->compareTo(200);
    }

    public function testSerialize()
    {
        $percent = new Percent(0.56);

        $this->assertEquals($percent, unserialize(serialize($percent)));
    }
}
