<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://Nimbles-framework.com/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */
namespace Nimbles\App\Request;

use Nimbles\Service,
    Nimbles\Core\Collection;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 * 
 * @uses       \Nimbles\App\Request\RequestAbstract
 * 
 * @uses       \Nimbles\Service\Request\Http
 * @uses       \Nimbles\Service\Http\Parameters
 * @uses       \Nimbles\Service\Http\Header
 * @uses       \Nimbles\Service\Http\Header\Collection
 * 
 * @uses       \Nimbles\Core\Collection
 */
class Http extends RequestAbstract {
    /**
     * Internal http request
     * @var \Nimbles\Service\Request\Http
     */
    protected $_http;
    
    /**
     * The request path that should be routed
     * @var string
     */
    protected $_path;
    
    /**
     * The server variables
     * @var \Nimbles\Service\Http\Parameters
     */
    protected $_server;
    
    /**
     * Class construct
     * @return void
     */
    public function __construct() {}
    
    /**
     * Gets a query parameter by key
     * @param string|null $key If null all parameters are returned
     * @return \Nimbles\Service\Http\Parameters|string|null
     */
    public function getQuery($key = null) {
        return $this->_getHttp()->getQuery($key);
    }
    
    /**
     * Gets a post parameter by key
     * @param string|null $key If null all parameters are returned
     * @return \Nimbles\Service\Http\Parameters|string|null
     */
    public function getPost($key = null) {
        return $this->_getHttp()->getPost($key);
    }
    
    /**
     * Gets a header by its name
     * @param string|null $name If NULL then the collection is returned
     * @return \Nimbles\Service\Http\Header|\Nimbles\Service\Http\Header\Collection|null
     */
    public function getHeader($name = null) {
        return $this->_getHttp()->getHeader($name);
    }
    
    /**
     * Gets a server parameter by key
     * @param string|null $key If null all parameters are returned
     * @return \Nimbles\Service\Http\Parameters|string|null
     */
    public function getServer($key = null) {
        if (null === $this->_server) {
            $this->_server = new Parameters();
        }
        
        if (null === $key) {
            return $this->_server;
        }
        
        return $this->_server->offsetExists($key) ? $this->_server[$key] : null;
    }
    
    /**
     * Gets the request method
     * @return string
     */
    public function getMethod() {
        if (null !== ($header = $this->getHeader('X-Http-Method-Override'))) {
            return strtoupper((string) $header->getValue());
        }

        if (null !== ($query = $this->getQuery('method_override'))) {
            return strtoupper($query);
        }

        return strtoupper($this->getServer('REQUEST_METHOD'));
    }
    
	/**
     * Gets the hostname
     * @return string
     */
    public function getHost() {
        return $this->getServer('SERVER_NAME');
    }

    /**
     * Gets the port
     * @return int
     */
    public function getPort() {
        return intval($this->getServer('SERVER_PORT'));
    }

    /**
     * Gets the request uri
     * @return string
     * @todo check against different OS/WebServer/PHP Installation combinations
     */
    public function getRequestUri() {
        if (null !== ($requestUri = $this->getServer('HTTP_X_REWRITE_URL'))) {
            return $requestUri;
        }

        return $this->getServer('REQUEST_URI');
    }
    
    /**
     * Gets the request path
     * @return string
     */
    public function getRequestPath() {
        if (null === $this->_path) {
            $this->_path = parse_url($this->getRequestUri(), PHP_URL_PATH);
        }
        
        return $this->_path;
    }
    
	/**
     * Indicates that the http request is a GET request
     * @return bool
     */
    public function isGet() {
        return 'GET' === $this->getMethod();
    }

    /**
     * Indicates that the http request is a POST request
     * @return bool
     */
    public function isPost() {
        return 'POST' === $this->getMethod();
    }

    /**
     * Indicates that the http request is a PUT request
     * @return bool
     */
    public function isPut() {
        return 'PUT' === $this->getMethod();
    }

    /**
     * Indicates that the http request is a DELETE request
     * @return bool
     */
    public function isDelete() {
        return 'DELETE' === $this->getMethod();
    }

    /**
     * Indicates that the http request is a OPTIONS request
     * @return bool
     */
    public function isOptions() {
        return 'OPTIONS' === $this->getMethod();
    }
    
    /**
     * Sets the server parameters
     * @param \Nimbles\Core\Collection $server
     */
    protected function _setServer(Collection $server) {
        $this->_server = $server;
        return $this;
    }
    
    /**
     * Gets the internal http request
     * @return \Nimbles\Service\Request\Http
     */
    protected function _getHttp() {
        if (null === $this->_http) {
            $this->_http = new Service\Request\Http();
        }
        
        return $this->_http;
    }
    
    /**
     * Builds a request object from super globals
     * @return Nimbles\App\Request\Http
     */
    public static function build() {
        $http = new static();
        
        // create the header objects here so that the name is normalised
        $headers = array();        
        foreach ($_SERVER as $key => $value) {
            if (0 === strpos($key, 'HTTP_')) {
                $header = new Service\Http\Header(
                    explode(',', $value),
                    array('name' => substr($key, 5))
                );
                
                $headers[$header->getName()] = $header;
            }
        }
        
        // set the server variables and then the internal http request
        $http->_setServer(new Collection(
            $_SERVER,
            array(
                'type'      => 'scalar',
                'indexType' => Collection::INDEX_ASSOCIATIVE,
            	'readonly'  => true
            )
        ))->_getHttp()
            ->setQuery(new Service\Http\Parameters(
                $_GET,
                array('readonly' => true)
            ))
            ->setPost(new Service\Http\Parameters(
                $_POST,
                array('readonly' => true)
            ))
            ->setHeader(new Service\Http\Header\Collection(
                $headers,
                array('readyonly' => true)
            ));
                        
        return $http;
    }
}