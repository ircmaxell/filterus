<?php

namespace Filterus\Filters;

class Arrays extends \Filterus\Filter {
    
    protected $defaultOptions = array(
        'min' => 0,
        'max' => PHP_INT_MAX,
        'keys' => null,
        'values' => null,
    );

    public function filter($var) {
        if (!is_array($var)) {
            return null;
        }
        $count = count($var);
        if ($this->options['min'] > $count) {
            return null;
        } elseif ($this->options['max'] < $count) {
            return null;
        }
        if ($this->options['keys']) {
            $filter = self::factory($this->options['keys']);
            foreach ($var as $key => $value) {
                if (!$filter->validate($key)) {
                    unset($var[$key]);
                }
            }
        }
        if ($this->options['values']) {
            $filter = self::factory($this->options['values']);
            foreach ($var as $key => $value) {
                if (!$filter->validate($value)) {
                    unset($var[$key]);
                }
            }
        }

        return $var;
    }

    public function validate($var) {
        if (!is_array($var)) {
            return false;
        }
        return parent::validate($var);
    }
}