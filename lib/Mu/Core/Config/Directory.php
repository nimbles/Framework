<?php
namespace Mu\Core\Config;

/**
 * Class used for reading a set of config files
 * @author rob
 *
 */
class Directory extends File {
	/**
	 * Class construct
	 * @param string $directory   The directory containing the config files
	 * @param string $environment The environment of which to load the config data
	 * @return void
	 */
	public function __construct($directory, $environment) {
		$this->_parsedConfig = array();
		$this->_readConfigFiles($directory, $environment);
	}

	/**
	 * Reads the config files from a given directory
	 * @param string $directory
	 * @param string $environment
	 * @return void
	 */
	protected function _readConfigFiles($directory, $environment) {
		if (!is_dir($directory)) {
			throw new Exception\MissingConfigDirectory('Cannot find config directory : ' . $directory);
		}

		foreach (scandir($directory) as $filename) {
			if (!is_dir($directory . '/' . $filename)) { // skip . and ..
				$this->_readConfigFile($directory . '/' . $filename, $environment);
			}
		}
	}
}