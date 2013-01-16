<?php

namespace Filterus\Filters;

class IPTest extends \PHPUnit_Framework_TestCase {

    public static function provideTestFilter() {
        return array(
            array(array(), '192.168.0.1', '192.168.0.1', true),
            array(array(), 'test', '', false),
            array(array('ipv4' => false), '192.168.0.1', null, false),
            array(array('private' => false), '192.168.0.1', null, false),
            array(array('reserved' => false), '0.0.0.0', null, false),
        );
    }

    /**
     * @dataProvider provideTestFilter
     */
    public function testFilter($options, $raw, $filtered, $valid) {
        $int = new IP($options);
        $this->assertEquals($filtered, $int->filter($raw));
        $this->assertEquals($valid, $int->validate($raw));
    }

}