<?php

namespace Tests;

use LaravelBridge\Zf1\Application;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Zend_Application;

class TestCase extends BaseTestCase
{
    /**
     * @return Zend_Application
     */
    protected function createApplication()
    {
        $application = new Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );

        $application->bootstrap();

        return $application;
    }
}
