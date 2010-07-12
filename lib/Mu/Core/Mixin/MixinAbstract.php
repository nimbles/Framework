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
 * @package   Mu\Core\Mixin\MixinAbstract
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Mixin;

/**
 * @category  Mu\Core
 * @package   Mu\Core\Mixin\MixinAbstract
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
abstract class MixinAbstract {
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
	 * @throws \Mu\Core\Mixin\Exception\MixinableMissing
	 */
	public function __construct() {
		foreach ($this->_implements as $mixin => $options) {
			if (is_numeric($mixin)) {
				$mixin = $options;
				$options = null;
			}
			if (!class_exists($mixin)) {
				throw new Exception\MixinableMissing();
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
				
				/**
				 * Getters and setters use the same Closure with the signature
				 * @param \Mu\Core\Mixin\MixinAbstract $this     Reference to $this as it doesn't exist within the Closure
				 * @param mixed                        $object   The object turned by the getObject method, passed in by reference
				 * @param bool			               $get      Indicates if a get (true) or set (false) is being called
				 * @param string                       $property The property name being called, useful for dynamic properties
				 * @param mixed                        $value    The value to set to, not passed by magic __get
				 */ 				
				return call_user_func_array($mixin->getProperty($property), array(
					$this, &$object, true, $property
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

				/**
				 * Getters and setters use the same Closure with the signature
				 * @param \Mu\Core\Mixin\MixinAbstract $this     Reference to $this as it doesn't exist within the Closure
				 * @param mixed                        $object   The object turned by the getObject method, passed in by reference
				 * @param bool			               $get      Indicates if a get (true) or set (false) is being called
				 * @param string                       $property The property name being called, useful for dynamic properties
				 * @param mixed                        $value    The value to set to, not passed by magic __get
				 */ 
				return call_user_func_array($mixin->getProperty($property), array(
					$this, &$object, false, $property, $value
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