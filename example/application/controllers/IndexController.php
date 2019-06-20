<?php

use Illuminate\Http\Request;
use LaravelBridge\Zf1\Controller\Action;

class IndexController extends Action
{
    public function indexAction()
    {
    }

    public function testInjectAction(Request $request)
    {
        // No view
        $this->_helper->viewRenderer->setNoRender(true);

        $this->_response->setBody(get_class($request));
    }
}
