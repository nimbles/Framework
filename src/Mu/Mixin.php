<?php
namespace Mu;

/**
 * @category Mu
 * @package Mu\Mixin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
abstract class Mixin {
	/**
	 * The array of implements for this mixin
	 * @var array
	 */
	protected $_implements = array();
	
	/**
	 * The array of properties this mixin supports
	 * @var array
	 */
	protected $_properties = array();
	
	/**
	 * The array of methods this mixin supports
	 * @var array
	 */
	protected $_methods = array();
	
	/**
	 * Class construct
	 * @return void
	 */
	public function __construct() {
		foreach ($this->_implements as $mixin) {
			if (!class_exists($mixin)) {
				throw new Mixin\Exception\MixinableMissing();
			}
			
			$class = new $mixin();
			$this->_methods = array_merge($this->_methods, $class->getMethods());
			$this->_properties = array_merge($this->_properties, $class->getProperties());
		}
	}
	
	/**
	 * Magic __call for the mixin'd methods
	 * @param string $method
	 * @param array $args
	 */
	public function __call($method, $args) {
		if (array_key_exists($method, $this->_methods)) {
			return call_user_func_array($this->_methods[$method], array_merge(array($this), $args));
		}
		
		throw new BadMethodCallException('Invalid method ' . $method . ' on ' . get_class());
	}
	
	/**
	 * Magic __get for the mixin'd properties
	 * @param string $property
	 */
	public function __get($property) {
		if (array_key_exists($property, $this->_properties)) {
			return call_user_func_array($this->_properties[$property], array($this, true));
		}
	}
	
	/**
	 * Masgic __set for the mixin'd properties
	 * @param string $property
	 * @param mixed $value
	 */
	public function __set($property, $value) {
		if (array_key_exists($property, $this->_properties)) {
			return call_user_func_array($this->_properties[$property], array($this, false, $value));
		}
	}
	
	/**
	 * Masgic __isset for the mixin'd properties
	 * @param string $property
	 */
	public function __isset($property) {
		return array_key_exists($property, $this->_properties);
	}
}