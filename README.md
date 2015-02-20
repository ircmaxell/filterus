Filterus - A flexible PHP 5.3 filter package
============================================

## Filter Methods:

Each filter class has two primary methods:

* `$filter->filter($var)` - returns a modified version of `$var` filtered to the options. If it cannot be safely modified, a default value will be returned.
* `$filter->validate($var)` - Returns a boolean identifying if the value is valid.

## Simple Filters (with options):

* `alnum` - Alpha numeric
    * `min` - 0 - Minimum length
    * `max` - PHP_INT_MAX - Maximum length
    * `default` - `''` - Default return value
* `array` - Array matching
    * `min` - 0 - Minimum size
    * `maximum` - PHP_INT_MAX - Maxim size
    * `keys` - `null` - Filter to run on the keys
    * `values` - `null` - Filter to run on the values
    * `default` - `array()` - Default return value
* `bool` - Boolean matching
    * `default` - `null` - Default return value
* `email` - Matches emails
* `float` - Floating point numbers
    * `min` - `null` - Minimum length
    * `max` - `null` - Maximum length
    * `default` - 0.0 - Default return value
* `int` - Integers numbers
    * `min` - `null` - Minimum length
    * `max` - `null` - Maximum length
    * `default` - 0 - Default return value
* `ip` - Matches IP addresses
    * `ipv4` - `true` - Boolean to match IPv4 addresses
    * `ipv6` - `true` - Boolean to match IPv6 addresses
    * `private` - `true` - Include private addresses?
    * `reserved` - `true` - Include reserved addresses?
* `object` - Objects
    * `class` - `''` - Required class or interface name
    * `default` - `null` - The default value
    * `defaultFactory` - `null` - A callback to instantiate a return value
* `raw` - Returns whatever is passed in
* `regex` - Matches strings via a regex
    * `min` - 0 - Minimum length
    * `max` - PHP_INT_MAX - Maximum length
    * `default` - `''` - Default return value
    * `regex` - `/.?/` - The regex to run
* `string` - Matches strings
    * `min` - 0 - Minimum length
    * `max` - PHP_INT_MAX - Maximum length
    * `default` - `''` - Default return value
* `url` - Matches URLs
    * `path` - `false` - Force a path to be present
    * `query` - `false` - Force a query string to be present

## Complex Filters

* `Filter::map(array())` - "maps" several filters over key-value pairs. Useful for filtering associative arrays or stdclass objects.
* `Filter::chain($filter1, $filter2...)` - Chains multiple filters together to run on the same value (similar to `AND` joining filters).
* `Filter::pool($filter1, $filter2...)` - Runs the same value through multiple filters using the first valid return (similar to `OR` joining filters)

## Usage:

Simple filters can be specified using a comma-separated-value list. So a filter specifying a string with minimum length of 5 could be represented as:

``` php
$filter = Filter::factory('string,min:5');
```

Or

``` php
$filter = new Filters\String(array('min' => 5));
```

If you pass a filter to `Filter::factory()`, it will be returned unmodified. So you can write functions like:

``` php
function foo($bar, $filter) {
    // do something with $bar and set in $baz
    return Filter::factory($filter)->filter($baz);
}
```

Complex chaining can also be supported. So if you wanted to check if an array with a minimum size of 4, with numeric keys and containing strings of minimum length 5, that could be built like so:

``` php
$filter = Filter::array('min:4', 'int', 'string,min:5');
```

If we wanted to validate an associative array, we would use a "map" filter:

``` php
$array = array(
    'foo' => 2,
    'bar' => 'test',
);

$filter = Filter::map(array(
    'foo' => 'int',
    'bar' => 'string,min:4',
));

var_dump($filter->validate($array)); // true
```

## Procedural Interface

Filterus also ships with a procedural interface for calling filters.

``` php
\Filterus\filter($var, $filter);
```

And

``` php
\Filterus\validate($var, $filter);
```

Any filter is supported (both are basically simple wrappers):

``` php
function \Filterus\filter($var, $filter) {
    return \Filterus\Filter::factory($filter)->filter($var);
}
```

Both are just convenience functions.


Security Vulnerabilities
========================

If you have found a security issue, please contact the author directly at [me@ircmaxell.com](mailto:me@ircmaxell.com).
