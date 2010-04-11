<?php
namespace Mu\Config;

/**
 * @category Mu
 * @package Mu\Config\Configurable
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Configurable implements \Mu\Mixin\IMixinable {
	/**
	 * Gets the properties which can be mixed in
	 * @return array
	 */
	public function getProperties() {
		return array(
			'config' => function($object, $get, array $value = null) {
				static $config = null;
				
				if (null === $config) {
					$config = new \Mu\Config($get ? null : $value);
				} else if (!$get) {
					$config->setConfig($value);	
				}
				
				return $config;
			}
		);
	}
	
	/**
	 * Gets the methods which can be mixed in
	 * @return array
	 */
	public function getMethods() {
		return array(
			'getConfig' => function($object, $key) {
				return $object->config->getConfig($key);
			},
			
			'setConfig' => function($object, $value = null) {
				return $object->config->setConfig($value);
			}
		);
	}
}