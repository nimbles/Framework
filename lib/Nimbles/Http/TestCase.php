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
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Http;


/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage TestCase
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 */
class TestCase extends \Nimbles\Core\TestCase {
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
     * Array of query variables
     * @var array
     */
    static protected $_query;

    /**
     * Array of post variables
     * @var array
     */
    static protected $_post;

    /**
     * Array of cookies
     * @var array
     */
    static protected $_cookies;

    /**
     * The session data
     * @var array
     */
    static protected $_session = array();

    /**
     * The session id
     * @var string
     */
    static protected $_sessionId = '';

    /**
     * The session name
     * @var string
     */
    static protected $_sessionName = 'PHPSESSID';

    /**
     * Creates a \Nimbles\Http\Request with the test delegate methods
     * @param array|null $options
     * @return \Nimbles\Http\Request
     */
    public function createRequest($options = null) {
        $request = new Request($options);
        $request->setDelegate('getInput', array('\Nimbles\Http\TestCase', 'getInput'));
        $request->setDelegate('getServerRaw', array('\Nimbles\Http\TestCase', 'getServer'));
        $request->setDelegate('getCookieRaw', array('\Nimbles\Http\TestCase', 'getCookie'));
        $request->setDelegate('getPostRaw', array('\Nimbles\Http\TestCase', 'getPost'));
        $request->setDelegate('getQueryRaw', array('\Nimbles\Http\TestCase', 'getQuery'));
        $request->setDelegate('createSession', array('\Nimbles\Http\TestCase', 'getReadOnlySession'));

        return $request;
    }

    /**
     * Creates a \Nimbles\Http\Response with the test delegate methods
     * @param array|null $options
     * @return \Nimbles\Http\Response
     */
    public function createResponse($options = null) {
        $response = new Response($options);
        $response->setDelegate('write', array('\Nimbles\Http\TestCase', 'setOutput'));
        $response->setDelegate('header', array('\Nimbles\Http\TestCase', 'header'));
        $response->setDelegate('headers_sent', array($this, 'isHeadersSent'));

        return $response;
    }

    /**
     * Creates a \Nimbles\Http\Header with the delegate methods
     * @param array|null $options
     * @return \Nimbles\Http\Header
     */
    public function createHeader($options = null) {
        $header = new Header($options);
        $header->setDelegate('header', array('\Nimbles\Http\TestCase', 'header'));
        $header->setDelegate('headers_sent', array('\Nimbles\Http\TestCase', 'isHeadersSent'));

        return $header;
    }

    /**
     * Creates a \Nimbles\Http\Status with delegate methods
     * @param array|null $options
     * @return \Nimbles\Http\Status
     */
    public function createStatus($options = null) {
        $status = new Status($options);
        $status->setDelegate('header', array('\Nimbles\Http\TestCase', 'header'));
        $status->setDelegate('headers_sent', array('\Nimbles\Http\TestCase', 'isHeadersSent'));

        return $status;
    }

    /**
     * Creates a \Nimbles\Http\Cookie with delegate methods
     * @param array|null $options
     * @return \Nimbles\Http\Cookie
     */
    public function createCookie($options = null) {
        $cookie = new Cookie($options);
        $cookie->setDelegate('setcookie', array('\Nimbles\Http\TestCase', 'setcookie'));
        $cookie->setDelegate('setrawcookie', array('\Nimbles\Http\TestCase', 'setrawcookie'));
        $cookie->setDelegate('headers_sent', array('\Nimbles\Http\TestCase', 'isHeadersSent'));

        return $cookie;
    }

    /**
     * Creates a \Nimbles\Http\Session with delegate methods
     * @param array|null $options
     * @return \Nimbles\Http\Session
     */
    public function createSession($options = null) {
        return static::getSession($options);
    }

    /**
     * Indicates that the headers have been sent
     * @return bool
     */
    static public function isHeadersSent($headersSent = null) {
        static::$_headersSent = is_bool($headersSent) ? $headersSent : static::$_headersSent;
        return static::$_headersSent;
    }

    /**
     * Appends a header
     *
     * @param string $header
     * @return void
     */
    static public function header($header) {
        static::$_headers[] = $header;
    }

    /**
     * Gets the cookies
     * @return array
     */
    static public function getCookie() {
        return static::$_cookies;
    }

