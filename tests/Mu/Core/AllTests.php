<?php
namespace Tests\Mu\Core;
require_once 'PHPUnit/Framework.php';
require_once 'Config/AllTests.php';
require_once 'Mixin/AllTests.php';
require_once 'Plugin/AllTests.php';
require_once 'Log/AllTests.php';

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
		$suite->addTest(Mixin\AllTests::suite());
		$suite->addTest(Plugin\AllTests::suite());
		$suite->addTest(Log\AllTests::suite());
		return $suite;
	}
}