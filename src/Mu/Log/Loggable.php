<?php
namespace Mu\Log;

/**
 * @category Mu
 * @package Mu\Log\Loggable
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Loggable extends \Mu\Mixin\Mixinable {
	/**
	 * Gets the object associated with this mixin
	 * @return \Mu\Log
	 */
	public function getObject() {
		return \Mu\Log::getInstance();
	}
	
	/**
	 * Gets the method available for this mixin
	 * @return array
	 */
	public function getMethods() {
		return array(
			'log' => function($object, &$log, $entry) {
				return $log->write($entry);
			}
		);
	}
}