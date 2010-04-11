<?php
namespace Tests\Mu;
require_once 'PHPUnit/Framework.php';

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
		$suite = new \PHPUnit_Framework_TestSuite('Mu Framework');
		$suite->addTest(Config\AllTests::suite());
		return $suite;
	}
}