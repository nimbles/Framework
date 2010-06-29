<?php
namespace Tests\Mu\Core\Log\Writer;

require_once 'StreamTest.php';
require_once 'MockTest.php';

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
		$suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Core - Log - Writer');
		$suite->addTestSuite('\Tests\Mu\Core\Log\Writer\StreamTest');
		$suite->addTestSuite('\Tests\Mu\Core\Log\Writer\MockTest');
		return $suite;
	}
}