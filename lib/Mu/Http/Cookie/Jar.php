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

use Mu\Http\Cookie;

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
     * Gets an instanceof the Cookie Jar
     * @return \Mu\Http\Cookie\Jar
     */
    static public function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new Jar();
        }

        return self::$_instance;
    }

    /**
     * Class construct
     * @param  array $array
     * @return void
     */
    public function __construct(array $array = null) {
        parent::__construct();

        if (is_array($array)) {
            foreach ($array as $key => $value) {
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

		        $this[$value->getName()] = $value;
            }
        }
    }

    /**
     * Overloads offsetSet to restrict value type
     * @param  int|string      $index
     * @param  \Mu\Http\Cookie $value
     * @return void
     * @throws \Mu\Http\Cookie\Exception\InvalidInstance
     */
    public function offsetSet($index, $value) {
        if (!($value instanceof Cookie)) {
            throw new Cookie\Exception\InvalidInstance('Invalid value, must be an instance of Mu\Http\Cookie');
        }

        return parent::offsetSet($value->getName(), $value);
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