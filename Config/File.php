<?php
namespace Mu\Config;

/**
 * @category Mu
 * @package Mu\Config\File
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class File {
	/**
	 * The parsed config
	 * @var array
	 */
	protected $_parsedConfig;
	
	/**
	 * Gets the parses config
	 * @return void
	 */
	public function getParsedConfig() {
		return $this->_parsedConfig;
	}
	
	/**
	 * Class construct
	 * @param string $directory   The directory containing the config files
	 * @param string $environment The environment of which to load the config data 
	 * @return void
	 */
	public function __construct($directory, $environment) {
		$this->_readConfigFiles($directory, $environment);
	}
	
	/**
	 * Loads in the config files
	 * @param string $directory   The directory containing the config files
	 * @param string $environment The environment of which to load the config data 
	 * @return void
	 */
	protected function _readConfigFiles($directory, $environment) {
		$this->_parseConfig = array();
		
		if (is_dir($directory)) {
			throw new Exception\MissingConfigDirectory('Cannot find config directory : ' . $directory);
		}
		
		foreach (scandir($directory) as $filename) {
			if (!is_dir($directory . '/' . $filename)) {			
				$section = substr($filename, 0, -4);
				$config = include $directory . '/' . $filename;
				
				$this->_parsedConfig[$section] = $this->_parseConfig($config, $environment);
			}
		}
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
			if (preg_match('/^[a-z]+ : [a-z]+$/i', $section)) {
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