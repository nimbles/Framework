<?php
namespace Mu\Core\Log;

/**
 * @category Mu\Core
 * @package Mu\Core\Log\Loggable
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Loggable extends \Mu\Core\Mixin\Mixinable {
	/**
	 * Gets the object associated with this mixin
	 * @return \Mu\Core\Log
	 */
	public function getObject() {
		return \Mu\Core\Log::getInstance();
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