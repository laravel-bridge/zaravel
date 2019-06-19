<?php

namespace Tests\Unit;

use LaravelBridge\Zf1\App;
use Tests\TestCase;
use Zend_Application;

class AppTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayWhenSimpleTest()
    {
        $target = new App(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );

        $target->bootstrap();

        $this->assertInstanceOf(Zend_Application::class, $target);
    }
}
