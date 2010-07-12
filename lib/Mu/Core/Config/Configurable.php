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
 * @package   Mu\Core\Config\Configurable
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Config;

/**
 * @category  Mu\Core
 * @package   Mu\Core\Config\Configurable
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class Configurable extends \Mu\Core\Mixin\Mixinable\MixinableAbstract {
	/**
	 * The config for this mixinable
	 * @var \Mu\Core\Config
	 */
	protected $_config;

	/**
	 * Gets the object associated with this mixin
	 * @return \Mu\Core\Config
	 */
	public function getObject() {
		if (null === $this->_config) {
			$this->_config = new \Mu\Core\Config();
		}

		return $this->_config;
	}

	/**
	 * Gets the properties which can be mixed in
	 * @return array
	 */
	public function getProperties() {
		return array(
			'config' => function($object, &$config, $get, $property, array $value = null) {
				if (!$get) {
					return $config->setConfig($value);
				}

				return $config;
			}
		);
	}
}