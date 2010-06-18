<?php
namespace Mu\Core\Config;

/**
 * @category Mu
 * @package Mu\Core\Config\Options
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Options extends Configurable {
	/**
	 * Gets the object associated with the mixin
	 * @return \Mu\Core\Config
	 */
	public function getObject() {
		$config = parent::getObject();
		if (null !== $this->getConfig()) {
			$config->setConfig($this->getConfig());
		}
		return $config;
	}

	/**
	 * Gets the methods which can be mixed in
	 * @return array
	 */
	public function getMethods() {
		return array(
			'getOption' => function($object, &$config, $key) {
				$method = 'get' . ucfirst($key);
				if (method_exists($object, $method)) {
					return $object->$method();
				}

				return $config->{$key};
			},

			'setOption' => function($object, &$config, $key, $value) {
				$method = 'set' . ucfirst($key);
				if (method_exists($object, $method)) {
					return $object->$method($value);
				}

				return $config->{$key} = $value;
			},

			'setOptions' => function($object, &$config, $options) {
				if (is_array($options) || ($options instanceof \Mu\Core\Config)) {
					foreach ($options as $key => $value) {
						$object->setOption($key, $value);
					}
				}
			}
		);
	}
}