<?php

namespace Tests;

use LaravelBridge\Zf1\App;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Zend_Application;

class TestCase extends BaseTestCase
{
    /**
     * @return Zend_Application
     */
    protected function createApplication()
    {
        $application = new App(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );

        $application->bootstrap();

        return $application;
    }
}
