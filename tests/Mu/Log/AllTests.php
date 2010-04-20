<?php
namespace Tests\Mu\Log;
require_once 'PHPUnit/Framework.php';
require_once 'Formatter/AllTests.php';

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
		$suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Log');
		$suite->addTest(Formatter\AllTests::suite());
		return $suite;
	}
}