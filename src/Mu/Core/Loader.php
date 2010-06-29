<?php
namespace Mu\Core;

/**
 * @category Mu\Core
 * @package Mu\Core\Loader
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Loader {
	/**
	 * Registers the autoloader
	 * @return void
	 */
	static public function register() {
		spl_autoload_register(__NAMESPACE__ . '\Loader::autoload');
	}

	/**
	 * The autoloader for Mu classes
	 * @param string $class
	 * @return void
	 */
	static public function autoload($class) {
		// only need to replace back slashes with forward slashes since php 5.3
		$file = str_replace('\\', '/', $class) . '.php';
		if (self::_fileExists($file)) {
			require_once $file;
		}
	}

	/**
	 * Checks if a file exists on include path
	 * @param string $file
	 * @return bool
	 */
	static protected function _fileExists($file) {
		if (false !== realpath($file)) {
			return true;
		}

		$include_paths = explode(PATH_SEPARATOR, get_include_path());
		foreach ($include_paths as $include_path) {
			if (false !== realpath($include_path . '/' . $file)) {
				return true;
			}
		}
		return false;
	}
}