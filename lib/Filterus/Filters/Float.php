<?php

namespace Filterus\Filters;

class Float extends \Filterus\Filter {
    
    protected $defaultOptions = array(
        'min' => null,
        'max' => null,
        'default' => 0.0,
    );

    public function filter($var) {
        if (!is_numeric($var)) {
            return $this->options['default'];
        }
        $var = (float) $var;
        if (null !== $this->options['min'] && $this->options['min'] > $var) {
            return $this->options['min'];
        } elseif (null !== $this->options['max'] && $this->options['max'] < $var) {
            return $this->options['max'];
        }
        return $var;
    }

    public function validate($var) {
        if (!is_numeric($var)) {
            return false;
        }
        return parent::validate($var);
    }
}