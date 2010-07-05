<?php
namespace Mu\Core\Mixin;

/**
 * @category Mu\Core
 * @package Mu\Core\Mixin\Mixinable
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
abstract class Mixinable {
	/**
	 * Mixinable config
	 * @var \Mu\Core\Config
	 */
	protected $_config;
	
	/**
	 * Gets the config
	 * @return \Mu\Core\Config
	 */
	public function getConfig() {
		return $this->_config;
	}
	
	/**
	 * Sets the config
	 * @param null|array|Mu\Core\Config $config
	 * @return \Mu\Core\Mixin\Mixinable
	 * @throws \Mu\Core\Mixin\Exception\InvalidConfig
	 */
	public function setConfig($config) {
		if (null === $config) {
			return $this;
		}
		
		if (is_array($config)) {
			$config = new \Mu\Core\Config($config);
		}
		
		if (!($config instanceof \Mu\Core\Config)) {
			throw new Exception\InvalidConfig('Config must be either null, an array or an instance of Mu\Core\\Config');
		}
		
		$this->_config = $config;
		return $this;
	}
	
	/**
	 * Class construct
	 * @param null|array|Mu\Core\Config $config
	 */
	public function __construct($config = null) {
		$this->setConfig($config);
	}
	
	/**
	 * Gets the object associated with this mixin
	 * @return null|object
	 */
	public function getObject() {
		return null;
	}
	
	/**
	 * Gets the properties which can be mixed in
	 * @return array
	 */
	public function getProperties() {
		return array();
	}
	
	/**
	 * Checks if the mixin provides the given property
	 * @param string $property
	 * @return bool
	 */
	public function hasProperty($property) {
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
			$properties = $this->getProperties();
			
			if (!($properties[$property] instanceof \Closure)) {
				throw new Exception\InvalidProperty('Property ' . $property . ' is not a closure');
			}
			
			return $properties[$property];
		}
	}
	
	/**
	 * Gets the methods which can be mixed in
	 * @return array
	 */
	public function getMethods() {
		return array();
	}
	
	/**
	 * Checks if the mixin provides the given method
	 * @param string $method
	 * @return bool
	 */
	public function hasMethod($method) {
		return array_key_exists($method, $this->getMethods());
	}
	
	/**
	 * Gets the requested method
	 * @param string $method
	 * @return \Closure
	 * @throws \Mu\Core\Mixin\Exception\InvalidMethod
	 */
	public function getMethod($method) {
		if ($this->hasMethod($method)) {
			$methods = $this->getMethods();
			
			if (!($methods[$method] instanceof \Closure)) {
				throw new Exception\InvalidMethod('Method ' . $method . ' is not a closure');
			}
			
			return $methods[$method];
		}
	}
} 