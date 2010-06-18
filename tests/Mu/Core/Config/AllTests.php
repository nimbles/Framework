<?php
namespace Tests\Mu\Core\Config;
require_once 'PHPUnit/Framework.php';
require_once 'ConfigTest.php';
require_once 'FileTest.php';
require_once 'DirectoryTest.php';
require_once 'ConfigurableTest.php';
require_once 'OptionsTest.php';

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
		$suite->addTestSuite('\Tests\Mu\Core\Config\ConfigTest');
		$suite->addTestSuite('\Tests\Mu\Core\Config\FileTest');
		$suite->addTestSuite('\Tests\Mu\Core\Config\DirectoryTest');
		$suite->addTestSuite('\Tests\Mu\Core\Config\ConfigurableTest');
		$suite->addTestSuite('\Tests\Mu\Core\Config\OptionsTest');
		return $suite;
	}
}