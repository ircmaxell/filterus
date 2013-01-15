<?php

namespace Filterus\Filters;

class RawTest extends \PHPUnit_Framework_TestCase {

    public static function provideTestFilter() {
        return array(
            array(1),
            array(array('foo')),
            array("bar"),
        );
    }

    /**
     * @dataProvider provideTestFilter
     */
    public function testFilter($raw) {
        $int = new Raw(array());
        $this->assertEquals($raw, $int->filter($raw));
        $this->assertEquals(true, $int->validate($raw));
    }

}