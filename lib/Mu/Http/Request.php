<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http;

use Mu\Core\Request\RequestAbstract,
    Mu\Core\Collection;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Request
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Request\RequestAbstract
 * @uses       \Mu\Core\Config\Options
 * @uses       \Mu\Core\Delegates\Delegatable
 *
 * @uses       \Mu\Core\Collection
 *
 * @uses       \Mu\Http\Header
 * @uses       \Mu\Http\Header\Collection
 * @uses       \Mu\Http\Cookie
 * @uses       \Mu\Http\Session
 *
 * @property   \Mu\Core\Collection $query
 * @property   \Mu\Core\Collection $post
 * @property   \Mu\Core\Collection $file
 * @property   \Mu\Http\Header\Collection $header
 * @property   \Mu\Http\Cookie\Jar $cookie
 * @property   \Mu\Http\Session $session
 */
class Request extends RequestAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array_merge_recursive(
            parent::_getImplements(),
            array(
                'Mu\Core\Delegates\Delegatable' => array(
                    'delegates' => array(
                        'getCookieRaw' => function() {
                            return $_COOKIE;
                        },
                        'getQueryRaw' => function() {
                            return $_GET;
                        },
                        'getPostRaw' => function() {
                            return $_POST;
                        },
                        'getFilesRaw' => function() {
                            return $_FILES;
                        },
                        'createSession' => function() {
                            $session = new Session();
                            $session->setDelegate('writeValue', function() {}); // do nothing, make read only
                            $session->setDelegate('clearValues', function() {}); // do nothing, make read only
                        },
                        'getInput' => array('\Mu\Http\Request', 'getRequestInput')
                    )
                )
            )
        );
    }

    /**
     * The query string variables
     * @var \Mu\Core\Collection
     */
    protected $_query;

    /**
     * The post variables
     * @var \Mu\Core\Collection
     */
    protected $_post;

    /**
     * The files
     * @var \Mu\Core\Collection
     */
    protected $_files;

    /**
     * The session variables
     * @var \Mu\Http\Session
     */
    protected $_session;

    /**
     * The cookie jar
     * @var \Mu\Http\Cookie\Jar
     */
    protected $_cookie;

    /**
     * The http headers
     * @var Mu\Http\Header\Collection
     */
    protected $_headers;

    /**
     * The request input
     * @var string
     */
    static protected $_input;

    /**
     * Gets a query variable
     * @param string|null $key
     * @return \Mu\Core\Collection|string|null
     */
    public function getQuery($key = null) {
        if (null === $this->_query) {
            $this->_query = new Collection($this->getQueryRaw(), array(
                'type' => 'string',
                'indexType' => Collection::INDEX_ASSOCITIVE,
                'readonly' => true
            ));
            $this->_query->setFlags(Collection::ARRAY_AS_PROPS);
        }

        if (null === $key) {
            return $this->_query;
        }

        return $this->_query->offsetExists($key) ? $this->_query[$key] : null;
    }

    /**
     * Gets a post variable
     * @param string|null $key
     * @return array|string|null
     */
    public function getPost($key = null) {
        if (null === $this->_post) {
            $this->_post = new Collection($this->getPostRaw(), array(
                'type' => 'string',
                'indexType' => Collection::INDEX_ASSOCITIVE,
                'readonly' => true
            ));
            $this->_post->setFlags(Collection::ARRAY_AS_PROPS);
        }

        if (null === $key) {
            return $this->_post;
        }

        return $this->_post->offsetExists($key) ? $this->_post[$key] : null;
    }

    /**
     * Gets a file
     * @param string|null $key
     * @return array|null
     */
    public function getFile($key = null) {
        if (null === $this->_files) {
            $this->_files = new Collection($this->getFilesRaw(), array(
                'type' => 'string',
                'indexType' => Collection::INDEX_ASSOCITIVE,
                'readonly' => true
            ));
            $this->_files->setFlags(Collection::ARRAY_AS_PROPS);
        }

        if (null === $key) {
            return $this->_files;
        }

        return $this->_files->offsetExists($key) ? $this->_files[$key] : null;
    }

    /**
     * Gets a session variable by key
     * @param string|null $key
     * @return \Mu\Http\Session|scalar
     */
    public function getSession($key = null) {
        if (null === $this->_session) {
            $this->_session = $this->createSession();
            if (!$this->_session->isStarted()) {
                $this->_session->start();
            }
        }

        if (null === $key) {
            return $this->_session;
        }

        return $this->_session->read($key);
    }

    /**
     * Gets a cookie variable by key
     * @param string|null $key
     * @return \Mu\Http\Cookie\Jar|string|null
     */
    public function getCookie($key = null) {
        if (null === $this->_cookie) {
            $this->_cookie = new Cookie\Jar(
                $this->getCookieRaw(),
                array('readonly' => true)
            );
        }

        if (null === $key) {
            return $this->_cookie;
        }

        return $this->_cookie->offsetExists($key) ? $this->_cookie[$key] : null;
    }

    /**
     * Gets the array of headers for this request
     * @param string|null $key
     * @return array|\Mu\Http\Header
     */
    public function getHeader($key = null) {
        if (null === $this->_headers) {
            $this->_headers = new Header\Collection(
                $this->getServer(),
                array('readonly' => true)
            );
        }

        if (null === $key) {
            return $this->_headers;
        }

        return $this->_headers->offsetExists($key) ? $this->_headers[$key] : null;
    }

    /**
     * Gets the request body
     * @return string
     */
    public function getBody() {
        return $this->getInput();
    }

    /**
     * Magic __get to add some accesses for request context
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        if (in_array($name, array('query', 'post', 'file', 'header', 'cookie', 'session'))) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }

        return parent::__get($name);
    }

    /**
     * Gets the request input
     * @return string
     */
    static public function getRequestInput() {
        if (null === self::$_body) {
            self:setRequestInput();
        }

        return self::$_body;
    }

    /**
     * Sets the request input
     * @param string|null $body if null then body is set from php://input
     * @return \Mu\Http\Request
     */
    static public function setRequestInput($body = null) {
        self::$_body = (null === $body) ? file_get_contents('php://input') : $body;
    }

    /**
     * Gets the scheme of the request, http or https
     * @return string
     */
    public function getScheme() {
        if ('on' === $this->getServer('HTTPS')) {
            return 'https';
        }

        return 'http';
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
     * Gets the http method
     * @return string
     */
    public function getMethod() {
        if (null !== ($header = $this->getHeader('X-Http-Method-Override'))) {
            return strtoupper($header->getValue());
        }

        if (null !== ($query = $this->getQuery('method_override'))) {
            return strtoupper($query);
        }

        return strtoupper($this->getServer('REQUEST_METHOD'));
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
     * Builds the request, used by factory
     * @return \Mu\Http\Request|null
     */
    static public function build() {
        if ('cli' !== PHP_SAPI) {
            $request = new self();

            if (('https' === $request->getScheme) && class_exists('Mu\Https\Request')) {
                return null;
            }

            return $request;
        }

        return null;
    }
}
