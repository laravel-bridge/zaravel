<?php

namespace LaravelBridge\Zf1;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerContract;
use LaravelBridge\Support\Traits\ContainerAwareTrait;
use Zend_Application;
use Zend_Application_Exception;

class Application extends Zend_Application
{
    use ContainerAwareTrait;

    /**
     * {@inheritDoc}
     *
     * Add Container parameter
     *
     * @param ContainerContract $container
     * @throws Zend_Application_Exception
     */
    public function __construct($environment, $options = null, $suppressNotFoundWarnings = null, $container = null)
    {
        if (null === $container) {
            $container = new Container();
        }

        $this->setContainer($container);

        parent::__construct($environment, $options, $suppressNotFoundWarnings);
    }

    /**
     * {@inheritDoc}
     *
     * Inject Illuminate Container into bootstrapper
     */
    public function setBootstrap($path, $class = null)
    {
        parent::setBootstrap($path, $class);

        $this->getBootstrap()->setContainer($this->container);

        return $this;
    }
}
