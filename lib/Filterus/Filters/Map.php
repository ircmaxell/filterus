<?php

namespace Filterus\Filters;

class Map extends \Filterus\Filter {
    
    protected $defaultOptions = array(
        'filters' => array(),
        'default' => null,
    );

    public function filter($var) {
        if (!is_object($var) && !is_array($var)) {
            return $this->getDefault();
        }
        $isArray = is_array($var) || $var instanceof ArrayAccess;

        foreach ($this->options['filters'] as $key => $filter) {
            $filter = self::factory($filter);
            if ($isArray) {
                if (!isset($var[$key])) {
                    $var[$key] = null;
                }
                $var[$key] = $filter->filter($var[$key]);
            } else {
                if (!isset($var->$key)) {
                    $var->$key = null;
                }
                $var->$key = $filter->filter($var->$key);
            }
        }

        return $var;
    }

    public function validate($var) {
        if (!is_object($var) && !is_array($var)) {
            return false;
        }
        if (is_object($var)) {
            return $var == $this->filter(clone $var);
        }
        return $var == $this->filter($var);
    }

}