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
	 * @var \Mu\Plugin
	 */
	protected $_plugin;
	
	/**
	 * Gets the object associated with this mixin
	 * @return \Mu\Plugin
	 */
	public function getObject() {
		if (null === $this->_plugin) {
			$this->_plugin = new \Mu\Plugin($this->getConfig());
		}
		
		return $this->_plugin;
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
			'attach' => function($object, &$plugins, $name, $plugin) {
				$plugins->attach($name, $plugin);
			},
			
			'detach' => function($object, &$plugins, $name) {
				$plugins->detach($name);
			},
			
			'notify' => function($object, &$plugins) {
				$plugins->notify($object);
			}
		);
	}
}