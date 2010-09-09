<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http;

use Mu\Core\Response\ResponseAbstract,
    Mu\Http\Status,
    Mu\Http\Cookie;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Response
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Response\ResponseAbstract
 * @uses       \Mu\Core\Delegates\Delegatable
 * @uses       \Mu\Core\Config\Options
 *
 * @uses       \Mu\Http\Header
 * @uses       \Mu\Http\Status
 * @uses       \Mu\Http\Cookie
 * @uses       \Mu\Http\Cookie\Jar
 *
 * @property   \Mu\Http\Header\Collection $header
 * @property   \Mu\Http\Cookie\Jar $cookie
 */
class Response extends ResponseAbstract {
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
                        /* @codeCoverageIgnoreStart */
                        'headers_sent' => 'headers_sent',
                        'header' => 'header',
                        'write' => function($body) {
                            echo $body;
                        }
                        /* @codeCoverageIgnoreEnd */
                    )
                )
            )
        );
    }

    /**
     * The collection of headers
     * @var \Mu\Http\Header\Collection
     */
    protected $_headers;

    /**
     * The http status code
     * @var \Mu\Http\Status
     */
    protected $_status;

    /**
     * The cookies to include in the response
     * @var \Mu\Http\Cookie\Jar
     */
    protected $_cookie;

    /**
     * The users session
     * @var \Mu\http\Session
     */
    protected $_session;

    /**
     * Indicates the response should be compressed
     * @var bool
     */
    protected $_compressed = false;

    /**
     * Sets the headers, clears out any existing
     * @param array $headers
     * @return \Mu\Http\Response
     */
    public function setHeaders(array $headers) {
        foreach ($headers as $name => $header) {
            if (is_string($name)) {
                $this->setHeader($name, $header);
            } else {
                $this->setHeader($header);
            }
        }

        return $this;
    }

    /**
     * Gets a header by its name
     * @param string $name
     * @return \Mu\Http\Header\Collection|\Mu\Http\Header|null
     * @todo Create header collection class once collection available, to include send method
     */
    public function getHeader($name = null) {
        if (null === $this->_headers) {
            $this->_headers = new Header\Collection();
        }

        if (null === $name) {
            return $this->_headers;
        }

        return $this->_headers->offsetExists($name) ? $this->_headers[$name] : null;
    }

    /**
     * Sets a header
     * @param string|\Mu\Http\Header             $name
     * @param string|\Mu\Http\Header|array|null  $value
     * @param bool                               $append
     * @return \Mu\Http\Response
     */
    public function setHeader($name, $value = null, $append = false) {
        if (null === $this->_headers) {
            $this->_headers = new Header\Collection();
        }

        $this->_headers->setHeader($name, $value, $append);
        return $this;
    }

    /**
     * Gets the http status
     * @return \Mu\Http\Status
     */
    public function getStatus() {
        if (null === $this->_status) {
            $this->_status = new Status();
        }
        return $this->_status;
    }

    /**
     * Sets the http status
     * @param int|string|\Mu\Http\Status $status
     * @return \Mu\Http\Response
     */
    public function setStatus($status) {
        $this->_status = ($status instanceof Status) ? $status : new Status(array('status' => $status));
        return $this;
    }

    /**
     * Gets the cookie or jar
     * @param string|null $key
     * @return \Mu\Http\Cookie|\Mu\Http\Cookie\Jar|null
     */
    public function getCookie($key = null) {
        if (null === $this->_cookie) {
            $this->setCookie();
        }

        if (null === $key) {
            return $this->_cookie;
        }

        if ($this->_cookie->offsetExists($key)) {
            return $this->_cookie[$key];
        }

        return null;
    }

    /**
     * Initializes the cookie jar, adds cookies to it
     * @param null|\Mu\Http\Cookie|string $cookie
     * @param null|string                 $value
     * @return \Mu\Http\Response
     */
    public function setCookie($cookie = null, $value = null) {
        if (null ===  $this->_cookie) {
            $this->_cookie = new Cookie\Jar();
        }

        if ($cookie instanceof Cookie) {
            $this->_cookie[] = $cookie;
        } else if (is_string($cookie) && is_string($value)) {
            $this->_cookie[$cookie] = $value;
        }

        return $this;
    }

    /**
     * Gets the users session or a value from the session
     * @param string|null $key
     * @return \Mu\Http\Session|scalar
     */
    public function getSession($key = null) {
        if (null === $this->_session) {
            $this->_session = new Session();
        }

        if (null === $key) {
            return $this->_session;
        }

        if (!$this->_session->isStarted()) {
            $this->_session->start();
        }

        return $this->_session->read($key);
    }

    /**
     * Sets the session or session value
     * @param string|\Mu\Http\Sesison $key
     * @param scalar $value
     * @return \Mu\Http\Response
     */
    public function setSession($key, $value = null) {
        if ($key instanceof Session) {
            $this->_session = $key;
            return $this;
        }

        $this->_session->write($key, $value);
        return $this;
    }

    /**
     * Gets if the response should be compressed
     * @return bool
     */
    public function getCompressed() {
        return $this->_compressed;
    }

    /**
     * Sets if the response should be compressed
     * @param bool $compressed
     * @return \Mu\Http\Response
     */
    public function setCompressed($compressed) {
        $this->_compressed = is_bool($compressed) ? $compressed : $this->_compressed;
        return $this;
    }

    /**
     * Magic __get to provide accesses for some properties
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        if (in_array($name, array('header', 'cookie', 'session'))) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }

        return parent::__get($name);
    }

    /**
     * Sends the Http response
     * @return void
     */
    public function send() {
        if (!$this->headers_sent()) {
            // @todo call send on collection once available
            foreach ($this->getHeader() as $header) {
                $header->send();
            }
            $this->getCookie()->send();

            // set the status last due to php changing the status if a location header has been sent
            $this->getStatus()->send();
        }

        if (
            (Status::STATUS_NO_CONTENT === $this->getStatus()->getStatus()) ||
            (Status::STATUS_NOT_MODIFIED === $this->getStatus()->getStatus())
        ) {
            return; // no body should be sent
        }

        if ($this->getCompressed() && extension_loaded('zlib')) {
            ini_set('zlib.output_compression', '1');
        }

        $this->write($this->getBody());
    }
}