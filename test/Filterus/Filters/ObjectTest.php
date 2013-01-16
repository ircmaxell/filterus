<?php

namespace Filterus\Filters;

require_once __DIR__ . '/../../Stubs/CastableClass.php';

class ObjectTest extends \PHPUnit_Framework_TestCase {

    public static function provideTestFilter() {
        return array(
            array(array(), 1, null, false),
            array(array(), '1', null, false),
            array(array(), 1.1, null, false),
            array(array(), array(), null, false),
            array(array(), new \StdClass, new \StdClass, true),
            array(array(), new \CastableClass('foo'), new \CastableClass('foo'), true),
            array(array('class' => 'StdClass'), new \CastableClass('foo'), null, false),
        );
    }

    /**
     * @dataProvider provideTestFilter
     */
    public function testFilter($options, $raw, $filtered, $valid) {
        $int = new Object($options);
        $this->assertEquals($filtered, $int->filter($raw));
        $this->assertEquals($valid, $int->validate($raw));
    }

}

