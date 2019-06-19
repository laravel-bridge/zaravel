<?php

include_once __DIR__ . '/../vendor/autoload.php';

// Define path to application directory
define('APPLICATION_PATH', dirname(__DIR__) . '/example/application');

// Define application environment
define('APPLICATION_ENV', 'testing');

Zend_Loader_Autoloader::getInstance();
