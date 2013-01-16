<?php

namespace Filterus\Filters;

class Regex extends String {
    
    protected $defaultOptions = array(
        'min' => 0,
        'max' => PHP_INT_MAX,
        'regex' => '/.?/',
    );

    public function filter($var) {
        $var = parent::filter($var);
        if (!preg_match($this->options['regex'], $var)) {
            return null;
        }
        return $var;
    }

}