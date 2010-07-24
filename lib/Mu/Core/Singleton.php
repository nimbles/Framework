<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category  Mu\Core
 * @package   Mu\Core\Singleton
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core;

/**
 * @category  Mu\Core
 * @package   Mu\Core\Singleton
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
abstract class Singleton {

    /**
     * Instances of each singleton
     *
     * @var Singleton[]
     */
	private static $_instances = array();

    /**
     * Class constructor
     *
     * @return void
     */
    protected function __construct() {}

    /**
     * Called when attempting to create a clone of the class
     *
     * @return void
     */
    final private function __clone() {}

    /**
     * Called when unserialising
     *
     * @return void
     */
	final private function __wakeup() {}

	/**
	 * Get an instance of the class
	 *
	 * @return Singleton
     * @todo Consider constructor arguments
	 */
	final public static function getInstance() {
		$class = get_called_class();

		if (!isset(self::$_instances[$class])) {
            self::$_instances[$class] = new static();
        }

        return self::$_instances[$class];
    }
}