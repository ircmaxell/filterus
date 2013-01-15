<?php

require 'vendor/autoload.php';

use Filterus\Filter;

$filter = Filter::map(array('foo' => 'string,min:4,default:test'));
$tmp = array('foo' => 'bar');

var_dump(Filter::factory($filter)->filter($tmp));

//var_dump(Filter::factory($argv[1])->validate($argv[2]));