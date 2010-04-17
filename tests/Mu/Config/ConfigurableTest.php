<?php
namespace Tests\Mu\Config;
require_once 'PHPUnit/Framework.php';
require_once 'ConfigurableMock.php';

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
		$mock = new ConfigurableMock();
		$this->assertType('\Mu\Config', $mock->config);
		
		$mock->config->a = 1;
		$this->assertEquals(1, $mock->config->a);
	}
}