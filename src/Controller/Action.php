<?php

namespace LaravelBridge\Zf1\Controller;

use LaravelBridge\Support\Traits\ContainerAwareTrait;
use Zend_Controller_Action as ZendAction;
use Zend_Controller_Request_Abstract;
use Zend_Controller_Response_Abstract;

class Action extends ZendAction
{
    use ContainerAwareTrait;

    public function __construct(
        Zend_Controller_Request_Abstract $request,
        Zend_Controller_Response_Abstract $response,
        array $invokeArgs = array()
    ) {
        parent::__construct($request, $response, $invokeArgs);

        /** @var Bootstrap $bootstrap */
        $bootstrap = $this->getInvokeArg('bootstrap');

        $this->setContainer($bootstrap->getContainer());
    }

    /**
     * Adjust call action behavior
     *
     * @param string $action
     * @throws \Zend_Controller_Action_Exception
     * @see ZendAction::dispatch()
     */
    public function dispatch($action)
    {
        $this->_helper->notifyPreDispatch();

        $this->preDispatch();
        if ($this->getRequest()->isDispatched()) {
            if (null === $this->_classMethods) {
                $this->_classMethods = get_class_methods($this);
            }

            if (!$this->getResponse()->isRedirect()) {
                if ($this->getInvokeArg('useCaseSensitiveActions') || in_array($action, $this->_classMethods, true)) {
                    if ($this->getInvokeArg('useCaseSensitiveActions')) {
                        $message = 'Using case sensitive actions without word separators is deprecated; ';
                        $message .= 'please do not rely on this "feature"';

                        trigger_error($message);
                    }

                    // Use the Container::call() to do auto inject
                    $this->container->call([$this, $action]);
                } else {
                    $this->__call($action, array());
                }
            }
            $this->postDispatch();
        }

        $this->_helper->notifyPostDispatch();
    }
}
