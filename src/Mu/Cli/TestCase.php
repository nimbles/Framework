<?php
namespace Mu\Cli;
require_once 'PHPUnit/Framework.php';

/**
 * @category Mu\Cli
 * @package Mu\Cli\TestCase
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class TestCase extends \Mu\Core\TestCase {
	/**
	 * Stdin to be used during test cases
	 * @var string
	 */
	static protected $_stdin = '';

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
	 */
	static public function setStdin($stdin) {
		self::$_stdin = is_string($stdin) ? $stdin : self::$_stdin;
	}
}