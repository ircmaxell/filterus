<?php

namespace Filterus\Filters;

class IntTest extends \PHPUnit_Framework_TestCase {

    public static function provideTestFilter() {
        return array(
            array(array(), 1, 1, true),
            array(array(), PHP_INT_MAX, PHP_INT_MAX, true),
            array(array(), ~PHP_INT_MAX, ~PHP_INT_MAX, true),
            array(array(), "1", 1, true),
            array(array(), "test", 0, false),
            array(array(), 1.1, 1, false),
            array(array(), new \StdClass, 0, false),
            array(array('min' => 2), 1, 2, false),
            array(array('min' => 2), 2, 2, true),
            array(array('min' => 2), 3, 3, true),
            array(array('max' => 2), 1, 1, true),
            array(array('max' => 2), 2, 2, true),
            array(array('max' => 2), 3, 2, false),
            array(array('max' => 2, 'default' => 5), 3, 2, false),
            array(array('min' => 2, 'default' => 5), 1, 2, false),
        );
    }

    /**
     * @dataProvider provideTestFilter
     */
    public function testFilter($options, $raw, $filtered, $valid) {
        $int = new Ints($options);
        $this->assertEquals($filtered, $int->filter($raw));
        $this->assertEquals($valid, $int->validate($raw));
    }

}