<?php

namespace Filterus;

abstract class Filter {

    protected static $filters = array(
        'alnum'  => 'Filterus\Filters\Alnum',
        'array'  => 'Filterus\Filters\Arrays',
        'bool'   => 'Filterus\Filters\Boolean',
        'email'  => 'Filterus\Filters\Email',
        'float'  => 'Filterus\Filters\Float',
        'int'    => 'Filterus\Filters\Int',
        'ip'     => 'Filterus\Filters\IP',
        'object' => 'Filterus\Filters\Object',
        'raw'    => 'Filterus\Filters\Raw',
        'regex'  => 'Filterus\Filters\Regex',
        'string' => 'Filterus\Filters\String',
        'url'    => 'Filterus\Filters\URL',
    );

    public static function arrays($filter = '', $keys = '', $values = '') {
        list(, $options) = static::parseFilter('array,' . $filter);
        if ($keys) {
            $options['keys'] = $keys;
        }
        if ($values) {
            $options['values'] = $values;
        }
        return new Filters\Arrays($options);
    }

    public static function map($filters) {
        return new Filters\Map(array('filters' => $filters));
    }

    public static function chain() {
        $filters = func_get_args();
        return new Filters\Chain(array('filters' => $filters));
    }

    public static function pool() {
        $filters = func_get_args();
        return new Filters\Pool(array('filters' => $filters));
    }

    public static function factory($filter) {
        if ($filter instanceof self) {
            return $filter;
        } 
        list ($filterName, $options) = static::parseFilter($filter);
        if (!isset(self::$filters[$filterName])) {
            throw new \RuntimeException('Invalid Filter Specified: ' . $filter);
        }
        $class = self::$filters[$filterName];
        return new $class($options);
    }
    
    public static function registerFilter($name, $class) {
        if (!$class instanceof self) {
            throw new \InvalidArgumentException("Class name must be an instance of Filter");
        }
        $this->filters[strtolower($name)] = $class;
    }
    

    protected $defaultOptions = array();

    protected $options = array();

    abstract public function filter($var);

    final public function __construct(array $options = array()) {
        $this->setOptions($options);
    }

    public function setOption($key, $value) {
        $this->options[$key] = $value;
        return $this;
    }

    public function setOptions(array $options) {
        $this->options = $options + $this->defaultOptions;
        return $this;
    }

    public function validate($var) {
        return $var == $this->filter($var);
    }

    protected static function parseFilter($filter) {
        $parts = explode(',', $filter);
        $filterName = strtolower(array_shift($parts));
        $options = array();
        foreach ($parts as $part) {
            $part = trim($part);
            if (empty($part)) {
                continue;
            }
            list ($name, $value) = explode(':', $part, 2);
            $options[$name] = $value;
        }
        return array($filterName, $options);
    }
}