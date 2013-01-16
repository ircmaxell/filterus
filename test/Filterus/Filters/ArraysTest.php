<?php

namespace Filterus\Filters;

class ArraysTest extends \PHPUnit_Framework_TestCase {

    public static function provideTestFilter() {
        return array(
            array(array(), 0, null, false),
            array(array(), array(), array(), true),
            array(array('min' => 2), array(1), null, false),
            array(array('min' => 2), array(1, 2), array(1, 2), true),
            array(array('min' => 2), array(1, 2, 3), array(1, 2, 3), true),
            array(array('max' => 2), array(1), array(1), true),
            array(array('max' => 2), array(1, 2), array(1, 2), true),
            array(array('max' => 2), array(1, 2, 3), null, false),
            array(array('keys' => 'int'), array(1, 2, 3), array(1, 2, 3), true),
            array(array('keys' => 'string,min:2'), array(1, 2, 3), array(), false),
            array(array('values' => 'int,min:2'), array(1, 2, 3), array(1 => 2, 2 => 3), false),
        );
    }

    /**
     * @dataProvider provideTestFilter
     */
    public function testFilter($options, $raw, $filtered, $valid) {
        $int = new Arrays($options);
        $this->assertEquals($filtered, $int->filter($raw));
        $this->assertEquals($valid, $int->validate($raw));
    }

}