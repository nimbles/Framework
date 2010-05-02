<?php
namespace Tests\Mu\Log\Formatter;
require_once 'PHPUnit/Framework.php';
require_once 'SimpleTest.php';
require_once 'FormatterTest.php';

/**
 * All tests file for Mu Framework
 * @author rob
 *
 */
class AllTests {
	/**
	 * Creates the Test Suite for Mu Framework
	 * @return \PHPUnit_Framework_TestSuite
	 */
	static public function suite() {
		$suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Log - Formatter');
		$suite->addTestSuite('\Tests\Mu\Log\Formatter\SimpleTest');
		$suite->addTestSuite('\Tests\Mu\Log\Formatter\FormatterTest');
		return $suite;
	}
}