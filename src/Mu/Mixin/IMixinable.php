<?php
namespace Mu\Mixin;

/**
 * @category Mu
 * @package Mu\Mixin\IMixinable
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
interface IMixinable {
	/**
	 * Gets the properties which can be mixed in
	 * @return array
	 */
	public function getProperties();
	
	/**
	 * Gets the methods which can be mixed in
	 * @return array
	 */
	public function getMethods();
} 