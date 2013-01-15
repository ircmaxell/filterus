<?php

namespace Filterus\Filters;

class String extends \Filterus\Filter {
    
    protected $defaultOptions = array(
        'min' => 0,
        'max' => PHP_INT_MAX,
        'default' => '',
    );

    public function filter($var) {
        if (is_object($var) && method_exists($var, '__toString')) {
            $var = (string) $var;
        }
        if (!is_scalar($var)) {
            return $this->options['default'];
        }
        $var = (string) $var;
        if ($this->options['min'] > strlen($var)) {
            return $this->options['default'];
        } elseif ($this->options['max'] < strlen($var)) {
            return $this->options['default'];
        }
        return $var;
    }

    public function validate($var) {
        if (is_object($var) && method_exists($var, '__toString')) {
            $var = (string) $var;
        }
        return parent::validate($var);
    }
}