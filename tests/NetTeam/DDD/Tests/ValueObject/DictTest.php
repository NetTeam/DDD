<?php

namespace NetTeam\DDD\Tests\ValueObject;

use NetTeam\DDD\ValueObject\Dict;

/**
 * @author Krzysztof Menżyk <krzysztof.menzyk@netteam.pl>
 *
 * @group Unit
 */
class DictTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $key   = 'PL';
        $value = 'Polska';

        $dict = new Dict($key, $value);

        $this->assertSame($key, $dict->getKey());
        $this->assertSame($value, $dict->getValue());
    }
}
