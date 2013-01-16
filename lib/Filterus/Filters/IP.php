<?php

namespace Filterus\Filters;

class IP extends \Filterus\Filter {
    
    protected $defaultOptions = array(
        'ipv4' => true,
        'ipv6' => true,
        'private' => true,
        'reserved' => true,
    );

    public function filter($var) {
        $flags = 0;
        if ($this->options['ipv4']) {
            $flags |= FILTER_FLAG_IPV4;
        }
        if ($this->options['ipv6']) {
            $flags |= FILTER_FLAG_IPV6;
        }
        if (!$this->options['private']) {
            $flags |= FILTER_FLAG_NO_PRIV_RANGE;
        }
        if (!$this->options['reserved']) {
            $flags |= FILTER_FLAG_NO_RES_RANGE;
        }
        return filter_var($var, FILTER_VALIDATE_IP, $flags);
    }

}