<?php

namespace LaravelBridge\Zf1\Controller;

use Illuminate\Container\Container;
use LaravelBridge\Support\Traits\ContainerAwareTrait;
use Zend_Application_Bootstrap_Bootstrap as ZendBootstrap;

class Bootstrap extends ZendBootstrap
{
    use ContainerAwareTrait;

    /**
     * Like has() defined in PSR-11
     *
     * @return bool
     * @see Container::bound()
     */
    public function hasResource($name)
    {
        // Use strtolower() to compatibility for Zend Framework
        $resourceName = strtolower($name);

        return $this->container->bound($resourceName);
    }

    /**
     * Like get() defined in PSR-11
     *
     * @return bool
     * @see Container::make()
     */
    public function getResource($name)
    {
        // Use strtolower() to compatibility for Zend Framework
        $resourceName = strtolower($name);

        return $this->container->make($resourceName);
    }
}
