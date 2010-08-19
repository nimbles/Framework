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
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http;


/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 */
class TestCase extends \Mu\Core\TestCase {
    /**
     * Indicates that the headers have been sent
     * @var bool
     */
    static protected $_headersSent;

    /**
     * Array of sent headers
     * @var array
     */
    static protected $_headers;

    /**
     * Creates a \Mu\Http\Request with the test delegate methods
     * @param array|null $options
     * @return \Mu\Http\Request
     */
    public function createRequest($options = null) {
        $request = new Request($options);
        $request->setDelegate('getInput', array('\Mu\Http\TestCase', 'getInput'));

        return $request;
    }

    /**
     * Creates a \Mu\Http\Response with the test delegate methods
     * @param array|null $options
     * @return \Mu\Http\Response
     */
    public function createResponse($options = null) {
        $response = new Response($options);
        $response->setDelegate('write', array('\Mu\Http\TestCase', 'setOutput'));
        $response->setDelegate('header', array('\Mu\Http\TestCase', 'header'));
        $response->setDelegate('headers_sent', array($this, 'isHeadersSent'));

        return $response;
    }

    /**
     * Creates a \Mu\Http\Header with the delegate methods
     * @param array|null $options
     * @return \Mu\Http\Header
     */
    public function createHeader($options = null) {
        $header = new Header($options);
        $header->setDelegate('header', array('\Mu\Http\TestCase', 'header'));
        $header->setDelegate('headers_sent', array('\Mu\Http\TestCase', 'isHeadersSent'));

        return $header;
    }

    /**
     * Creates a \Mu\Http\Status with delegate methods
     * @param array|null $options
     * @return \Mu\Http\Status
     */
    public function createStatus($options = null) {
        $status = new Status($options);
        $status->setDelegate('header', array('\Mu\Http\TestCase', 'header'));
        $status->setDelegate('headers_sent', array('\Mu\Http\TestCase', 'isHeadersSent'));

        return $status;
    }

    /**
     * Creates a \Mu\Http\Cookie with delegate methods
     * @param array|null $options
     * @return \Mu\Http\Cookie
     */
    public function createCookie($options = null) {
        $cookie = new Cookie($options);
        $cookie->setDelegate('setcookie', array('\Mu\Http\TestCase', 'setcookie'));
        $cookie->setDelegate('setrawcookie', array('\Mu\Http\TestCase', 'setrawcookie'));
        $cookie->setDelegate('headers_sent', array('\Mu\Http\TestCase', 'isHeadersSent'));

        return $cookie;
    }

    /**
     * Creates a \Mu\Http\Session with delegate methods
     * @param array|null $options
     * @return \Mu\Http\Session
     */
    public function createSession($options = null) {
        $session = new Session($options);
        return $session;
    }

    /**
     * Indicates that the headers have been sent
     * @return bool
     */
    static public function isHeadersSent($headersSent = null) {
        self::$_headersSent = is_bool($headersSent) ? $headersSent : self::$_headersSent;
        return self::$_headersSent;
    }

    /**
     * Appends a header
     *
     * @param string $header
     * @return void
     */
    static public function header($header) {
        self::$_headers[] = $header;
    }

    /**
     * Sets a cookie
     *
     * @param string $name
     * @param string $value
     * @param int    $expire
     * @param string $path
     * @param string $domain
     * @param bool   $secure
     * @param bool   $httponly
     */
    static public function setcookie($name, $value, $expire = 0, $path = '/', $domain = null, $secure = false, $httponly = false) {
        return self::setrawcookie($name, urldecode($value), $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * Sets a raw cookie
     *
     * @param string $name
     * @param string $value
     * @param int    $expire
     * @param string $path
     * @param string $domain
     * @param bool   $secure
     * @param bool   $httponly
     */
    static public function setrawcookie($name, $value, $expire = 0, $path = '/', $domain = null, $secure = false, $httponly = false) {
        $header = sprintf('Set-Cookie: %s=%s', $name, $value);

        if (0 !== $expire) {
            $header .= sprintf("; expires=%s", date('D, d-m-Y H:i:s e', $expire));
        }

        $header .= sprintf("; path=%s", $path);

        if (null !== $domain) {
            $header .= sprintf("; domain=%s", $domain);
        }

        if ($secure) {
            $header .= '; secure';
        }

        if ($httponly) {
            $header .= '; httponly';
        }

        self::$_headers[] = $header;
    }

    /**
     * Resets headers
     * @return void
     */
    public function resetDelegatesVars() {
        parent::resetDelegatesVars();
        self::$_headersSent = false;
        self::$_headers = array();
    }
}