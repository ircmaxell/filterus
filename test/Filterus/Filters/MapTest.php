<?php

namespace Filterus\Filters;

require_once __DIR__ . '/../../Stubs/CastableClass.php';

class MapTest extends \PHPUnit_Framework_TestCase {

    public static function provideTestFilter() {
        $obj1 = new \StdClass;
        $obj1->foo = 'bar';
        $obj2 = new \StdClass;
        $obj2->foo = array('test');
        $obj3 = new \StdClass;
        $obj3->foo = '';
        return array(
            array(array(), 1, null, false),
            array(array(), '1', null, false),
            array(array(), 1.1, null, false),

            array(array(), array(), array(), true),
            array(array(), new \StdClass, new \StdClass, true),
            array(array('filters' => array('test' => 'int')), array(), array('test' => 0), false),
            array(array('filters' => array('foo' => 'string')), new \StdClass, $obj3, false),
            array(array('filters' => array('test' => 'int')), array('test' => 2), array('test' => 2), true),
            array(array('filters' => array('foo' => 'string')), $obj1, $obj1, true),
            array(array('filters' => array('foo' => 'string')), $obj2, $obj3, false),
        );
    }

    /**
     * @dataProvider provideTestFilter
     */
    public function testFilter($options, $raw, $filtered, $valid) {
        $int = new Map($options);
        $this->assertEquals($filtered, $int->filter($raw));
        $this->assertEquals($valid, $int->validate($raw));
    }

}

