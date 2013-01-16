<?php

namespace Filterus\Filters;

class PoolTest extends \PHPUnit_Framework_TestCase {

    public static function provideTestFilter() {
        return array(
            array(array(), 'foo', null, false),
            array(array('filters' => array('int')), 'foo', null, false),
            array(array('filters' => array('int', 'string')), 'foo', 'foo', true),
            array(array('filters' => array('int', 'string')), 1, 1, true),
        );
    }

    /**
     * @dataProvider provideTestFilter
     */
    public function testFilter($options, $raw, $filtered, $valid) {
        $int = new Pool($options);
        $this->assertEquals($filtered, $int->filter($raw));
        $this->assertEquals($valid, $int->validate($raw));
    }

}