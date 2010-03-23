<?php
namespace Mu;

/**
 * @category Mu
 * @package Mu\Config
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Config extends \ArrayObject {
	/**
	 * Static instance
	 * @var Config
	 */
	static protected $_instance;
	
	/**
	 * Gets the instance
	 * @return Config
	 */
	public function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	/**
	 * Gets the parsed config
	 * @param string|null $key use dot notation to navigate down sub config values
	 * @return Config|scalar
	 */
	protected function _getConfig($key = null) {
		if (null !== $key) {
			$keys = explode('.', $key);
			$config = $this;
			
			while (null !== ($section = array_shift($keys))) {
				if (!isset($config[$section])) {
					return null;
				}			 
				
				$config = $config[$section];
			}
			
			return $config;
		}
		return $this;
	}
	
	/**
	 * Sets config
	 * @param string $section
	 * @param array $config
	 * @return Config
	 */
	protected function _setConfig(array $config = null, $clear = false) {
		if (null === $config) {
			$config = array();
		}
		
		if ($clear) {
			$this->exchangeArray(array());
		}
		
		/**
		 * @todo make set the same as get (dot notation)
		 */
		foreach ($config as $key => $value) {
			$this[$key] = $value;
		}
		return $this;
	}
	
	/**
	 * Class construct
	 * @return void
	 */
	public function __construct(array $config = null) {
		$this->_setConfig($config);
	}
	
	/**
	 * Overrload offsetGet to get arrays as Config
	 * @param mixed $index
	 * @return Config|scalar
	 */
	public function offsetGet($index) {
		$mixed = parent::offsetGet($index);
		
		if (is_array($mixed)) {
			$mixed = new Config($mixed);
		}
		
		return $mixed;
	}
	
	/**
	 * Magic method to allow getConfig as a public method
	 * @param string $name
	 * @param array $args
	 * @return Config|scalar
	 */
	public function __call($method, $args) {
		if ('getConfig' === $method) {
			return call_user_func_array(array($this, '_getConfig'), $args);
		}
		
		if ('setConfig' === $method) {
			return call_user_func_array(array($this, '_setConfig'), $args);
		}
		
		throw new BadMethodCallException('Invalid method ' . $method . ' on Config');
	}
	
	/**
	 * Magic method to allow getConfig as a static method
	 * @param string $name
	 * @param array $args
	 * @return Config|scalar
	 */
	static public function __callStatic($method, $args) {
		$object = self::getInstance();
		
		if ('getConfig' === $method) {
			return call_user_func_array(array($object, '_getConfig'), $args);	
		}
		
		if ('setConfig' === $method) {
			return call_user_func_array(array($object, '_setConfig'), $args);
		}
		
		throw new BadMethodCallException('Invalid static method ' . $method . ' on Config');
	}
}