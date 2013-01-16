<?php

namespace Filterus\Filters;

class URLTest extends \PHPUnit_Framework_TestCase {

    public static function provideTestFilter() {
        return array(
            array(array(), 'http://www.foo.bar', 'http://www.foo.bar', true),
            array(array(), 'test', '', false),
            array(array('path' => true), 'http://www.foo.bar', null, false),
            array(array('path' => true), 'http://www.foo.bar/', 'http://www.foo.bar/', true),
            array(array('query' => true), 'http://www.foo.bar/', null, false),
            array(array('query' => true), 'http://www.foo.bar/?1', 'http://www.foo.bar/?1', true),
        );
    }

    /**
     * @dataProvider provideTestFilter
     */
    public function testFilter($options, $raw, $filtered, $valid) {
        $int = new URL($options);
        $this->assertEquals($filtered, $int->filter($raw));
        $this->assertEquals($valid, $int->validate($raw));
    }

}