<?php
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