<?php

namespace Filterus\Filters;

require_once __DIR__ . '/../../Stubs/CastableClass.php';

class AlnumTest extends \PHPUnit_Framework_TestCase {

    public static function provideTestFilter() {
        return array(
            array(array(), 1, '1', true),
            array(array(), '1', '1', true),
            array(array(), '$', null, false),
            array(array(), 1.1, null, false),
            array(array(), array(), null, false),
            array(array(), new \StdClass, null, false),
            array(array(), new \CastableClass('foo'), 'foo', true),
            array(array('min' => 2), '1', null, false),
            array(array('min' => 2), '12', '12', true),
            array(array('min' => 2), '123', '123', true),
            array(array('max' => 2), '1', '1', true),
            array(array('max' => 2), '12', '12', true),
            array(array('max' => 2), '123', null, false),
            array(array('min' => 2, 'max' => 2), '1', null, false),
            array(array('min' => 2, 'max' => 2), '12', '12', true),
            array(array('min' => 2, 'max' => 2), '123', null, false),
        );
    }

    /**
     * @dataProvider provideTestFilter
     */
    public function testFilter($options, $raw, $filtered, $valid) {
        $int = new Alnum($options);
        $this->assertEquals($filtered, $int->filter($raw));
        $this->assertEquals($valid, $int->validate($raw));
    }

}

