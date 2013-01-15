<?php

namespace Filterus\Filters;

class Email extends \Filterus\Filter {
    
    public function filter($var) {
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

}