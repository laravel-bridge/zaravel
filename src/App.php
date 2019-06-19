<?php

namespace LaravelBridge\Zf1;

use LaravelBridge\Support\Traits\ContainerAwareTrait;
use Zend_Application;

class App extends Zend_Application
{
    use ContainerAwareTrait;
}
