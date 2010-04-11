<?php
namespace Tests;

require_once 'PHPUnit/Framework.php';
require_once 'Mu/AllTests.php';

class AllTests {
	static public function suite() {
		$suite = new \PHPUnit_Framework_TestSuite('All Tests');
		$suite->addTest(Mu\AllTests::suite());
		return $suite;
	}
}