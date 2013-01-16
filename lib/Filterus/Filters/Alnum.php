<?php

namespace Filterus\Filters;

class Alnum extends Regex {
    
    protected $defaultOptions = array(
        'min' => 0,
        'max' => PHP_INT_MAX,
        'regex' => '/^[a-zA-Z0-9]*$/',
    );

}