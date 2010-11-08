<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://nimbl.es/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */
namespace Nimbles\Http\Client;

use Nimbles\Http\Client\Request,
    Nimbles\Http\Client,
    Nimbles\Http;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Http\Client\Request
 * @uses       \Nimbles\Http\Client
 * @uses       \Nimbles\Http
 */
class Request extends Http\Request {
    /**
     * Request URI
     * @var string
     */
    protected $_requestUri;

    /**
     * Method of request
     * @var string
     */
    protected $_method = null;

    /**
     * Get the request URI
     * @return string
     */
    public function getRequestUri() {
        return $this->_requestUri;
    }

    /**
     * Set the request URI
     * @param string $value
     * @return \Nimbles\Http\Client\Request
     * @throws \Nimbles\Http\Client\Exception
     */
    public function setRequestUri($value) {
        if (!is_string($value)) {
            throw new Exception('Request URI must be a string');
        }

        $this->_requestUri = (string)$value;
        return $this;
    }

    /**
     * Get the HTTP method
     * @return string
     */
    public function getMethod() {
        return $this->_method;
    }

    /**
     * Set the HTTP method
     * @param string $method
     * @return \Nimbles\Http\Client
     * @throws \Nimbles\Http\Client\Exception\InvalidMethod
     */
    public function setMethod($method) {
        if (!is_string($method)) {
            throw new Request\Exception\InvalidMethod('Method must be of type string');
        }
        $method = strtoupper($method);
        if (0 === preg_match('/^[A-Z0-9]+$/', $method)) {
            throw new Request\Exception\InvalidMethod('Invalid HTTP method [' . $method . ']');
        }

        $this->_method = $method;
        return $this;
    }
}