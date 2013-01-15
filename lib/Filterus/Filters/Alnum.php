<?php

namespace Filterus\Filters;

class Alnum extends Regex {
    
    protected $defaultOptions = array(
        'min' => 0,
        'max' => PHP_INT_MAX,
        'default' => '',
        'regex' => '/^[a-zA-Z0-9]*$/',
    );

}