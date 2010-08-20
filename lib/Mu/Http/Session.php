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
 * @subpackage Header
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http;

use Mu\Core\Mixin\MixinAbstract,
    Mu\Http\Session,
    Mu\Http\Cookie;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Status
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 * @uses       \Mu\Core\Delegates\Delegatable
 */
class Session extends MixinAbstract {
    /**
     * Class implements
     * @var array
     */
    protected $_implements = array(
        'Mu\Core\Delegates\Delegatable' => array(
            'delegates' => array(
                'session_start'             => 'session_start',
                'session_id'                => 'session_id',
                'session_name'              => 'session_name',
                'session_regenerate_id'     => 'session_regenerate_id',
                'session_destroy'           => 'session_destroy',
                'session_get_cookie_params' => 'session_get_cookie_params',
                'session_set_cookie_params' => 'session_set_cookie_params',
                'headers_sent'              => 'headers_sent',
                'setcookie'                 => 'setcookie',
                'setrawcookie'              => 'setrawcookie',
                'readValue'                 => array('\Mu\Http\Session', 'readSession'),
                'writeValue'                => array('\Mu\Http\Session', 'writeSession'),
                'clearValues'               => array('\Mu\Http\Session', 'clearSession'),
            )
        ),
        'Mu\Core\Config\Options'
    );

    /**
     * Indicates that the session has started
     * @var bool
     */
    static protected $_started = false;

    /**
     * The session name
     * @var string
     */
    protected $_name;

    /**
     * Indicates that the session has started
     * @param bool $started
     * @return bool
     */
    public function isStarted($started = null) {
        return static::$_started = is_bool($started) ? $started : static::$_started;
    }

    /**
     * Gets the session id
     * @return string
     */
    public function getId() {
        return $this->session_id();
    }

    /**
     * Sets the session id
     * @param string $id
     * @return \Mu\Http\Session
     */
    public function setId($id) {
        $this->session_id($id);
        return $this;
    }

    /**
     * Regenerate the session id
     * @return string
     */
    public function regenterateId() {
        $this->destroy();
        return $this->session_regenerate_id();
    }

    /**
     * Gets the session name
     * @return string
     */
    public function getName() {
        if (null === $this->_name) {
            $this->_name = $this->session_name();
        }

        return $this->_name;
    }

    /**
     * Sets the session name
     * @param string $name
     * @return \Mu\Http\Session
     * @throws \Mu\Http\Session\Exception\SessionStarted
     * @throws \Mu\Http\Session\Exception\InvalidSessionName
     */
    public function setName($name) {
        if ($this->isStarted()) {
            throw new Session\Exception\SessionStarted('Cannot change session name once session has been started');
        }

        if (0 === preg_match('/^[0-9a-z]+/i', $name)) {
            throw new Session\Exception\InvalidSessionName('Session name must be alphanumeric');
        }

        $this->_name = $name;
        $this->session_name($name);

        return $this;
    }

    /**
     * Gets the cookie params
     * @return array
     */
    public function getCookieParams() {
        return $this->session_get_cookie_params();
    }

    /**
     * Sets the cookie params
     * @param array $params
     * @return \Mu\Http\Session
     */
    public function setCookieParams(array $params) {
        call_user_func_array(array($this, 'session_set_cookie_params'), $params);
        return $this;
    }

    /**
     * Class construct
     * @param array|null $options
     * @return void
     */
    public function __construct($options = null) {
        parent::__construct();
        $this->setOptions($options);
    }

    /**
     * Starts the session
     * @return \Mu\Http\Session
     * @throws \Mu\Http\Session\Exception\SessionStarted
     * @throws \Mu\Http\Session\Exception\StartFailure
     */
    public function start() {
        if ($this->isStarted()) {
            throw new Session\Exception\SessionStarted('Session already started');
        }

        if (!$this->isStarted($this->session_start())) {
            throw new Session\Exception\StartFailure('Failed to start session');
        }

        return $this;
    }

    /**
     * Destroys the session
     * @return \Mu\Http\Session
     */
    public function destroy() {
        if (!$this->isStarted()) {
            return;
        }

        $this->clear();

        if (ini_get('session.use_cookies')) {
            $params = $this->getCookieParams();
            $cookie = new Cookie(array(
                'name'     => $this->getName(),
                'value'    => '',
                'expire'   => time() - 42000,
                'path'     => $params['path'],
                'domain'   => $params['domain'],
                'secure'   => $params['secure'],
                'httponly' => $params['httponly']
            ));

            $cookie->setDelegate('headers_sent', $this->getDelegate('headers_sent'));
            $cookie->setDelegate('setcookie', $this->getDelegate('setcookie'));
            $cookie->setDelegate('setrawcookie', $this->getDelegate('setrawcookie'));

            $cookie->send();
        }

        $this->session_destroy();
        return $this;
    }

    /**
     * Reads from the session
     * @param string|null $key
     * @return mixed
     */
    public function read($key = null) {
        return $this->readValue($key);
    }

    /**
     * Writes to the session
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function write($key, $value) {
        if (!$this->isStarted()) {
            throw new Session\Exception\SessionStarted('Cannot write to session when it has not been started');
        }

        if ($this->headers_sent()) {
            throw new Session\Exception\HeadersAlreadySent('Cannot write to session once headers have already been sent');
        }

        return $this->writeValue($key, $value);
    }

    /**
     * Clears the session
     * @return void
     */
    public function clear() {
        return $this->clearValues();
    }

    /**
     * Reads from the session
     * @param string|null $key
     * @return mixed
     */
    static public function readSession($key = null) {
        if (null === $key) {
            return $_SESSION;
        }

        return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : null;
    }

    /**
     * Writes to the session
     * @param string $key
     * @param mixed $value
     */
    static public function writeSession($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * Clears the session
     * @return void
     */
    static public function clearSession() {
        $_SESSION = array();
    }
}