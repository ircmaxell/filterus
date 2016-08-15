<?php

namespace Filterus\Filters;

class UUID extends Regex {
    
    protected $defaultOptions = array(
        'min' => 36,
        'max' => 36,
        'regex' => '/^[a-f0-9]{8}(-[a-f0-9]{4}){3}-[a-f0-9]{12}$/',
    );

}
