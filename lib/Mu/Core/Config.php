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
 * @package   Mu\Core\Config
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core;

/**
 * @category  Mu\Core
 * @package   Mu\Core\Config
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class Config extends \ArrayObject {
	/**
	 * Static instance
	 * @var \Mu\Core\Config
	 */
	static protected $_instance;

	/**
	 * Gets the instance
	 * @return \Mu\Core\Config
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
	 * @return \Mu\Core\Config|scalar
	 */
	protected function _getConfig($key = null) {
		if (null !== $key) {
			$keys = explode('.', $key);
			$config = $this;

			while (null !== ($section = array_shift($keys))) {
				if (!array_key_exists($section, $config)) {
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
	 * @param string|array $section
	 * @param scalar|array $config The config values
	 * @param bool $clear Clears the config if set to true
	 * @return \Mu\Core\Config
	 * @throws \Mu\Core\Config\Exception\InvalidConfig
	 */
	protected function _setConfig($section, $config = null, $clear = false) {
		if ($clear) {
			$this->exchangeArray(array());
		}

		if (is_array($section) || ($section instanceof Config)) {
			foreach ($section as $index => $value) {
				$this[$index] = $value;
			}
		} else if (null !== $config) {
			if (is_string($section) && (false !== strpos($section, '.'))) {
				$parts = explode('.', $section);

				$tmp = array();
				$current = &$config;
				$count = count($parts);

				for($i = 1; $i < $count; $i++) {
					$part = $parts[$i];

					$current[$part] = ($i < ($count - 1)) ? array() : $value;
					$current = &$current[$part];
				}

				$section = $parts[0];
				$config = $tmp;
			}

			$this[$section] = $config;
		} else if (null !== $section) {
			throw new Config\Exception\InvalidConfig('Config must be provided if section is not an array');
		}

		return $this;
	}

	/**
	 * Class construct
	 * @param array|scalar|null $section
	 * @param array|scalar|null $config
	 * @return void
	 */
	public function __construct($section = null, $config = null) {
		$this->_setConfig($section, $config);
	}

	/**
	 * Magic method __get to allow accesses for config
	 * @param string $name
	 * @return mixed|null
	 */
	public function __get($name) {
		return $this->_getConfig($name);
	}

	/**
	 * Magic method __set to allow accesses for config
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value) {
		return $this->_setConfig(array($name => $value));
	}
	
	/**
	 * Magic method __isset to allow accesses for config
	 * @param string $name
	 */
	public function __isset($name) {
		return (null !== $this->_getConfig($name));
	}

	/**
	 * Overload offsetGet to get arrays as Config
	 * @param mixed $index
	 * @return \Mu\Core\Config|scalar
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
	 * @return \Mu\Core\Config|scalar
	 * @throws \BadMethodCallException
	 */
	public function __call($method, $args) {
		if ('getConfig' === $method) {
			return call_user_func_array(array($this, '_getConfig'), $args);
		}

		if ('setConfig' === $method) {
			return call_user_func_array(array($this, '_setConfig'), $args);
		}

		throw new \BadMethodCallException('Invalid method ' . $method . ' on Config');
	}

	/**
	 * Magic method to allow getConfig as a static method
	 * @param string $name
	 * @param array $args
	 * @return \Mu\Core\Config|scalar
	 * @throws \BadMethodCallException
	 */
	static public function __callStatic($method, $args) {
		$object = self::getInstance();

		if ('getConfig' === $method) {
			return call_user_func_array(array($object, '_getConfig'), $args);
		}

		if ('setConfig' === $method) {
			return call_user_func_array(array($object, '_setConfig'), $args);
		}

		throw new \BadMethodCallException('Invalid static method ' . $method . ' on Config');
	}
}