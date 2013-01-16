<?php

namespace Filterus;

class FilterTest extends \PHPUnit_Framework_TestCase {

    public function testOptions() {
        $filter = new Filters\Raw;
        $filter->setOptions(array(1, 2));
        $this->assertEquals(array(1, 2), $filter->getOptions());
        $filter->setOption('foo', 'bar');
        $this->assertEquals(array(1, 2, 'foo' => 'bar'), $filter->getOptions());
        $filter->setOptions(array(2, 3));
        $this->assertEquals(array(2, 3), $filter->getOptions());
    }

    public function testFactory() {
        $raw = Filter::factory('raw');
        $this->assertTrue($raw instanceof Filters\Raw);
    }

    public function testFactoryParsing() {
        $raw = Filter::factory('raw,foo:bar');
        $this->assertTrue($raw instanceof Filters\Raw);
        $this->assertEquals(array('foo' => 'bar'), $raw->getOptions());
        $raw = Filter::factory('raw,foo:bar,');
        $this->assertTrue($raw instanceof Filters\Raw);
        $this->assertEquals(array('foo' => 'bar'), $raw->getOptions());
    }

    public function testFactorySelf() {
        $raw = Filter::factory('raw');
        $expect = Filter::factory($raw);
        $this->assertSame($raw, $expect);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFactoryFail() {
        Filter::factory('gibberish');
    }

    public function testFactoryRegister() {
        Filter::registerFilter('gibberish', 'Filterus\Filters\Raw');
        $expect = Filter::factory('gibberish');
        $this->assertTrue($expect instanceof Filters\Raw);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFactoryRegisterFail() {
        Filter::registerFilter('gibberish', 'StdClass');
    }

    public function testPool() {
        $pool = Filter::pool('int', 'string');
        $this->assertTrue($pool instanceof Filters\Pool);
        $this->assertEquals(array('filters' => array('int', 'string')), $pool->getOptions());
    }

    public function testChain() {
        $pool = Filter::chain('int', 'string');
        $this->assertTrue($pool instanceof Filters\Chain);
        $this->assertEquals(array('filters' => array('int', 'string')), $pool->getOptions());
    }

    public function testMap() {
        $mapArray = array('a' => 'int');
        $map = Filter::map($mapArray);
        $this->assertTrue($map instanceof Filters\Map);
        $this->assertEquals(array('filters' => $mapArray), $map->getOptions());
    }

    public function testArrays() {
        $array = Filter::arrays();
        $this->assertTrue($array instanceof Filters\Arrays);
    }

    public function testArraysOptions() {
        $array = Filter::arrays('foo:bar');
        $this->assertTrue($array instanceof Filters\Arrays);
        $this->assertEquals(array('foo' => 'bar', 'min' => 0, 'max' => PHP_INT_MAX, 'keys' => null, 'values' => null), $array->getOptions());
    }

    public function testArraysKeys() {
        $array = Filter::arrays('', 'int');
        $this->assertTrue($array instanceof Filters\Arrays);
        $this->assertEquals(array('min' => 0, 'max' => PHP_INT_MAX, 'keys' => 'int', 'values' => null), $array->getOptions());
    }

    public function testArraysValues() {
        $array = Filter::arrays('', '', 'int');
        $this->assertTrue($array instanceof Filters\Arrays);
        $this->assertEquals(array('min' => 0, 'max' => PHP_INT_MAX, 'keys' => null, 'values' => 'int'), $array->getOptions());
    }

}