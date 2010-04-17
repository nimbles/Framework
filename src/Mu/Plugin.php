<?php
namespace Mu;

/**
 * @category Mu
 * @package Mu\Plugin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Plugin extends Mixin {
	/**
	 * Class implements
	 * @var array
	 */
	protected $_implements = array('Mu\Config\Options');
	
	/**
	 * Plugin collection
	 * @var array
	 */
	protected $_plugins;
	
	/**
	 * Checks if a plugin exists
	 * @param string $name
	 * @return bool
	 */
	public function hasPlugin($name) {
		$plugins = $this->getPlugins();
		return array_key_exist($name, $plugins);
	}
	
	/**
	 * Gets a plugin by name
	 * @param string $name
	 * @return object|null
	 */
	public function getPlugin($name) {
		if ($this->hasPlugin($name)) {
			if (is_string($this->_plugins[$name])) {
				$this->_plugins[$name] = new $plugin();
			}
			
			return $this->_plugins[$name];
		}
		
		return null;
	}
	
	/**
	 * Gets the plugin collection
	 * @return array
	 */
	public function getPlugins() {
		if (!is_array($this->_plugins)) {
			$this->_plugins = array();
		}
		
		return $this->_plugins;
	}
	
	/**
	 * Class construct
	 * @param array|\Mu\Config $options
	 * @return void
	 */
	public function __construct($options) {
		$this->setOptions($options);
	}
	
	/**
	 * Magic __get for getting a plugin by name
	 * @param string $name
	 * @return object|null
	 */
	public function __get($name) {
		return $this->getPlugin($name);
	}
	
	/**
	 * Magic __isset for checking if a plugin exists
	 * @param string $name
	 * @return bool
	 */
	public function __iset($name) {
		return $this->hasPlugin($name);
	}
	
	/**
	 * Registers a plugin
	 * @param string|object $plugin
	 * @throws \Mu\Plugin\Exception\InvalidAbstract
	 * @throws \Mu\Plugin\Exception\InvalidInterface
	 * @throws \Mu\Plugin\Exception\PluginNotFound
	 * @throws \Mu\Plugin\Exception
	 */
	public function register($name, $plugin) {
		try {
			$ref = new \ReflectionClass($plugin);
			if (null !== ($abstract = $this->getOption('abstract'))) {
				if (!$ref->isSubclassOf($abstract)) {
					throw new Plugin\Exception\InvalidAbstract('Plugin does not extend abstract ' . $abstract);
				}
			} else if (null !== ($interface = $this->getOption('interface'))) {
				if (!$ref->implementsInterface($interface)) {
					throw new Plugin\Exception\InvalidInterface('Plugin does not implement interface ' . $interface);
				}
			}
			
			if (!is_array($this->_plugins)) {
				$this->_plugins = array();
			}
			
			$this->_plugins[$name] = $plugin;
		} catch (\ReflectionException $ex) {
			if (is_string($plugin)) {
				throw new Plugin\Exception\PluginNotFound('Plugin ' . $plugin . ' does not exist');
			}
			
			throw new Plugin\Exception('Unknown error when registering the plugin: ' . $ex->getMessage());
		}
	}
	
	/**
	 * Notifies the plugins, following the observer pattern
	 * @param object $object
	 * @return void
	 */
	public function notify($object) {
		$plugin_names = array_keys($this->getPlugins());
		foreach ($plugin_names as $plugin_name) {
			$plugin = $this->getPlugin($plugin_name);
			if (method_exists($plugin, 'update')) {
				$plugin->update($object);
			}
		}
	}
}