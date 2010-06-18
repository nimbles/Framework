<?php
namespace Mu\Core\Config;

/**
 * @category Mu
 * @package Mu\Core\Config\Configurable
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Configurable extends \Mu\Core\Mixin\Mixinable {
	/**
	 * The config for this mixinable
	 * @var \Mu\Core\Config
	 */
	protected $_config;

	/**
	 * Gets the object associated with this mixin
	 * @return \Mu\Core\Config
	 */
	public function getObject() {
		if (null === $this->_config) {
			$this->_config = new \Mu\Core\Config();
		}

		return $this->_config;
	}

	/**
	 * Gets the properties which can be mixed in
	 * @return array
	 */
	public function getProperties() {
		return array(
			'config' => function($object, &$config, $get, array $value = null) {
				if (!$get) {
					return $config->setConfig($value);
				}

				return $config;
			}
		);
	}
}