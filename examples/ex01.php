<?php

require 'vendor/autoload.php';

use Claxifieds\Cache\Object_Cache_Factory;

$cache = Object_Cache_Factory::newInstance();
var_dump($cache);