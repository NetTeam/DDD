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
}
