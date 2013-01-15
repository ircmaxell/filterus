<?php

namespace Filterus\Filters;

class URL extends \Filterus\Filter {
    
    protected $defaultOptions = array(
        'path' => false,
        'query' => false,
    );

    public function filter($var) {
        $flags = 0;
        if ($this->options['path']) {
            $flags |= FILTER_FLAG_PATH_REQUIRED;
        }
        if ($this->options['query']) {
            $flags |= FILTER_FLAG_QUERY_REQUIRED;
        }
        return filter_var($var, FILTER_VALIDATE_URL, $flags);
    }

}