    /**
     * Gets the query variables
     * @return array
     */
    static public function getQuery() {
        return static::$_query;
    }

    /**
     * Gets the post variables
     * @return array
     */
    static public function getPost() {
        return static::$_post;
    }

    /**
     * Gets a session
     * @param array $options
     * @return \Nimbles\Http\Session
     */
    static public function getSession($options = null) {
        $session = new Session($options);
        $session->isStarted(false);

        $session->setDelegate('session_start', array('\Nimbles\Http\TestCase', 'sessionStart'));
        $session->setDelegate('session_id', array('\Nimbles\Http\TestCase', 'sessionId'));
        $session->setDelegate('session_name', array('\Nimbles\Http\TestCase', 'sessionName'));
        $session->setDelegate('session_regenerate_id', array('\Nimbles\Http\TestCase', 'generateSessionId'));
        $session->setDelegate('session_destroy', array('\Nimbles\Http\TestCase', 'sessionDestroy'));
        $session->setDelegate('headers_sent', array('\Nimbles\Http\TestCase', 'isHeadersSent'));
        $session->setDelegate('setcookie', array('\Nimbles\Http\TestCase', 'setcookie'));
        $session->setDelegate('setrawcookie', array('\Nimbles\Http\TestCase', 'setrawcookie'));
        $session->setDelegate('readValue', array('\Nimbles\Http\TestCase', 'readSession'));
        $session->setDelegate('writeValue', array('\Nimbles\Http\TestCase', 'writeSession'));
        $session->setDelegate('clearValues', array('\Nimbles\Http\TestCase', 'clearSession'));
        $session->setDelegate('offsetExists', array('\Nimbles\Http\TestCase', 'sessionKeyExists'));

        return $session;
    }

    /**
     * Gets a read only session
     * @param array $options
     * @return \Nimbles\Http\Session
     */
    static public function getReadOnlySession($options = null) {
        $session = static::getSession($options);
        $session->setDelegate('writeValue', function() {});
        $session->setDelegate('clearValues', function() {});
        return $session;
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
        return static::setrawcookie($name, urldecode($value), $expire, $path, $domain, $secure, $httponly);
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

        static::$_headers[] = $header;
    }

    /**
     * Starts the session
     * @return bool
     */
    static public function sessionStart() {
        if ('' === static::$_sessionId) {
            static::generateSessionId();
        }
        return true;
    }

    /**
     * Gets and sets the session id
     * @param string|null $id
     * @return void
     */
    static public function sessionId($id = null) {
        return static::$_sessionId = (null === $id) ? static::$_sessionId : $id;
    }

    /**
     * Gets and sets the session name
     * @param string|null $name
     * @return void
     */
    static public function sessionName($name = null) {
        return static::$_sessionName = (null === $name) ? static::$_sessionName : $name;
    }

    /**
     * Destroys the session
     */
    static public function sessionDestroy() {
        static::$_sessionId = '';
        static::$_sessionName = 'PHPSESSID';
        static::$_session = array();
        return true;
    }

    /**
     * Generates a session id
     * @return bool
     */
    static public function generateSessionId($deleteOld = false) {
        static::$_sessionId = md5((string) (time() + rand(0, 1000)));
        return true;
    }

    /**
     * Reads from the session
     * @param string $key
     * @return mixed
     */
    static public function readSession($key) {
        if ('' === static::$_sessionId) {
            if (null === $key) {
                return array();
            }

            return null;
        }

        if (null === $key) {
            return static::$_session;
        }

        return array_key_exists($key, static::$_session) ? static::$_session[$key] : null;
    }

    /**
     * Writes to the session
     * @param string $key
     * @param mixed $value
     * @return void
     */
    static public function writeSession($key, $value) {
        static::$_session[$key] = $value;
    }

    /**
     * Clears the session
     * @return void
     */
    static public function clearSession() {
        static::$_session = array();
    }

    /**
     * Checks if a session key exists
     * @param string $key
     * @return bool
     */
    static public function sessionKeyExists($key) {
        return array_key_exists($key, static::$_session);
    }

    /**
     * Resets headers
     * @return void
     */
    public function resetDelegatesVars() {
        parent::resetDelegatesVars();
        static::$_headersSent = false;
        static::$_headers = array();
        static::$_cookies = array();
        static::$_sessionId = '';
        static::$_sessionName = 'PHPSESSID';
        static::$_session = array();
    }
}