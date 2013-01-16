<?php

namespace Filterus\Filters;

class ChainTest extends \PHPUnit_Framework_TestCase {

    public static function provideTestFilter() {
        return array(
            array(array(), 'foo', 'foo', true),
            array(array('filters' => array('int')), 'foo', null, false),
            array(array('filters' => array('int', 'string')), 'foo', null, false),
            array(array('filters' => array('int', 'string')), 1, '1', true),
        );
    }

    /**
     * @dataProvider provideTestFilter
     */
    public function testFilter($options, $raw, $filtered, $valid) {
        $int = new Chain($options);
        $this->assertEquals($filtered, $int->filter($raw));
        $this->assertEquals($valid, $int->validate($raw));
    }

}