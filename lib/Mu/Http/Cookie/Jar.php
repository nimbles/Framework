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

namespace Mu\Http\Cookie;

use Mu\Http\Cookie,
    Mu\Http\Cookie\Jar;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Cookie
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \ArrayObject
 *
 * @uses       \Mu\Http\Cookie
 * @uses       \Mu\Http\Cookie\Exception\InvalidInstance
 *
 * @todo Migrate to using the collection class once available
 */
class Jar extends \ArrayObject {
    /**
     * Instance of the Cookie Jar
     * @var \Mu\Http\Cookie\Jar
     */
    static protected $_instance;

    /**
     * Indicates that the jar is readonly
     * @var bool
     */
    protected $_readonly;

    /**
     * Gets an instanceof the Cookie Jar
     * @return \Mu\Http\Cookie\Jar
     */
    static public function getInstance() {
        return self::$_instance ?: self::$_instance = new static();
    }

    /**
     * Indicates that the jar is readonly
     * @return bool
     */
    public function isReadOnly() {
        return $this->_readonly;
    }

    /**
     * Class construct
     * @param array $array
     * @param bool  $readonly indicates that the jar should be readonly
     * @return void
     */
    public function __construct(array $array = null, $readonly = false) {
        parent::__construct();

        $this->setCookies($array, true);
        $this->_readonly = is_bool($readonly) ? $readonly : false;
    }

    /**
     * Overloads offsetSet to restrict value type
     * @param  int|string      $key
     * @param  \Mu\Http\Cookie $value
     * @return void
     * @throws \Mu\Http\Cookie\Exception\InvalidInstance
     */
    public function offsetSet($key, $value) {
        if ($this->isReadOnly()) {
            throw new Jar\Exception\ReadOnly('Cannot write to cookie jar when it is read only');
        }

        if (is_string($value)) {
            $value = new Cookie(array(
                'name' => $key,
                'value' => $value
            ));
        }

        if (!($value instanceof Cookie)) {
            throw new Cookie\Exception\InvalidInstance('Invalid value, must be an instance of Mu\Http\Cookie');
        }

        if (null === $value->getName()) {
            $value->setName($key);
        }

        return parent::offsetSet($value->getName(), $value);
    }

    /**
     * Sets the cookies
     * @param array|null $cookies
     * @param bool       $clear   clears out any existing cookies
     * @return \Mu\Http\Cookie\Jar
     */
    public function setCookies(array $cookies = null, $clear = false) {
        if (is_bool($clear) && $clear && (0 !== $this->count())) {
            $this->exchangeArray(array());
        }

        if (null !== $cookies) {
            foreach ($cookies as $key => $value) {
                $this[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * Sends the cookies
     * @return void
     */
    public function send() {
        foreach ($this as $cookie) {
            $cookie->send();
        }
    }
}