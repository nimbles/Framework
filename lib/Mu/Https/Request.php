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
 * @category  Mu\Https
 * @package   Mu\Https\Request
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Https;

/**
 * @category Mu\Https
 * @package Mu\Https\Request
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Request extends \Mu\Http\Request {
	/**
	 * Builds the request, used by factory
	 * @return \Mu\Https\Request|null
	 */
	static public function build() {
	    if ('cli' !== PHP_SAPI) {
	        $request = new self();

	        if (('http' === $request->getScheme)) {
	            return null;
	        }

	        return $request;
	    }

	    return null;
	}
}