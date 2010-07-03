<?php
namespace Mu\Core\Request;

/**
 * @category Mu\Core
 * @package Mu\Core\Request\IRequest
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
interface IRequest {
	/**
	 * Builds the request, used by factory
	 * @return \Mu\Core\Request|null
	 */
	static public function build();
}