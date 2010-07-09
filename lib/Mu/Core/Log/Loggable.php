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
 * @category  Mu\Core
 * @package   Mu\Core\Log\Loggable
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Log;

/**
 * @category  Mu\Core
 * @package   Mu\Core\Log\Loggable
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
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