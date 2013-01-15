<?php

class CastableClass {
    public $string = '';
    public function __toString() {
        return $this->string;
    }
    public function __construct($string) {
        $this->string = $string;
    }
}