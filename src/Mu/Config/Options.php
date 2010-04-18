<?php
namespace Mu\Config;

/**
 * @category Mu
 * @package Mu\Config\Options
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Options extends Configurable {
	/**
	 * Geths the object associated with the mixin
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
				
				return $config->getConfig($key);
			},
			
			'setOption' => function($object, &$config, $key, $value) {
				$method = 'set' . ucfirst($key);
				if (method_exists($object, $method)) {
					return $object->$method($value);
				}
				
				return $config->setConfig($key, $value);
			},
			
			'setOptions' => function($object, &$config, $options) {
				if (is_array($options) || ($options instanceof \Mu\Config)) {
					foreach ($options as $key => $value) {
						$object->setOption($key, $value);
					}
				}
			}
		);
	}
}