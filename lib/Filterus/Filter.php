<?php

namespace Filterus;

abstract class Filter {

    protected static $filters = array(
        'alnum'  => 'Filterus\Filters\Alnum',
        'array'  => 'Filterus\Filters\Arrays',
        'bool'   => 'Filterus\Filters\Booleans',
        'email'  => 'Filterus\Filters\Email',
        'float'  => 'Filterus\Filters\Floats',
        'int'    => 'Filterus\Filters\Ints',
        'ip'     => 'Filterus\Filters\IP',
        'object' => 'Filterus\Filters\Objects',
        'raw'    => 'Filterus\Filters\Raw',
        'regex'  => 'Filterus\Filters\Regex',
        'string' => 'Filterus\Filters\Strings',
        'url'    => 'Filterus\Filters\URL',
        'uuid'   => 'Filterus\Filters\UUID',
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
            throw new \InvalidArgumentException('Invalid Filter Specified: ' . $filter);
        }
        $class = self::$filters[$filterName];
        return new $class($options);
    }

    public static function registerFilter($name, $class) {
        if (!is_subclass_of($class, __CLASS__)) {
            throw new \InvalidArgumentException("Class name must be an instance of Filter");
        }
        self::$filters[strtolower($name)] = $class;
    }


    protected $defaultOptions = array();

    protected $options = array();

    abstract public function filter($var);

    final public function __construct(array $options = array()) {
        $this->setOptions($options);
    }

    public function getOptions() {
        return $this->options;
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
        $filtered = $this->filter($var);
        return !is_null($filtered) && $filtered == $var;
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
