<?php
namespace Tests\Mu\Config;
require_once 'PHPUnit/Framework.php';
require_once 'ConfigTest.php';
require_once 'FileTest.php';
require_once 'DirectoryTest.php';
require_once 'ConfigurableTest.php';

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
		$suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Config');
		$suite->addTestSuite('\Tests\Mu\Config\ConfigTest');
		$suite->addTestSuite('\Tests\Mu\Config\FileTest');
		$suite->addTestSuite('\Tests\Mu\Config\DirectoryTest');
		$suite->addTestSuite('\Tests\Mu\Config\ConfigurableTest');
		return $suite;
	}
}