<?php

namespace Filterus\Filters;

class Booleans extends \Filterus\Filter {
    
    protected $defaultOptions = array(
        'default' => null,
    );

    public function filter($var) {
        return filter_var($var, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }

    public function validate($var) {
        return $this->filter($var) !== null;
    }
}