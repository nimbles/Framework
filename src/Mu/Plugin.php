<?php
namespace Mu;

/**
 * @category Mu
 * @package Mu\Plugin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Plugin extends Mixin
	implements \IteratorAggregate {
	/**
	 * Class implements
	 * @var array
	 */
	protected $_implements = array('Mu\Config\Options');
	
	/**
	 * Plugin collection
	 * @var \ArrayObject
	 */
	protected $_plugins;
	
	/**
	 * Checks if a plugin exists
	 * @param string $name
	 * @return bool
	 */
	public function hasPlugin($name) {
		return $this->getPlugins()->offsetExists($name);
	}
	
	/**
	 * Gets a plugin by name
	 * @param string $name
	 * @return object|null
	 */
	public function getPlugin($name) {
		if ($this->hasPlugin($name)) {
			if (is_string($this->_plugins[$name])) {
				$plugin = $this->_plugins[$name]; 
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
		if (!($this->_plugins instanceof \ArrayObject)) {
			$this->_plugins = new \ArrayObject();
		}
		
		return $this->_plugins;
	}
	
	/**
	 * Class construct
	 * @param array|\Mu\Config $options
	 * @return void
	 */
	public function __construct($options = null) {
		parent::__construct();
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
	 * Magic __set to attach a plugin
	 * @param string $name
	 * @param object $plugin
	 */
	public function __set($name, $plugin) {
		return $this->attach($name, $plugin);
	}
	
	/**
	 * Magic __isset for checking if a plugin exists
	 * @param string $name
	 * @return bool
	 */
	public function __isset($name) {
		return $this->hasPlugin($name);
	}
	
	/**
	 * Magic __unset to detach a plugin
	 * @param string $name
	 */
	public function __unset($name) {
		$this->detach($name);
	}
	
	/**
	 * Get iteractor method to allow foreach
	 * @return \Traversable
	 */
	public function getIterator() {
		return $this->getPlugins()->getIterator();
	}
	
	/**
	 * Attaches a plugin
	 * @param string|object $plugin
	 * @throws \Mu\Plugin\Exception\InvalidAbstract
	 * @throws \Mu\Plugin\Exception\InvalidInterface
	 * @throws \Mu\Plugin\Exception\PluginNotFound
	 * @throws \Mu\Plugin\Exception
	 */
	public function attach($name, $plugin) {
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
				$this->_plugins = new \ArrayObject();
			}
			
			$this->_plugins[$name] = $plugin;
		} catch (\ReflectionException $ex) {
			if (is_string($plugin)) {
				throw new Plugin\Exception\PluginNotFound('Plugin ' . $plugin . ' does not exist');
			}
			
			throw new Plugin\Exception('Unknown error when attaching the plugin: ' . $ex->getMessage());
		}
	}
	
	/**
	 * Detaches a plugin
	 * @param string $name
	 * @return void
	 */
	public function detach($name) {
		if ($this->hasPlugin($name)) {
			unset($this->_plugins[$name]);
		}
	}
	
	/**
	 * Notifies the plugins, following the observer pattern
	 * @param object $object
	 * @return void
	 */
	public function notify($object = null) {
		$plugin_names = array_keys($this->getPlugins()->getArrayCopy());
		foreach ($plugin_names as $plugin_name) {
			$plugin = $this->getPlugin($plugin_name);
			if (method_exists($plugin, 'update')) {
				$plugin->update($object);
			}
		}
	}
}