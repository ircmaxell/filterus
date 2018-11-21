<?php

namespace Filterus\Filters;

class Objects extends \Filterus\Filter {

    protected $defaultOptions = array(
        'class' => '',
    );

    public function filter($var) {
        if (!is_object($var)) {
            return null;
        }
        if ($this->options['class'] && !$var instanceof $this->options['class']) {
            return null;
        }

        return $var;
    }

    public function validate($var) {
        return $var === $this->filter($var);
    }

}
