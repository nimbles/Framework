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
 * @category  Mu\Http
 * @package   Mu\Http\Cookie
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Http;

use \Mu\Core\Mixin\MixinAbstract,
    \Mu\Http\Cookie\Exception;

/**
 * @category  Mu\Http
 * @package   Mu\Http\Cookie
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @version   $Id$
 *
 * @uses      \Mu\Core\Mixin\MixinAbstract
 *
 * @uses      \Mu\Http\Cookie\Exception\InvalidName
 * @uses      \Mu\Http\Cookie\Exception\InvalidValue
 * @uses      \Mu\Http\Cookie\Exception\InvalidPath
 * @uses      \Mu\Http\Cookie\Exception\InvalidDomain
 */
class Cookie extends MixinAbstract {
    /**
     * Class implements
     * @var array
     */
    protected $_implements = array(
        'Mu\Core\Config\Options' => array(
            'expire' => 0,
            'secure' => false,
            'httponly' => false
        ),
	    'Mu\Core\Delegates\Delegatable' => array(
	        'delegates' => array(
				'setcookie' => 'setcookie',
				'setrawcookie' => 'setrawcookie'
	        )
	    )
    );

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
    protected $_expire;

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
            throw new Exception\InvalidName('Cookie name must be a string');
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
            throw new Exception\InvalidValue('Cookie value must be a string');
        }
        $this->_value = $value;
        return $this;
    }

    /**
     * Gets the time the cookie expires
     * @return int
     */
    public function getExpire() {
        return $this->_expire;
    }

    /**
     * Sets the time the cookie expires
     * @param  int $expire
     * @return \Mu\Http\Cookie
     */
    public function setExpire($expire) {
        $this->_expire = (is_int($expire) && (0 <= $expire)) ? $expire : $this->_expire;
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
            throw new Exception\InvalidPath('Path must be a string');
        }

        /**
         * @todo improve path matching
         */
        if ('/' !== strpos($path, 0, 1)) {
            throw new Exception\InvalidPath('Path must start with /');
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
        if (!is_string($domain)) {
            throw new Exception\InavlidDomain('Domain must be a string');
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
    public function getSecure() {
        return $this->_secure;
    }

    /**
     * Sets the indicator that the cookie should only be
     * transmitted over a secure HTTPS connection from the client
     * @param  bool $secure
     * @return \Mu\Http\Cookie
     */
    public function setSecure($secure) {
        $this->_secure = is_bool($secure) ? $secure : $this->_secure;
        return $this;
    }

    /**
     * Gets the indicator that the cookie will be made
     * accessible only through the HTTP protocol
     * @return bool
     */
    public function getHttponly() {
        return $this->_httponly;
    }

    /**
     * Sets the indicator that the cookie will be made
     * accessible only through the HTTP protocol
     * @param  bool $httponly
     * @return \Mu\Http\Cookie
     */
    public function setHttponly($httponly) {
        $this->_httponly = is_bool($httponly) ? $httponly : $this->_httponly;
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
     * Converts this class to a string
     * @return string
     */
    public function __toString() {
        return $this->getValue();
    }
}