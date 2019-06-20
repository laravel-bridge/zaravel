<?php

namespace Tests\Feature;

use Illuminate\Http\Request as IlluminateRequest;
use LaravelBridge\Zf1\Controller\Request;
use Tests\TestCase;
use Zend_Application;
use Zend_Controller_Response_Http;

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

    /**
     * @test
     */
    public function shouldBeOkayWhenRun()
    {
        /** @var Zend_Controller_Response_Http $actual */
        $actual = $this->createApplication()->getBootstrap()->run();

        $this->assertContains('Zend Framework!', $actual->getBody());
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenRunTestInject()
    {
        $app = $this->createApplication();

        /** @var \Zend_Controller_Front $front */
        $front = $app->getBootstrap()->getResource('FrontController');
        $front->setRequest(new Request(IlluminateRequest::create('/index/test-inject')));

        $actual = $app->getBootstrap()->run();

        $this->assertContains(IlluminateRequest::class, $actual->getBody());
    }
}
