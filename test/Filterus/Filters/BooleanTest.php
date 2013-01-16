<?php

namespace Filterus\Filters;

class BooleanTest extends \PHPUnit_Framework_TestCase {

    public static function provideTestFilter() {
        return array(
            array(array(), 1, true, true),
            array(array(), 'yes', true, true),
            array(array(), 'no', false, true),
            array(array(), '0', false, true),
            array(array(), 'test', null, false),
        );
    }

    /**
     * @dataProvider provideTestFilter
     */
    public function testFilter($options, $raw, $filtered, $valid) {
        $int = new Boolean($options);
        $this->assertEquals($filtered, $int->filter($raw));
        $this->assertEquals($valid, $int->validate($raw));
    }

}