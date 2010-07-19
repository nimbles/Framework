<?php
namespace Tests\Mu\Cli;

require_once 'PHPUnit/Framework.php';
require_once 'OptTest.php';
require_once 'RequestTest.php';
require_once 'ResponseTest.php';

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
		$suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Cli');
		$suite->addTestSuite('\Tests\Mu\Cli\OptTest');
		$suite->addTestSuite('\Tests\Mu\Cli\RequestTest');
		$suite->addTestSuite('\Tests\Mu\Cli\ResponseTest');
		return $suite;
	}
}