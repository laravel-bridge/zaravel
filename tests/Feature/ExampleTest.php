<?php

namespace Tests\Feature;

use Tests\TestCase;
use Zend_Application;

class ExampleTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayWhenSimpleTest()
    {
        $target = $this->createApplication();

        $this->assertInstanceOf(Zend_Application::class, $target);
    }
}
