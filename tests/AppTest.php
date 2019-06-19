<?php

namespace Tests;

use LaravelBridge\Zf1\App;
use PHPUnit\Framework\TestCase;
use Zend_Application;

class AppTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayWhenSimpleTest()
    {
        $target = new App('whatever');

        $this->assertInstanceOf(Zend_Application::class, $target);
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenBootstrap()
    {
        $target = new App('whatever');
        $target->bootstrap();

        $this->assertInstanceOf(Zend_Application::class, $target);
    }
}
