<?php

namespace NetTeam\DDD\Tests;

use NetTeam\DDD\EnumUtil;

/**
 * @author Paweł A. Wacławczyk <pawel.waclawczyk@netteam.pl>
 * @autor Dawid Drelichowski <dawid.drelichowski@netteam.pl>
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
            'FOUR' => 4
        ), EnumUtil::getAvailableValues(new Enum(Enum::ONE)));
    }

    public function testGetAvailableValuesFromFQCN()
    {
        $this->assertEquals(array(
            '__NULL' => null,
            'ONE' => 1,
            'TWO' => 2,
            '__THREE' => 3,
            'FOUR' => 4
        ), EnumUtil::getAvailableValues('NetTeam\DDD\Tests\Enum'));
    }

    public function testCreateChoicesFromObject()
    {
        $this->assertEquals(array(
            1 => 'enum.one',
            2 => 'enum.two',
            4 => 'enum.four'
                ), EnumUtil::createChoiceList(new Enum(Enum::ONE)));
    }

    public function testCreateChoicesFromFQCN()
    {
        $this->assertEquals(array(
            1 => 'enum.one',
            2 => 'enum.two',
            4 => 'enum.four'
                ), EnumUtil::createChoiceList('NetTeam\DDD\Tests\Enum'));
    }

    public function testCreateChoicesWithOwnPrefix()
    {
        $this->assertEquals(array(
            1 => 'prefix.one',
            2 => 'prefix.two',
            4 => 'prefix.four'
                ), EnumUtil::createChoiceList('NetTeam\DDD\Tests\Enum', 'prefix'));
    }

    public function testCreateSortedChoiceListWithPrefix()
    {
        $this->assertEquals(
            array(
                1 => 'prefix.one',
                4 => 'prefix.four',
                2 => 'prefix.two'
            ),
            EnumUtil::createSortedChoiceList($this->getMockTranslator(), 'NetTeam\DDD\Tests\Enum', 'prefix')
        );
    }

    public function testCreateSortedChoiceListWithoutPrefix()
    {
        $this->assertEquals(
            array(
                1 => 'enum.one',
                4 => 'enum.four',
                2 => 'enum.two'
            ),
            EnumUtil::createSortedChoiceList($this->getMockTranslator(), 'NetTeam\DDD\Tests\Enum')
        );
    }

    private function getMockTranslator()
    {
        return \Mockery::mock('Symfony\Component\Translation\TranslatorInterface')
            ->shouldReceive('trans')
            ->andReturnUsing(function ($value) { return $value; })
            ->getMock();
    }

}

class Enum
{

    const __NULL = null;
    const ONE = 1;
    const TWO = 2;
    const __THREE = 3;
    const FOUR = 4;

}
