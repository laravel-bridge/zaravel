<?php

namespace LaravelBridge\Zf1\Controller;

use Illuminate\Http\Request as IlluminateRequest;
use Illuminate\Support\Traits\Macroable;
use Zend_Controller_Exception as ZendException;
use Zend_Controller_Request_Exception as ZendRequestException;
use Zend_Controller_Request_Http as ZendRequest;

/**
 * Overwrite Zend Request to adapter to Illuminate Request
 */
class Request extends ZendRequest
{
    use Macroable;

    /**
     * @var IlluminateRequest
     */
    private $illuminateRequest;

    /**
     * Request constructor.
     * @param IlluminateRequest|null $illuminateRequest
     * @throws ZendRequestException
     */
    public function __construct(IlluminateRequest $illuminateRequest = null)
    {
        if ($illuminateRequest === null) {
            $illuminateRequest = IlluminateRequest::capture();
        }

        $this->illuminateRequest = $illuminateRequest;

        parent::__construct($illuminateRequest->getUri());
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::$query
     * @see IlluminateRequest::$request
     * @see IlluminateRequest::$cookies
     * @see IlluminateRequest::$server
     */
    public function __get($key)
    {
        switch (true) {
            case isset($this->_params[$key]):
                return $this->_params[$key];
            case $this->illuminateRequest->query->has($key):
                return $this->illuminateRequest->query->get($key);
            case $this->illuminateRequest->request->has($key):
                return $this->illuminateRequest->request->get($key);
            case $this->illuminateRequest->cookies->has($key):
                return $this->illuminateRequest->cookies->get($key);
            case ($key == 'REQUEST_URI'):
                return $this->getRequestUri();
            case ($key == 'PATH_INFO'):
                return $this->getPathInfo();
            case $this->illuminateRequest->server->has($key):
                return $this->illuminateRequest->server->get($key);
            case isset($_ENV[$key]):
                return $_ENV[$key];
            default:
                return null;
        }
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::$query
     * @see IlluminateRequest::$request
     * @see IlluminateRequest::$cookies
     * @see IlluminateRequest::$server
     */
    public function __isset($key)
    {
        switch (true) {
            case isset($this->_params[$key]):
                return true;
            case $this->illuminateRequest->query->has($key):
                return true;
            case $this->illuminateRequest->request->has($key):
                return true;
            case $this->illuminateRequest->cookies->has($key):
                return true;
            case $this->illuminateRequest->server->has($key):
                return true;
            case isset($_ENV[$key]):
                return true;
            default:
                return false;
        }
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::$query
     */
    public function setQuery($spec, $value = null)
    {
        if ((null === $value) && !is_array($spec)) {
            require_once 'Zend/Controller/Exception.php';
            $message = 'Invalid value passed to setQuery(); must be either array of values or key/value pair';
            throw new ZendException($message);
        }

        if ((null === $value) && is_array($spec)) {
            foreach ($spec as $key => $value) {
                $this->setQuery($key, $value);
            }
            return $this;
        }

        $this->illuminateRequest->query->set((string)$spec, $value);

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::query()
     */
    public function getQuery($key = null, $default = null)
    {
        return $this->illuminateRequest->query($key, $default);
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::$request
     */
    public function setPost($spec, $value = null)
    {
        if ((null === $value) && !is_array($spec)) {
            require_once 'Zend/Controller/Exception.php';
            $message = 'Invalid value passed to setPost(); must be either array of values or key/value pair';
            throw new ZendException($message);
        }

        if ((null === $value) && is_array($spec)) {
            foreach ($spec as $key => $value) {
                $this->setPost($key, $value);
            }
            return $this;
        }

        $this->illuminateRequest->request->set((string)$spec, $value);

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * Use IlluminateRequest::$request for downward compatibility for Laravel 5.4
     *
     * @see IlluminateRequest::$request
     */
    public function getPost($key = null, $default = null)
    {
        if ($key === null) {
            return $this->illuminateRequest->request->all();
        }

        return $this->illuminateRequest->request->get($key, $default);
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::cookie()
     */
    public function getCookie($key = null, $default = null)
    {
        return $this->illuminateRequest->cookie($key, $default);
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::server()
     */
    public function getServer($key = null, $default = null)
    {
        return $this->illuminateRequest->server($key, $default);
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::getRequestUri()
     */
    public function setRequestUri($requestUri = null)
    {
        if ($requestUri === null) {
            $requestUri = $this->illuminateRequest->getRequestUri();
        }

        $this->_requestUri = $requestUri;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::getBaseUrl()
     */
    public function setBaseUrl($baseUrl = null)
    {
        if ((null !== $baseUrl) && !is_string($baseUrl)) {
            return $this;
        }

        if ($baseUrl === null) {
            $baseUrl = $this->illuminateRequest->getBaseUrl();
        }

        $this->_baseUrl = rtrim($baseUrl, '/');

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::getBasePath()
     */
    public function setBasePath($basePath = null)
    {
        if ($basePath === null) {
            $basePath = $this->illuminateRequest->getBasePath();
        }

        if (strpos(PHP_OS, 'WIN') === 0) {
            $basePath = str_replace('\\', '/', $basePath);
        }

        $this->_basePath = rtrim($basePath, '/');
        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::getPathInfo()
     */
    public function setPathInfo($pathInfo = null)
    {
        if ($pathInfo === null) {
            $pathInfo = $this->illuminateRequest->getPathInfo();
        }

        $this->_pathInfo = (string)$pathInfo;
        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::$query
     * @see IlluminateRequest::$request
     */
    public function getParam($key, $default = null)
    {
        $keyName = (null !== ($alias = $this->getAlias($key))) ? $alias : $key;

        $paramSources = $this->getParamSources();
        if (isset($this->_params[$keyName])) {
            return $this->_params[$keyName];
        } elseif (in_array('_GET', $paramSources, true) && $this->illuminateRequest->query->has($keyName)) {
            return $this->getQuery($keyName);
        } elseif (in_array('_POST', $paramSources, true) && $this->illuminateRequest->request->has($keyName)) {
            return $this->getPost($keyName);
        }

        return $default;
    }

    /**
     * {@inheritDoc}
     */
    public function getParams()
    {
        $return = $this->_params;
        $paramSources = $this->getParamSources();

        if (in_array('_GET', $paramSources, true)) {
            $return += $this->getQuery();
        }

        if (in_array('_POST', $paramSources, true)) {
            $return += $this->getPost();
        }

        return $return;
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::getMethod()
     */
    public function getMethod()
    {
        return $this->illuminateRequest->getMethod();
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::isXmlHttpRequest()
     */
    public function isXmlHttpRequest()
    {
        return $this->illuminateRequest->isXmlHttpRequest();
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::isSecure()
     */
    public function isSecure()
    {
        return $this->illuminateRequest->isSecure();
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::getContent()
     */
    public function getRawBody()
    {
        return $this->illuminateRequest->getContent();
    }

    /**
     * {@inheritDoc}
     *
     * Adjust the return type
     *
     * @return string|array|null
     * @see IlluminateRequest::header()
     */
    public function getHeader($header)
    {
        return $this->illuminateRequest->header($header);
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::getScheme()
     */
    public function getScheme()
    {
        return $this->illuminateRequest->getScheme();
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::getHttpHost()
     */
    public function getHttpHost()
    {
        return $this->illuminateRequest->getHttpHost();
    }

    /**
     * {@inheritDoc}
     *
     * @see IlluminateRequest::ip()
     */
    public function getClientIp($checkProxy = true)
    {
        return $this->illuminateRequest->ip();
    }
}
