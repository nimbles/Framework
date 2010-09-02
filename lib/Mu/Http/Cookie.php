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
 * @subpackage Cookie
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http;

use Mu\Core\Mixin\MixinAbstract,
    Mu\Http\Cookie;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Cookie
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\MixinAbstract
 *
 * @uses       \Mu\Http\Cookie\Exception\InvalidName
 * @uses       \Mu\Http\Cookie\Exception\InvalidValue
 * @uses       \Mu\Http\Cookie\Exception\InvalidPath
 * @uses       \Mu\Http\Cookie\Exception\InvalidDomain
 */
class Cookie extends MixinAbstract {
    /**
     * Gets the array of implements for this mixin
     * @var array
     */
    static protected function _getImplements() {
        return array(
            'Mu\Core\Config\Options' => array(
                'expires'   => 0,
                'path'     => '/',
                'domain'   => null,
                'secure'   => false,
                'httponly' => false
            ),
            'Mu\Core\Delegates\Delegatable' => array(
                'delegates' => array(
                    'headers_sent' => 'headers_sent',
                    'setcookie'    => 'setcookie',
                    'setrawcookie' => 'setrawcookie'
                )
            )
        );
    }

    /**
     * The name of the cookie
     * @var string
     */
    protected $_name;

    /**
     * The value of the cookie
     * @var string
     */
    protected $_value;

    /**
     * The time the cookie expires
     * @var int
     */
    protected $_expires;

    /**
     * The path on the server in which the cookie will be available on
     * @var string
     */
    protected $_path;

    /**
     * The domain that the cookie is available
     * @var string
     */
    protected $_domain;

    /**
     * Indicates that the cookie should only be transmitted over a secure HTTPS connection from the client
     * @var bool
     */
    protected $_secure;

    /**
     * Indicates that the cookie will be made accessible only through the HTTP protocol
     * @var bool
     */
    protected $_httponly;

    /**
     * Gets the cookies name
     * @return string
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * Sets the cookies name
     * @param  string $name
     * @return \Mu\Http\Cookie
     * @throws \Mu\Http\Cookie\Exception\InvalidName
     */
    public function setName($name) {
        if (!is_string($name)) {
            throw new Cookie\Exception\InvalidName('Cookie name must be a string');
        }
        $this->_name = $name;
        return $this;
    }

    /**
     * Gets the cookies value
     * @return string
     */
    public function getValue() {
        return $this->_value;
    }

    /**
     * Sets the cookies value
     * @param  string $value
     * @return \Mu\Http\Cookie
     * @throws \Mu\Http\Cookie\Exception\InvalidValue
     */
    public function setValue($value) {
        if (!is_string($value)) {
            throw new Cookie\Exception\InvalidValue('Cookie value must be a string');
        }
        $this->_value = $value;
        return $this;
    }

    /**
     * Gets the time the cookie expires
     * @return int
     */
    public function getExpires() {
        return $this->_expires;
    }

    /**
     * Sets the time the cookie expires
     * @param  int|string $expires
     * @return \Mu\Http\Cookie
     */
    public function setExpires($expires) {
        if(is_string($expires)) {
            $expires = strtotime($expires) - time();
        }
        $this->_expires = (is_int($expires) && (0 <= $expires)) ? $expires : $this->_expires;
        return $this;
    }

    /**
     * Gets the path on the server in which the cookie will be available on
     * @return string
     */
    public function getPath() {
        return $this->_path;
    }

    /**
     * Sets the path on the server in which the cookie will be available on
     * @param  string $path
     * @return \Mu\Http\Cookie
     * @throws \Mu\Http\Cookie\Exception\InvalidPath
     */
    public function setPath($path) {
        if (!is_string($path)) {
            throw new Cookie\Exception\InvalidPath('Path must be a string');
        }

        /**
         * @todo improve path matching
         */
        if ('/' !== substr($path, 0, 1)) {
            throw new Cookie\Exception\InvalidPath('Path must start with /');
        }

        $this->_path = $path;
        return $this;
    }

    /**
     * Gets the domain that the cookie is available
     * @return string
     */
    public function getDomain() {
        return $this->_domain;
    }

    /**
     * Sets the domain that the cookie is available
     * @param  string $domain
     * @return \Mu\Http\Cookie
     * @throws \Mu\Http\Cookie\Exception\InavlidDomain
     */
    public function setDomain($domain) {
        if (!((null === $domain) || is_string($domain))) {
            throw new Cookie\Exception\InvalidDomain('Domain must be null or a string');
        }

        /**
         * @todo add validation of the domain
         */
        $this->_domain = $domain;
        return $this;
    }

    /**
     * Gets the indicator that the cookie should only be
     * transmitted over a secure HTTPS connection from the client
     * @return bool
     */
    public function isSecure($secure = null) {
        return $this->_secure = is_bool($secure) ? $secure : $this->_secure;
    }

    /**
     * Gets the indicator that the cookie will be made
     * accessible only through the HTTP protocol
     * @return bool
     */
    public function isHttponly($httponly = null) {
        return $this->_httponly = is_bool($httponly) ? $httponly : $this->_httponly;
    }

    /**
     * Class construct
     * @param array|null $options
     * @return void
     */
    public function __construct($options = null) {
        $this->setOptions($options);
    }

    /**
     * Converts this class to a string
     * @return string
     */
    public function __toString() {
        return $this->getValue();
    }

    /**
     * Sends the cookie
     * @param bool $raw
     * @return void
     * @throw \Mu\Http\Cookie\Exception\HeadersAlreadySent
     */
    public function send($raw = false) {
        if ($this->headers_sent()) {
            throw new Cookie\Exception\HeadersAlreadySent('Cannot send cookie when headers already sent');
        }

        $args = array(
            $this->getName(),
            $this->getValue(),
            $this->getExpires(),
            $this->getPath(),
            $this->getDomain(),
            $this->isSecure(),
            $this->isHttponly()
        );

        if ($raw) {
            return call_user_func_array(array($this, 'setrawcookie'), $args);
        }

        return call_user_func_array(array($this, 'setcookie'), $args);
    }
}