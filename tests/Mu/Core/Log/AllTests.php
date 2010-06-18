<?php
namespace Tests\Mu\Core\Log;
require_once 'PHPUnit/Framework.php';
require_once 'Formatter/AllTests.php';
require_once 'Writer/AllTests.php';
require_once 'Filter/AllTests.php';
require_once 'EntryTest.php';
require_once 'LogTest.php';
require_once 'LoggableTest.php';

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
		$suite->addTest(Writer\AllTests::suite());
		$suite->addTest(Filter\AllTests::suite());
		
		$suite->addTestSuite('\Tests\Mu\Core\Log\EntryTest');
		$suite->addTestSuite('\Tests\Mu\Core\Log\LogTest');
		$suite->addTestSuite('\Tests\Mu\Core\Log\LoggableTest');
		return $suite;
	}
}