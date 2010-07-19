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
 * @category  Mu\Cli
 * @package   Mu\Cli\TestCase
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
namespace Mu\Cli;

require_once 'PHPUnit/Framework.php';

/**
 * @category  Mu\Cli
 * @package   Mu\Cli\TestCase
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class TestCase extends \Mu\Core\TestCase {
	/**
	 * Stdin to be used during test cases
	 * @var string
	 */
	static protected $_stdin = '';

	/**
	 * Stdout to be used during test cases
	 * @var string
	 */
	static protected $_stdout = '';

	/**
	 * Argv to be used during test cases
	 * @var array
	 */
	static protected $_argv = array();

	/**
	 * Gets stdin to be used during test cases
	 * @return string
	 */
	static public function getStdin() {
		return self::$_stdin;
	}

	/**
	 * Sets stdin to be used during test cases
	 * @param string $stdin
	 * @return void
	 */
	static public function setStdin($stdin) {
		self::$_stdin = is_string($stdin) ? $stdin : self::$_stdin;
	}

	/**
	 * Gets stdout to be used during test cases
	 * @return string
	 */
	static public function getStdout() {
		return self::$_stdout;
	}

	/**
	 * Sets stdout to be used during test cases
	 * @param string $stdout
	 */
	static public function setStdout($stdout) {
		self::$_stdout = is_string($stdout) ? $stdout : self::$_stdout;
	}

	/**
	 * Gets the Argv to be used during test cases
	 * @return array
	 */
	static public function getArgv() {
		return self::$_argv;
	}

	/**
	 * Sets the Argv to be used during test cases
	 * @param array $argv
	 * @return void
	 */
	static public function setArgv(array $argv) {
		self::$_argv = $argv;
	}

	/**
	 * Simulates php's getopt of the Argv provides
	 * @todo create parser that simulates native PHP 5.3 getopt
	 * @param string $options
	 * @param array $longopts
	 */
	static public function getopt($options, array $longopts = null) {

	}
}