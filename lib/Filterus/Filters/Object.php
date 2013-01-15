<?php

namespace Filterus\Filters;

class Object extends \Filterus\Filter {
    
    protected $defaultOptions = array(
        'class' => '',
        'default' => null,
        'defaultFactory' => null,
    );

    public function filter($var) {
        if (!is_object($var)) {
            return $this->getDefault();
        }
        if ($this->options['class'] && !$var instanceof $this->options['class']) {
            return $this->getDefault();
        }

        return $var;
    }

    protected function getDefault() {
        if ($this->options['defaultFactory']) {
            $factory = $this->options['defaultFactory'];
            return $factory();
        }
        return $this->options['default'];
    }
}