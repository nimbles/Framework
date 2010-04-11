<?php
namespace Tests\Mu;
require_once 'PHPUnit/Framework.php';
require_once 'ConfigTest.php';

class AllTests {
	static public function suite() {
		$suite = new \PHPUnit_Framework_TestSuite('Mu Framework');
		$suite->addTestSuite('\Tests\Mu\ConfigTest');
		return $suite;
	}
}