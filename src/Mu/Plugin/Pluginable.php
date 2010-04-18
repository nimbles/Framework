<?php
namespace Mu\Plugin;

/**
 * @category Mu
 * @package Mu\Plugin\Pluginable
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Pluginable extends \Mu\Mixin\Mixinable {
	/**
	 * The plugins
	 * @var \Mu\Plugin\Plugins
	 */
	protected $_plugins;
	
	/**
	 * Gets the object associated with this mixin
	 * @return \Mu\Plugin
	 */
	public function getObject() {
		if (null === $this->_plugins) {
			$this->_plugins = new \Mu\Plugin\Plugins($this->getConfig());
		}
		
		return $this->_plugins;
	}
	
	/**
	 * Gets the properties available for this mixin
	 * @return array
	 */
	public function getProperties() {
		return array(
			'plugins' => function($object, &$plugins, $get) {
				if (!$get) {
					throw new \Mu\Mixin\Exception\ReadOnly('plugins property is read only');
				}
				
				return $plugins;
			}
		);
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