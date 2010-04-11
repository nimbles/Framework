<?php
namespace Tests;

require_once 'PHPUnit/Framework.php';
require_once 'Mu/AllTests.php';

/**
 * All tests file, exists so that can be part of wider system
 * @author rob
 *
 */
class AllTests {
	/**
	 * Creates the Test Suite for All Tests
	 * @return \PHPUnit_Framework_TestSuite
	 */
	static public function suite() {
		$suite = new \PHPUnit_Framework_TestSuite('All Tests');
		$suite->addTest(Mu\AllTests::suite());
		return $suite;
	}
}