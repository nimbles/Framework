<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://nimbl.es/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Cookie
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Http\Cookie;

use Nimbles\Http\Cookie,
    Nimbles\Http\Cookie\Jar,
    Nimbles\Core\Collection;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Cookie
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       Collection
 *
 * @uses       \Nimbles\Http\Cookie
 * @uses       \Nimbles\Http\Cookie\Exception\InvalidInstance
 * @uses       \Nimbles\Http\Cookie\Jar\Exception\ReadOnly
 *
 * @todo Migrate to using the collection class once available
 */
class Jar extends Collection {
    /**
     * Instance of the Cookie Jar
     * @var \Nimbles\Http\Cookie\Jar
     */
    protected static $_instance;

    /**
     * Gets an instanceof the Cookie Jar
     * @return \Nimbles\Http\Cookie\Jar
     */
    public static function getInstance() {
        return self::$_instance ?: self::$_instance = new static();
    }

    /**
     * Class construct
     * @param array $array
     * @param bool  $readonly indicates that the jar should be readonly
     * @return void
     */
    public function __construct(array $array = null, array $options = null) {
        parent::__construct(
            $array,
            array_merge(
                is_array($options) ? $options : array('readonly' => false),
                array(
                    'type' => 'Nimbles\Http\Cookie',
                    'indexType' => static::INDEX_ASSOCIATIVE
                )
            )
        );
        $this->setFlags(self::ARRAY_AS_PROPS);
    }

    /**
     * Overloads offsetSet to restrict value type
     * @param  int|string      $key
     * @param  \Nimbles\Http\Cookie $value
     * @return void
     * @throws \Nimbles\Http\Cookie\Exception\InvalidInstance
     */
    public function offsetSet($key, $value) {
        if (is_string($value)) {
            $value = new Cookie(array(
                'name' => $key,
                'value' => $value
            ));
        }

        if (!($value instanceof Cookie)) {
            throw new Cookie\Exception\InvalidInstance('Invalid value, must be an instance of Nimbles\Http\Cookie');
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
     * @return \Nimbles\Http\Cookie\Jar
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
        if ($this->isReadOnly()) {
            return;
        }

        foreach ($this as $cookie) {
            $cookie->send();
        }
    }

    /**
     * Gets a cookie
     *
     * @param $name
     */
    public function getCookie($name) {
        return $this[$name];
    }
}