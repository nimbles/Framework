<?php
namespace Tests\Mu\Log\Filter;
require_once 'PHPUnit/Framework.php';
require_once 'LevelTest.php';
require_once 'CategoryTest.php';

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
		$suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Log - Filter');
		$suite->addTestSuite('\Tests\Mu\Log\Filter\LevelTest');
		$suite->addTestSuite('\Tests\Mu\Log\Filter\CategoryTest');
		return $suite;
	}
}