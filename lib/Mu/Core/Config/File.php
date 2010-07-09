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
 * @package   Mu\Core\Config\File
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Config;

/**
 * @category  Mu\Core
 * @package   Mu\Core\Config\File
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class File {
	/**
	 * The parsed config
	 * @var array
	 */
	protected $_parsedConfig;

	/**
	 * Gets the parses config
	 * @return \Mu\Core\Config
	 */
	public function getParsedConfig() {
		return new \Mu\Core\Config($this->_parsedConfig);
	}

	/**
	 * Class construct
	 * @param string $directory   The directory containing the config files
	 * @param string $environment The environment of which to load the config data
	 * @return void
	 */
	public function __construct($file, $environment) {
		$this->_parsedConfig = array();
		$this->_readConfigFile($file, $environment);
	}

	/**
	 * Loads in the config file
	 * @param string $file        The file containing the config array
	 * @param string $environment The environment of which to load the config data
	 * @return void
	 */
	protected function _readConfigFile($file, $environment) {
		$section = substr(basename($file), 0, -4);
		$config = include $file;

		$this->_parsedConfig[$section] = $this->_parseConfig($config, $environment);
	}

	/**
	 * Parses the config
	 * @param array  $config      The config to parse
	 * @param string $environment The environment of which to load the config data
	 * @return array
	 **/
	protected function _parseConfig(array $config, $environment) {
		$configCopy = array();

		foreach ($config as $section => &$subconfig) {
			if (preg_match('/^[a-z0-9]+ : [a-z0-9]+$/i', $section)) {
				list($section, $parent) = explode(' : ', $section);

				if (!isset($configCopy[$parent])) {
					throw new Exception\InvalidConfig('Invalid config, parent config not defined: ' . $parent);
				}

				$subconfig = $this->_mergeConfig($configCopy[$parent], $subconfig);
			}

			$configCopy[$section] = $subconfig;
		}

		// navigate over derived sections and return one for this environment
		foreach ($configCopy as $section => $subconfig) {
			if ($environment === $section) {
				return $subconfig;
			}
		}

		// return first value, no match to environment found
		return reset($configCopy);
	}

	/**
	 * Merges a source config with overriding values
	 * @param array $source
	 * @param array $override
	 * @return array
	 */
	protected function _mergeConfig(array $source, array $override) {
		foreach ($override as $key => $value) {
			if (is_array($value)) {
				if (isset($source[$key])) {
					$value = $this->_mergeConfig($source[$key], $value);
				}
			}

			$source[$key] = $value;
		}

		return $source;
	}
}