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
 * @package   Mu\Core\Plugin\Pluginable
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Plugin;

/**
 * @category  Mu\Core
 * @package   Mu\Core\Plugin\Pluginable
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class Pluginable extends \Mu\Core\Mixin\Mixinable {
	/**
	 * The plugins
	 * @var \Mu\Core\Plugin\Plugins
	 */
	protected $_plugins;
	
	/**
	 * The properties
	 * @var array
	 */
	protected $_properties;

	/**
	 * Gets the object associated with this mixin
	 * @return \Mu\Core\Plugin
	 */
	public function getObject() {
		if (null === $this->_plugins) {
			$this->_plugins = new \Mu\Core\Plugin\Plugins($this->getConfig());
		}

		return $this->_plugins;
	}

	/**
	 * Gets the properties available for this mixin
	 * @return array
	 */
//	public function getProperties() {
//		$types = $this->getObject()->getOption('types');
//		
//		if ($types instanceof \ArrayObject) {
//			$types = $types->getArrayCopy();
//		} else if (!is_array($types)) {
//			$types = array();
//		}
//		
//		$types = array_keys($types);
//		$plugins = array();
//		
//		foreach ($types as $type) {
//			$plugins[$type] = function($object, &$plugins, $get, $property) {
//				if (!$get) {
//					throw new \Mu\Core\Mixin\Exception\ReadOnly('plugins property is read only');
//				}
//				
//				print_r($plugins);
//
//				return $plugins->$property;
//			};
//		}
//		
//		return $plugins;
//		
//		return array(
//			'plugins' => function($object, &$plugins, $get) {
//				if (!$get) {
//					throw new \Mu\Core\Mixin\Exception\ReadOnly('plugins property is read only');
//				}
//
//				return $plugins;
//			}
//		);
//	}
	
	/**
	 * Gets the properties which can be mixed in
	 * @return array
	 */
	public function getProperties() {
		if (!is_array($this->_properties)) {
			$this->_properties = array();
		}
		
		return $this->_properties; 
	}

	/**
	 * Checks if the mixin provides the given property
	 * @param string $property
	 * @return bool
	 */
	public function hasProperty($property) {
		if (!array_key_exists($property, $this->getProperties())) {
			if (null !== ($value = $this->getObject()->getType($property))) {
				$this->_properties[$property] = function($object, &$plugins, $get, $property) {
					if (!$get) {
						throw new \Mu\Core\Mixin\Exception\ReadOnly('plugins property is read only');
					}
	
					return $plugins->$property;
				};
			}
		}
		
		return array_key_exists($property, $this->getProperties());
	}

	/**
	 * Gets the requested property from the mixin
	 * @param string $property
	 * @return \Closure
	 * @throws \Mu\Core\Mixin\Exception\InvalidProperty
	 */
	public function getProperty($property) {
		if ($this->hasProperty($property)) {		
			if (!($this->_properties[$property] instanceof \Closure)) {
				throw new Exception\InvalidProperty('Property ' . $property . ' is not a closure');
			}
			
			return $this->_properties[$property];
		}
		
		return null;
	}

	/**
	 * Gets the method available for this mixin
	 * @return array
	 */
	public function getMethods() {
		return array(
			'attach' => function($object, &$plugins, $type, $name, $plugin) {
				if (isset($plugins->{$type})) {
					return $plugins->{$type}->attach($name, $plugin);
				}

				throw new Exception\UndefinedType('Plugin type ' . $type . ' is undefined');
			},

			'detach' => function($object, &$plugins, $type, $name) {
				if (isset($plugins->{$type})) {
					return $plugins->{$type}->detach($name);
				}

				throw new Exception\UndefinedType('Plugin type ' . $type . ' is undefined');
			},

			'notify' => function($object, &$plugins, $type = null) {
				if (null !== $type) {
					if (isset($plugins->{$type})) {
						return $plugins->{$type}->notify($object);
					}
					throw new Exception\UndefinedType('Plugin type ' . $type . ' is undefined');
				} else {
					return $plugins->notify($object);
				}
			}
		);
	}
}