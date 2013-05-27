<?php

namespace NetTeam\DDD\Tests\ValueObject;

use NetTeam\DDD\ValueObject\KeyValue;

/**
 * @author Krzysztof Menżyk <krzysztof.menzyk@netteam.pl>
 *
 * @group Unit
 */
class KeyValueTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $key   = 'PL';
        $value = 'Polska';

        $keyValue = new KeyValue($key, $value);

        $this->assertSame($key, $keyValue->getKey());
        $this->assertSame($value, $keyValue->getValue());
    }
}
