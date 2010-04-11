<?php
namespace Tests\Mu\Config;
require_once 'PHPUnit/Framework.php';
require_once 'Mock.php';

/**
 * Config Tests
 * @author rob
 *
 */
class ConfigurableTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Tests the mixin properties are created and behave properly
	 * @return void
	 */
	public function testMixinProperties() {
		$mock = new Mock();
		$this->assertType('\Mu\Config', $mock->config);
		
		$mock->config->a = 1;
		$this->assertEquals(1, $mock->config->a);
	}
	
	/**
	 * Tests the mixin methods are created and behave properly
	 */
	public function textMixinMethods() {
		$mock = new Mock();
		$this->assertType('\Mu\Config', $mock->config);
		
		$mock->setConfig('a', 1);
		$this->assertEquals(1, $mock->getConfig('a'));
		
		$mock->setConfig('b.c', 2);
		$this->asssertType('\Mu\Config', $mock->getConfig('b'));
		$this->assertEquals(2, $mock->getConfig('b.c'));
	}
}