<?php
namespace Tests\Mu\Http;

require_once 'PHPUnit/Framework.php';
require_once 'HeaderTest.php';
require_once 'RequestTest.php';

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
		$suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Http');
		$suite->addTestSuite('\Tests\Mu\Http\HeaderTest');
		$suite->addTestSuite('\Tests\Mu\Http\RequestTest');
		return $suite;
	}
}