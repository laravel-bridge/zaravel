<?php

namespace Tests\Unit;

use LaravelBridge\Zf1\Application;
use Tests\TestCase;
use Zend_Application;

class ApplicationTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayWhenSimpleTest()
    {
        $target = new Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );

        $target->bootstrap();

        $this->assertInstanceOf(Zend_Application::class, $target);
    }
}
