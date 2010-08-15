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
     * Class construct
     * @param  array $array
     * @return void
     */
    public function __construct(array $array = null) {
        if (is_array($array)) {
            foreach ($array as $value) {
	            if (!($value instanceof Cookie)) {
		            throw new Cookie\Exception\InvalidInstance('Invalid value, must be an instance of Mu\Http\Cookie');
		        }
            }
        } else {
            $array = array();
        }

        parent::__construct($array);
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

        return parent::offsetSet($index, $value);
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