<?php
namespace Tests\Mu;

require_once 'PHPUnit/Framework.php';
require_once 'Core/AllTests.php';
require_once 'Cli/AllTests.php';

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
		$suite = new \PHPUnit_Framework_TestSuite('Mu Framework');

		$suite->addTest(Core\AllTests::suite());
		$suite->addTest(Cli\AllTests::suite());

		return $suite;
	}
}