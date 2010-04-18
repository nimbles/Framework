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
	protected $_mixins = array();
	
	/**
	 * Class construct
	 * @return void
	 * @throws \Mu\Mixin\Exception\MixinableMissing
	 */
	public function __construct() {
		foreach ($this->_implements as $mixin => $options) {
			if (is_numeric($mixin)) {
				$mixin = $options;
				$options = null;
			}
			if (!class_exists($mixin)) {
				throw new Mixin\Exception\MixinableMissing();
			}
			
			$this->_mixins[$mixin] = new $mixin($options);
		}
	}
	
	/**
	 * Magic __call for the mixin'd methods
	 * @param string $method
	 * @param array $args
	 * @throws \BadMethodCallException
	 */
	public function __call($method, $args) {
		foreach ($this->_mixins as &$mixin) {
			if ($mixin->hasMethod($method)) {
				$object = $mixin->getObject();
				return call_user_func_array($mixin->getMethod($method), array_merge(array(
					$this, &$object
				), $args));
			}
		}
		
		throw new \BadMethodCallException('Invalid method ' . $method . ' on ' . get_class());
	}
	
	/**
	 * Magic __get for the mixin'd properties
	 * @param string $property
	 */
	public function __get($property) {
		foreach ($this->_mixins as &$mixin) {
			if ($mixin->hasProperty($property)) {
				$object = $mixin->getObject();
				return call_user_func_array($mixin->getProperty($property), array(
					$this, &$object, true
				));
			}
		}
		
		return null;
	}
	
	/**
	 * Magic __set for the mixin'd properties
	 * @param string $property
	 * @param mixed $value
	 */
	public function __set($property, $value) {
		foreach ($this->_mixins as &$mixin) {
			if ($mixin->hasProperty($property)) {
				$object = $mixin->getObject();
				
				return call_user_func_array($mixin->getProperty($property), array(
					$this, &$object, false, $value
				));
			}
		}
	}
	
	/**
	 * Magic __isset for the mixin'd properties
	 * @param string $property
	 */
	public function __isset($property) {
		$var = $this->$property;
		return isset($var);
	}
}