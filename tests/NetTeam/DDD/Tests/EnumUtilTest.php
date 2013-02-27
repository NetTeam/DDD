<?php

namespace NetTeam\DDD\Tests;

use NetTeam\DDD\EnumUtil;

/**
 * @author Paweł A. Wacławczyk <pawel.waclawczyk@netteam.pl>
 *
 * @group Unit
 */
class EnumUtilTest extends \PHPUnit_Framework_TestCase
{

    public function testGetAvailableValuesFromObjbect()
    {
        $this->assertEquals(array(
            '__NULL' => null,
            'ONE' => 1,
            'TWO' => 2,
            '__THREE' => 3,
        ), EnumUtil::getAvailableValues(new Enum(Enum::ONE)));
    }

    public function testGetAvailableValuesFromFQCN()
    {
        $this->assertEquals(array(
            '__NULL' => null,
            'ONE' => 1,
            'TWO' => 2,
            '__THREE' => 3,
        ), EnumUtil::getAvailableValues('NetTeam\DDD\Tests\Enum'));
    }

    public function testCreateChoicesFromObject()
    {
        $this->assertEquals(array(
            1 => 'enum.one',
            2 => 'enum.two',
                ), EnumUtil::createChoiceList(new Enum(Enum::ONE)));
    }

    public function testCreateChoicesFromFQCN()
    {
        $this->assertEquals(array(
            1 => 'enum.one',
            2 => 'enum.two',
                ), EnumUtil::createChoiceList('NetTeam\DDD\Tests\Enum'));
    }

    public function testCreateChoicesWithOwnPrefix()
    {
        $this->assertEquals(array(
            1 => 'prefix.one',
            2 => 'prefix.two',
                ), EnumUtil::createChoiceList('NetTeam\DDD\Tests\Enum', 'prefix'));
    }

}

class Enum
{

    const __NULL = null;
    const ONE = 1;
    const TWO = 2;
    const __THREE = 3;

}
