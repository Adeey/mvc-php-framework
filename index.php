<?php

define('BASE_PATH', realpath(dirname(__FILE__)));

include_once 'system\autoloader.php';
include_once 'system\functions.php';

use System\Autoload;
use System\Config\ApplicationConfig;

Autoload::init();

if (ApplicationConfig::APPLICATION_TYPE === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

if (ApplicationConfig::APPLICATION_TYPE === 'production') {
    error_reporting(0);
    ini_set('display_errors', 0);
}

include_once 'system/core/Framework.php';