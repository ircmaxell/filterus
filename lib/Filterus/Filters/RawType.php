<?php

namespace Filterus\Filters;

class RawType extends \Filterus\Filter {

    public function filter($var) {
        return $var;
    }
}