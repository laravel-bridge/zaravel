<?php

namespace Tests\Unit\Controller;

use Illuminate\Http\Request as IlluminateRequest;
use LaravelBridge\Zf1\Controller\Request;
use Tests\TestCase;

class RequestTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeOkayWhenCreateSimpleRequest()
    {
        $target = new Request(IlluminateRequest::create('http://laravel.com/zend'));

        $this->assertInstanceOf(Request::class, $target);
        $this->assertSame('http', $target->getScheme());
        $this->assertSame('laravel.com', $target->getHttpHost());
        $this->assertSame('/zend', $target->getPathInfo());
        $this->assertSame('/zend', $target->getRequestUri());
        $this->assertSame([], $target->getQuery());
        $this->assertSame([], $target->getPost());
        $this->assertSame([], $target->getCookie());
        $this->assertSame('127.0.0.1', $target->getServer('REMOTE_ADDR'));
        $this->assertSame('127.0.0.1', $target->getClientIp());
        $this->assertSame('GET', $target->getMethod());
        $this->assertFalse($target->isSecure());
        $this->assertFalse($target->isXmlHttpRequest());
    }
}
