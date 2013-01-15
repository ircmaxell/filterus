<?php

namespace Filterus\Filters;

class Raw extends \Filterus\Filter {
    
    public function filter($var) {
        return $var;
    }
}