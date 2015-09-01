<?php

namespace Filterus\Filters;

require_once __DIR__ . '/../../Stubs/CastableClass.php';

class StringTest extends \PHPUnit_Framework_TestCase {

    public static function provideTestFilter() {
        return array(
            array(array(), 1, '1', true),
            array(array(), '1', '1', true),
            array(array(), 1.1, '1.1', true),
            array(array(), array(), '', false),
            array(array(), new \StdClass, '', false),
            array(array(), new \CastableClass('foo'), 'foo', true),
            array(array('min' => 2), '1', '', false),
            array(array('min' => 2), '12', '12', true),
            array(array('min' => 2), '123', '123', true),
            array(array('max' => 2), '1', '1', true),
            array(array('max' => 2), '12', '12', true),
            array(array('max' => 2), '123', '', false),
            array(array('min' => 2, 'max' => 2), '1', '', false),
            array(array('min' => 2, 'max' => 2), '12', '12', true),
            array(array('min' => 2, 'max' => 2), '123', '', false),
        );
    }

    /**
     * @dataProvider provideTestFilter
     */
    public function testFilter($options, $raw, $filtered, $valid) {
        $int = new StringType($options);
        $this->assertEquals($filtered, $int->filter($raw));
        $this->assertEquals($valid, $int->validate($raw));
    }

}

