<?php
namespace Tests\Mu\Core\Plugin;

require_once 'PluginTest.php';
require_once 'PluginsTest.php';
require_once 'PluginableTest.php';

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
		$suite = new \PHPUnit_Framework_TestSuite('Mu Framework - Core - Plugin');
		$suite->addTestSuite('\Tests\Mu\Core\Plugin\PluginTest');
		$suite->addTestSuite('\Tests\Mu\Core\Plugin\PluginsTest');
		$suite->addTestSuite('\Tests\Mu\Core\Plugin\PluginableTest');
		return $suite;
	}
}