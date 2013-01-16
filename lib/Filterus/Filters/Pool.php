<?php

namespace Filterus\Filters;

class Pool extends \Filterus\Filter {
    
    protected $defaultOptions = array(
        'filters' => array(),
    );

    public function filter($var) {
        foreach ($this->options['filters'] as $filter) {
            $filter = self::factory($filter);
            if ($filter->validate($var)) {
                return $filter->filter($var);
            }
        }
        return null;
    }

    public function validate($var) {
        foreach ($this->options['filters'] as $filter) {
            $filter = self::factory($filter);
            if ($filter->validate($var)) {
                return true;
            }
        }
        return false;
    }

}