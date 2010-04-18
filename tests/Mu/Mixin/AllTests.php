<?php
namespace Tests\Mu\Mixin;
require_once 'PHPUnit/Framework.php';
require_once 'MixinTest.php';
require_once 'MixinableTest.php';

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
		$suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Mixin');
		$suite->addTestSuite('\Tests\Mu\Mixin\MixinTest');
		$suite->addTestSuite('\Tests\Mu\Mixin\MixinableTest');
		return $suite;
	}
}